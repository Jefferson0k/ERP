<?php

namespace App\Http\Resources\Supplier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierList extends JsonResource{
    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'year' => $this->year,
            'ingresos_netos' => $this->ingresos_netos,
            'total_activos' => $this->total_activos,
            'total_pasivo' => $this->total_pasivo,
            'total_patrimonio' => $this->total_patrimonio,
            'capital_social' => $this->capital_social,
            'resultado_bruto' => $this->resultado_bruto,
            'resultado_antes_imp' => $this->resultado_antes_imp,
            'importe_pagado' => $this->importe_pagado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
