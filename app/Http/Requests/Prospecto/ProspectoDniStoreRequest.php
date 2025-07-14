<?php

namespace App\Http\Requests\Prospecto;

use Illuminate\Foundation\Http\FormRequest;

class ProspectoDniStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dni' => ['nullable'], //tony
            'activity_start_date' => ['nullable'], 
            'sales_executive' => ['nullable'],
            'nombre' => ['nullable'], //tony
            'address' => ['nullable'],
            'fecha_nacimiento' => ['nullable'], //tony
            'sexo' => ['nullable'], //tony
            'estado_civil' => ['nullable'], //tony
            'expected_rate' => ['nullable'],
            'commission' => ['nullable'],
            'email' => ['nullable'],
            'numero_movil' => ['nullable'], //tony
        ];
    }
}
