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
        Schema::table('ministros', function (Blueprint $table) {
            $table->foreignId('grado_ministerial_id')->nullable()->after('persona_id')
            ->constrained('grado_ministeriales','id')
            ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ministros', function (Blueprint $table) {
            $table->dropForeign('ministros_grado_ministerial_id_foreign');
            $table->dropColumn('grado_ministerial_id');
        });
    }
};
