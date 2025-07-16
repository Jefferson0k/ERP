<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SunatReport extends Model
{
    use HasFactory;
    protected $table = 'sunat_reports';
    protected $fillable = [
        'supplier_id',
        'ano',
        'nombre_comercial',
        'fecha_inscripcion',
        'fecha_inicio_actividades',
        'estado_contribuyente',
        'condicion_contribuyente',
        'domicilio_fiscal',
        'actividad_comercio_exterior',
        'actividad_economica',
        'ingresos_netos',
        'otros_ingresos',
        'total_activos',
        'total_cuentas_por_pagar',
        'total_pasivo',
        'total_patrimonio',
        'capital_social',
        'resultado_bruto',
        'resultado_antes_imp',
        'importe_pagado',
        'ingreso_12_meses',
        'ingreso_6_meses',
        'promedio_ingreso_12_meses',
        'promedio_ingreso_6_meses',
    ];

    // Relación: Un reporte pertenece a un proveedor
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}