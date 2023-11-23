<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_electorals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cargo_directivo_eleccion_junta_id')->nullable()->constrained('cargo_directivo_eleccion_junta','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('vuelta_proceso_id')->nullable()->constrained('vuelta_procesos','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedTinyInteger('votos_validos')->default(0);
            $table->unsignedTinyInteger('votos_emitidos')->default(0);
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->unsignedTinyInteger('es_activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proceso_electorals');
    }
};
