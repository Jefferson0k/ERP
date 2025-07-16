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

    Route::resource('Supplier', SupplierController::class);
    Route::prefix('panel')->group(function () {
        Route::get('/comite', [SupplierController::class, 'comite'])->name('Supplier.comite');
        Route::get('/deudor', [SupplierController::class, 'deudor'])->name('Supplier.deudor');
        Route::get('/list', [SupplierController::class, 'list'])->name('Supplier.list');
    });


    Route::get('/prospectos', [ProspectoController::class, 'index'])->name('prospecto');
    Route::prefix('prospectos')->group(function () {
        Route::get('/prospecto', [ProspectoController::class, 'prospecto'])->name('prospecto.reporte');
        Route::get('/prospecto/reporte', [ProspectoController::class, 'reporte'])->name('prospecto.reporte');
    });

    Route::get('/comite', [ComiteController::class, 'index'])->name('comite');
    Route::prefix('comite')->group(function () {
        Route::get('/factoring-a/{id}', [ComiteController::class, 'factoringA'])->name('comite.factoring.a');
        Route::get('/factoring-b', [ComiteController::class, 'factoringB'])->name('comite.factoring.b');
        Route::get('/confirming', [ComiteController::class, 'confirming'])->name('comite.confirming');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
