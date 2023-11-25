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
        Schema::create('registro_mesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users','id')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('proceso_electoral_id')->nullable()->constrained('proceso_electorals','id')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('eleccion_junta_candidato_id')->nullable()->constrained('eleccion_junta_candidatos','id')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedSmallInteger('cantidad_votos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_mesas');
    }
};
