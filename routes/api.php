<?php

use App\Http\Controllers\Api\CavaliController;
use App\Http\Controllers\Api\SunatController;
use Illuminate\Support\Facades\Route;

Route::prefix('cavali')->group(function () {
    Route::post('/consultar-facturas', [CavaliController::class, 'consultarFacturas']);
    Route::get('/consulta/{id}', [CavaliController::class, 'obtenerResultadoConsulta']);
    Route::post('/enviar-factura-xml', [CavaliController::class, 'enviarFacturaXML']);
    Route::get('/probar-conexion', [CavaliController::class, 'probarConexion']);
});

Route::prefix('consultas')->group(function () {
    Route::get('/ruc/{ruc?}', [SunatController::class, 'consultar'])->name('consultar.ruc');
});
