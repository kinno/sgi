<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePEvaluacionExpediente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('p_evaluacion_expediente', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_expediente_tecnico');
            $table->dateTime('fecha_observacion');
             $table->text('observaciones');
             $table->unsignedInteger('id_usuario');
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
        Schema::drop('p_evaluacion_expediente');
    }
}
