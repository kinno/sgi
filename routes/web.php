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
use Illuminate\Http\Request;

Route::get('/', function () {
    if (\Auth::check()) {
        return view('layouts.master');
    } else {
        return view('auth.login');
    }

})->name('inicio')->middleware('verifica.notificaciones');

Route::post('/marcar_leida', function (Request $request) {
    $notificaciones         = App\P_Notificacion::find($request->id);
    $notificaciones->bleido = 1;
    $notificaciones->save();
    if (\Auth::user()->id_tipo_usuario == 2) {
        // DGI
        $sectores           = array();
        $rel_usuario_sector = \Auth::user()->sectores()->get();
        // dd($rel_usuario_sector);
        foreach ($rel_usuario_sector as $value) {
            array_push($sectores, $value->id);
        }
        $notificaciones = App\P_Notificacion::whereIn('id_sector', $sectores)
            ->latest()
            ->limit(5)
            ->get();
    } else {
        // DEPENDENCIA
        $notificaciones = App\P_Notificacion::where('id_usuario_destino', '=', \Auth::user()->id)
            ->latest()
            ->limit(5)
            ->get();
    }
    session(['notificaciones' => $notificaciones]);

});
Route::get('/actualizar_head', function () {return view('layouts.header-panel');});

Route::get('sin_permiso', function () {return view('sin_permiso');});

//Rutas Estudio
Route::group(['prefix' => 'EstudioSocioeconomico'], function () {
    Route::get('crear_estudio', 'EstudioSocioeconomico\EstudioController@index')->name('creacion');
    Route::post('buscar_estudio', 'EstudioSocioeconomico\EstudioController@buscar_estudio');
    Route::post('guardar_hoja_1', 'EstudioSocioeconomico\EstudioController@guardar_hoja_1');
    Route::post('guardar_hoja_2', 'EstudioSocioeconomico\EstudioController@guardar_hoja_2');
    Route::post('eliminar_imagen', 'EstudioSocioeconomico\EstudioController@eliminar_imagen');
    Route::post('enviar_dictaminar', 'EstudioSocioeconomico\EstudioController@enviar_dictaminar');
    Route::get('ficha_tecnica/{id_estudio_socioeconomico}', 'EstudioSocioeconomico\EstudioController@ficha_tecnica');
    //
});

// Rutas Banco
Route::group(['prefix' => 'Banco'], function () {
    Route::get('dictaminacion', 'Banco\BancoController@index')->name('dictaminacion');
    Route::post('obtener_tipo_evaluacion', 'Banco\BancoController@obtener_tipo_evaluacion');
    Route::post('buscar_estudio', 'Banco\BancoController@buscar_estudio');
    Route::post('guardar_evaluacion', 'Banco\BancoController@guardar_evaluacion');
    Route::get('imprime_dictamen/{id_estudio_socioeconomico}/{dictamen}', 'Banco\BancoController@imprime_dictamen');
    Route::get('consultas_banco', 'Banco\ConsultasBancoController@index')->name('consulta_banco');
    Route::get('get_datos_consulta', 'Banco\ConsultasBancoController@getData');
    Route::get('get_datos_movimientos/{id_estudio_socioeconomico}', 'Banco\ConsultasBancoController@getDetailsData');
    Route::get('get_datos_comentarios/{id_evaluacion}', 'Banco\ConsultasBancoController@getComentariosDetail');
});

// Rutas Expediente Técnico Asignacion
Route::group(['prefix' => 'ExpedienteTecnico/Asignacion'], function () {
    Route::get('crear_expediente', 'ExpedienteTecnico\ExpedienteController@index')->name('creacionExpediente');
    Route::post('buscar_expediente', 'ExpedienteTecnico\ExpedienteController@buscar_expediente');
    Route::post('guardar_hoja_1', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_1');
    Route::post('guardar_hoja_2', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_2');
    Route::post('eliminar_imagen', 'ExpedienteTecnico\ExpedienteController@eliminar_imagen');
    Route::get('get_data_conceptos/{id_expediente_tecnico}', 'ExpedienteTecnico\ExpedienteController@get_data_conceptos');
    Route::post('guardar_hoja_3', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_3');
    Route::get('descargar_plantilla', function () {
        return response()->download(public_path() . '\docs/plantillaConceptos.xls');
    });
    Route::post('carga_externa', 'ExpedienteTecnico\ExpedienteController@carga_externa');
    Route::get('get_data_programa/{id_expediente_tecnico}', 'ExpedienteTecnico\ExpedienteController@get_data_programa');
    Route::post('guardar_hoja_4', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_4');
    Route::post('guardar_hoja_5', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_5');
    Route::post('guardar_hoja_6', 'ExpedienteTecnico\ExpedienteController@guardar_hoja_6');
    Route::post('enviar_revision', 'ExpedienteTecnico\ExpedienteController@cambiar_estatus');
    Route::get('revision_expediente_tecnico', 'ExpedienteTecnico\RevisionExpedienteController@index')->name('revision_expediente');
    Route::get('get_datos_revision', 'ExpedienteTecnico\RevisionExpedienteController@get_data_revision');
    Route::post('aceptar_expediente', 'ExpedienteTecnico\ExpedienteController@cambiar_estatus');
    Route::post('regresar_observaciones', 'ExpedienteTecnico\RevisionExpedienteController@regresar_observaciones');
    Route::get('impresion_expediente/{id_expediente_tecnio}', 'ExpedienteTecnico\ExpedienteController@imprime_expediente');
    Route::post('buscar_obra', 'Obra\ObraController@buscar_obra');
});

// Rutas Expediente Técnico Autorizacion
Route::group(['prefix' => 'ExpedienteTecnico/Autorizacion'], function () {
    Route::get('crear_autorizacion/', 'ExpedienteTecnico\AutorizacionExpedienteController@index')->name('creacionAutorizacion');
    Route::get('crear_autorizacion/{id_obra}', 'ExpedienteTecnico\AutorizacionExpedienteController@index')->name('creacionAutorizacion');
    Route::get('crear_contrato/{id_obra}/{id_contrato}','ExpedienteTecnico\AutorizacionExpedienteController@crear_contrato')->name('crear_contrato');
    Route::post('buscar_obra', 'ExpedienteTecnico\AutorizacionExpedienteController@buscar_obra');
    Route::post('generar_autorizacion', 'ExpedienteTecnico\AutorizacionExpedienteController@generar_autorizacion');
    Route::post('buscar_rfc', 'ExpedienteTecnico\AutorizacionExpedienteController@buscar_rfc');
    Route::post('buscar_contrato', 'ExpedienteTecnico\AutorizacionExpedienteController@buscar_contrato');
    Route::post('guardar_contrato_datos_generales', 'ExpedienteTecnico\AutorizacionExpedienteController@guardar_datos_generales');
    Route::get('get_data_contratos/{id_expediente_tecnico}','ExpedienteTecnico\AutorizacionExpedienteController@get_data_contratos');
    Route::get('get_data_conceptos_contrato/{id_contrato}','ExpedienteTecnico\AutorizacionExpedienteController@get_data_conceptos_contrato');
    Route::post('guardar_conceptos_contrato', 'ExpedienteTecnico\AutorizacionExpedienteController@guardar_conceptos_contrato');
    Route::post('guardar_contrato_garantias', 'ExpedienteTecnico\AutorizacionExpedienteController@guardar_contrato_garantias');
    Route::get('get_data_programa/{id_contrato}', 'ExpedienteTecnico\AutorizacionExpedienteController@get_data_programa');
    Route::post('guardar_programa_contrato', 'ExpedienteTecnico\AutorizacionExpedienteController@guardar_programa_contrato');
    Route::post('guardar_avance_financiero_contrato', 'ExpedienteTecnico\AutorizacionExpedienteController@guardar_avance_financiero_contrato');
    Route::post('eliminar_contrato', 'ExpedienteTecnico\AutorizacionExpedienteController@eliminar_contrato');
    Route::post('enviar_revision', 'ExpedienteTecnico\AutorizacionExpedienteController@asignar_autorizado_fuentes');
});

// Rutas Expediente Técnico Revision
Route::group(['prefix' => 'ExpedienteTecnico/Revision'], function () {
    Route::get('revision_expediente_tecnico', 'ExpedienteTecnico\RevisionExpedienteController@index')->name('revision_expediente');
    Route::get('get_datos_revision', 'ExpedienteTecnico\RevisionExpedienteController@get_data_revision');
    Route::post('aceptar_expediente', 'ExpedienteTecnico\ExpedienteController@cambiar_estatus');
    Route::post('regresar_observaciones', 'ExpedienteTecnico\RevisionExpedienteController@regresar_observaciones');
    Route::get('impresion_expediente/{id_expediente_tecnio}', 'ExpedienteTecnico\ExpedienteController@imprime_expediente');
});

Route::group(['prefix' => 'ExpedienteTecnico/'], function () {
    Route::get('impresion_expediente/{id_expediente_tecnio}', 'ExpedienteTecnico\ExpedienteController@imprime_expediente');
    Route::get('impresion_contrato/{id_expediente_tecnio}', 'ExpedienteTecnico\AutorizacionExpedienteController@imprime_contrato');
});

// Rutas Oficios
Route::group(['prefix' => 'Oficios'], function() {
    Route::get('crear_oficios', 'Oficios\OficiosController@index')->name('creacionOficios');
    Route::post('buscar_oficio', 'Oficios\OficiosController@buscar_oficio');
    Route::post('buscar_obra', 'Oficios\OficiosController@buscar_obra');
    Route::get('get_data_fuentes/{id_det_obra}', 'Oficios\OficiosController@get_data_fuentes');
    Route::get('get_data_obras/{id_oficio}', 'Oficios\OficiosController@get_data_obras');
    Route::post('cargar_textos', 'Oficios\OficiosController@cargar_texto');
    Route::post('guardar', 'Oficios\OficiosController@guardar');
    Route::get('imprimir_oficio/{id_oficio}', 'Oficios\OficiosController@imprime_oficio');
    Route::get('imprimir_detalle_oficio/{id_oficio}', 'Oficios\OficiosController@imprime_detalle_oficio');
    Route::get('textos_oficios', 'Oficios\TextoOficiosController@index')->name('controlTextos');
    Route::post('guardar_texto', 'Oficios\TextoOficiosController@guardar_texto');
    Route::post('buscar_texto', 'Oficios\TextoOficiosController@buscar_texto');
    Route::get('firma_oficios', 'Oficios\EstatusOficioController@index')->name('firmaOficios');
    Route::post('buscar_ofi', 'Oficios\EstatusOficioController@buscar_oficio');
    Route::post('guarda_firma', 'Oficios\EstatusOficioController@guardar');
});

// Rutas Catalogo - Sector
Route::group(['prefix' => 'Catalogo/Sector', 'middleware' => 'valida_ruta:Catalogo/Sector'], function () {
    //Route::resource('', 'Catalogo\Sector\SectorController');
    Route::get('','Catalogo\Sector\SectorController@index')->name('Sector.index');
	Route::get('create','Catalogo\Sector\SectorController@create')->name('Sector.create');
	Route::post('','Catalogo\Sector\SectorController@store')->name('Sector.store');
	Route::get('{id}/edit/{page}','Catalogo\Sector\SectorController@edit')->name('Sector.edit');
	Route::put('{id}','Catalogo\Sector\SectorController@update')->name('Sector.update');
	Route::post('{id}/destroy', 'Catalogo\Sector\SectorController@destroy');
	Route::post('dropdownArea', 'Catalogo\Sector\SectorController@dropdownArea');
});

// Rutas Catalogo/Ejecutora
Route::group(['prefix' => 'Catalogo/Ejecutora', 'middleware' => 'valida_ruta:Catalogo/Ejecutora'], function () {
    //Route::resource('', 'Catalogo\Ejecutora\EjecutoraController');
    Route::get('','Catalogo\Ejecutora\EjecutoraController@index')->name('Ejecutora.index');
	Route::get('create','Catalogo\Ejecutora\EjecutoraController@create')->name('Ejecutora.create');
	Route::post('','Catalogo\Ejecutora\EjecutoraController@store')->name('Ejecutora.store');
	Route::get('{id}/edit/{page}','Catalogo\Ejecutora\EjecutoraController@edit')->name('Ejecutora.edit');
	Route::put('{id}','Catalogo\Ejecutora\EjecutoraController@update')->name('Ejecutora.update');
    Route::post('{id}/destroy', 'Catalogo\Ejecutora\EjecutoraController@destroy');
});

// Rutas Catalogo/Menu
Route::group(['prefix' => 'Catalogo/Menu', 'middleware' => 'valida_ruta:Catalogo/Menu'], function () {
    //Route::resource('', 'Catalogo\Menu\MenuController');
    Route::get('','Catalogo\Menu\MenuController@index')->name('Menu.index');
	Route::get('create','Catalogo\Menu\MenuController@create')->name('Menu.create');
	Route::post('','Catalogo\Menu\MenuController@store')->name('Menu.store');
	Route::get('{id}/edit','Catalogo\Menu\MenuController@edit')->name('Menu.edit');
	Route::put('{id}','Catalogo\Menu\MenuController@update')->name('Menu.update');
    Route::post('{id}/destroy', 'Catalogo\Menu\MenuController@destroy');
});

// Rutas Administracion/Usuario
Route::group(['prefix' => 'Administracion/Usuario', 'middleware' => 'valida_ruta:Administracion/Usuario'], function () {
    //Route::resource('Usuario', 'Administracion\Usuario\UsuarioController');
    Route::get('','Administracion\Usuario\UsuarioController@index')->name('Usuario.index');
	Route::get('create','Administracion\Usuario\UsuarioController@create')->name('Usuario.create');
	Route::post('','Administracion\Usuario\UsuarioController@store')->name('Usuario.store');
	Route::get('{id}/edit','Administracion\Usuario\UsuarioController@edit')->name('Usuario.edit');
	Route::put('{id}','Administracion\Usuario\UsuarioController@update')->name('Usuario.update');
	Route::post('{id}/destroy', 'Administracion\Usuario\usuarioController@destroy');
	Route::post('dropdownSector', 'Administracion\Usuario\UsuarioController@dropdownSector');
	Route::post('dropdownArea', 'Administracion\Usuario\UsuarioController@dropdownArea');
});

// Rutas Administracion/Modulo
Route::group(['prefix' => 'Administracion/Modulo', 'middleware' => 'valida_ruta:Administracion/Modulo/permisos'], function () {
	Route::get('permisos', 'Administracion\Modulo\ModuloController@permisos')->name('Administracion.Modulo.permisos');
	Route::post('dropdownUsuario', 'Administracion\Modulo\ModuloController@dropdownUsuario');
	Route::post('guarda_permisos', 'Administracion\Modulo\ModuloController@guarda_permisos');
});

// Rutas Administracion/Sector
Route::group(['prefix' => 'Administracion/Sector', 'middleware' => 'valida_ruta:Administracion/Sector/permisos'], function () {
	Route::get('permisos', 'Administracion\Sector\SectorController@permisos')->name('Administracion.Sector.permisos');
	Route::post('dropdownUsuario', 'Administracion\Sector\SectorController@dropdownUsuario');
	Route::post('guarda_permisos', 'Administracion\Sector\SectorController@guarda_permisos');
});

// Rutas Obra
Route::group(['prefix' => 'Obra', 'middleware' => 'valida_ruta:Obra/crear'], function () {
	Route::get('crear', 'Obra\ObraController@index')->name('Obra.crear');
	Route::post('buscar_expediente', 'Obra\ObraController@buscar_expediente');
	Route::post('buscar_obra', 'Obra\ObraController@buscar_obra');
	Route::post('guardar', 'Obra\ObraController@guardar');
	Route::post('update', 'Obra\ObraController@update');
	Route::post('dropdownEjercicio', 'Obra\ObraController@dropdownEjercicio');
	Route::post('dropdownSector', 'Obra\ObraController@dropdownSector');
	Route::post('dropdownPrograma', 'Obra\ObraController@dropdownPrograma');
});

\Auth::routes();

// Rutas Techos Financieros
Route::group(['prefix' => 'TechoFinanciero', 'middleware' => 'valida_ruta:TechoFinanciero'], function () {
    Route::get('','TechoFinanciero\TechoController@index')->name('TechoFinanciero.index');
	Route::get('create','TechoFinanciero\TechoController@create')->name('TechoFinanciero.create');
	Route::post('','TechoFinanciero\TechoController@store');
	Route::get('{id}/agregar','TechoFinanciero\TechoController@agregar')->name('TechoFinanciero.agregar');
	Route::post('guarda/{id}','TechoFinanciero\TechoController@guarda');
	Route::get('{id}/edit','TechoFinanciero\TechoController@edit')->name('TechoFinanciero.edit');
	Route::put('{id}','TechoFinanciero\TechoController@update')->name('TechoFinanciero.update');
	Route::post('{id}/destroy','TechoFinanciero\TechoController@destroy')->name('TechoFinanciero.destroy');
	Route::post('dropdownEjercicio', 'TechoFinanciero\TechoController@dropdownEjercicio');
	Route::post('dropdownSector', 'TechoFinanciero\TechoController@dropdownSector');
	Route::post('dropdownPrograma', 'TechoFinanciero\TechoController@dropdownPrograma');
	Route::post('dropdownTipoFuente','TechoFinanciero\TechoController@dropdownTipoFuente');
});

// Rutas Consultas
Route::group(['prefix' => 'Consulta', 'middleware' => 'valida_ruta:Consulta'], function () {
    Route::get('','Consulta\ConsultaController@index')->name('Consulta.index');
	Route::post('get_datos_obra', 'Consulta\ConsultaController@getDataObra');
	Route::post('get_oficios_obra', 'Consulta\ConsultaController@getDataOficios');
	Route::post('get_detalle_oficio', 'Consulta\ConsultaController@getDataDetalleOficios');
	Route::post('buscar_obra', 'Consulta\ConsultaController@buscar_obra');
});


