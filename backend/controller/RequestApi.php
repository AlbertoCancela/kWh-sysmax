<?php

class ApiClient
{
    private string $baseUrl;
    private array $headers;

    public function __construct(string $baseUrl, array $headers = [])
    {
        $this->baseUrl = rtrim($baseUrl, "/");
        $this->headers = array_merge([
            'Content-Type: application/json',
            'Accept: application/json'
        ], $headers);
    }

    private function request(string $method, string $endpoint, array $data = null)
    {
        $url = $this->baseUrl . $endpoint;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Si hay datos (POST/PUT)
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return ["error" => $error];
        }

        return json_decode($response, true); // decode automático
    }

    // Métodos accesibles
    public function get(string $endpoint)
    {
        return $this->request("GET", $endpoint);
    }

    public function post(string $endpoint, array $data)
    {
        return $this->request("POST", $endpoint, $data);
    }

    public function put(string $endpoint, array $data)
    {
        return $this->request("PUT", $endpoint, $data);
    }

    public function delete(string $endpoint)
    {
        return $this->request("DELETE", $endpoint);
    }
}
