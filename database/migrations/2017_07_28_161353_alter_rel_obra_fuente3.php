<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRelObraFuente3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_obra_fuente', function($table) {
            $table->smallInteger('id_unidad_ejecutora')->after('id_fuente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rel_obra_fuente', function ($table) {
            $table->dropColumn('id_unidad_ejecutora');
        });
    }
}
