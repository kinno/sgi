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

Route::get('/EstudioSocioeconomico/crear_estudio', 'EstudioSocioeconomico\EstudioController@index');
Route::post('/EstudioSocioeconomico/buscar_estudio', 'EstudioSocioeconomico\EstudioController@buscar_estudio');
Route::post('/EstudioSocioeconomico/guardar_hoja_1', 'EstudioSocioeconomico\EstudioController@guardar_hoja_1');
Route::post('/EstudioSocioeconomico/guardar_hoja_2', 'EstudioSocioeconomico\EstudioController@guardar_hoja_2');
Route::post('/EstudioSocioeconomico/eliminar_imagen', 'EstudioSocioeconomico\EstudioController@eliminar_imagen');
Route::post('/EstudioSocioeconomico/enviar_dictaminar', 'EstudioSocioeconomico\EstudioController@enviar_dictaminar');
Route::get('/EstudioSocioeconomico/ficha_tecnica/{id_estudio_socioeconomico}', 'EstudioSocioeconomico\EstudioController@ficha_tecnica');

// Rutas Banco

Route::get('/Banco/','Banco\BancoController@index');
Route::post('/Banco/obtener_tipo_evaluacion','Banco\BancoController@obtener_tipo_evaluacion');


// Rutas Catalogo - Sector
Route::group(['prefix' => 'Catalogo'], function() {
	Route::resource ('Sector', 'Catalogo\Sector\SectorController');
});


Route::get('Catalogo/dropdown', [
	'uses'	=> 'Catalogo\Sector\SectorController@dropdown',
	'as'	=> 'Sector.dropdown'
]);



