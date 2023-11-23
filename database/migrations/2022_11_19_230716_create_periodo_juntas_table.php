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
        Schema::create('periodo_juntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('anio_inicio');
            $table->unsignedSmallInteger('anio_fin');
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
        Schema::dropIfExists('perido_juntas');
    }
};
