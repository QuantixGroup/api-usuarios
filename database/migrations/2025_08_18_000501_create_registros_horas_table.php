<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosHorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_horas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cedula');
            $table->date('fecha');
            $table->decimal('conteo_de_horas', 5, 2);
            $table->string('tipo_trabajo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('comprobante_compensacion')->nullable();
            $table->decimal('monto_compensacion', 10, 2)->nullable();
            $table->date('fecha_compensacion')->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->timestamps();

            $table->foreign('cedula')->references('cedula')->on('socios')->onDelete('cascade');
            $table->index('cedula');
            $table->index('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros_horas');
    }
}
