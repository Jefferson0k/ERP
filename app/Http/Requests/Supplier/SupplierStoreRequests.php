<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequests extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'registration_date' => ['nullable', 'date'],
            'sales_executive' => ['nullable', 'string'],
            'ruc' => ['nullable', 'string', 'unique:suppliers,ruc'],
            'business_name' => ['nullable', 'string'],
            'trade_name' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'economic_activity' => ['nullable', 'string'],
            'activity_start_date' => ['nullable', 'date'],
            'expected_rate' => ['nullable', 'string'],
            'commission' => ['nullable', 'string'],
            'contact_person' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            'dni' => ['nullable', 'string', 'unique:suppliers,dni'],
            'ce' => ['nullable', 'string', 'unique:suppliers,ce'],
            'tipo_documento' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string'],
            'id_factoring' => ['nullable', 'integer'],

            'fecha_reporte_tributario' => ['nullable', 'date'],
            'fecha_sentinel' => ['nullable', 'date'],
            'top' => ['nullable', 'integer'],
            'ventas_aproximadas' => ['nullable', 'numeric'],

            'nombre' => ['nullable', 'string'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'sexo' => ['nullable', 'string'],
            'estado_civil' => ['nullable', 'string'],
            'numero_movil' => ['nullable', 'string'],

            'entidad_apefac' => ['nullable', 'string'],
            'endeudamiento_apefac' => ['nullable', 'numeric'],
            'endeudamiento_pomedio_6_apefac' => ['nullable', 'numeric'],
            'cliente_situacion_sf' => ['nullable', 'string'],
            'endeudamiento_bancario' => ['nullable', 'numeric'],
            'cuenta_con_protestos' => ['nullable', 'boolean'],
            'protestos' => ['nullable', 'numeric'],
            'rl_nombre' => ['nullable', 'string'],
            'situacion_sf' => ['nullable', 'string'],
            'edad' => ['nullable', 'integer'],
            'comentarios_area_riesgos' => ['nullable', 'string'],
            'comentarios_area_comercial' => ['nullable', 'string'],
            'comentarios_area_operaciones' => ['nullable', 'string'],

            'linea_cliente_sugerido' => ['nullable', 'numeric'],
            'anticipo_sugerido' => ['nullable', 'numeric'],
            'monto_comision_sugerido' => ['nullable', 'numeric'],
            'tasa_tem_sugerido' => ['nullable', 'numeric'],
            'adelanto_sugerido' => ['nullable', 'numeric'],
            'linea_adelanto_sugerido' => ['nullable', 'numeric'],
            'linea_cliente_definitivo' => ['nullable', 'numeric'],
            'anticipo_definitivo' => ['nullable', 'numeric'],
            'monto_comision_definitivo' => ['nullable', 'numeric'],
            'tasa_tem_definitivo' => ['nullable', 'numeric'],
            'adelanto_definitivo' => ['nullable', 'numeric'],
            'linea_adelanto_definitivo' => ['nullable', 'numeric'],
        ];
    }
}