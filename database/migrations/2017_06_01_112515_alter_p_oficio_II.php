<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPOficioII extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_oficio', function($table) {
            $table->unsignedSmallInteger('id_sector')->after('ejercicio')->nullable()->change();
            $table->unsignedSmallInteger('id_unidad_ejecutora')->after('id_sector')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
