<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('p_pagos', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('id_autorizacion_pago');
			$table->unsignedInteger('id_det_obra');
			$table->unsignedSmallInteger('serie');
			$table->boolean('adefa');
			$table->char('cheque', 12);
			$table->date('fecha_pago');
			$table->decimal('monto',15,2);
			$table->timestamps();
		});

		Schema::create('tmp_pagos', function (Blueprint $table) {
			$table->char('clave', 10);
			$table->unsignedSmallInteger('serie');
			$table->boolean('adefa');
			$table->char('cheque', 12);
			$table->date('fecha');
			$table->decimal('monto',15,2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('p_pagos');
		Schema::drop('tmp_pagos');
	}
}
