<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class SunatController extends Controller{
public function consultar(string $ruc = null): JsonResponse{
        if (empty($ruc) || !preg_match('/^\d{11}$/', $ruc)) {
            return response()->json(['error' => 'Debe proporcionar un RUC válido de 11 dígitos'], 400);
        }
        $token = env('CONSULTA_RUC_API_TOKEN');
        try {
            $response = Http::withToken($token)
                ->get('https://api.apis.net.pe/v2/sunat/ruc/full', [
                    'numero' => $ruc,
                ]);
            if ($response->successful()) {
                return response()->json($response->json());
            }
            if ($response->status() === 404) {
                return response()->json(['error' => 'No se encontró información para el RUC proporcionado'], 404);
            }
            return response()->json([
                'error' => 'Error en la consulta al servicio externo',
                'status' => $response->status(),
                'body' => $response->body(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al consultar el RUC',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

