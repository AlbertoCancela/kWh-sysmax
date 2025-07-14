<?php
require 'TuyaCloud.php';
include_once 'tuyaController.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);


$options = [
  'baseUrl' => 'https://openapi-ueaz.tuyaus.com', // URL API of Tuya
  'accessKey' => 'vmjspjt3hks4aagqratn', // access key 
  'secretKey' => '0a678287cdf64fb8a4a99a520be9c30d', // access secret 
];

$tuya = new TuyaCloud($options);

$response = $tuya->getDevice($data['deviceId']);

$data = [];
$requiredData = ['total_forward_energy', 'switch', 'temp_current'];
$j = 0;
while($j < count($response['result'])){
  if(in_array($response['result'][$j]['code'], $requiredData)){
    $data[$response['result'][$j]['code']] = $response['result'][$j]['value'];
  }
  $j++;
}

echo json_encode($data, JSON_PRETTY_PRINT);
