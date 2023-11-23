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
        Schema::create('proceso_electoral_votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proceso_electoral_id')->nullable()->constrained('proceso_electorals','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedSmallInteger('orden');
            $table->foreignId('ministro_id')->nullable()->constrained('ministros','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedSmallInteger('cantidad_votos')->default(0);
            $table->unsignedTinyInteger('no_continua')->default(0);
            $table->unsignedTinyInteger('pasa_vuelta')->default(0);
            $table->unsignedTinyInteger('es_ganador')->default(0);
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
        Schema::dropIfExists('proceso_electoral_votos');
    }
};
