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

// Rutas Expediente Técnico
Route::group(['prefix' => 'ExpedienteTecnico'], function () {
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
});

// Rutas Catalogo - Sector
Route::group(['prefix' => 'Catalogo'], function () {
    Route::resource('Sector', 'Catalogo\Sector\SectorController');
});
Route::post('Catalogo/Sector/dropdownArea', 'Catalogo\Sector\SectorController@dropdownArea');
Route::post('Catalogo/Sector/{id}/destroy', 'Catalogo\Sector\SectorController@destroy');

// Rutas Catalogo - Unidad Ejecutora
Route::group(['prefix' => 'Catalogo'], function () {
    Route::resource('Ejecutora', 'Catalogo\Ejecutora\EjecutoraController');
});
Route::post('Catalogo/Ejecutora/{id}/destroy', 'Catalogo\Ejecutora\EjecutoraController@destroy');

// Rutas Catalogo - Menues
Route::group(['prefix' => 'Catalogo'], function () {
    Route::resource('Menu', 'Catalogo\Menu\MenuController');
});
Route::post('Catalogo/Menu/{id}/destroy', 'Catalogo\Menu\MenuController@destroy');

// Rutas Administracion
Route::group(['prefix' => 'Administracion'], function () {
    Route::resource('Usuario', 'Administracion\Usuario\UsuarioController');
});
Route::post('Administracion/Usuario/dropdownSector', 'Administracion\Usuario\UsuarioController@dropdownSector');
Route::post('Administracion/Usuario/dropdownArea', 'Administracion\Usuario\UsuarioController@dropdownArea');
Route::post('Administracion/Usuario/{id}/destroy', 'Administracion\Usuario\usuarioController@destroy');

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
Route::post('Obra/update', 'Obra\ObraController@update');
Route::post('Obra/dropdownEjercicio', 'Obra\ObraController@dropdownEjercicio');
Route::post('Obra/dropdownSector', 'Obra\ObraController@dropdownSector');
Route::post('Obra/dropdownPrograma', 'Obra\ObraController@dropdownPrograma');

\Auth::routes();
