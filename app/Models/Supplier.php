<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model{
    use HasFactory;
    protected $fillable = [
        'registration_date',
        'sales_executive',
        'ruc',
        'business_name',
        'trade_name',
        'address',
        'economic_activity',
        'activity_start_date',
        'expected_rate',
        'commission',
        'contact_person',
        'position',
        'email',
        'website',
        'notes',

        'dni', //tony
        'ce', //tony
        'nombre', //tony
        'fecha_nacimiento', //tony
        'sexo', //tony
        'estado_civil', //tony
        'numero_movil', //tony

        'entidad_apefac', //tony
        'endeudamiento_apefac', //tony
        'endeudamiento_pomedio_6_apefac', //tony
        'entidadcliente_situacion_sf_apefac', //tony
        'endeudamiento_bancario', //tony
        'cuenta_con_protestos', //tony
        'protestos', //tony
        'rl_nombre', //tony
        'situacion_sf', //tony
        'edad', //tony
        'comentarios_area_riesgos', //tony
        'comentarios_area_comercial', //tony
    ];
}
