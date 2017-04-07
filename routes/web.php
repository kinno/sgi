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
	if(\Auth::check()){
		// $user=\Auth::user()->load('menus');
		// dd(\Auth::user()->menus()->with('menuPadre')->get());
		return view('layouts.master');
	}else{
		return view('auth.login');
	}
    
});

Route::get('/EstudioSocioeconomico/crear_estudio', 'EstudioSocioeconomico\EstudioController@index');
Route::post('/EstudioSocioeconomico/buscar_estudio', 'EstudioSocioeconomico\EstudioController@buscar_estudio');
Route::post('/EstudioSocioeconomico/guardar_hoja_1', 'EstudioSocioeconomico\EstudioController@guardar_hoja_1');
Route::post('/EstudioSocioeconomico/guardar_hoja_2', 'EstudioSocioeconomico\EstudioController@guardar_hoja_2');
Route::post('/EstudioSocioeconomico/eliminar_imagen', 'EstudioSocioeconomico\EstudioController@eliminar_imagen');
Route::post('/EstudioSocioeconomico/enviar_dictaminar', 'EstudioSocioeconomico\EstudioController@enviar_dictaminar');
Route::get('/EstudioSocioeconomico/ficha_tecnica/{id_estudio_socioeconomico}', 'EstudioSocioeconomico\EstudioController@ficha_tecnica');

// Rutas Banco

Route::get('/Banco/dictaminacion','Banco\BancoController@index');
Route::post('/Banco/obtener_tipo_evaluacion','Banco\BancoController@obtener_tipo_evaluacion');
Route::post('/Banco/buscar_estudio','Banco\BancoController@buscar_estudio');
Route::post('/Banco/guardar_evaluacion','Banco\BancoController@guardar_evaluacion');
Route::get('/Banco/imprime_dictamen/{id_estudio_socioeconomico}','Banco\BancoController@imprime_dictamen');


// Rutas Catalogo - Sector
Route::group(['prefix' => 'Catalogo'], function() {
	Route::resource ('Sector', 'Catalogo\Sector\SectorController');
});
Route::post('Catalogo/Sector/dropdownArea','Catalogo\Sector\SectorController@dropdownArea');
Route::post('Catalogo/Sector/{id}/destroy','Catalogo\Sector\SectorController@destroy');


// Rutas Catalogo - Unidad Ejecutora
Route::group(['prefix' => 'Catalogo'], function() {
	Route::resource ('Ejecutora', 'Catalogo\Ejecutora\EjecutoraController');
});
Route::post('Catalogo/Ejecutora/{id}/destroy','Catalogo\Ejecutora\EjecutoraController@destroy');


// Rutas Administracion
Route::group(['prefix' => 'Administracion'], function() {
	Route::resource ('Usuario', 'Administracion\Usuario\UsuarioController');
});
Route::post('Administracion/Usuario/dropdownSector','Administracion\Usuario\UsuarioController@dropdownSector');
Route::post('Administracion/Usuario/dropdownArea','Administracion\Usuario\UsuarioController@dropdownArea');
Route::post('Administracion/Usuario/{id}/destroy','Administracion\Usuario\usuarioController@destroy');

Auth::routes();
//Route::get('/home', 'HomeController@index');

Route::get('Administracion/Modulo/permisos', 'Administracion\Modulo\ModuloController@permisos');
Route::post('Administracion/Modulo/guarda_permisos', 'Administracion\Modulo\ModuloController@guarda_permisos');