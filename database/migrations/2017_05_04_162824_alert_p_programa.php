<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertPPrograma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_programa', function($table) {
            $table->renameColumn('procentaje_enero', 'porcentaje_enero');
            $table->renameColumn('procentaje_febrero', 'porcentaje_febrero');
            $table->renameColumn('procentaje_marzo', 'porcentaje_marzo');
            $table->renameColumn('procentaje_abril', 'porcentaje_abril');
            $table->renameColumn('procentaje_mayo', 'porcentaje_mayo');
            $table->renameColumn('procentaje_junio', 'porcentaje_junio');
            $table->renameColumn('procentaje_julio', 'porcentaje_julio');
            $table->renameColumn('procentaje_agosto', 'porcentaje_agosto');
            $table->renameColumn('procentaje_septiembre', 'porcentaje_septiembre');
            $table->renameColumn('procentaje_octubre', 'porcentaje_octubre');
            $table->renameColumn('procentaje_noviembre', 'porcentaje_noviembre');
            $table->renameColumn('procentaje_diciembre', 'porcentaje_diciembre');
            $table->renameColumn('procentaje_total', 'porcentaje_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->renameColumn('porcentaje_enero', 'procentaje_enero');
            $table->renameColumn('porcentaje_febrero', 'procentaje_febrero');
            $table->renameColumn('porcentaje_marzo', 'procentaje_marzo');
            $table->renameColumn('porcentaje_abril', 'procentaje_abril');
            $table->renameColumn('porcentaje_mayo', 'procentaje_mayo');
            $table->renameColumn('porcentaje_junio', 'procentaje_junio');
            $table->renameColumn('porcentaje_julio', 'procentaje_julio');
            $table->renameColumn('porcentaje_agosto', 'procentaje_agosto');
            $table->renameColumn('porcentaje_septiembre', 'procentaje_septiembre');
            $table->renameColumn('porcentaje_octubre', 'procentaje_octubre');
            $table->renameColumn('porcentaje_noviembre', 'procentaje_noviembre');
            $table->renameColumn('porcentaje_diciembre', 'procentaje_diciembre');
            $table->renameColumn('porcentaje_total', 'procentaje_total');
    }
}
