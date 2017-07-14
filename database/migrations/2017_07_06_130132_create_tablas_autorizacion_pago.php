<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablasAutorizacionPago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_autorizacion_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave',10);
            $table->unsignedInteger('id_tipo_ap');
            $table->unsignedInteger('id_estatus');
            $table->unsignedInteger('id_obra');
            $table->unsignedInteger('ejercicio');
            $table->unsignedInteger('id_fuente');
            $table->unsignedInteger('id_contrato')->nullable();
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_unidad_ejecutora');
            $table->unsignedInteger('id_sector');
            $table->string('observaciones')->nullable();
            $table->decimal('monto',15,2);
            $table->decimal('monto_amortizacion',15,2)->nullable();
            $table->decimal('monto_iva_amortizacion',15,2)->nullable();
            $table->string('folio_amortizacion',10)->nullable();
            $table->decimal('iva',15,2);
            $table->decimal('icic',15,2);
            $table->decimal('cmic',15,2);
            $table->decimal('supervision',15,2);
            $table->decimal('ispt',15,2);
            $table->decimal('otro',15,2);
            $table->decimal('federal_1',15,2);
            $table->decimal('federal_2',15,2);
            $table->decimal('federal_5',15,2);
            $table->unsignedInteger('id_relacion_envio')->nullable();
            $table->unsignedInteger('id_turno')->nullable();
            $table->unsignedInteger('id_usuario');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_sistema')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->dateTime('fecha_recepcion')->nullable();
            $table->dateTime('fecha_validacion')->nullable();
            $table->boolean('finiquito')->nullable();
            $table->boolean('desafectacion')->nullable();
            $table->smallInteger('numero_estimacion')->nullable();
            $table->unsignedInteger('id_usuario_recepcion')->nullable();
            $table->dateTime('fecha_recepcion_tesoreria')->nullable();
            $table->dateTime('fecha_programacion_tesoreria')->nullable();
            $table->timestamps();
        });

        Schema::create('rel_ap_documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_ap');
            $table->string('folio')->nullable();
            $table->string('documento')->nullable();
            $table->decimal('importe',15,2)->nullable();
            $table->string('partida_presupuestal')->nullable();
            $table->timestamps();
        });

         Schema::create('p_relacion_envio_ap', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_relacion');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('ejercicio');
            $table->string('clave',15);
            $table->dateTime('fecha_envio');
            $table->string('oficio');
            $table->timestamps();
        });

         Schema::create('p_turno_ap', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_direccion');
            $table->unsignedInteger('id_usuario');
            $table->dateTime('fecha_turno');
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
        Schema::drop('p_autorizacion_pago');
        Schema::drop('rel_ap_documentos');
        Schema::drop('p_relacion_envio_ap');
        Schema::drop('p_turno_ap');
    }
}
