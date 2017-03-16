<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelEstudioAcuerdo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_estudio_acuerdo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_estudio_socioeconomico');
            $table->unsignedInteger('id_acuerdo');
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
        Schema::drop('rel_estudio_acuerdo');
    }
}
