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
        Schema::table('proceso_electorals', function (Blueprint $table) {
            $table->unsignedSmallInteger('votos_blancos')->nullable()->after('votos_emitidos');
            $table->unsignedSmallInteger('votos_validos')->change();
            $table->unsignedSmallInteger('votos_emitidos')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proceso_electorals', function (Blueprint $table) {
            $table->dropColumn('votos_blancos');
            $table->unsignedTinyInteger('votos_validos')->change();
            $table->unsignedTinyInteger('votos_emitidos')->change();
        });
    }
};
