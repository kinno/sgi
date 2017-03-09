<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePAnexoCinco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_anexo_cinco', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->text('observaciones_unidad_ejecutora');
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
        Schema::drop('p_anexo_cinco');
    }
}
