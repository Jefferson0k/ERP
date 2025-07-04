<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CavaliService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class CavaliController extends Controller{
    protected $cavaliService;
    public function __construct(CavaliService $cavaliService){
        $this->cavaliService = $cavaliService;
    }
    public function consultarFacturas(Request $request): JsonResponse{
        try {
            $validated = $request->validate([
                'tipo_accion' => 'nullable|string',
                'tipo_estado' => 'nullable|string',
                'tipo_fecha' => 'nullable|string',
                'fecha_desde' => 'nullable|date',
                'fecha_hasta' => 'nullable|date',
                'ruc_proveedor' => 'nullable|string',
                'ruc_adquirente' => 'nullable|string',
                'serie_factura' => 'nullable|string',
                'numero_factura' => 'nullable|string',
            ]);

            $filtros = [
                'tipoAccion' => $validated['tipo_accion'] ?? 'Todos',
                'tipoEstado' => $validated['tipo_estado'] ?? 'Todos',
                'tipoFecha' => $validated['tipo_fecha'] ?? 'Fecha de registro',
                'fechaDesde' => $validated['fecha_desde'] ?? '01/01/2021',
                'fechaHasta' => $validated['fecha_hasta'] ?? date('d/m/Y'),
                'rucProveedor' => $validated['ruc_proveedor'] ?? '',
                'rucAdquirente' => $validated['ruc_adquirente'] ?? '',
                'serieFactura' => $validated['serie_factura'] ?? '',
                'numeroFactura' => $validated['numero_factura'] ?? '',
            ];

            $resultado = $this->cavaliService->consultarFacturas($filtros);

            return response()->json([
                'success' => true,
                'data' => $resultado
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function obtenerResultadoConsulta($consultaId): JsonResponse{
        try {
            $resultado = $this->cavaliService->obtenerResultadoConsulta($consultaId);

            return response()->json([
                'success' => true,
                'data' => $resultado
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function enviarFacturaXML(Request $request): JsonResponse{
        try {
            $validated = $request->validate([
                'xml_data' => 'required|string',
            ]);

            $resultado = $this->cavaliService->enviarFacturaXML($validated);

            return response()->json([
                'success' => true,
                'data' => $resultado
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function probarConexion(): JsonResponse{
        try {
            $token = $this->cavaliService->getAccessToken();
            
            return response()->json([
                'success' => true,
                'message' => 'Conexión exitosa con CAVALI',
                'token_obtenido' => !empty($token)
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage()
            ], 500);
        }
    }
}