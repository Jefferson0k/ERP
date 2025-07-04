<?php

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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
