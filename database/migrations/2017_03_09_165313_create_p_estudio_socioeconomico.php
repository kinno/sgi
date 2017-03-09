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
            $table->unsignedInteger('id_anexo_uno');
            $table->unsignedInteger('id_anexo_dos');
            $table->integer('id_estatus');
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
        Schema::drop('p_estudio_socioeconomico');
    }
}
