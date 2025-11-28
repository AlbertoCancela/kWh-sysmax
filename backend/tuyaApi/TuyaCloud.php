<?php
class TuyaCloud {
  private $baseUrl;
  private $accessKey;
  private $secretKey;
  private $tokenStore;

  public function __construct($options) {
    $this->baseUrl = $options['baseUrl'];
    $this->accessKey = $options['accessKey'];
    $this->secretKey = $options['secretKey'];
  }

  // Function to sign the request
  private function signRequest($method, $path, $timestamp, $accessToken = '', $body = '') {
    $ctxHash = hash_init('sha256');
    hash_update($ctxHash, $body);
    $contentHash = bin2hex(hash_final($ctxHash, true));

    $stringToSign = strtoupper($method) . "\n" . $contentHash . "\n\n" . urldecode($path);

    $signStr = $this->accessKey . $accessToken . $timestamp . $stringToSign;

    return strtoupper(hash_hmac('sha256', $signStr, $this->secretKey));
  }

  public function getAccessToken() {
  $timestamp = round(microtime(true) * 1000);
  $path = '/v1.0/token?grant_type=1';
  $signature = $this->signRequest('GET', $path, $timestamp);

  $headers = [
    'client_id: ' . $this->accessKey,
    'sign: ' . $signature,
    't: ' . $timestamp,
    'sign_method: HMAC-SHA256'
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $path);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($response, true);
  if (isset($data['result']['access_token'])) {
    return $data['result']['access_token'];
  }

  throw new Exception('[tuyacloud] Unable to retrieve access token: ' . json_encode($data));
}

  private function sendRequest($path, $method, $data = "{}") {

    if (is_string($data)) {
      json_decode($data);
      if (json_last_error() !== JSON_ERROR_NONE) {
        throw new InvalidArgumentException("[tuyacloud] The argument must be a valid JSON string, an array, or a stdClass object.");
      }
    }    
    // encode the array to a JSON string
    else if (is_array($data)) {
      $data = json_encode($data);
    }    
    // if it's a stdClass object, convert it to a JSON string
    else if (is_object($data) && $data instanceof stdClass) {
      $data = json_encode($data);
    }

    $timestamp = round(microtime(true) * 1000);
    $token = $this->getAccessToken();
    $sign = $this->signRequest($method, $path, $timestamp, $token, $data);

    $url = $this->baseUrl . $path;
    $headers = [
      'Accept: application/json, text/plain, */*',
      't: ' . $timestamp,
      'sign: ' . $sign,
      'client_id: ' . $this->accessKey,
      'sign_method: HMAC-SHA256',
      'access_token: ' . $token,
      'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($data !== null) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
  }

  public function getDevice($deviceId) {
    if (!isset($deviceId)) throw "[tuyacloud] You have to pass the `device_id` as an argument to this function 'getDevice'.";
    return $this->sendRequest('/v1.0/iot-03/devices/' . $deviceId. '/status', 'GET');
  }


  public function setDevice($deviceId, $commands) {
    if (func_num_args() != 2) throw "[tuyacloud] You have to pass the `device_id` and the `commands` as arguments to this function 'setDevice'.";
    return $this->sendRequest('/v1.0/iot-03/devices/' . $deviceId. '/commands', 'POST', $commands);
  }

  public function getStatus($deviceId){
    if (!isset($deviceId)) throw "[tuyacloud] You have to pass the `device_id` as an argument to this function 'getDevice'.";
    return $this->sendRequest('/v1.0/iot-03/devices/' . $deviceId, 'GET');
  }

public function getDevices($pageSize = 20, $pageNo = 1, $schema = null) {
  $queryParams = [
    'page_size' => $pageSize,
    'page_no' => $pageNo
  ];

  if ($schema) {
    $queryParams['schema'] = $schema;
  }

  $query = http_build_query($queryParams);
  $path = "/v1.0/devices?$query";

  return $this->sendRequest($path, 'GET');
}
  // public function getScenes() {

  //   $spaces = $this->sendRequest('/v2.0/cloud/space/child', 'GET');
  //   if ($spaces['success'] != 1) throw "[tuyacloud] An error occured with space/child: ".$spaces['error_msg'];

  //   $spaces = $spaces['result']['data'];
  //   $ret = [];
  //   foreach($spaces as $spaceId) {

  //     $scenesDetails = $this->sendRequest('/v2.0/cloud/scene/rule?space_id='.$spaceId, 'GET');
  //     if ($scenesDetails['success'] != 1) throw "[tuyacloud] An error occured with scene/rule?space_id=".$spaceId.": ".$scenesDetails['error_msg'];
  //     foreach($scenesDetails['result']['list'] as $scenes) {
  //       array_push($ret, $scenes);
  //     }
  //   }
  //   return $ret;
  // }


  // public function startScene($sceneId) {
  //   if (!isset($sceneId)) throw "[tuyacloud] You have to pass the `scene_id` as an argument to this function 'startScene'.";
  //   return $this->sendRequest('/v2.0/cloud/scene/rule/'.$sceneId.'/actions/trigger', 'POST');
  // }
}
?>
