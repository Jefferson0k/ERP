<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prospecto\ProspectoUpdateRequest;
use App\Http\Requests\Supplier\SupplierStoreRequests;
use App\Models\SunatReport;
use App\Models\Supplier;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ComiteController extends Controller {
    public function index() {
        return Inertia::render('comite/Index', [
            'prospectos' => Supplier::whereIn('tipo', ['Confirming', 'Factoring'])->get()
        ]);
    }
    public function factoringCliente(int $id) {
        //$datos = Http::get("http://127.0.0.1:8000/api/consultas/ruc/{$ruc}");
        $prospecto = DB::table('suppliers')->where('id', $id)->get();
        $reporte = SunatReport::first();
        return Inertia::render('comite/FactoringCliente', [
            'id' => $id,
            'prospecto' => $prospecto,
            'reporte' => $reporte,
        ]);
    }
    public function factoringAceptante(int $id) {
        $prospecto = DB::table('suppliers')->where('id_factoring', $id)->get();
        $reporte = SunatReport::first();
        return Inertia::render('comite/FactoringAceptante', [
            'id' => $id,
            'prospecto' => $prospecto,
            'reporte' => $reporte,
        ]);
    }
    public function confirming(int $id) {
        $prospecto = DB::table('suppliers')->where('id', $id)->get();
        $reporte = SunatReport::first();
        return Inertia::render('comite/Confirming', [
            'id' => $id,
            'prospecto' => $prospecto,
            'reporte' => $reporte,
        ]);
    }
    public function actualizar(SupplierStoreRequests $request, int $id) {
        $data = $request->validated();
        $prospecto = Supplier::findOrFail($id);
        $prospecto->update($data);
        return response()->json([
            'message' => 'Prospecto updated successfully',
            'data' => 'ok'
        ], 201);
    }
    public function actualizarArreglo(SupplierStoreRequests $request, int $id) {
        /*$data = $request->validate([
            'prospecto' => 'array',
        ]);
        $prospecto = Supplier::findOrFail($id);
        $prospecto->prospecto = $data['prospecto'];
        $prospecto->save();
        return response()->json([
            'message' => 'Prospecto actualizado',
            'data' => 'ok',
        ], 201);*/
    }
}