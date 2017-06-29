<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPAvanceFinancieroContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_avance_financiero_contrato', function($table) {
         $table->decimal('enero',12,2)->change();
            $table->decimal('febrero',12,2)->change();
            $table->decimal('marzo',12,2)->change();
            $table->decimal('abril',12,2)->change();
            $table->decimal('mayo',12,2)->change();
            $table->decimal('junio',12,2)->change();
            $table->decimal('julio',12,2)->change();
            $table->decimal('agosto',12,2)->change();
            $table->decimal('septiembre',12,2)->change();
            $table->decimal('octubre',12,2)->change();
            $table->decimal('noviembre',12,2)->change();
            $table->decimal('diciembre',12,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_avance_financiero_contrato', function($table) {
         $table->decimal('enero',5,3)->change();
            $table->decimal('febrero',5,3)->change();
            $table->decimal('marzo',5,3)->change();
            $table->decimal('abril',5,3)->change();
            $table->decimal('mayo',5,3)->change();
            $table->decimal('junio',5,3)->change();
            $table->decimal('julio',5,3)->change();
            $table->decimal('agosto',5,3)->change();
            $table->decimal('septiembre',5,3)->change();
            $table->decimal('octubre',5,3)->change();
            $table->decimal('noviembre',5,3)->change();
            $table->decimal('diciembre',5,3)->change();
        });
    }
}
