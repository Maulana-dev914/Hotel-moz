<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('max_adults')->default(2)->after('type');
            $table->integer('max_children')->default(0)->after('max_adults');
        });

        // Atualizar valores padrão baseado no tipo
        DB::statement("UPDATE rooms SET max_adults = 1, max_children = 0 WHERE type = 'single'");
        DB::statement("UPDATE rooms SET max_adults = 2, max_children = 0 WHERE type = 'double'");
        DB::statement("UPDATE rooms SET max_adults = 2, max_children = 1 WHERE type = 'matrimonial'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['max_adults', 'max_children']);
        });
    }
};
