<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->text('criterios_sociales')->nullable();
            $table->text('unidad_ejecutora_normativa')->nullable();
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
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('p_anexo_seis');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        

    }
}
