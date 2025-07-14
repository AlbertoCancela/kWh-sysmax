<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode(['status' => 'seted', 'data' => $data]);
}else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    echo json_encode(['status' => 'updated', 'data' => $data]);
}else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    echo json_encode(['status' => 'deleted', 'data' => $data]);
}
else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}