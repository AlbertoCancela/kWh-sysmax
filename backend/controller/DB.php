<?php


class Connection{ #Thinking to the future :)
    private $host = "";
    private $port = "";
    private $dbname = "";
    private $username = "";
    private $password = "";

    private $conn;

    protected $testing;

    public function __construct($myTestArg) {
        try {
            if (!$myTestArg){ 
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
                $this->conn = new PDO($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            }
            else{
                $this->testing = ["admon" => ["4321", 1, "Administrador"], "user" => ["123", 2, "Usuario básico"]];
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Error de conexión: " . $e->getMessage()
            ]);
            exit;
        }
    }
    protected function getConnection() { 
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


class QueryHandler extends Connection{
    public function verifyCredentials(...$args){
        $response = $this->testing; #change this when testing ends
        if ( $response[$args[0]][1] == 1){
            $r = $response['admon'][0] == $args[1] ? $response[$args[0]] : false;
            return $r;
        }
        else{
            $r = $response['user'][0] == $args[1] ? $response[$args[0]] : false;
            return $r;
        }
    }

    protected function executeQuery(){

    }
}