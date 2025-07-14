<?php
require_once 'DB.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$DB = new QueryHandler();

$queries = [
    'safr' => "SELECT * FROM RECORDS",
    'safrW-rId' => "SELECT * FROM RECORDS WHERE ID = :id",
    'safrW-bId' => "SELECT * FROM RECORDS WHERE ID_BREAKER = :id_breaker",
    'ssfb' =>"SELECT b.ID, b.DEVICE_NAME AS NAME, SUM(r.KWH) as CONSUMPTION,
            (
                SELECT rr.TEMP
                FROM RECORDS rr
                WHERE rr.ID_BREAKER = b.ID
                ORDER BY rr.RECORD_DATE DESC
                LIMIT 1
            ) AS LAST_TEMP, u.USERNAME as PROPERTY FROM BREAKERS b 
            JOIN RECORDS r ON (b.ID = r.ID_BREAKER)
            JOIN USERS u ON (b.ID_USER = u.ID)
            GROUP BY b.ID"
];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST': #to get some data
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