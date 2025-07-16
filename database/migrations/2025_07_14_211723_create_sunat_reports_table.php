<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunat_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('ano');
            $table->string('nombre_comercial')->nullable();
            $table->date('fecha_inscripcion')->nullable();
            $table->date('fecha_inicio_actividades')->nullable();
            $table->string('estado_contribuyente')->nullable();
            $table->string('condicion_contribuyente')->nullable();
            $table->string('domicilio_fiscal')->nullable();
            $table->string('actividad_comercio_exterior')->nullable();
            $table->string('actividad_economica')->nullable();
            $table->decimal('ingresos_netos', 15, 2)->nullable();
            $table->decimal('otros_ingresos', 15, 2)->nullable();
            $table->decimal('total_activos', 15, 2)->nullable();
            $table->decimal('total_cuentas_por_pagar', 15, 2)->nullable();
            $table->decimal('total_pasivo', 15, 2)->nullable();
            $table->decimal('total_patrimonio', 15, 2)->nullable();
            $table->decimal('capital_social', 15, 2)->nullable();
            $table->decimal('resultado_bruto', 15, 2)->nullable();
            $table->decimal('resultado_antes_imp', 15, 2)->nullable();
            $table->decimal('importe_pagado', 15, 2)->nullable();
            $table->decimal('ingreso_12_meses', 15, 2)->nullable();
            $table->decimal('ingreso_6_meses', 15, 2)->nullable();
            $table->decimal('promedio_ingreso_12_meses', 15, 2)->nullable();
            $table->decimal('promedio_ingreso_6_meses', 15, 2)->nullable();
            $table->timestamps();
            //$table->unique(['supplier_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sunat_reports');
    }
};
