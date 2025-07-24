<?php
require 'TuyaCloud.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

$options = [
  'baseUrl' => 'https://openapi-ueaz.tuyaus.com',
  'accessKey' => 'vmjspjt3hks4aagqratn', 
  'secretKey' => '0a678287cdf64fb8a4a99a520be9c30d',
];

$status = $data['status'];
$breakerId = $data['breakerid'];


$tuya = new TuyaCloud($options);
$commands = [
  "commands" => [
    [
      "code" => "switch",
      "value" => $status
    ]
  ]
];

$response = $tuya->setDevice($breakerId, $commands);
echo json_encode($response, JSON_PRETTY_PRINT);