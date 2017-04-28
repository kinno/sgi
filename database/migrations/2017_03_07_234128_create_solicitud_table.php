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
        Schema::create('p_expediente_tecnico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_estudio_socioeconomico')->nullable();
            $table->unsignedInteger('id_obra')->nullable();
            $table->unsignedInteger('id_tipo_solicitud')->nullable();
            $table->unsignedInteger('id_estatus');
            $table->unsignedInteger('id_usuario');
            $table->smallInteger('ejercicio');
            $table->unsignedInteger('id_anexo_uno')->nullable();
            $table->unsignedInteger('id_anexo_dos')->nullable();
            $table->unsignedInteger('id_anexo_cinco')->nullable();
            $table->unsignedInteger('id_anexo_seis')->nullable();
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_envio')->nullable();
            $table->dateTime('fecha_ingreso')->nullable();
            $table->dateTime('fecha_evaluacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
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
        Schema::drop('p_expediente_tecnico');
    }
}
