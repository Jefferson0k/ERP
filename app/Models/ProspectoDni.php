<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectoDni extends Model{
    use HasFactory;
    protected $fillable = [
        'dni', //tony
        'activity_start_date', 
        'sales_executive',
        'nombre', //tony
        'address',
        'fecha_nacimiento', //tony
        'sexo', //tony
        'estado_civil', //tony
        'expected_rate',
        'commission',
        'email',
        'numero_movil', //tony
    ];
}

