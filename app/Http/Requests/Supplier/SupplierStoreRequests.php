<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequests extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'sales_executive'       => ['required', 'string', 'max:255'],
            'ruc'                   => ['required', 'digits:11', 'unique:suppliers,ruc'],
            'business_name'         => ['required', 'string', 'max:255'],
            'trade_name'            => ['nullable', 'string', 'max:255'],
            'address'               => ['required', 'string', 'max:255'],
            'economic_activity'     => ['nullable', 'string', 'max:255'],
            'activity_start_date'   => ['nullable', 'date'],
            'expected_rate'         => ['nullable', 'numeric'],
            'commission'            => ['nullable', 'numeric'],
            'contact_person'        => ['nullable', 'string', 'max:255'],
            'position'              => ['nullable', 'string', 'max:255'],
            'email'                 => ['nullable', 'email', 'max:255'],
            'website'               => ['nullable', 'url', 'max:255'],
            'notes'                 => ['nullable', 'string'],

            'dni'                   => ['required', 'digits:8'],
        ];
    }
}
