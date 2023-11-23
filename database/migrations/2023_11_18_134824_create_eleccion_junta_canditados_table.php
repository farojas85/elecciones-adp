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
        Schema::create('eleccion_junta_candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleccion_junta_id')->nullable()->constrained('eleccion_juntas','id')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('ministro_id')->nullable()->constrained('ministros','id')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedSmallInteger('numero_candidato');
            $table->unsignedTinyInteger('es_activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleccion_junta_candidatos');
    }
};
