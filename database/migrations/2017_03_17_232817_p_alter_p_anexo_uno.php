<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PAlterPAnexoUno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_anexo_uno_estudiosocioeconomico', function($table) {
            $table->unsignedInteger('id_usuario')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_anexo_uno_estudiosocioeconomico', function($table) {
            //
        });
    }
}
