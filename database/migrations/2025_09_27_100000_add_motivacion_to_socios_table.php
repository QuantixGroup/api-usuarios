<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            if (!Schema::hasColumn('socios', 'motivacion')) {
                $table->text('motivacion')->nullable()->after('fecha_egreso');
            }
        });
    }

    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            if (Schema::hasColumn('socios', 'motivacion')) {
                $table->dropColumn('motivacion');
            }
        });
    }
};
