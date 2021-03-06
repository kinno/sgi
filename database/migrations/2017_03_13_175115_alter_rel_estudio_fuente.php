<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterRelEstudioFuente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_estudio_fuente', function ($table) {
            $table->char('tipo_fuente', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rel_estudio_fuente', function ($table) {
            $table->dropColumn('tipo_fuente');
        });
    }
}
