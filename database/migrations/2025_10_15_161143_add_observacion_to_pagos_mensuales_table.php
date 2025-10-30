<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservacionToPagosMensualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagos_mensuales', function (Blueprint $table) {
            $table->text('observacion')->nullable()->after('estado');
        });
    }

    public function down()
    {
        Schema::table('pagos_mensuales', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });
    }
}
