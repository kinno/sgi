<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('d_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_obra');
            $table->smallInteger('ejercicio');
            $table->text('nombre');
            $table->text('justificacion')->nullable();
            $table->text('caracteristicas')->nullable();
            $table->string('localidad', 150)->nullable();
            $table->unsignedInteger('id_sector');
            $table->unsignedInteger('id_unidad_ejecutora');
            $table->unsignedInteger('id_grupo_social')->default(0);
            $table->unsignedInteger('id_modalidad_ejecucion');
            $table->unsignedInteger('id_proyecto_ep');
            $table->unsignedInteger('id_clasificacion_obra');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_cobertura');
            $table->unsignedInteger('id_municipio');
            $table->decimal('asignado', 15, 2)->default(0);
            $table->decimal('autorizado', 15, 2)->default(0);
            $table->decimal('ejercido', 15, 2)->default(0);
            $table->decimal('anticipo', 15, 2)->default(0);
            $table->decimal('retenciones', 15, 2)->default(0);
            $table->decimal('comprobado', 15, 2)->default(0);
            $table->decimal('pagado', 15, 2)->default(0);
            $table->timestamps();
        });
        Schema::create('rel_obra_acuerdo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_det_obra');
            $table->integer('id_acuerdo');
        });
        Schema::create('rel_obra_fuente', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_det_obra');
            $table->integer('id_fuente');
            $table->decimal('monto', 12, 2);
            $table->string('cuenta', 40);
            $table->string('tipo_fuente', 40);
        });
        Schema::create('rel_obra_region', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_det_obra');
            $table->unsignedInteger('id_region');
        });
        Schema::create('rel_obra_municipio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_det_obra');
            $table->unsignedInteger('id_municipio');
        });
        Schema::table('rel_estudio_expediente_obra', function ($table) {
            $table->renameColumn('id_obra', 'id_det_obra');
            $table->dropColumn('ejercicio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('d_obra');
        Schema::drop('rel_obra_acuerdo');
        Schema::drop('rel_obra_fuente');
        Schema::drop('rel_obra_region');
        Schema::drop('rel_obra_municipio');
    }
}
