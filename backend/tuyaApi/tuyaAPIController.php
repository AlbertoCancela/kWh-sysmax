<?php
require 'TuyaCloud.php';

$options = [
  'baseUrl' => 'https://openapi-ueaz.tuyaus.com', // URL API of Tuya
  'accessKey' => 'vmjspjt3hks4aagqratn', // access key 
  'secretKey' => '0a678287cdf64fb8a4a99a520be9c30d', // access secret 
];

$tuya = new TuyaCloud($options);
$IdDevicesPath = "tuyaIdDevices.json";

try {
    $jsonString = file_get_contents($IdDevicesPath);
    $data = json_decode($jsonString, true);
    $i = 1;
    $breakersData = [];
    while($i <= count($data)){
        // echo "Data for Breaker $i: \n".$data["breaker".$i]."\n";
        $response = $tuya->getDevice($data["breaker".$i]);
        $j = 0;
        $breakerId = $data["breaker".$i];
        $breakersData[$breakerId] = [];
        $requiredData = ['total_forward_energy', 'switch', 'temp_current'];
        while($j < count($response['result'])){
            if(in_array($response['result'][$j]['code'], $requiredData)){
                $breakersData[$breakerId][$response['result'][$j]['code']] = $response['result'][$j]['value']; 
            }
            $j++;
        }
        $i++;
    }
    echo json_encode($breakersData, JSON_PRETTY_PRINT);
    
    // $response = $tuya->getDevice('65e6a732254c5669aceikp');
    // $kWh = $response['result'][0];
    // $status = $response['result'][10];
    // $tempCurrent = $response['result'][11];
    // echo (json_encode($response, JSON_PRETTY_PRINT));
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
?>
