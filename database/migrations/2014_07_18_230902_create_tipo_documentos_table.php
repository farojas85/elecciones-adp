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
        Schema::create('tipo_documentos', function (Blueprint $table) {
            $table->id();
            $table->char('tipo',1);
            $table->string('nombre_corto');
            $table->string('nombre_largo');
            $table->unsignedTinyInteger('longitud');
            $table->unsignedTinyInteger('es_activo')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_documentos');
    }
};
