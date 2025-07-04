<?php

use App\Http\Controllers\Api\ConsultasDni;
use App\Http\Controllers\Api\ConsultasRucController;
use App\Http\Controllers\Web\Ejemplo;
use App\Http\Controllers\Api\CavaliController;
use App\Http\Controllers\Panel\SupplierController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('Supplier', SupplierController::class);
Route::get('/Supplier/committee', [SupplierController::class, 'committee'])->name('supplier.committee');

Route::prefix('api')->group(function () {
    Route::get('/consultar-dni/{dni?}', [ConsultasDni::class, 'consultar'])->name('consultar.dni');
    Route::get('/consultar-ruc/{ruc?}', [ConsultasRucController::class, 'consultar'])->name('consultar.ruc');
});

Route::get('/prueba',[Ejemplo::class, 'vista']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';