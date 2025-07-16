<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prospecto\ProspectoDniStoreRequest;
use App\Http\Requests\Prospecto\ProspectoCeStoreRequest;
use App\Http\Requests\Prospecto\ProspectoRucStoreRequest;
use App\Http\Requests\Reporte\SunatReporteStoreRequest;
use App\Models\SunatReport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProspectoController extends Controller {

    public function index() {
        return Inertia::render('prospecto/Index', [
            'prospectos' => Supplier::all()
        ]);
    }

    public function prospecto() {
        return inertia('prospecto/Prospecto');
    }

    public function reporte() {
        return inertia('prospecto/Reporte');
    }

    public function guardarRuc(ProspectoRucStoreRequest $request){
        $data = $request->validated();
        $response = Supplier::create($data);
        return response()->json([
            'message' => 'Prospecto created successfully',
            'data' => $response
        ], 201);
    }

    public function guardarDni(ProspectoDniStoreRequest $request){
        $data = $request->validated();
        $response = DB::table('suppliers')->insert($data);
        return response()->json([
            'message' => 'Prospecto created successfully',
            'data' => $response
        ], 201);
    }
    public function guardarCe(ProspectoCeStoreRequest $request){
        $data = $request->validated();
        $response = DB::table('suppliers')->insert($data);
        return response()->json([
            'message' => 'Prospecto created successfully',
            'data' => $response
        ], 201);
    }

    public function guardarSunatReporte(SunatReporteStoreRequest $request){
                Log::debug('This is an irequest.');
        Log::debug($request);
        Log::debug('This is an irequest.');
        $data = $request->validated();

        Log::debug('This is an informational message.');
        Log::debug($data);
        Log::debug('This is an informational message.');
        //$data['registration_date'] = now();
        $response = SunatReport::create($data);
        return response()->json([
            'message' => 'SunatReport created successfully',
            'data' => $response
        ], 201);
    }
}
