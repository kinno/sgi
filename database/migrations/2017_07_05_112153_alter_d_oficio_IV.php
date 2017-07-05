<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDOficioIV extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_oficio', function ($table) {
            $table->unsignedInteger('id_solicitud_presupuesto')->after('id_unidad_ejecutora')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_oficio', function (Blueprint $table) {
            $table->dropColumn('id_solicitud_presupuesto');
        });
    }
}
