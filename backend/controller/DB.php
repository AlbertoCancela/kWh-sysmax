<?php

class Connection {
    private $dbPath = __DIR__ . '/../dataBases/SYSMAX-KWH.db';
    private $conn;

    public function __construct() {
        try {
            $dsn = "sqlite:" . $this->dbPath;
            $this->conn = new PDO($dsn);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Error de conexión: " . $e->getMessage()
            ]);
            exit;
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

class UserSession {
    private $userName = "";
    private $userPermissions = "";
    private $userData = [];

    public function __construct($userName, $userPermissions, $userData = [])
    {
        $this->userName = $userName;
        $this->userPermissions = $userPermissions;
        $this->userData = $userData;
        $this->startSession();
    }

    private function startSession(){
        session_name('sysmax-tuya');
        session_start();
        $_SESSION['userName'] = $this->userName;
        $_SESSION['permissions'] = $this->userPermissions;
        $_SESSION['data'] = $this->userData;
    }

    public function endSession(){
        session_start();
        $_SESSION = [];
        session_destroy();
    }
}

class QueryHandler extends Connection {
    public function verifyCredentials(...$args){
        $result = $this->executeQuery('SELECT u.*, IFNULL(b.ID, "NO_BREAKER") AS ID_BREAKER  FROM USERS u LEFT JOIN BREAKERS b ON (b.ID_USER = u.ID) WHERE USERNAME = :username', ['username' => $args[0]]);
        if($result[0]['USERNAME'] == $args[0] && $result[0]['PASSWORD'] == $args[1])
            return $result;
        else
            return false;
    }
    public function executeQuery($query, $params = []) {
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute($params);

            $queryType = strtoupper(strtok(trim($query), " "));

            if ($queryType === 'SELECT') {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (in_array($queryType, ['INSERT', 'UPDATE', 'DELETE'])) {
                return [
                    'rowCount' => $stmt->rowCount(), // cuántas filas fueron afectadas
                    'lastInsertId' => $this->getConnection()->lastInsertId()
                ];
            } else {
                return ['status' => 'ok'];
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Error en consulta: " . $e->getMessage()
            ]);
            exit;
        }
    }
}
