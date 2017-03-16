<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelSolicitudMunicipio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('rel_expediente_municipio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_expediente_tecnico');
            $table->unsignedInteger('id_municipio');
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
        Schema::drop('rel_expediente_municipio');
    }
}
