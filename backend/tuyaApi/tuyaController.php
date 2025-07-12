<?php
require_once __DIR__ . '/../controller/DB.php';

class TuyaController {
    private $db;

    public function __construct() {
        $conn = new Connection(false);
        $this->db = $conn->getConnection();
    }

    public function dataProcessing($data) {
        foreach ($data as $breakerId => $deviceData) {
            $this->saveRecord($breakerId, $deviceData);
        }

        echo json_encode([
            "success" => true,
            "message" => "Datos insertados en RECORDS correctamente."
        ], JSON_PRETTY_PRINT);
    }

    protected function saveRecord($id_breaker, $deviceData) {
        $stmt = $this->db->prepare("
            INSERT INTO RECORDS (ID_BREAKER, KWH, TEMP)
            VALUES (:id_breaker, :kwh, :temp)
        ");

        $stmt->execute([
            ':id_breaker' => $id_breaker,
            ':kwh' => $deviceData['total_forward_energy'],
            ':temp' => $deviceData['temp_current']
        ]);
    }
}
