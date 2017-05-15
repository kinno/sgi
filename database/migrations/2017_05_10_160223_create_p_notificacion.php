<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_notificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario_destino')->nullable();
            $table->unsignedInteger('id_usuario_envio')->nullable();
            $table->unsignedInteger('id_sector')->nullable();
            $table->text('detalle_notificacion');
            $table->boolean('bleido');
            $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('p_notificacion');
    }
}
