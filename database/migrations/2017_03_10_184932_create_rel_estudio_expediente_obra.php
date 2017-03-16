<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelEstudioExpedienteObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_estudio_expediente_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_estudio_socioeconomico')->nullable();
            $table->unsignedInteger('id_expediente_tecnico')->nullable();
            $table->unsignedInteger('id_obra')->nullable();
            $table->smallInteger('ejercicio')->nullable();
            $table->unsignedInteger('id_usuario')->nullable();
            $table->timestamps();

            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_estudio_expediente_obra');
    }
}
