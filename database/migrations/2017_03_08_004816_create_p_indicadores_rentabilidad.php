<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePIndicadoresRentabilidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_indicadores_rentabilidad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->integer('id_estudio_socioeconomico');
            $table->integer('id_evaluacion');
            $table->dateTime('fecha');
            $table->decimal('tasa_social_descuento',5,2);
            $table->decimal('van',15,2);
            $table->decimal('tir',5,2);
            $table->decimal('tri',5,2);
            $table->decimal('vacpta',15,2);
            $table->decimal('caepta',15,2);
            $table->decimal('vacalt',15,2);
            $table->decimal('caealt',15,2);
            $table->text('observaciones');
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
        Schema::drop('p_indicadores_rentabilidad');
    }
}
