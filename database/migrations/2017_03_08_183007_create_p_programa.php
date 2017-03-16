<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPrograma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_programa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_expediente_tecnico');
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
            $table->integer('id_contrato')->nullable();
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
        Schema::drop('p_programa');
    }
}
