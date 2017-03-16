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
            $table->text('observaciones_unidad_ejecutora')->nullable();
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
        
         DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('p_anexo_cinco');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
