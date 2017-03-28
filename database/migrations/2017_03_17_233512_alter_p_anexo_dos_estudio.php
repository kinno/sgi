<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPAnexoDosEstudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_anexo_dos_estudiosocioeconomico', function($table) {
             $table->decimal('latitud_inicial',11,7)->nullable()->change();
            $table->decimal('longitud_inicial',11,7)->nullable()->change();
            $table->decimal('latitud_final',11,7)->nullable()->change();
            $table->decimal('longitud_final',11,7)->nullable()->change();
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
