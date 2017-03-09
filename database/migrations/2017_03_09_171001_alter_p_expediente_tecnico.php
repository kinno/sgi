<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPExpedienteTecnico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_expediente_tecnico', function($table) {
            $table->dropColumn('id_estudio_socioeconomico');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_expediente_tecnico', function($table) {
            $table->unsignedInteger('id_estudio_socioeconomico');
           
        });
    }
}
