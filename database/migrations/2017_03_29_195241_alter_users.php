<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('username', 12)->unique();
            $table->char('iniciales', 4)->nullable();
            $table->boolean('bactivo');
            $table->unsignedTinyInteger('id_tipo_usuario');
            $table->unsignedTinyInteger('id_departamento');
            $table->unsignedSmallInteger('id_unidad_ejecutora');
        });

        Schema::create('p_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100)->nullable();
            $table->text('ruta')->nullable();
            $table->boolean('blink');
            $table->unsignedTinyInteger('orden');
            $table->string('descripcion', 255)->nullable();
            $table->unsignedInteger('id_menu_padre');
            $table->timestamps();
        });

        Schema::create('rel_usuario_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_menu');
            $table->timestamps();
        });

        Schema::create('rel_usuario_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_sector');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('username');
            $table->dropColumn('iniciales');
            $table->dropColumn('bactivo');
            $table->dropColumn('id_tipo_usuario');
            $table->dropColumn('id_departamento');
            $table->dropColumn('id_unidad_ejecutora');
        });
        Schema::dropIfExists('p_menu');
        Schema::dropIfExists('rel_usuario_menu');
        Schema::dropIfExists('rel_usuario_sector');
    }
}
