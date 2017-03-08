<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_estudio_socioeconomico');
            $table->integer('id_obra');
            $table->integer('id_estatus');
            $table->integer('id_usuario');
            $table->smallInteger('ejercicio');
            $table->integer('id_anexo_uno');
            $table->integer('id_anexo_dos');
            $table->integer('id_anexo_cinco');
            $table->integer('id_anexo_seis');
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_envio');
            $table->dateTime('fecha_ingreso');
            $table->dateTime('fecha_evaluacion');
            $table->dateTime('fecha_modificacion');
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
        Schema::drop('p_solicitud');
    }
}
