<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('sunat_financials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('year', 4);
            $table->decimal('ingresos_netos', 15, 2)->nullable();
            $table->decimal('total_activos', 15, 2)->nullable();
            $table->decimal('total_pasivo', 15, 2)->nullable();
            $table->decimal('total_patrimonio', 15, 2)->nullable();
            $table->decimal('capital_social', 15, 2)->nullable();
            $table->decimal('resultado_bruto', 15, 2)->nullable();
            $table->decimal('resultado_antes_imp', 15, 2)->nullable();
            $table->decimal('importe_pagado', 15, 2)->nullable();
            $table->timestamps();
            $table->unique(['supplier_id', 'year']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sunat_financials');
    }
};
