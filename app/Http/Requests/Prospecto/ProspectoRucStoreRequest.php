<?php

namespace App\Http\Requests\Prospecto;

use Illuminate\Foundation\Http\FormRequest;

class ProspectoRucStoreRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'sales_executive'                      => ['required', 'string', 'max:255'],
            'ruc'                                  => ['required', 'digits:11', 'unique:suppliers,ruc'],
            'business_name'                        => ['required', 'string', 'max:255'],
            'trade_name'                           => ['nullable', 'string', 'max:255'],
            'address'                              => ['required', 'string', 'max:255'],
            'economic_activity'                    => ['nullable', 'string', 'max:255'],
            'activity_start_date'                  => ['nullable', 'date'],
            'expected_rate'                        => ['nullable', 'numeric'],
            'commission'                           => ['nullable', 'numeric'],
            'contact_person'                       => ['nullable', 'string', 'max:255'],
            'position'                             => ['nullable', 'string', 'max:255'],
            'email'                                => ['nullable', 'email', 'max:255'],
            'website'                              => ['nullable', 'url', 'max:255'],
            'notes'                                => ['nullable', 'string'],

            'dni'                                  => ['nullable', 'string'], //tony
            'ce'                                   => ['nullable', 'string'], //tony
            'nombre'                               => ['nullable', 'string'], //tony
            'fecha_nacimiento'                     => ['nullable', 'date'], //tony
            'sexo'                                 => ['nullable', 'string'], //tony
            'estado_civil'                         => ['nullable', 'string'], //tony
            'numero_movil'                         => ['nullable', 'string'], //tony

            'entidad_apefac'                       => ['nullable', 'string'], //tony
            'endeudamiento_apefac'                 => ['nullable', 'numeric'], //tony
            'endeudamiento_pomedio_6_apefac'       => ['nullable', 'numeric'], //tony
            'entidadcliente_situacion_sf_apefac'   => ['nullable', 'string'], //tony
            'endeudamiento_bancario'               => ['nullable', 'numeric'], //tony
            'cuenta_con_protestos'                 => ['boolean'], //tony
            'protestos'                            => ['nullable', 'numeric'], //tony
            'rl_nombre'                            => ['nullable', 'string'], //tony
            'situacion_sf'                         => ['nullable', 'string'], //tony
            'edad'                                 => ['nullable', 'integer'], //tony
            'comentarios_area_riesgos'             => ['nullable', 'string'], //tony
            'comentarios_area_comercial'           => ['nullable', 'string'], //tony
        ];
    }
}
