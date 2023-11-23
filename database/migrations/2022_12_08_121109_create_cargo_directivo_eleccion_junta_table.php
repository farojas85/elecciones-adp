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
        Schema::create('cargo_directivo_eleccion_junta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cargo_directivo_id')->nullable()->constrained('cargo_directivos','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('eleccion_junta_id')->nullable()->constrained('eleccion_juntas','id')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('cargo_directivo_eleccion_junta');
    }
};
