<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePAvanceFinancieroContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_avance_financiero_contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato');
            $table->decimal('enero',5,3);
            $table->decimal('febrero',5,3);
            $table->decimal('marzo',5,3);
            $table->decimal('abril',5,3);
            $table->decimal('mayo',5,3);
            $table->decimal('junio',5,3);
            $table->decimal('julio',5,3);
            $table->decimal('agosto',5,3);
            $table->decimal('septiembre',5,3);
            $table->decimal('octubre',5,3);
            $table->decimal('noviembre',5,3);
            $table->decimal('diciembre',5,3);
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
        Schema::drop('p_avance_financiero_contrato');
    }
}
