<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud');
            $table->string('numero_contrato');
            $table->dateTime('fecha_celebracion');
            $table->text('descripcion');
            $table->integer('id_empresa');
            $table->tinyInteger('id_tipo_contrato');
            $table->tinyInteger('id_modalidad_ejecucion_contrato');
            $table->decimal('monto',17,2);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('dias_calendario');
            $table->boolean('bdisponibilidad_inmueble');
            $table->text('motivo_no_disponible');
            $table->dateTime('fecha_disponibilidad');
            $table->tinyInteger('id_tipo_obra_contrato');
            $table->string('folio_garantia');
            $table->dateTime('fecha_emision_garantia');
            $table->decimal('importe_garantia',17,2);
            $table->dateTime('fecha_inicio_garantia');
            $table->dateTime('fecha_fin_garantia');
            $table->decimal('porcentaje_anticipo',8,5);
            $table->decimal('importe_anticipo',8,5);
            $table->text('motivo_importe');
            $table->text('forma_pago_anticipo');
            $table->string('folio_garantia_cumplimiento');
            $table->decimal('importe_garantia_cumplimiento',17,2);
            $table->dateTime('fecha_inicio_garantia_cumplimiento');
            $table->dateTime('fecha_fin_garantia_cumplimiento');
            $table->integer('id_contrato_padre');
            $table->tinyInteger('estatus');
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
        Schema::drop('p_contrato');
    }
}
