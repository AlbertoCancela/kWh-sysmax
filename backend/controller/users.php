<?php
require_once 'DB.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$DB = new QueryHandler();

$queries = [
    'safu' => 'SELECT * FROM USERS'
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
        # code...
        break;
    case 'DELETE':
        # code...
        break;    
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
