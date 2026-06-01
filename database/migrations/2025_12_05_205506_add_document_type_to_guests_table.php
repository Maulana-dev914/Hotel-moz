<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->enum('document_type', ['bi', 'passport', 'driving_license', 'nuit', 'company_registration'])->nullable()->after('document');
            $table->string('document')->nullable()->change(); // Tornar nullable e remover unique temporariamente
        });
        
        // Remover unique constraint se existir
        Schema::table('guests', function (Blueprint $table) {
            $table->dropUnique(['document']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('document_type');
            $table->string('document')->nullable(false)->change();
        });
    }
};
