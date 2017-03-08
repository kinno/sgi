<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePMovimientoBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_movimiento_banco', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_estudio_socioeconomico');
            $table->dateTime('fecha_movimiento');
            $table->tinyInteger('id_tipo_movimiento');
            $table->text('observaciones');
            $table->string('status');
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
        Schema::drop('p_movimiento_banco');
    }
}
