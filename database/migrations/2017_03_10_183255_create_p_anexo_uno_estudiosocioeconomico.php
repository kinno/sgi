<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePAnexoUnoEstudiosocioeconomico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('p_anexo_uno_estudiosocioeconomico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_sector');
            $table->unsignedinteger('id_unidad_ejecutora');
            $table->smallInteger('ejercicio');
            $table->tinyInteger('id_tipo_obra');
            $table->tinyInteger('id_modalidad_ejecucion');
            $table->text('nombre_obra');
            $table->text('justificacion_obra');
            $table->text('principales_caracteristicas');
            $table->decimal('monto',10,2);
            $table->decimal('monto_municipal',10,2)->nullable();
            $table->text('fuente_municipal')->nullable();
            $table->unsignedInteger('id_meta');
            $table->integer('cantidad_meta');
            $table->unsignedInteger('id_beneficiario')->nullable();
            $table->decimal('cantidad_beneficiario',10,2)->nullable();
            $table->dateTime('fecha_captura');
            $table->tinyInteger('vida_proyecto');
            $table->unsignedInteger('id_grupo_social')->nullable();
            $table->tinyInteger('duracion_anios');
            $table->tinyInteger('duracion_meses');
            $table->text('jfactibilidad_legal');
            $table->text('jfactibilidad_ambiental');
            $table->text('jfactibilidad_tecnica');
            $table->unsignedInteger('id_usuario');
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
        Schema::drop('p_anexo_uno_estudiosocioeconomico');
    }
}
