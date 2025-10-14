<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('cedula')->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento');
            $table->string('telefono');
            $table->string('direccion');
            $table->string('departamento');
            $table->string('ciudad');
            $table->string('email')->unique();
            $table->string('foto_perfil')->nullable();
            $table->string('contraseña')->nullable();
            $table->decimal('ingreso_mensual', 10, 2);
            $table->enum('situacion_laboral', ['Empleado/a', 'Desempleado/a', 'Independiente']);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->string('estado_civil')->nullable();
            $table->enum('integrantes_familiares', ['1', '2', '3', '4+']);
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_egreso')->nullable();
            $table->text('motivacion')->nullable();
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
