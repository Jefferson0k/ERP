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

        'dni',
        'ce',
        'tipo_documento',
        'tipo',
        'id_factoring',

        'fecha_reporte_tributario',
        'fecha_sentinel',
        'top',
        'ventas_aproximadas',
        'nombre',
        'fecha_nacimiento',
        'sexo',
        'estado_civil',
        'numero_movil',

        'entidad_apefac',
        'endeudamiento_apefac',
        'endeudamiento_pomedio_6_apefac',
        'cliente_situacion_sf',
        'endeudamiento_bancario',
        'cuenta_con_protestos',
        'protestos',
        'rl_nombre',
        'situacion_sf',
        'edad',
        'comentarios_area_riesgos',
        'comentarios_area_comercial',
        'comentarios_area_operaciones',

        'linea_cliente_sugerido',
        'anticipo_sugerido',
        'monto_comision_sugerido',
        'tasa_tem_sugerido',
        'adelanto_sugerido',
        'linea_adelanto_sugerido',
        'linea_cliente_definitivo',
        'anticipo_definitivo',
        'monto_comision_definitivo',
        'tasa_tem_definitivo',
        'adelanto_definitivo',
        'linea_adelanto_definitivo',
    ];
}
