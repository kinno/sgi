<?php

namespace App\Http\Controllers\ExpedienteTecnico;

use App\Cat_Acuerdo;
use App\Cat_Beneficiario;
use App\Cat_Cobertura;
use App\Cat_Ejercicio;
use App\Cat_Fuente;
use App\Cat_Meta;
use App\Cat_Municipio;
use App\Cat_Region;
use App\Cat_Solicitud_Presupuesto;
use App\Cat_Tipo_Localidad;
use App\Http\Controllers\Controller;
use App\Jobs\CrearNotificacion;
use App\P_Anexo_Cinco;
use App\P_Anexo_Dos;
use App\P_Anexo_Seis;
use App\P_Anexo_Uno;
use App\P_Avance_Financiero;
use App\P_Estudio_Socioeconomico;
use App\P_Expediente_Tecnico;
use App\P_Presupuesto_Obra;
use App\P_Programa;
use App\Rel_Estudio_Expediente_Obra;
use App\Rel_Estudio_Municipio;
use App\Rel_Estudio_Region;
use App\Rel_Expediente_Municipio;
use App\Rel_Expediente_Region;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpedienteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        $barraMenu = array('input' => array('id' => 'id_expediente_tecnico_search', 'class' => 'text-right num', 'title' => 'No. Solcitud:'),
            'botones'                  => array([
                'id'    => 'buscar',
                'tipo'  => 'btn-default',
                'icono' => 'fa fa-search',
                'title' => 'Buscar Solicitud',
            ], [
                'id'    => 'limpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ], [
                'id'      => 'observaciones',
                'tipo'    => 'btn-danger',
                'icono'   => 'fa fa-exclamation-triangle',
                'title'   => 'Ver observaciones',
                
            ], [
                'id'    => 'guardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
            ], [
                'id'    => 'enviar_revision',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-share-square',
                'title' => 'Enviar a la DGI para revisión',
            ], [
                'id'    => 'imprimir_expediente',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-file-pdf-o',
                'title' => 'Imprimir Expediente Técnico',
            ]));
        $user              = \Auth::user()->load('unidad_ejecutora')->load('sectores');
        $ejercicios        = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
        $tipoSolicitud     = Cat_Solicitud_Presupuesto::whereIn('id', array(1, 10, 11, 8))->get();
        $accionesFederales = Cat_Acuerdo::where('id_tipo', '=', 4)->get();
        $accionesEstatales = Cat_Acuerdo::where('id_tipo', '=', 1)
            ->orWhere('id_tipo', '=', 2)
            ->get();
        $coberturas     = Cat_Cobertura::where('id', '>', 0)->get();
        $localidades    = Cat_Tipo_Localidad::where('id', '>', 0)->get();
        $regiones       = Cat_Region::where('id', '>', 0)->get();
        $municipios     = Cat_Municipio::where('id', '>', 0)->get();
        $metas          = Cat_Meta::where('id', '>', 0)->get();
        $beneficiarios  = Cat_Beneficiario::where('id', '>', 0)->get();
        $fuentesFederal = Cat_Fuente::where('tipo', '=', 'F')->get();
        $fuentesEstatal = Cat_Fuente::where('tipo', '=', 'E')->get();
        $ue             = array('id' => $user->unidad_ejecutora->id, 'nombre' => $user->unidad_ejecutora->nombre);
        $sector         = array('id' => $user->sectores[0]->id, 'nombre' => $user->sectores[0]->nombre);
        return view('ExpedienteTecnico.index', compact('ejercicios', 'tipoSolicitud', 'accionesFederales', 'accionesEstatales', 'coberturas', 'localidades', 'regiones', 'municipios', 'metas', 'beneficiarios', 'fuentesFederal', 'fuentesEstatal', 'ue', 'sector', 'barraMenu'));
    }

    public function buscar_expediente(Request $request)
    {
        try {

            // $expediente_tecnico = P_Expediente_Tecnico::
            //     with(['hoja1.sector', 'hoja1.unidad_ejecutora', 'hoja2', 'acuerdos', 'fuentes_monto', 'regiones', 'municipios'])
            //     ->findOrFail($request->id_expediente_tecnico);

            $expediente_tecnico = Rel_Estudio_Expediente_Obra::with(['expediente.hoja1.sector', 'expediente.hoja1.unidad_ejecutora', 'expediente.hoja2', 'expediente.acuerdos', 'expediente.fuentes_monto', 'expediente.regiones', 'expediente.municipios', 'expediente.avance_financiero', 'expediente.hoja5', 'expediente.hoja6'])
                ->with(array('expediente.observaciones' => function ($query) {
                    $query->orderBy('created_at', 'desc');

                }))
                ->where('id_expediente_tecnico', '=', $request->id_expediente_tecnico)
                ->first();

            if ($expediente_tecnico->expediente->id_estatus == 1 || $expediente_tecnico->expediente->id_estatus == 5) {
                //*CREACIÓN/EDICION    DEVOLUCIÓN A DEPENDENCIA
                $expediente_tecnico['rutaReal'] = asset('/uploads/');
                return $expediente_tecnico;
            } else {
                $expediente_tecnico          = array();
                $expediente_tecnico['error'] = "El Expediente Técnico no se puede editar";
                return $expediente_tecnico;
            }

        } catch (\Exception $e) {
            $expediente_tecnico            = array();
            $expediente_tecnico['message'] = $e->getMessage();
            $expediente_tecnico['trace']   = $e->getTrace();
            $expediente_tecnico['error']   = "No existe ese número de Expediente Técnico";
            return ($expediente_tecnico);
        }
    }

    public function guardar_hoja_1(Request $request)
    {
        // dd($request->all());
        //Bandera para saber si es nuevo registro o actualización
        $bNuevo     = true;
        $data       = array();
        $expediente = array();

        $validator = \Validator::make($request->all(), [
            'id_tipo_solicitud'           => 'required',
            'bevaluacion_socioeconomica'  => 'required',
            'id_estudio_socioeconomico'   => 'required_if:bevaluacion_socioeconomica,(1,3)',
            'nombre_obra'                 => 'required',
            'justificacion_obra'          => 'required',
            'id_modalidad_ejecucion'      => 'required',
            'id_tipo_obra'                => 'required',
            'monto'                       => 'required',
            'principales_caracteristicas' => 'required',
            'id_meta'                     => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }
        // dd($request->id_hoja_uno);
        if ($request->id_hoja_uno != "") {
            $bNuevo = false;
        } else {
            $bNuevo = true;
        }
        // dd($request->all());
        DB::beginTransaction();
        try {

            if ($bNuevo) {
                $hoja1 = new P_Anexo_Uno($request->only(['id_tipo_solicitud', 'bevaluacion_socioeconomica', 'bestudio_socioeconomico', 'bproyecto_ejecutivo', 'bderecho_via', 'bimpacto_ambiental', 'bobra', 'baccion', 'botro', 'descripcion_botro', 'ejercicio', 'nombre_obra', 'id_tipo_obra', 'id_modalidad_ejecucion', 'id_unidad_ejecutora', 'id_sector', 'justificacion_obra', 'monto', 'monto_municipal', 'fuente_municipal', 'principales_caracteristicas', 'id_meta', 'cantidad_meta', 'id_beneficiario', 'cantidad_beneficiario']));
                $hoja1->save();
            } else {

                $hoja1                              = P_Anexo_Uno::find($request->id_hoja_uno);
                $hoja1->id_tipo_solicitud           = $request->id_tipo_solicitud;
                $hoja1->bevaluacion_socioeconomica  = $request->bevaluacion_socioeconomica;
                $hoja1->bestudio_socioeconomico     = $request->bestudio_socioeconomico;
                $hoja1->bproyecto_ejecutivo         = $request->bproyecto_ejecutivo;
                $hoja1->bderecho_via                = $request->bderecho_via;
                $hoja1->bimpacto_ambiental          = $request->bimpacto_ambiental;
                $hoja1->bobra                       = $request->bobra;
                $hoja1->baccion                     = $request->baccion;
                $hoja1->botro                       = $request->botro;
                $hoja1->descripcion_botro           = $request->descripcion_botro;
                $hoja1->ejercicio                   = $request->ejercicio;
                $hoja1->nombre_obra                 = $request->nombre_obra;
                $hoja1->id_tipo_obra                = $request->id_tipo_obra;
                $hoja1->id_modalidad_ejecucion      = $request->id_modalidad_ejecucion;
                $hoja1->id_unidad_ejecutora         = $request->id_unidad_ejecutora;
                $hoja1->id_sector                   = $request->id_sector;
                $hoja1->justificacion_obra          = $request->justificacion_obra;
                $hoja1->monto                       = $request->monto;
                $hoja1->monto_municipal             = $request->monto_municipal;
                $hoja1->fuente_municipal            = $request->fuente_municipal;
                $hoja1->principales_caracteristicas = $request->principales_caracteristicas;
                $hoja1->id_meta                     = $request->id_meta;
                $hoja1->cantidad_meta               = $request->cantidad_meta;
                $hoja1->id_beneficiario             = $request->id_beneficiario;
                $hoja1->cantidad_beneficiario       = $request->cantidad_beneficiario;
                $hoja1->save();
            }

            if ($bNuevo) {
                //Guardamos la relacion del Anexo 1 a la tabla estudio socioeconomuico
                $expediente_tecnico                    = new P_Expediente_Tecnico;
                $expediente_tecnico->ejercicio         = $request->ejercicio;
                $expediente_tecnico->id_anexo_uno      = $hoja1->id;
                $expediente_tecnico->id_estatus        = 1;
                $expediente_tecnico->fecha_creacion    = date('Y-m-d H:i:s');
                $expediente_tecnico->id_usuario        = \Auth::user()->id;
                $expediente_tecnico->id_tipo_solicitud = $request->id_tipo_solicitud;
                $expediente_tecnico->save();

                $id_expediente_tecnico = $expediente_tecnico->id;

                // Se verifica si tiene estudio
                // Si tiene se actualiza la relacion Rel_Estudio_Expediente_obra
                // Si no se crea una nueva relacion
                if ($request->bevaluacion_socioeconomica == "1" || $request->bevaluacion_socioeconomica == "3") {
                    $rel_estudio_expediente_obra = Rel_Estudio_Expediente_Obra::where('id_estudio_socioeconomico', '=', $request->id_estudio_socioeconomico)
                        ->where('ejercicio', '=', $request->ejercicio)
                        ->first();
                    $rel_estudio_expediente_obra->id_expediente_tecnico = $id_expediente_tecnico;
                    $rel_estudio_expediente_obra->id_usuario            = \Auth::user()->id;
                    $rel_estudio_expediente_obra->save();
                    //SE clona la hoja 2 del estudio al expediente
                    $this->mergeData($request->id_estudio_socioeconomico, $id_expediente_tecnico);

                    // dd($rel_estudio_regionTEMP);

                } else {
                    $rel_estudio_expediente_obra                        = new Rel_Estudio_Expediente_Obra;
                    $rel_estudio_expediente_obra->id_expediente_tecnico = $id_expediente_tecnico;
                    // $rel_estudio_expediente_obra->ejercicio             = $request->ejercicio;
                    $rel_estudio_expediente_obra->id_usuario = \Auth::user()->id;
                    $rel_estudio_expediente_obra->save();
                }
            } else {
                //obtener el id del expediente que se quiere actualizar
                $expediente_tecnico             = P_expediente_tecnico::find($request->id_expediente_tecnico);
                $expediente_tecnico->id_estatus = 1;
                $expediente_tecnico->id_usuario = \Auth::user()->id;
                $expediente_tecnico->save();
            }

            // Guardado de la relacion de fuentes con el expediente
            $syncArray = array();
            if (isset($request->fuente_federal[0])) {
                foreach ($request->fuente_federal as $key => $value) {
                    $syncArray[$value] = array('id_expediente_tecnico' => $expediente_tecnico->id,
                        'monto'                                            => str_replace(",", "", $request->monto_fuente_federal[$key]),
                        'tipo_fuente'                                      => 'F');
                }
            }

            if (isset($request->fuente_estatal[0])) {
                foreach ($request->fuente_estatal as $key => $value) {
                    $syncArray[$value] = array('id_expediente_tecnico' => $expediente_tecnico->id,
                        'monto'                                            => str_replace(",", "", $request->monto_fuente_estatal[$key]),
                        'tipo_fuente'                                      => 'E');
                }
            }
            // dd($syncArray);

            $expediente_tecnico->fuentes_monto()->sync($syncArray);

            //Guardado de la relacion de acuerdos con el expediente
            if (isset($request->accion_federal) && isset($request->accion_estatal)) {
                $acciones = array_merge($request->accion_federal, $request->accion_estatal);
            } elseif (isset($request->accion_federal) && !isset($request->accion_estatal)) {
                $acciones = array_merge($request->accion_federal);
            } elseif (!isset($request->accion_federal) && isset($request->accion_estatal)) {
                $acciones = array_merge($request->accion_estatal);
            } else {
                $acciones = null;
            }

            if (isset($acciones)) {
                $expediente_tecnico->acuerdos()->sync($acciones);
            } else {
                $expediente_tecnico->acuerdos()->detach();
            }

            DB::commit();

            $expediente['id_anexo_uno']          = $hoja1->id;
            $expediente['id_expediente_tecnico'] = $expediente_tecnico->id;
            return $expediente;
        } catch (\Exception $e) {
            DB::rollback();
            $expediente            = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($expediente);
        }

    }

    public function guardar_hoja_2(Request $request)
    {

        $expediente   = array();
        $bNuevo       = true;
        $bNuevaImagen = false;

        $validator = \Validator::make($request->all(), [
            'id_cobertura'              => 'required',
            'id_region'                 => 'required_if:id_cobertura,2',
            'id_municipio'              => 'required_if:id_cobertura,3',
            'id_tipo_localidad'         => 'required',
            'bcoordenadas'              => 'required',
            'observaciones_coordenadas' => 'required_if:bcoordenadas,2',
            'latitud_inicial'           => 'required_if:bcoordenadas,1',
            'longitud_inicial'          => 'required_if:bcoordenadas,1',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }

        // dd($request->all());
        if ($file = $request->file('microlocalizacion')) {
            //obtenemos el nombre del archivo
            $nombre = $file->getClientOriginalName();
            \Storage::disk('uploads')->put($nombre, \File::get($file));
            $expediente['microlocalizacion'] = asset('/uploads/' . $nombre);
            $bNuevaImagen                    = true;
        }

        if ($request->id_hoja_dos != "") {
            $bNuevo = false;
        } else {
            $bNuevo = true;
        }

        DB::beginTransaction();
        try {

            if ($bNuevo) {
                $hoja2 = new P_Anexo_Dos;
            } else {
                $hoja2 = P_Anexo_Dos::find($request->id_hoja_dos);
                if ($bNuevaImagen) {
                    $imagen_anterior = $hoja2->microlocalizacion;
                }

            }

            $hoja2->id_cobertura              = $request->id_cobertura;
            $hoja2->nombre_localidad          = $request->nombre_localidad;
            $hoja2->id_tipo_localidad         = $request->id_tipo_localidad;
            $hoja2->bcoordenadas              = $request->bcoordenadas;
            $hoja2->observaciones_coordenadas = $request->observaciones_coordenadas;
            $hoja2->latitud_inicial           = $request->latitud_inicial;
            $hoja2->longitud_inicial          = $request->longitud_inicial;
            $hoja2->latitud_final             = $request->latitud_final;
            $hoja2->longitud_final            = $request->longitud_final;
            if (isset($nombre)) {
                $hoja2->microlocalizacion = $nombre;
            }

            $hoja2->save();
            $expediente_tecnico = P_Expediente_Tecnico::find($request->id_expediente_tecnico);

            if (isset($request->id_region)) {
                $expediente_tecnico->regiones()->sync($request->id_region);
            } else {
                $expediente_tecnico->regiones()->detach();
            }

            if (isset($request->id_municipio)) {
                $expediente_tecnico->municipios()->sync($request->id_municipio);
            } else {
                $expediente_tecnico->municipios()->detach();
            }

            //Guardamos la relacion del Anexo 2 a la tabla expediente técnico
            if ($bNuevo) {
                $expediente_tecnico->id_anexo_dos = $hoja2->id;
                $expediente_tecnico->id_usuario   = \Auth::user()->id;
                $expediente_tecnico->save();
            }

            if (isset($imagen_anterior)) {
                \Storage::disk('uploads')->delete($imagen_anterior);
            }

            //indicamos que queremos guardar un nuevo archivo en el disco local

            DB::commit();

            $estudio['id_anexo_dos']          = $hoja2->id;
            $estudio['id_expediente_tecnico'] = $expediente_tecnico->id;

            return $estudio;

        } catch (\Exception $e) {
            DB::rollback();
            $estudio            = array();
            $estudio['message'] = $e->getMessage();
            $estudio['trace']   = $e->getTrace();
            $estudio['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($estudio);
        }

    }

    public function mergeData($id_estudio, $id_expediente)
    {
        $estudio                          = P_Estudio_Socioeconomico::with('hoja2')->find($id_estudio);
        $hoja2                            = new P_Anexo_Dos;
        $hoja2->id_cobertura              = $estudio->hoja2->id_cobertura;
        $hoja2->nombre_localidad          = $estudio->hoja2->nombre_localidad;
        $hoja2->id_tipo_localidad         = $estudio->hoja2->id_tipo_localidad;
        $hoja2->bcoordenadas              = $estudio->hoja2->bcoordenadas;
        $hoja2->observaciones_coordenadas = $estudio->hoja2->observaciones_coordenadas;
        $hoja2->latitud_inicial           = $estudio->hoja2->latitud_inicial;
        $hoja2->longitud_inicial          = $estudio->hoja2->longitud_inicial;
        $hoja2->latitud_final             = $estudio->hoja2->latitud_final;
        $hoja2->longitud_final            = $estudio->hoja2->longitud_final;
        $hoja2->microlocalizacion         = $estudio->hoja2->microlocalizacion;
        $hoja2->save();
        $expediente['id_anexo_dos'] = $hoja2->id;

        $rel_estudio_municipioTEMP = Rel_Estudio_Municipio::where('id_estudio_socioeconomico', '=', $id_estudio)
            ->get();

        foreach ($rel_estudio_municipioTEMP as $value) {
            $rel_expediente_municipio                        = new Rel_Expediente_Municipio();
            $rel_expediente_municipio->id_expediente_tecnico = $id_expediente;
            $rel_expediente_municipio->id_municipio          = $value['id_municipio'];
            $rel_expediente_municipio->save();
        }

        $rel_estudio_regionTEMP = Rel_Estudio_Region::where('id_estudio_socioeconomico', '=', $id_estudio)
            ->get();

        foreach ($rel_estudio_regionTEMP as $value) {
            $rel_expediente_region                        = new Rel_Expediente_Region();
            $rel_expediente_region->id_expediente_tecnico = $id_expediente;
            $rel_expediente_region->id_region             = $value['id_region'];
            $rel_expediente_region->save();
        }

        $expediente_tecnicoTEMP               = P_expediente_tecnico::find($id_expediente);
        $expediente_tecnicoTEMP->id_anexo_dos = $hoja2->id;
        $expediente_tecnicoTEMP->id_usuario   = \Auth::user()->id;
        $expediente_tecnicoTEMP->save();

    }

    public function eliminar_imagen(Request $request)
    {
        $hoja2 = P_Anexo_Dos::find($request->id_hoja_dos);
        if ($hoja2->microlocalizacion) {
            \Storage::disk('uploads')->delete($hoja2->microlocalizacion);
            $hoja2->microlocalizacion = null;
            $hoja2->save();
        }
    }

    public function get_data_conceptos($id_expediente_tecnico)
    {

        $conceptos = P_Presupuesto_Obra::
            where('id_expediente_tecnico', '=', $id_expediente_tecnico);

        return \Datatables::of($conceptos)
            ->make(true);
    }

    public function guardar_hoja_3(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $arrayIds = array();
            foreach ($request->conceptosPresupuesto as $value) {
                if ($value['id']) {
                    //ID
                    $conceptos = P_Presupuesto_Obra::find($value['id']);
                } else {
                    $conceptos = new P_Presupuesto_Obra;
                }
                $conceptos->id_expediente_tecnico = $request->id_expediente_tecnico;
                $conceptos->clave_objeto_gasto    = $value['clave_objeto_gasto'];
                $conceptos->concepto              = $value['concepto'];
                $conceptos->unidad_medida         = $value['unidad_medida'];
                $conceptos->cantidad              = $value['cantidad'];
                $conceptos->precio_unitario       = $value['precio_unitario'];
                $conceptos->importe               = $value['importe'];
                $conceptos->iva                   = $value['iva'];
                $conceptos->total                 = $value['total'];
                $conceptos->save();
                array_push($arrayIds, $conceptos->id);
            }

            if (isset($request->conceptosEliminados)) {
                P_Presupuesto_Obra::destroy($request->conceptosEliminados);
            }
            DB::commit();
            return $arrayIds;
        } catch (\Exception $e) {
            DB::rollback();
            $conceptos            = array();
            $conceptos['message'] = $e->getMessage();
            $conceptos['trace']   = $e->getTrace();
            $conceptos['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($conceptos);
        }
    }

    public function carga_externa(Request $request)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'archivoExcel' => 'mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }

        if ($file = $request->file('archivoExcel')) {
            // //obtenemos el nombre del archivo
            $nombre = $file->getClientOriginalName();
            \Storage::disk('uploads')->put($nombre, \File::get($file));

            $result = Excel::selectSheetsByIndex(0)->load('uploads/' . $nombre, function ($reader) {
            })->get()->toArray();

            \Storage::disk('uploads')->delete($nombre);
        }
        return json_encode($result);

    }

    public function get_data_programa($id_expediente_tecnico)
    {

        $conceptos = P_Programa::
            where('id_expediente_tecnico', '=', $id_expediente_tecnico);

        return \Datatables::of($conceptos)
            ->make(true);
    }

    public function guardar_hoja_4(Request $request)
    {
        DB::beginTransaction();
        try {
            $hoja4['programas'] = $this->guardar_programas($request->calendarizadoPrograma, $request->id_expediente_tecnico, $request->programasEliminados);
            $this->guardar_avance_financiero($request->avanceFinanciero, $request->id_expediente_tecnico);
            DB::commit();
            return $hoja4;
        } catch (\Exception $e) {
            DB::rollback();
            $hoja4            = array();
            $hoja4['message'] = $e->getMessage();
            $hoja4['trace']   = $e->getTrace();
            $hoja4['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($hoja4);
        }
    }

    public function guardar_programas($programas, $id_expediente_tecnico, $programasEliminados)
    {
        $arrayIds = array();
        foreach ($programas as $value) {
            if ($value['id']) {
                //ID
                $programa = P_Programa::find($value['id']);
            } else {
                $programa = new P_Programa;
            }
            $programa->id_expediente_tecnico = $id_expediente_tecnico;
            $programa->concepto              = $value['concepto'];
            $programa->porcentaje_enero      = $value['porcentaje_enero'];
            $programa->porcentaje_febrero    = $value['porcentaje_febrero'];
            $programa->porcentaje_marzo      = $value['porcentaje_marzo'];
            $programa->porcentaje_abril      = $value['porcentaje_abril'];
            $programa->porcentaje_mayo       = $value['porcentaje_mayo'];
            $programa->porcentaje_junio      = $value['porcentaje_junio'];
            $programa->porcentaje_julio      = $value['porcentaje_julio'];
            $programa->porcentaje_agosto     = $value['porcentaje_agosto'];
            $programa->porcentaje_septiembre = $value['porcentaje_septiembre'];
            $programa->porcentaje_octubre    = $value['porcentaje_octubre'];
            $programa->porcentaje_noviembre  = $value['porcentaje_noviembre'];
            $programa->porcentaje_diciembre  = $value['porcentaje_diciembre'];
            $programa->porcentaje_total      = $value['porcentaje_total'];

            $programa->save();
            array_push($arrayIds, $programa->id);
        }

        if (isset($programasEliminados)) {
            P_Programa::destroy($programasEliminados);
        }
        return $arrayIds;
    }

    public function guardar_avance_financiero($avance_financiero, $id_expediente_tecnico)
    {
        $p_avance = P_Avance_Financiero::where('id_expediente_tecnico', '=', $id_expediente_tecnico)
            ->first();
        // dd($p_avance);
        if (!$p_avance) {
                $p_avance = new P_Avance_Financiero;
        }

        $p_avance->id_expediente_tecnico = $id_expediente_tecnico;
        $p_avance->enero                 = $avance_financiero['enero'];
        $p_avance->febrero               = $avance_financiero['febrero'];
        $p_avance->marzo                 = $avance_financiero['marzo'];
        $p_avance->abril                 = $avance_financiero['abril'];
        $p_avance->mayo                  = $avance_financiero['mayo'];
        $p_avance->junio                 = $avance_financiero['junio'];
        $p_avance->julio                 = $avance_financiero['julio'];
        $p_avance->agosto                = $avance_financiero['agosto'];
        $p_avance->septiembre            = $avance_financiero['septiembre'];
        $p_avance->octubre               = $avance_financiero['octubre'];
        $p_avance->noviembre             = $avance_financiero['noviembre'];
        $p_avance->diciembre             = $avance_financiero['diciembre'];
        $p_avance->save();
    }

    public function guardar_hoja_5(Request $request)
    {
        if ($request->id_hoja_cinco != "") {
            $bNuevo = false;
        } else {
            $bNuevo = true;
        }
        DB::beginTransaction();
        try {

            if ($bNuevo) {
                $hoja5 = new P_Anexo_Cinco;
            } else {
                $hoja5 = P_Anexo_Cinco::find($request->id_hoja_cinco);
            }

            $hoja5->observaciones_unidad_ejecutora = $request->observaciones_unidad_ejecutora;

            $hoja5->save();
            $expediente_tecnico = P_Expediente_Tecnico::find($request->id_expediente_tecnico);

            //Guardamos la relacion del Anexo 5 a la tabla expediente técnico
            if ($bNuevo) {
                $expediente_tecnico->id_anexo_cinco = $hoja5->id;
                $expediente_tecnico->id_usuario     = \Auth::user()->id;
                $expediente_tecnico->save();
            }

            DB::commit();

            $estudio['id_anexo_cinco']        = $hoja5->id;
            $estudio['id_expediente_tecnico'] = $expediente_tecnico->id;

            return $estudio;

        } catch (\Exception $e) {
            DB::rollback();
            $estudio            = array();
            $estudio['message'] = $e->getMessage();
            $estudio['trace']   = $e->getTrace();
            $estudio['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($estudio);
        }
    }

    public function guardar_hoja_6(Request $request)
    {
        if ($request->id_hoja_seis != "") {
            $bNuevo = false;
        } else {
            $bNuevo = true;
        }
        DB::beginTransaction();
        try {

            if ($bNuevo) {
                $hoja6 = new P_Anexo_Seis;
            } else {
                $hoja6 = P_Anexo_Seis::find($request->id_hoja_seis);
            }

            $hoja6->criterios_sociales         = $request->criterios_sociales;
            $hoja6->unidad_ejecutora_normativa = $request->unidad_ejecutora_normativa;

            $hoja6->save();
            $expediente_tecnico = P_Expediente_Tecnico::find($request->id_expediente_tecnico);

            //Guardamos la relacion del Anexo 5 a la tabla expediente técnico
            if ($bNuevo) {
                $expediente_tecnico->id_anexo_seis = $hoja6->id;
                $expediente_tecnico->id_usuario    = \Auth::user()->id;
                $expediente_tecnico->save();
            }

            DB::commit();

            $expediente['id_anexo_seis']         = $hoja6->id;
            $expediente['id_expediente_tecnico'] = $expediente_tecnico->id;

            return $expediente;

        } catch (\Exception $e) {
            DB::rollback();
            $expediente            = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($expediente);
        }
    }

    public function cambiar_estatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $expediente_tecnico             = P_Expediente_Tecnico::find($request->id_expediente_tecnico);
            $expediente_tecnico->id_estatus = $request->estatus;
            if ($request->estatus == 2) {
                $expediente_tecnico->fecha_envio = date('Y-m-d H:i:s');

                foreach (\Auth::user()->sectores()->get() as $value) {
                    $sectorUser = $value->id;
                };
                $detalle = "La dependencia " . \Auth::user()->name . " ha enviado el Expediente Técnico: " . $expediente_tecnico->id . " para su revisión y aprobación.";
                // dd($detalle);
                dispatch(new CrearNotificacion(null, \Auth::user()->id, $sectorUser, $detalle));

            } else if ($request->estatus == 3) {
                $expediente_tecnico->fecha_ingreso = date('Y-m-d H:i:s');
            } else if ($request->estatus == 5) {
                $expediente_tecnico->fecha_evaluacion = date('Y-m-d H:i:s');
            } else if ($request->estatus == 6) {
                $expediente_tecnico->fecha_evaluacion = date('Y-m-d H:i:s');
                $detalle                              = "El Expediente Técnico: " . $expediente_tecnico->id . " ha sido aprobado por la Dirección General de Inversión.";
                dispatch(new CrearNotificacion($expediente_tecnico->id_usuario, \Auth::user()->id, null, $detalle));
            }
            $expediente_tecnico->save();
            DB::commit();
            $expediente['id_expediente_tecnico'] = $expediente_tecnico->id;
            return ($expediente);

        } catch (Exception $e) {
            DB::rollback();
            $expediente            = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($expediente);
        }

    }

    public function imprime_expediente($id_expediente_tecnico)
    {

        $relacion = Rel_Estudio_Expediente_Obra::with(['expediente.tipoSolicitud', 'expediente.hoja1.sector', 'expediente.hoja1.unidad_ejecutora', 'expediente.hoja1.beneficiario', 'expediente.hoja2.cobertura', 'expediente.hoja2.localidad', 'expediente.acuerdos', 'expediente.fuentes_monto', 'expediente.regiones', 'expediente.municipios', 'expediente.conceptos', 'expediente.programas', 'expediente.avance_financiero', 'expediente.hoja5', 'expediente.hoja6', 'obra'])
            ->where('id_expediente_tecnico', '=', $id_expediente_tecnico)
            ->first();

        // return view('PDF/expediente_tecnico', compact('relacion'));
        $pdf = \PDF::loadView('PDF/expediente_tecnico', compact('relacion'));
        return $pdf->stream('ExpedienteTecnico_' . $relacion->id_expediente_tecnico . '.pdf');
    }
}
