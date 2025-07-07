<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class CavaliService{
    private $clientId;
    private $clientSecret;
    private $apiKey;
    private $authUrl;
    private $baseUrl;

    public function __construct(){
        $this->clientId = config('services.cavali.client_id');
        $this->clientSecret = config('services.cavali.client_secret');
        $this->apiKey = config('services.cavali.api_key');
        $this->authUrl = config('services.cavali.auth_url');
        $this->baseUrl = config('services.cavali.base_url');
    }

    public function getAccessToken() {
        $cachedToken = Cache::get('cavali_access_token');
        if ($cachedToken) {
            return [
                'access_token' => $cachedToken,
                'from_cache' => true
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])->post($this->authUrl, [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials'
            ]);
            return $response->json();
        } catch (Exception $e) {
            return [
                'success' => false,
                'exception' => $e->getMessage()
            ];
        }
    }
    public function consultarFacturas($filtros){
        $token = $this->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'x-api-key' => $this->apiKey
        ])->post($this->baseUrl . '/factrack/v2/invoice/', $filtros);
        return $response->json();
    }
    public function obtenerResultadoConsulta($consultaId){
        $token = $this->getAccessToken();
        $maxIntentos = 10;
        $intentos = 0;

        do {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'x-api-key' => $this->apiKey
            ])->get($this->baseUrl . '/factrack/v2/invoice/' . $consultaId);

            $data = $response->json();

            if (isset($data['status']) && $data['status'] === 'NOTIFIED') {
                return $data;
            }

            sleep(2);
            $intentos++;

        } while ($intentos < $maxIntentos && (!isset($data['status']) || $data['status'] === 'CREATED'));

        return $data;
    }
    public function enviarFacturaXML($xmlString){
        $token = $this->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'x-api-key' => $this->apiKey
        ])->post($this->baseUrl . '/factrack/v2/add-invoice-xml', [
            'xml' => $xmlString
        ]);

        return $response->json();
    }

}
