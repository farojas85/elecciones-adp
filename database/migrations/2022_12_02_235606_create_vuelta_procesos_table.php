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
        Schema::create('vuelta_procesos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('abreviatura')->nullable();
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
        Schema::dropIfExists('vuelta_procesos');
    }
};
