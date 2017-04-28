<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelSolicitudFuente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('rel_expediente_fuente', function (Blueprint $table) {
           $table->increments('id');
           $table->unsignedInteger('id_expediente_tecnico');
           $table->integer('id_fuente');
           $table->decimal('monto',10,2);
           
           $table->char('tipo_fuente', 1);
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
        Schema::drop('rel_expediente_fuente');
    }
}
