<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class Ejemplo extends Controller{
    public function vista(){
        return inertia('Ejemplo/index');
    }
}
