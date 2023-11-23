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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->nullable()->constrained('tipo_documentos')
                ->onDelete('set null')->onUpdate('cascade');
            $table->string('numero_documento',15)->nullable();
            $table->string('nombres');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->unsignedBigInteger('sexo_id')->nullable();
            $table->foreign('sexo_id')->references('id')->on('sexos')
                    ->onDelete('set null')->onUpdate('cascade');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
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
        Schema::dropIfExists('personas');
    }
};
