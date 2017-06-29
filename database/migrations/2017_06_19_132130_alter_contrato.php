<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_contrato', function($table) {
            $table->decimal('monto',17,2)->default(0.00)->change();
            $table->decimal('ejercido',17,2)->default(0.00)->change();
            $table->decimal('anticipo',17,2)->default(0.00)->change();
            $table->decimal('retenciones',17,2)->default(0.00)->change();
            $table->decimal('pagado',17,2)->default(0.00)->change();
        });

        Schema::table('d_contrato', function($table) {
            $table->dropColumn('id_tipo_contrato');
            $table->dropColumn('id_modalidad_ejecucion_contrato');
            $table->dropColumn('id_tipo_obra_contrato');
        });

        Schema::table('d_contrato', function($table) {
            $table->text('descripcion')->nullable()->change();
            $table->unsignedtinyInteger('id_tipo_contrato')->nullable();
            $table->unsignedtinyInteger('id_modalidad_ejecucion_contrato')->nullable();
            $table->dateTime('fecha_inicio')->nullable()->change();
            $table->dateTime('fecha_fin')->nullable()->change();
            $table->integer('dias_calendario')->nullable()->change();
            $table->boolean('bdisponibilidad_inmueble')->nullable()->change();
            $table->unsignedtinyInteger('id_tipo_obra_contrato')->nullable();
            $table->string('folio_garantia')->nullable()->change();
            $table->dateTime('fecha_emision_garantia')->nullable()->change();
            $table->decimal('importe_garantia',17,2)->nullable()->change();
            $table->dateTime('fecha_inicio_garantia')->nullable()->change();
            $table->dateTime('fecha_fin_garantia')->nullable()->change();
            $table->decimal('porcentaje_anticipo',8,5)->nullable()->change();
            $table->decimal('importe_anticipo',8,5)->nullable()->change();
            $table->string('folio_garantia_cumplimiento')->nullable()->change();
            $table->dateTime('fecha_emision_garantia_cumplimiento')->nullable()->change();
            $table->decimal('importe_garantia_cumplimiento',17,2)->nullable()->change();
            $table->dateTime('fecha_inicio_garantia_cumplimiento')->nullable()->change();
            $table->dateTime('fecha_fin_garantia_cumplimiento')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_contrato', function($table) {
             $table->tinyInteger('id_tipo_contrato');
             $table->tinyInteger('id_modalidad_ejecucion_contrato');
            $table->tinyInteger('id_tipo_obra_contrato');
        });
    }
}
