<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosMensualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_mensuales', function (Blueprint $table) {
            $table->id('id_pago');
            $table->string('cedula');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_comprobante');
            $table->string('archivo_comprobante')->nullable();
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->timestamps();

            $table->foreign('cedula')->references('cedula')->on('socios')->onDelete('cascade');
            $table->index(['mes', 'anio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_mensuales');
    }
}
