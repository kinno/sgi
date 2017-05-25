<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPAnexoDos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_anexo_dos_estudiosocioeconomico', function($table) {
            $table->text('nombre_localidad')->nullable()->change();
        });

         Schema::table('p_anexo_dos', function($table) {
            $table->text('nombre_localidad')->nullable()->change();
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
