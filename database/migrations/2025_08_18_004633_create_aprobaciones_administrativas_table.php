<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAprobacionesAdministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprobaciones_administrativas', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->string('cedula_adm');
            $table->string('cedula_socio');
            $table->date('fecha');
            $table->enum('tipo', ['registro', 'aporte', 'pago', 'compensacion']);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado']);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('cedula_adm')->references('cedula')->on('admins')->onDelete('cascade');
            $table->foreign('cedula_socio')->references('cedula')->on('socios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aprobaciones_administrativas');
    }
}
