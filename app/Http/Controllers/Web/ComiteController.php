<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ComiteController extends Controller {
    public function index() {
        return inertia('comite/Index');
    }
}