<?php

use App\Http\Controllers\Panel\SupplierController;
use App\Http\Controllers\Web\ComiteController;
use App\Http\Controllers\Web\ProspectoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    /*Route::get('/prospectos', function () {
        return Inertia::render('prospecto/Index');
    })->name('dashboard');*/

    Route::resource('Supplier', SupplierController::class);
    Route::prefix('panel')->group(function () {
        Route::get('/comite', [SupplierController::class, 'comite'])->name('Supplier.comite');
        Route::get('/deudor', [SupplierController::class, 'deudor'])->name('Supplier.deudor');
        Route::get('/list', [SupplierController::class, 'list'])->name('Supplier.list');
    });


    Route::get('/prospectos', [ProspectoController::class, 'index'])->name('prospecto');
    Route::prefix('prospectos')->group(function () {
        Route::get('/prospecto', [ProspectoController::class, 'prospecto'])->name('prospecto.reporte');
        Route::get('/prospecto/reporte/{id}', [ProspectoController::class, 'reporte'])->name('prospecto.reporte');
        Route::get('/prospecto/aceptante/{id}', [ProspectoController::class, 'aceptante'])->name('prospecto.aceptante');
    });

    Route::get('/comite', [ComiteController::class, 'index'])->name('comite');
    Route::prefix('comite')->group(function () {
        Route::get('/factoring/cliente/{id}', [ComiteController::class, 'factoringCliente'])->name('comite.factoring.cliente');
        Route::get('/factoring/aceptante/{id}', [ComiteController::class, 'factoringAceptante'])->name('comite.factoring.aceptante');
        Route::get('/confirming/{id}', [ComiteController::class, 'confirming'])->name('comite.confirming');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
