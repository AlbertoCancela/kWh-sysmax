<?php
require_once "DB.php";
require_once "RequestApi.php";
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$queryHandler = new QueryHandler();

switch($data['action']){
    case 'startSession':
        // $response = $queryHandler->verifyCredentials($data['username'], $data['password']);
        // echo json_encode($response[0]['USERNAME']);
        $api = new ApiClient("http://localhost:8080/sysmax");
        $response = $api->post("/user/verify", [
            "username" => $data['username'],
            "password" => $data['password']
        ]);
        
        $response = $response['data'];
        if ( $response )
            try{
                $userData = $response[0]['ID_PERMISSION'] == '1' ? ['userBreaker' => 'op'] : ['userBreaker' => $response[0]['ID_BREAKER']];
                $userData['name'] = $response[0]['NAME'];
                $userData['id'] = $response[0]['ID'];
                $userData['department'] = $response[0]['DEPARTMENT'];
                $userData['email'] = $response[0]['EMAIL'];
                $user = new UserSession($response[0]['USERNAME'],$response[0]['ID_PERMISSION'], $userData);
                echo json_encode(['status' => 'ok']);
            }catch(error){
                echo $error;
            }
        else
            echo json_encode([
                'status' => 'error',
                'message' => 'error starting the session',
                'response' => $response
                ]
            );
    break;
    case 'closeSession':
        try{
            $user = new UserSession('','',[]);
            $user->endSession();
            echo true;
        }catch(error){
            echo $error;
        }
}


?>