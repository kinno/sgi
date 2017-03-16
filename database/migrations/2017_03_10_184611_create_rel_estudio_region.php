<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelEstudioRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_estudio_region', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_estudio_socioeconomico');
            $table->unsignedInteger('id_region');
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
        Schema::drop('rel_estudio_region');
    }
}
