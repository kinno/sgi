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
       Schema::create('rel_solicitud_fuente', function (Blueprint $table) {
           $table->integer('id_solicitud');
           $table->integer('id_fuente');
           $table->decimal('monto',10,2);
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
        Schema::drop('rel_solicitud_fuente');
    }
}
