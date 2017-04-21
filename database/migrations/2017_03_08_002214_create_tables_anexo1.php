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
            $table->unsignedInteger('id_tipo_solicitud');
            $table->unsignedInteger('id_sector');
            $table->unsignedInteger('id_unidad_ejecutora');
            $table->smallInteger('ejercicio');
            $table->boolean('bevaluacion_socioeconomica');
            $table->tinyInteger('id_tipo_obra');
            $table->tinyInteger('id_modalidad_ejecucion');
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
            $table->unsignedInteger('id_meta');
            $table->unsignedInteger('id_beneficiaro')->nullable();
            $table->integer('cantidad_meta')->nullable();
            $table->decimal('cantidad_beneficiario',10,2);
            $table->dateTime('fecha_captura');
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
         DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('p_anexo_uno');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
