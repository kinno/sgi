<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePDOficio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_oficio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave',8);
            $table->unsignedInteger('id_solicitud_presupuesto');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_estatus');
            $table->unsignedSmallInteger('ejercicio');
            $table->date('fecha_oficio');
            $table->date('fecha_firma')->nullable();
            $table->string('titular',200);
            $table->text('asunto');
            $table->text('ccp');
            $table->string('prefijo',20);
            $table->string('iniciales',20);
            $table->string('tarjeta_turno',20)->nullable();
            $table->text('texto');
            $table->timestamps();
        });

        Schema::create('d_oficio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_oficio');
            $table->unsignedInteger('id_det_obra');
            $table->unsignedInteger('id_fuente');
            $table->decimal('monto',15,2);
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
        Schema::drop('p_oficio');
        Schema::drop('d_oficio');
    }
}
