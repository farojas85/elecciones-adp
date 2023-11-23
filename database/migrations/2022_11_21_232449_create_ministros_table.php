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
        Schema::create('ministros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->nullable()->constrained('personas','id')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->string('foto')->default('foto.png');
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
        Schema::dropIfExists('ministros');
    }
};
