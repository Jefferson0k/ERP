<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SunatReport;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ComiteController extends Controller {
    public function index() {
        return Inertia::render('comite/Index', [
            'prospectos' => Supplier::all()
        ]);
    }
    public function factoringA(int $id) {
        //$datos = Http::get("http://127.0.0.1:8000/api/consultas/ruc/{$ruc}");
        $prospecto = DB::table('suppliers')->where('id', $id)->get();
        Log::debug($prospecto);
        $reporte = SunatReport::first();
        return Inertia::render('comite/FactoringA', [
            'id' => $id,
            'prospecto' => $prospecto,
            'reporte' => $reporte,
        ]);
    }
    public function factoringB() {
        return Inertia::render('comite/FactoringB');
    }
    public function confirming() {
        return Inertia::render('comite/Confirming');
    }
}