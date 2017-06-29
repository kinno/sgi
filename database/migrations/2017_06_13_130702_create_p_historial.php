<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePHistorial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_historial_obra_expediente', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_expediente_tecnico');
            $table->unsignedInteger('id_det_obra');
            $table->unsignedInteger('id_solicitud_presupuesto');
            $table->decimal('monto',12,2);
            $table->unsignedInteger('id_usuario');
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
        Schema::drop('p_historial_obra_expediente.');
    }
}
