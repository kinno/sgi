<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPAutorizacionPagoIII extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('p_autorizacion_pago', function($table) {
            $table->unsignedInteger('id_det_obra')->after("id_estatus");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_autorizacion_pago', function($table) {
            $table->dropColumn('id_det_obra');
        });
    }
}
