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
    
})->name('inicio');

Route::get('/EstudioSocioeconomico/crear_estudio', 'EstudioSocioeconomico\EstudioController@index')->name('creacion');
Route::post('/EstudioSocioeconomico/buscar_estudio', 'EstudioSocioeconomico\EstudioController@buscar_estudio');
Route::post('/EstudioSocioeconomico/guardar_hoja_1', 'EstudioSocioeconomico\EstudioController@guardar_hoja_1');
Route::post('/EstudioSocioeconomico/guardar_hoja_2', 'EstudioSocioeconomico\EstudioController@guardar_hoja_2');
Route::post('/EstudioSocioeconomico/eliminar_imagen', 'EstudioSocioeconomico\EstudioController@eliminar_imagen');
Route::post('/EstudioSocioeconomico/enviar_dictaminar', 'EstudioSocioeconomico\EstudioController@enviar_dictaminar');
Route::get('/EstudioSocioeconomico/ficha_tecnica/{id_estudio_socioeconomico}', 'EstudioSocioeconomico\EstudioController@ficha_tecnica');

// Rutas Banco
Route::get('/Banco/dictaminacion','Banco\BancoController@index')->name('dictaminacion');
Route::post('/Banco/obtener_tipo_evaluacion','Banco\BancoController@obtener_tipo_evaluacion');
Route::post('/Banco/buscar_estudio','Banco\BancoController@buscar_estudio');
Route::post('/Banco/guardar_evaluacion','Banco\BancoController@guardar_evaluacion');
Route::get('/Banco/imprime_dictamen/{id_estudio_socioeconomico}/{dictamen}','Banco\BancoController@imprime_dictamen');
Route::get('/Banco/consultas_banco','Banco\ConsultasBancoController@index')->name('consulta_banco');
Route::get('/Banco/get_datos_consulta','Banco\ConsultasBancoController@getData');
Route::get('/Banco/get_datos_movimientos/{id_estudio_socioeconomico}','Banco\ConsultasBancoController@getDetailsData');
Route::get('/Banco/get_datos_comentarios/{id_evaluacion}','Banco\ConsultasBancoController@getComentariosDetail');

// Rutas Expediente Técnico
Route::get('/ExpedienteTecnico/crear_expediente','ExpedienteTecnico\ExpedienteController@index')->name('creacionExpediente');
Route::post('/ExpedienteTecnico/buscar_expediente', 'ExpedienteTecnico\ExpedienteController@buscar_expediente');
Route::post('/ExpedienteTecnico/guardar_hoja_1', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_1');
Route::post('/ExpedienteTecnico/guardar_hoja_2', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_2');
Route::post('/ExpedienteTecnico/eliminar_imagen', 'ExpedienteTecnico\ExpedienteController@eliminar_imagen');
Route::get('/ExpedienteTecnico/get_data_conceptos/{id_expediente_tecnico}', 'ExpedienteTecnico\ExpedienteController@get_data_conceptos');
Route::post('/ExpedienteTecnico/guardar_hoja_3', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_3');
Route::get('/ExpedienteTecnico/descargar_plantilla', function() {
    return response()->download(public_path().'\docs/plantillaConceptos.xls');
});
Route::post('/ExpedienteTecnico/carga_externa', 'ExpedienteTecnico\ExpedienteController@carga_externa');
Route::get('/ExpedienteTecnico/get_data_programa/{id_expediente_tecnico}', 'ExpedienteTecnico\ExpedienteController@get_data_programa');
Route::post('/ExpedienteTecnico/guardar_hoja_4', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_4');




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


// Rutas Catalogo - Menues
Route::group(['prefix' => 'Catalogo'], function() {
	Route::resource ('Menu', 'Catalogo\Menu\MenuController');
});
Route::post('Catalogo/Menu/{id}/destroy','Catalogo\Menu\MenuController@destroy');


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
Route::post('Administracion/Modulo/dropdownUsuario', 'Administracion\Modulo\ModuloController@dropdownUsuario');
Route::post('Administracion/Modulo/guarda_permisos', 'Administracion\Modulo\ModuloController@guarda_permisos');

Route::get('Administracion/Sector/permisos', 'Administracion\Sector\SectorController@permisos');
Route::post('Administracion/Sector/dropdownUsuario', 'Administracion\Sector\SectorController@dropdownUsuario');
Route::post('Administracion/Sector/guarda_permisos', 'Administracion\Sector\SectorController@guarda_permisos');

// Rutas Obra
Route::get('Obra/crear', 'Obra\ObraController@index');
Route::post('Obra/buscar_expediente', 'Obra\ObraController@buscar_expediente');
Route::post('Obra/buscar_obra', 'Obra\ObraController@buscar_obra');
Route::post('Obra/guardar', 'Obra\ObraController@guardar');
Route::post('Obra/dropdownEjercicio', 'Obra\ObraController@dropdownEjercicio');
Route::post('Obra/dropdownSector', 'Obra\ObraController@dropdownSector');
Route::post('Obra/dropdownPrograma', 'Obra\ObraController@dropdownPrograma');

