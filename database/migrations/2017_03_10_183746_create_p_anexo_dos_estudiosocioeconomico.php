<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePAnexoDosEstudiosocioeconomico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('p_anexo_dos_estudiosocioeconomico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cobertura');
            $table->text('nombre_localidad');
            $table->integer('id_tipo_localidad');
            $table->boolean('bcoordenadas');
            $table->text('observaciones_coordenadas')->nullable();
            $table->decimal('latitud_inicial',11,2)->nullable();
            $table->decimal('longitud_inicial',11,2)->nullable();
            $table->decimal('latitud_final',11,2)->nullable();
            $table->decimal('longitud_final',11,2)->nullable();
            $table->text('microlocalizacion')->nullable();
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
        Schema::drop('p_anexo_dos_estudiosocioeconomico');
    }
}
