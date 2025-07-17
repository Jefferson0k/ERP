<?php

namespace App\Http\Requests\Prospecto;

use Illuminate\Foundation\Http\FormRequest;

class ProspectoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'entidad_apefac' => ['nullable', 'string'],
        ];
    }
}
