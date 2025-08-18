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
            $table->id('id_horas');
            $table->string('cedula');
            $table->integer('conteo_de_horas');
            $table->date('fecha');
            $table->string('comprobante_compensacion')->nullable();
            $table->decimal('monto_compensacion', 10, 2)->nullable();
            $table->date('fecha_compensacion')->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado']);
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
        Schema::dropIfExists('registros_horas');
    }
}
