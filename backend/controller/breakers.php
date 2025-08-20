<?php
require_once 'DB.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$DB = new QueryHandler();

$queries = [
    'safr' => "SELECT * FROM RECORDS",
    'safrW-rId' => "SELECT * FROM RECORDS WHERE ID = :id",
    'safrW-bId' => "SELECT * FROM RECORDS WHERE ID_BREAKER = :id_breaker",
    'ssfrjo' => "SELECT 
                    r.ID_BREAKER as ID, 
                    d.DEPARTMENT_CODE,
                    r.TEMP AS LAST_TEMP, 
                    r.KWH AS CONSUMPTION, 
                    u.USERNAME AS PROPERTY,
                    r.RECORD_DATE 
                FROM RECORDS r 
                    JOIN BREAKERS    b ON b.ID = r.ID_BREAKER
                    JOIN USERS       u ON u.ID = b.ID_USER
                    JOIN DEPARTMENTS d ON d.ID = u.ID_DEPARTMENT",
    'ssfb' =>"SELECT 
                    b.ID,
                    d.DEPARTMENT_CODE, 
                    b.DEVICE_NAME AS NAME, 
                    rr.KWH AS CONSUMPTION,
                    rr.TEMP AS LAST_TEMP,
                    rr.RECORD_DATE AS RECORD_DATE,
                    u.USERNAME AS PROPERTY
                FROM BREAKERS b
                JOIN USERS u ON b.ID_USER = u.ID
                LEFT JOIN (
                    SELECT r1.*
                    FROM RECORDS r1
                    WHERE r1.ROWID IN (
                        SELECT ROWID
                        FROM RECORDS r2
                        WHERE r2.ID_BREAKER = r1.ID_BREAKER
                        LIMIT 1
                    )
                ) rr ON rr.ID_BREAKER = b.ID
                JOIN DEPARTMENTS d ON u.ID_DEPARTMENT = d.ID
                ORDER BY rr.RECORD_DATE",
    'safrW-bIdL7' => "SELECT * FROM RECORDS 
                        WHERE ID_BREAKER = :id_breaker 
                        ORDER BY RECORD_DATE DESC, ID DESC 
                        LIMIT 7",
    'ssfbW-bId' => "SELECT 
                        b.ID, b.DEVICE_NAME, 
                        u.USERNAME,
                        u.NAME,
                        d.DEPARTMENT_CODE 
                    FROM BREAKERS b 
                    JOIN USERS u ON (u.ID = b.ID_USER) 
                    JOIN DEPARTMENTS d ON (d.ID = u.ID_DEPARTMENT)
                    WHERE b.ID = :id_breaker",
    'ssfrjoaf' => "SELECT 
                    r.ID_BREAKER as ID, 
                    d.DEPARTMENT_CODE,
                    r.TEMP AS LAST_TEMP, 
                    SUM(r.KWH) AS CONSUMPTION, 
                    u.USERNAME AS PROPERTY,
                    r.RECORD_DATE 
                FROM RECORDS r 
                    JOIN BREAKERS    b ON b.ID = r.ID_BREAKER
                    JOIN USERS       u ON u.ID = b.ID_USER
                    JOIN DEPARTMENTS d ON d.ID = u.ID_DEPARTMENT"
];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST': #to get some data
        switch( $data['action'] ){
            case 'getAllBreakersD':
                $query = $queries[$data['query']];
                $params = $data['params'] ?? [];
                $permitidos = ['id_breaker', 'id', 'date', 'temp', 'kwh'];
                foreach ($params as $key => $value) {
                    if (in_array($key, $permitidos)) {
                        $$key = $value;
                    } else {
                        unset($params[$key]);
                    }
                }
                $result = $DB->executeQuery($query, $params);
                echo json_encode([
                    'status' => 'ok',
                    'breakers' => $result
                ]);
                break;
            case 'getSingleBreakerD':
                $query = $queries[$data['query']];
                $query2 = $queries[$data['query2']];
                $params = $data['params'] ?? [];

                $result = $DB->executeQuery($query, $params);
                $result2 = $DB->executeQuery($query2, $params);
                echo json_encode([
                    'status' => 'ok',
                    'records' => $result,
                    'breakerData' => $result2
                ]);
                break;
            case 'getRecordsToReport':
                $query = $queries[$data['query']];
                $query .= $data['addition'];
                $params = $data['params'] ?? [];
                $permitidos = ['id_breaker', 'id', 'date', 'temp', 'kwh'];
                foreach ($params as $key => $value) {
                    if (in_array($key, $permitidos)) {
                        $$key = $value;
                    } else {
                        unset($params[$key]);
                    }
                }
                $result = $DB->executeQuery($query, $params);
                echo json_encode([
                    'status' => 'ok',
                    'breakers' => $result
                ]);
                break;
        }

        break;
    case 'PUT': #to update data
        # code...
        break;
    case 'DELETE': #to delete data
        # code...
        break;    
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}