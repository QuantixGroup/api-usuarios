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
        Schema::table('socios', function (Blueprint $table) {
            if (Schema::hasColumn('socios', 'nucleo_familiar_detalle')) {
                $table->dropColumn('nucleo_familiar_detalle');
            }
            if (Schema::hasColumn('socios', 'nucleo_familiar')) {
                $table->dropColumn('nucleo_familiar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            if (!Schema::hasColumn('socios', 'nucleo_familiar')) {
                $table->integer('nucleo_familiar')->nullable()->after('estado_civil');
            }
            if (!Schema::hasColumn('socios', 'nucleo_familiar_detalle')) {
                $table->text('nucleo_familiar_detalle')->nullable()->after('nucleo_familiar');
            }
        });
    }
};
