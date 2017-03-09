<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePAnexoSeis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p_anexo_seis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->text('criterios_sociales');
            $table->text('unidad_ejecutora_normativa');
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
        //
        Schema::drop('p_anexo_seis');
    }
}
