<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPAutorizacionPago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_autorizacion_pago', function($table) {
            $table->unsignedInteger('id_ap_amortizacion')->nullable()->after('monto_iva_amortizacion');
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
            $table->dropColumn('id_ap_amortizacion');
        });
    }
}
