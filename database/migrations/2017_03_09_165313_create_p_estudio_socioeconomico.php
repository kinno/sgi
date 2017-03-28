<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePEstudioSocioeconomico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_estudio_socioeconomico', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('ejercicio')->nullable();
            $table->unsignedInteger('id_anexo_uno_estudio')->nullable();
            $table->unsignedInteger('id_anexo_dos_estudio')->nullable();
            $table->integer('id_estatus');
            $table->unsignedInteger('id_tipo_evaluacion')->nullable();
            $table->string('dictamen')->nullable();
            $table->dateTime('fecha_registro');
            $table->dateTime('fecha_ingreso')->nullable();
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
        Schema::drop('p_estudio_socioeconomico');
    }
}
