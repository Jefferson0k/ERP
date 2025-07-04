<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class CavaliService {
    private $apiKey;
    private $baseUrl;
    private $manualToken;

    public function __construct() {
        $this->apiKey = config('services.cavali.api_key');
        $this->baseUrl = config('services.cavali.base_url');
        $this->manualToken = env('CAVALI_MANUAL_TOKEN');
    }

    public function getAccessToken() {
        if (!$this->manualToken) {
            throw new Exception('CAVALI token no definido en .env');
        }

        return $this->manualToken;
    }

    public function consultarFacturas($filtros) {
        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'x-api-key' => $this->apiKey
            ])->post($this->baseUrl . '/factrack/v2/invoice/', $filtros);

            if (!$response->successful()) {
                throw new Exception('Error al crear consulta: ' . $response->body());
            }

            $data = $response->json();
            $consultaId = $data['id'];

            return $this->obtenerResultadoConsulta($consultaId);

        } catch (Exception $e) {
            throw new Exception('Error en consulta de facturas: ' . $e->getMessage());
        }
    }

    public function obtenerResultadoConsulta($consultaId) {
        try {
            $token = $this->getAccessToken();
            $maxIntentos = 10;
            $intentos = 0;

            do {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'x-api-key' => $this->apiKey
                ])->get($this->baseUrl . '/factrack/v2/invoice/' . $consultaId);

                if (!$response->successful()) {
                    throw new Exception('Error al obtener resultado: ' . $response->body());
                }

                $data = $response->json();

                if (isset($data['status']) && $data['status'] === 'NOTIFIED') {
                    return $data;
                }

                sleep(2);
                $intentos++;

            } while ($intentos < $maxIntentos && (!isset($data['status']) || $data['status'] === 'CREATED'));

            if (!isset($data['status']) || $data['status'] !== 'NOTIFIED') {
                throw new Exception('Consulta no completada después de ' . $maxIntentos . ' intentos');
            }

            return $data;

        } catch (Exception $e) {
            throw new Exception('Error al obtener resultado de consulta: ' . $e->getMessage());
        }
    }

    public function enviarFacturaXML($xmlData) {
        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'x-api-key' => $this->apiKey
            ])->post($this->baseUrl . '/factrack/v2/add-invoice-xml', $xmlData);

            if (!$response->successful()) {
                throw new Exception('Error al enviar factura XML: ' . $response->body());
            }

            return $response->json();

        } catch (Exception $e) {
            throw new Exception('Error al enviar factura XML: ' . $e->getMessage());
        }
    }
}
