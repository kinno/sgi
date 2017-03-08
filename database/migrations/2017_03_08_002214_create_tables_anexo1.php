<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesAnexo1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('p_anexo_uno', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->integer('id_tipo_solicitud');
            $table->integer('id_sector');
            $table->integer('id_unidad_ejecutora');
            $table->smallInteger('ejercicio');
            $table->boolean('bevaluacion_socioeconomica');
            $table->tinyInteger('id_tipo_obra');
            $table->tinyInteger('id_modalidad_ejecucion');
            $table->integer('id_obra');
            $table->text('nombre_obra');
            $table->text('justificacion_obra');
            $table->text('principales_caracteristicas');
            $table->boolean('bestudio_socioeconomico');
            $table->boolean('bproyecto_ejecutivo');
            $table->boolean('bderecho_via');
            $table->boolean('bimpacto_ambiental');
            $table->boolean('bobra');
            $table->boolean('baccion');
            $table->boolean('botro');
            $table->text('descripcion_botro');
            $table->decimal('monto',10,2);
            $table->decimal('monto_municipal',10,2);
            $table->text('fuente_municipal');
            $table->integer('id_meta');
            $table->integer('cantidad_meta');
            $table->decimal('cantidad_beneficiario',10,2);
            $table->dateTime('fecha_captura');
            $table->integer('id_estudio_socioeconomico');
            $table->string('dictamen');
            $table->tinyInteger('vida_proyecto');
            $table->integer('id_grupo_social');
            $table->tinyInteger('duracion_anios');
            $table->tinyInteger('duracion_meses');
            $table->text('jfactibilidad_legal');
            $table->text('jfactibilidad_ambiental');
            $table->text('jfactibilidad_tecnica');
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
        Schema::drop('p_anexo_uno');
    }
}
