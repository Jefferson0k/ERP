<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SunatFinancial extends Model{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'year',
        'ingresos_netos',
        'total_activos',
        'total_pasivo',
        'total_patrimonio',
        'capital_social',
        'resultado_bruto',
        'resultado_antes_imp',
        'importe_pagado',
    ];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
