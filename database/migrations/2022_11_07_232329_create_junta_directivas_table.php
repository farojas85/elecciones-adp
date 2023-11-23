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
        Schema::create('junta_directivas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ambito_junta_id')->nullable()
                ->constrained('ambito_juntas')->onUpdate('cascade')->onDelete('set null');
            $table->string('nombre');
            $table->string('ubigeo',6)->nullable();
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
        Schema::dropIfExists('junta_directivas');
    }
};
