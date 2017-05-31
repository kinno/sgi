<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRelObraFuente2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('rel_obra_fuente', function (Blueprint $table) {
            $table->char('partida', 4)->after('cuenta');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rel_obra_fuente', function (Blueprint $table) {
            $table->dropColumn('partida');
        });
    }
}
