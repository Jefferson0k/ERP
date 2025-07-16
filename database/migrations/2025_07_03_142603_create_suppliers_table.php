<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->date('registration_date')->nullable();
            $table->string('sales_executive')->nullable();
            $table->string('ruc', 20)->unique()->nullable();
            $table->string('business_name')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('address')->nullable();
            $table->string('economic_activity')->nullable();
            $table->date('activity_start_date')->nullable();
            $table->string('expected_rate')->nullable();
            $table->string('commission')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->string('dni', 20)->unique()->nullable(); //tony
            $table->string('ce', 20)->unique()->nullable(); //tony
            $table->string('nombre')->nullable(); //tony
            $table->date('fecha_nacimiento')->nullable(); //tony
            $table->string('sexo')->nullable(); //tony
            $table->string('estado_civil')->nullable(); //tony
            $table->string('numero_movil')->nullable(); //tony

            $table->string('entidad_apefac')->nullable(); //tony
            $table->decimal('endeudamiento_apefac', 15, 2)->nullable(); //tony
            $table->decimal('endeudamiento_pomedio_6_apefac', 15, 2)->nullable(); //tony
            $table->string('entidadcliente_situacion_sf_apefac')->nullable(); //tony
            $table->decimal('endeudamiento_bancario', 15, 2)->nullable(); //tony
            $table->boolean('cuenta_con_protestos')->default(false); //tony
            $table->decimal('protestos', 15, 2)->nullable(); //tony
            $table->string('rl_nombre')->nullable(); //tony
            $table->string('situacion_sf')->nullable(); //tony
            $table->integer('edad')->nullable(); //tony
            $table->text('comentarios_area_riesgos')->nullable(); //tony
            $table->text('comentarios_area_comercial')->nullable(); //tony
        });
    }

    public function down(): void{
        Schema::dropIfExists('suppliers');
    }
};
