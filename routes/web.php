<?php

use App\Http\Controllers\Api\ConsultasDni;
use App\Http\Controllers\Api\ConsultasRucController;
use App\Http\Controllers\Web\Ejemplo;
use App\Http\Controllers\Web\Prospecto;
use App\Http\Controllers\Panel\SupplierController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

        Route::resource('Supplier', SupplierController::class);


    Route::prefix('panel')->group(function () {
        Route::get('/comite', [SupplierController::class, 'comite'])->name('Supplier.comite');
        Route::get('/deudor', [SupplierController::class, 'deudor'])->name('Supplier.deudor');
        Route::get('/list', [SupplierController::class, 'list'])->name('Supplier.list');
    });
});

Route::get('/prueba',[Ejemplo::class, 'vista']);
Route::get('/prospecto',[Prospecto::class, 'vista']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
