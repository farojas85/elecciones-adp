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
        Schema::create('grado_ministerial_ministro', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('grado_ministerial_id')->nullable()->constrained('grado_ministeriales','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ministro_id')->nullable()->constrained('ministros','id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->unsignedTinyInteger('es_activo')->nullable();
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
        Schema::dropIfExists('grado_ministerial_ministro');
    }
};
