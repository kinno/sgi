<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPresupuestoObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('p_presupuesto_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_expediente_tecnico');
            $table->string('clave_objeto_gasto')->nullable();
            $table->text('concepto');
            $table->text('unidad_medida');
            $table->decimal('cantidad',15,2);
            $table->decimal('precio_unitario',15,2);
            $table->decimal('importe',15,2);
            $table->decimal('iva',15,2);
            $table->decimal('total',15,2);
            $table->integer('id_contrato')->nullable();
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
        Schema::drop('p_presupuesto_obra');
    }
}
