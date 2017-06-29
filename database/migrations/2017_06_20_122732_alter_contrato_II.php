<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContratoII extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_contrato', function($table) {
            $table->renameColumn('id_modalidad_ejecucion_contrato','id_modalidad_adjudicacion_contrato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       $table->renameColumn('id_modalidad_adjudicacion_contrato','id_modalidad_ejecucion_contrato');
    }
}
