<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePEvaluacionEstudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_evaluacion_estudio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sub_indice');
            $table->boolean('brespuesta');
            $table->text('observaciones');
            $table->string('pagina');
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
        Schema::drop('p_evaluacion_estudio');
    }
}
