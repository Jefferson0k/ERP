<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class Prospecto extends Controller {
    public function index() {
        return inertia('prospecto/index');
    }
    public function reporte() {
        return inertia('prospecto/components/reporte');
    }
}
