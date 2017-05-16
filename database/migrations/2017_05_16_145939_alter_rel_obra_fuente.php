<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRelObraFuente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_obra_fuente', function (Blueprint $table) {
            $table->decimal('monto',15,2)->change();
            $table->decimal('asignado', 15, 2)->default(0);
            $table->decimal('autorizado', 15, 2)->default(0);
            $table->decimal('ejercido', 15, 2)->default(0);
            $table->decimal('anticipo', 15, 2)->default(0);
            $table->decimal('retenciones', 15, 2)->default(0);
            $table->decimal('comprobado', 15, 2)->default(0);
            $table->decimal('pagado', 15, 2)->default(0);
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
            $table->decimal('monto',12,2)->change();
            $table->dropColumn('asignado');
            $table->dropColumn('autorizado');
            $table->dropColumn('ejercido');
            $table->dropColumn('anticipo');
            $table->dropColumn('retenciones');
            $table->dropColumn('comprobado');
            $table->dropColumn('pagado');
        });
    }
}
