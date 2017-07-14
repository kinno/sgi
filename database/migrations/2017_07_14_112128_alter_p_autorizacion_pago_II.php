<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPAutorizacionPagoII extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_autorizacion_pago', function($table) {
            $table->decimal('importe_sin_iva',15,2)->after("folio_amortizacion");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_autorizacion_pago', function($table) {
            $table->dropColumn('importe_sin_iva');
        });
    }
}
