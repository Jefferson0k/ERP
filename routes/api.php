<?php

use App\Http\Controllers\Api\CavaliController;
use App\Http\Controllers\Api\ConsultasDni;
use App\Http\Controllers\Api\SunatController;
use App\Http\Controllers\Api\SunatReportController;
use App\Http\Controllers\Web\ProspectoController;
use Illuminate\Support\Facades\Route;

Route::prefix('cavali')->group(function () {
    Route::post('/consultar-facturas', [CavaliController::class, 'consultarFacturas']);
    Route::get('/consulta/{id}', [CavaliController::class, 'obtenerResultadoConsulta']);
    Route::post('/enviar-factura-xml', [CavaliController::class, 'enviarFacturaXML']);
    Route::get('/probar-conexion', [CavaliController::class, 'probarConexion']);
});

Route::prefix('consultas')->group(function () {
    Route::get('/ruc/{ruc?}', [SunatController::class, 'consultar'])->name('consultar.ruc');
    Route::get('/consultar-dni/{dni?}', [ConsultasDni::class, 'consultar'])->name('consultar.dni');
});

Route::post('/procesar-pdf-sunat', [SunatReportController::class, 'procesar']);

Route::post('/prospecto/guardar_ruc', [ProspectoController::class, 'guardarRuc']);
Route::post('/prospecto/guardar_dni', [ProspectoController::class, 'guardarDni']);
Route::post('/prospecto/guardar_ce', [ProspectoController::class, 'guardarCe']);
Route::post('/prospecto/guardar_sunat_reporte', [ProspectoController::class, 'guardarSunatReporte']);
