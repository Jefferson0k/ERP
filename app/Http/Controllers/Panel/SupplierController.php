<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierStoreRequests;
use App\Http\Resources\Supplier\SupplierList;
use App\Models\SunatFinancial;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller{

    public function index(){
        return Inertia::render('panel/supplier/indexSupplier', [
            'prospects' => Supplier::all()
        ]);
    }
    public function create(){
        return Inertia::render('panel/supplier/components/formSupplier');
    }
    public function comite(){
        return Inertia::render('panel/supplier/components/committee');
    }
    public function deudor(){
        return Inertia::render('panel/supplier/components/deudor');
    }
    public function store(SupplierStoreRequests $request){
        $data = $request->validated();
        $data['registration_date'] = now();
        $supplier = Supplier::create($data);
        return response()->json([
            'message' => 'Supplier created successfully',
            'data' => $supplier
        ], 201);
    }
    public function list(){
        $records = SunatFinancial::with('supplier')->latest()->paginate(10);
        return SupplierList::collection($records);
    }
    public function show(SunatFinancial $sunatFinancial){
        return new SupplierList($sunatFinancial->load('supplier'));
    }
    public function update(Request $request, SunatFinancial $sunatFinancial){
        $data = $request->validate([
            'year' => 'required|integer',
            'ingresos_netos' => 'nullable|numeric',
            'total_activos' => 'nullable|numeric',
            'total_pasivo' => 'nullable|numeric',
            'total_patrimonio' => 'nullable|numeric',
            'capital_social' => 'nullable|numeric',
            'resultado_bruto' => 'nullable|numeric',
            'resultado_antes_imp' => 'nullable|numeric',
            'importe_pagado' => 'nullable|numeric',
        ]);

        $sunatFinancial->update($data);

        return response()->json([
            'message' => 'Registro actualizado correctamente.',
            'data' => new SupplierList($sunatFinancial)
        ]);
    }
    public function destroy(SunatFinancial $sunatFinancial){
        $sunatFinancial->delete();

        return response()->json([
            'message' => 'Registro eliminado correctamente.'
        ]);
    }
}
