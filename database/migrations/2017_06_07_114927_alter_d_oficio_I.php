<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDOficioI extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_oficio', function($table) {
            $table->decimal('asignado',15,2)->after('id_fuente')->nullable();
            $table->decimal('autorizado',15,2)->after('asignado')->nullable();
            $table->dropColumn('monto');
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
