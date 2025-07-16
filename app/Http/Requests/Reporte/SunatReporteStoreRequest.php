<?php

namespace App\Http\Requests\Reporte;

use Illuminate\Foundation\Http\FormRequest;

class SunatReporteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'ano' => 'nullable|string',
            'nombre_comercial' => 'nullable|string',
            'fecha_inscripcion' => 'nullable|date',
            'fecha_inicio_actividades' => 'nullable|date',
            'estado_contribuyente' => 'nullable|string',
            'condicion_contribuyente' => 'nullable|string',
            'domicilio_fiscal' => 'nullable|string',
            'actividad_comercio_exterior' => 'nullable|string',
            'actividad_economica' => 'nullable|string',
            'ingresos_netos' => 'nullable|numeric',
            'otros_ingresos' => 'nullable|numeric',
            'total_activos' => 'nullable|numeric',
            'total_cuentas_por_pagar' => 'nullable|numeric',
            'total_pasivo' => 'nullable|numeric',
            'total_patrimonio' => 'nullable|numeric',
            'capital_social' => 'nullable|numeric',
            'resultado_bruto' => 'nullable|numeric',
            'resultado_antes_imp' => 'nullable|numeric',
            'importe_pagado' => 'nullable|numeric',
            'ingreso_12_meses' => 'nullable|numeric',
            'ingreso_6_meses' => 'nullable|numeric',
            'promedio_ingreso_12_meses' => 'nullable|numeric',
            'promedio_ingreso_6_meses' => 'nullable|numeric',
        ];
    }
}
