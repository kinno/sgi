<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePTecho extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_techo', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('ejercicio');
            $table->unsignedInteger('id_unidad_ejecutora');
            $table->unsignedInteger('id_proyecto_ep');
            $table->tinyInteger('id_tipo_fuente');
            $table->unsignedinteger('id_fuente');
            $table->decimal('techo', 15, 2)->default(0);
            $table->timestamps();
        });
        Schema::create('d_techo', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto', 15, 2)->default(0);
            $table->string('observaciones', 255);
            $table->unsignedInteger('id_techo');
            $table->tinyInteger('id_tipo_movimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('p_techo');
        Schema::drop('d_techo');
    }
}
