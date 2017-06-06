<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('p_contrato');

        Schema::create('p_contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_expediente_tecnico');
            $table->string('numero_contrato');
            $table->dateTime('fecha_celebracion');
            $table->integer('id_empresa');
            $table->unsignedInteger('id_contrato_padre')->nullable();
            $table->decimal('monto',17,2);
            $table->decimal('ejercido',17,2);
            $table->decimal('anticipo',17,2);
            $table->decimal('retenciones',17,2);
            $table->decimal('pagado',17,2);
            $table->unsignedInteger('id_usuario');
            $table->timestamps();
        });

        Schema::create('d_contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_contrato');
            $table->text('descripcion');
            $table->tinyInteger('id_tipo_contrato');
            $table->tinyInteger('id_modalidad_ejecucion_contrato');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('dias_calendario');
            $table->boolean('bdisponibilidad_inmueble');
            $table->text('motivo_no_disponible')->nullable();
            $table->dateTime('fecha_disponibilidad')->nullable();
            $table->tinyInteger('id_tipo_obra_contrato');
            $table->string('folio_garantia');
            $table->dateTime('fecha_emision_garantia');
            $table->decimal('importe_garantia',17,2);
            $table->dateTime('fecha_inicio_garantia');
            $table->dateTime('fecha_fin_garantia');
            $table->decimal('porcentaje_anticipo',8,5);
            $table->decimal('importe_anticipo',8,5);
            $table->text('motivo_importe')->nullable();
            $table->text('forma_pago_anticipo')->nullable();
            $table->string('folio_garantia_cumplimiento');
            $table->dateTime('fecha_emision_garantia_cumplimiento');
            $table->decimal('importe_garantia_cumplimiento',17,2);
            $table->dateTime('fecha_inicio_garantia_cumplimiento');
            $table->dateTime('fecha_fin_garantia_cumplimiento');
            $table->tinyInteger('estatus');
            $table->unsignedInteger('id_usuario');
            $table->timestamps();

        });

        Schema::create('p_programa_contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_contrato');
            $table->text('concepto');
            $table->decimal('procentaje_enero',5,2);
            $table->decimal('procentaje_febrero',5,2);
            $table->decimal('procentaje_marzo',5,2);
            $table->decimal('procentaje_abril',5,2);
            $table->decimal('procentaje_mayo',5,2);
            $table->decimal('procentaje_junio',5,2);
            $table->decimal('procentaje_julio',5,2);
            $table->decimal('procentaje_agosto',5,2);
            $table->decimal('procentaje_septiembre',5,2);
            $table->decimal('procentaje_octubre',5,2);
            $table->decimal('procentaje_noviembre',5,2);
            $table->decimal('procentaje_diciembre',5,2);
            $table->decimal('procentaje_total',5,2);
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
        Schema::drop('p_contrato');
        Schema::drop('d_contrato');
        Schema::drop('p_programa_contrato');
    }
}
