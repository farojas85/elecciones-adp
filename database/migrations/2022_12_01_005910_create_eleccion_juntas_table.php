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
        Schema::create('eleccion_juntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periodo_junta_id')->nullable()->constrained('periodo_juntas','id')
                ->onDelete('cascade')->onDelete('cascade');
            $table->foreignId('junta_directiva_id')->nullable()->constrained('junta_directivas','id')
                ->onDelete('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('eleccion_juntas');
    }
};
