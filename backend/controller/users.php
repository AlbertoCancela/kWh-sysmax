<?php
require_once 'DB.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$DB = new QueryHandler();

$queries = [
    'safu' => "SELECT * FROM USERS",
    'ufu-un' => "UPDATE USERS SET USERNAME = :username WHERE ID = :id",
    'safuW-pw' => "SELECT * FROM USERS WHERE USERNAME = :username AND PASSWORD = :password",
    'ufu-up' => "UPDATE USERS SET PASSWORD = :password WHERE USERNAME = :username"
];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $query = $queries[$data['query']];
        $params = $data['params'] ?? [];
        $permitidos = ['id', 'password'];
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
    case 'PUT':
        // echo json_encode(['status' => 'ok']);
        $query = $queries[$data['query']];
        switch( $data['action'] ){
            case 'changeUserName':
                $params = $data['params'] ?? [];
                $result = $DB->executeQuery($query, $params);
                echo json_encode(['status' => 'ok', 'result' => $result]);
                break;
            case 'verifyPassword':
                $params = $data['params'] ?? [];
                $result = $DB->executeQuery($query, $params);
                echo json_encode(['status' => 'ok', 'result' => $result]);
                break;
            case 'changePassword':
                $params = $data['params'] ?? [];
                $result = $DB->executeQuery($query, $params);
                echo json_encode(['status' => 'ok', 'result' => $result]);
                break;
        }
        break;
    case 'DELETE':
        # code...
        break;    
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
