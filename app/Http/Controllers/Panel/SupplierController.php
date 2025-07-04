<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierStoreRequests;
use App\Models\Supplier;
use Inertia\Inertia;

class SupplierController extends Controller{
    public function index(){
        return Inertia::render('panel/supplier/indexSupplier');
    }
    public function create(){
        return Inertia::render('panel/supplier/components/formSupplier');
    }
    public function store(SupplierStoreRequests $request){
        $supplier = Supplier::create($request->validated());
        return response()->json([
            'message' => 'Supplier created successfully',
            'data' => $supplier
        ], 201);
    }
}
