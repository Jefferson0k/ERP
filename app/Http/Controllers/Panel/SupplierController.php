<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierStoreRequests;
use App\Models\Supplier;

class SupplierController extends Controller{
    public function store(SupplierStoreRequests $request){
        $supplier = Supplier::create($request->validated());
        return response()->json([
            'message' => 'Supplier created successfully',
            'data' => $supplier
        ], 201);
    }
}
