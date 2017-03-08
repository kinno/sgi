<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelSolicitudBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_solicitud_banco', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->integer('id_estudio_socioeconomico');
            $table->integer('id_estado');
            $table->string('dictamen');
            $table->dateTime('fecha_registro');
            $table->dateTime('fecha_ingreso');
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
        Schema::drop('rel_solicitud_banco');
    }
}
