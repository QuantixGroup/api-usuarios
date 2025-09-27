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
            if (!Schema::hasColumn('socios', 'estado_civil')) {
                $table->string('estado_civil')->nullable()->after('estado_civil');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            if (Schema::hasColumn('socios', 'estado_civil')) {
                $table->dropColumn('estado_civil');
            }
        });
    }
};
