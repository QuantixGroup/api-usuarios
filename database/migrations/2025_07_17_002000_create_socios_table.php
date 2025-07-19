<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->string('Cedula')->primary();
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Telefono');
            $table->string('Direccion');
            $table->string('Email')->unique();
            $table->string('Contraseña');
            $table->decimal('IngresoMensual', 10, 2);
            $table->string('Profesion');
            $table->enum('Estado', ['pendiente', 'aprobado', 'rechazado']);
            $table->integer('IntegrantesFamiliares');
            $table->date('FechaIngreso');
            $table->date('FechaEgreso')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
