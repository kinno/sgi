<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nombre_obra')->nullable();
            $table->unsignedInteger('id_proyecto_ep')->nullable();
            $table->unsignedInteger('id_clasificacion_proyecto')->nullable();
            $table->decimal('monto_asignado',15,12)->nullable();
            $table->decimal('monto_autorizado',15,12)->nullable();
            $table->decimal('monto_ejercido',15,12)->nullable();
            $table->decimal('monto_disponible',15,12)->nullable();
            $table->decimal('suma_anticipo',15,12)->nullable();
            $table->decimal('retenciones',15,12)->nullable();
            $table->decimal('comprobado',15,12)->nullable();
            $table->decimal('pagado',15,12)->nullable();
            
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
        Schema::drop('p_obra');
    }
}
