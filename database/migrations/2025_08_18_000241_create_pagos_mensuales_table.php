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
            $table->string('archivo_comprobante')->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado']);
            $table->date('fecha_comprobante');
            $table->timestamps();

            $table->foreign('cedula')->references('cedula')->on('socios')->onDelete('cascade');
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
