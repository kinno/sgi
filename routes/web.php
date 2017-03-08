<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.master');
});

Route::get('/EstudioSocioeconomico/crear_estudio','EstudioSocioeconomico\EstudioController@index');


// Rutas Banco
Route::get('/Banco/','Banco\BancoController@index');
Route::post('/Banco/obtener_tipo_evaluacion','Banco\BancoController@obtener_tipo_evaluacion');

