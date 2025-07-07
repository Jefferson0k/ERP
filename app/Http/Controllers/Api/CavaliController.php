<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CavaliService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Validation\ValidationException;

class CavaliController extends Controller{
    protected $cavaliService;
    public function __construct(CavaliService $cavaliService){
        $this->cavaliService = $cavaliService;
    }
    public function consultarFacturas(Request $request): JsonResponse{
        try {
            $validated = $request->validate([
                'tipo_accion' => 'nullable|integer',
                'tipo_estado' => 'nullable|integer',
                'tipo_fecha' => 'nullable|integer',
                'fecha_desde' => 'nullable|date',
                'fecha_hasta' => 'nullable|date',
                'ruc_proveedor' => 'nullable|numeric',
                'ruc_adquirente' => 'nullable|numeric',
                'serie_factura' => 'nullable|string',
                'numero_factura' => 'nullable|numeric',
            ]);

            $payload = [
                'invoice' => [
                    'actionType'   => $validated['tipo_accion'] ?? 0,
                    'stateType'    => $validated['tipo_estado'] ?? 0,
                    'dateType'     => $validated['tipo_fecha'] ?? 0,
                    'startDate'    => isset($validated['fecha_desde']) ? date('d/m/Y', strtotime($validated['fecha_desde'])) : '01/01/2021',
                    'endDate'      => isset($validated['fecha_hasta']) ? date('d/m/Y', strtotime($validated['fecha_hasta'])) : date('d/m/Y'),
                    'issuerRuc'    => isset($validated['ruc_proveedor']) ? (int) $validated['ruc_proveedor'] : null,
                    'acquirerRuc'  => isset($validated['ruc_adquirente']) ? (int) $validated['ruc_adquirente'] : null,
                    'series'       => $validated['serie_factura'] ?? null,
                    'numeration'   => isset($validated['numero_factura']) ? (int) $validated['numero_factura'] : null,
                ]
            ];

            $payload['invoice'] = array_filter($payload['invoice'], fn($v) => !is_null($v));

            $resultado = $this->cavaliService->consultarFacturas($payload);

            return response()->json([
                'success' => true,
                'data' => $resultado
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error en consulta de facturas: ' . $e->getMessage()
            ], 500);
        }
    }
    public function obtenerResultadoConsulta($consultaId): JsonResponse{
        $resultado = $this->cavaliService->obtenerResultadoConsulta($consultaId);

        if (
            isset($resultado['status']) && $resultado['status'] === 'ERROR' &&
            isset($resultado['body']['message'])
        ) {
            return response()->json([
                'success' => false,
                'error' => $resultado['body']['message']
            ], 200);
        }
        return response()->json([
            'success' => true,
            'data' => $resultado
        ]);
    }
    public function enviarFacturaXML(Request $request): JsonResponse
{
    try {
        $validated = $request->validate([
            'xml' => 'required|file|mimes:xml|max:2048',
        ]);

        $xmlContent = file_get_contents($validated['xml']->getPathname());
        
        // Limpiar la codificación del XML
        $xmlContent = mb_convert_encoding($xmlContent, 'UTF-8', 'UTF-8');
        
        // Estructurar los datos como espera el servicio
        $invoiceData = [
            'invoiceXMLDetail' => $xmlContent,
            // Posiblemente necesites más campos aquí
        ];
        
        $resultado = $this->cavaliService->enviarFacturaXML($invoiceData);
        
        return response()->json([
            'success' => true,
            'data' => $resultado
        ], 200, [], JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
    private function cleanUtf8Array($array){
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_string($value)) {
                    $array[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                } elseif (is_array($value)) {
                    $array[$key] = $this->cleanUtf8Array($value);
                }
            }
        }
        return $array;
    }
    public function probarConexion(): JsonResponse {
        try {
            $respuesta = $this->cavaliService->getAccessToken();
            return response()->json($respuesta);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
