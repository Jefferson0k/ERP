<?php

namespace App\Http\Resources\Supplier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierList extends JsonResource{
    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
        ];
    }
}
