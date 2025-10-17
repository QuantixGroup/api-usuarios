<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesHabitacionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones_habitacionales', function (Blueprint $table) {
            $table->unsignedInteger('cedula');
            $table->unsignedBigInteger('id_unidad');
            $table->date('fecha_asignacion');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado']);
            $table->timestamps();

            $table->primary(['cedula', 'id_unidad']);
            $table->foreign('cedula')->references('cedula')->on('socios')->onDelete('cascade');
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades_habitacionales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaciones_habitacionales');
    }
}
