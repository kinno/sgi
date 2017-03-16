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

// Rutas Catalogo - Sector
Route::group(['prefix' => 'Catalogo'], function() {
	Route::resource ('Sector', 'Catalogo\Sector\SectorController');
});


Route::get('Catalogo/dropdown', [
	'uses'	=> 'Catalogo\Sector\SectorController@dropdown',
	'as'	=> 'Sector.dropdown'
]);
