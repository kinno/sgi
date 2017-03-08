<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePAnexoDos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_anexo_dos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->integer('id_cobertura');
            $table->text('nombre_localidad');
            $table->integer('id_tipo_localidad');
            $table->boolean('bcoordenadas');
            $table->text('observaciones_coordenadas');
            $table->decimal('latitud_inicial',11,2);
            $table->decimal('longitud_inicial',11,2);
            $table->decimal('latitud_final',11,2);
            $table->decimal('longitud_final',11,2);
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
        Schema::drop('p_anexo_dos');
    }
}
