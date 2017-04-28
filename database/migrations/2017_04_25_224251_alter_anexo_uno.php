<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAnexoUno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_anexo_uno', function($table) {
            $table->renameColumn('id_beneficiaro', 'id_beneficiario');
             $table->boolean('bestudio_socioeconomico')->nullable()->change();
            $table->boolean('bproyecto_ejecutivo')->nullable()->change();
            $table->boolean('bderecho_via')->nullable()->change();
            $table->boolean('bimpacto_ambiental')->nullable()->change();
            $table->boolean('bobra')->nullable()->change();
            $table->boolean('baccion')->nullable()->change();
            $table->boolean('botro')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('p_anexo_uno', function($table) {
            $table->renameColumn('id_beneficiario', 'id_beneficiaro');
        });
        
    }
}
