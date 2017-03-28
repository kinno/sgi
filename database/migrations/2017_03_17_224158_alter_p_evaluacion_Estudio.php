<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPEvaluacionEstudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_evaluacion_estudio', function($table) {
            $table->unsignedInteger('id_evaluacion_estudio')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_evaluacion_estudio', function($table) {
         $table->increments('id')->change();
         });
    }
}
