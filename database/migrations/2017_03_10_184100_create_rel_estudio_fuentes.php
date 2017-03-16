<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelEstudioFuentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_estudio_fuente', function (Blueprint $table) {
           $table->increments('id'); 
           $table->unsignedInteger('id_estudio_socioeconomico');
           $table->unsignedInteger('id_fuente');
           $table->decimal('monto',10,2);
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
        Schema::drop('rel_estudio_fuente');
    }
}
