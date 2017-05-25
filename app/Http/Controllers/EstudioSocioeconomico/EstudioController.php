<?php

namespace App\Http\Controllers\EstudioSocioeconomico;

use App\Cat_Acuerdo;
use App\Cat_Beneficiario;
use App\Cat_Cobertura;
use App\Cat_Ejercicio;
use App\Cat_Fuente;
use App\Cat_Grupo_Social;
use App\Cat_Meta;
use App\Cat_Municipio;
use App\Cat_Region;
use App\Cat_Tipo_Localidad;
use App\Http\Controllers\Controller;
use App\P_Anexo_Dos_Estudiosocioeconomico;
use App\P_Anexo_Uno_Estudiosocioeconomico;
use App\P_Estudio_Socioeconomico;
use App\P_Movimiento_Banco;
use App\Rel_Estudio_Expediente_Obra;
use DB;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);

    }

    public function index()
    {
        $barraMenu = array('input'=>array('id'=>'id_estudio_socioeconomico','class'=>'text-right num','title'=>'No. de Banco de Proyectos:'),
            'botones' => array([
                'id'    => 'buscar',
                'tipo'  => 'btn-default',
                'icono' => 'fa fa-search',
                'title' => 'Buscar Estudio',
            ], [
                'id'    => 'limpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ], [
                'id'    => 'guardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
            ], [
                'id'    => 'dictaminar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-share-square',
                'title' => 'Enviar a la DGI para dictaminar',
            ], [
                'id'    => 'ficha_tecnica',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-file-pdf-o',
                'title' => 'Imprimir ficha técnica',
            ]));
        $user              = \Auth::user()->load('unidad_ejecutora')->load('sectores');
        $ejercicios        = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
        $accionesFederales = Cat_Acuerdo::where('id_tipo', '=', 4)->get();
        $accionesEstatales = Cat_Acuerdo::where('id_tipo', '=', 1)
            ->orWhere('id_tipo', '=', 2)
            ->get();
        $grupoSocial    = Cat_Grupo_Social::All();
        $coberturas     = Cat_Cobertura::where('id', '>', 0)->get();
        $localidades    = Cat_Tipo_Localidad::where('id', '>', 0)->get();
        $regiones       = Cat_Region::where('id', '>', 0)->get();
        $municipios     = Cat_Municipio::where('id', '>', 0)->get();
        $metas          = Cat_Meta::where('id', '>', 0)->get();
        $beneficiarios  = Cat_Beneficiario::where('id', '>', 0)->get();
        $fuentesFederal = Cat_Fuente::where('tipo', '=', 'F')->get();
        $fuentesEstatal = Cat_Fuente::where('tipo', '=', 'E')->get();
        // dd($user);
        $ue             = array('id' => $user->unidad_ejecutora->id, 'nombre' => $user->unidad_ejecutora->nombre);
        $sector         = array('id' => $user->sectores[0]->id, 'nombre' => $user->sectores[0]->nombre);

        // dump($accionesFederales);
        return view('EstudioSocioeconomico.index', compact('ejercicios', 'accionesFederales', 'accionesEstatales', 'grupoSocial', 'coberturas', 'localidades', 'regiones', 'municipios', 'metas', 'beneficiarios', 'fuentesFederal', 'fuentesEstatal', 'ue', 'sector', 'barraMenu'));
    }

    public function buscar_estudio(Request $request)
    {
        try {

            $estudio = P_Estudio_Socioeconomico::with(['hoja1.sector', 'hoja1.unidad_ejecutora', 'hoja2', 'acuerdos', 'fuentes_monto', 'regiones', 'municipios'])->findOrFail($request->id_estudio_socioeconomico);

            if ($estudio->id_estatus == 1 || $estudio->id_estatus == 5) {
                //*CREACIÓN/EDICION    DEVOLUCIÓN A DEPENDENCIA
                $estudio['rutaReal'] = asset('/uploads/');
                return $estudio;
            } else {
                //Si la petición es desde la creación del Expediente Técnico
                //no tomar en cuenta el status
                if (isset($request->externo)) {
                    $estudio['rutaReal'] = asset('/uploads/');
                    return $estudio;
                } else {

                    $estudio          = array();
                    $estudio['error'] = "El Estudio Socioeconómico no se puede editar";
                    return $estudio;

                }
            }

        } catch (\Exception $e) {
            $estudio            = array();
            $estudio['message'] = $e->getMessage();
            $estudio['trace']   = $e->getTrace();
            $estudio['error']   = "No existe ese número de Estudio Socioeconomico";
            return ($estudio);
        }
    }

    public function guardar_hoja_1(Request $request)
    {
        //Bandera para saber si es nuevo registro o actualización
        $bNuevo  = true;
        $data    = array();
        $estudio = array();

        $validator = \Validator::make($request->all(), [
            'ejercicio'                   => 'required',
            'nombre_obra'                 => 'required',
            'justificacion_obra'          => 'required',
            'id_modalidad_ejecucion'      => 'required',
            'id_tipo_obra'                => 'required',
            'monto'                       => 'required|min:1',
            'principales_caracteristicas' => 'required',
            'id_meta'                     => 'required',
            'cantidad_meta'               => 'required|min:1',
            'duracion_anios'              => 'required',
            'duracion_meses'              => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }

        //Se recorre el array de datos para crear el Json de las factibilidades
        foreach ($request->all() as $key => $val) {
            if (stristr($key, 'fl_')) {
                $data['factibilidad_legal']['cu'][] = array($key => $val);
            }
            if (stristr($key, 'fa_')) {
                if (stristr($key, 'fa_us')) {
                    $data['factibilidad_ambiental']['uso_suelo'][] = array($key => $val);
                } elseif (stristr($key, 'fa_ia')) {
                    $data['factibilidad_ambiental']['impacto_ambiental'][] = array($key => $val);
                } elseif (stristr($key, 'fa_ea')) {
                    $data['factibilidad_ambiental']['extensiones_avisos'][] = array($key => $val);
                }
            }
            if (stristr($key, 'ft_')) {
                $data['factibilidad_tecnica']['cu'][] = array($key => $val);
            }
        }
        $factibilidad_legal     = json_encode($data['factibilidad_legal']);
        $factibilidad_ambiental = json_encode($data['factibilidad_ambiental']);
        $factibilidad_tecnica   = json_encode($data['factibilidad_tecnica']);
        //
        if ($request->id_hoja_uno != "") {
            $bNuevo = false;
        } else {
            $bNuevo = true;
        }

        DB::beginTransaction();

        try {

            if ($bNuevo) {
                $hoja1 = new P_Anexo_Uno_Estudiosocioeconomico;
            } else {
                $hoja1 = P_Anexo_Uno_Estudiosocioeconomico::find($request->id_hoja_uno);
            }

            $hoja1->id_sector                   = $request->id_sector;
            $hoja1->id_unidad_ejecutora         = $request->id_unidad_ejecutora;
            $hoja1->ejercicio                   = $request->ejercicio;
            $hoja1->id_tipo_obra                = $request->id_tipo_obra;
            $hoja1->id_modalidad_ejecucion      = $request->id_modalidad_ejecucion;
            $hoja1->nombre_obra                 = $request->nombre_obra;
            $hoja1->justificacion_obra          = $request->justificacion_obra;
            $hoja1->principales_caracteristicas = $request->principales_caracteristicas;
            $hoja1->monto                       = str_replace(",", "", $request->monto);
            $hoja1->monto_municipal             = ($request->monto_fuente_municipal == "") ? null : str_replace(",", "", $request->monto_fuente_municipal);
            $hoja1->fuente_municipal            = $request->fuente_municipal;
            $hoja1->id_meta                     = $request->id_meta;
            $hoja1->id_beneficiario             = $request->id_beneficiario;
            $hoja1->cantidad_meta               = str_replace(",", "", $request->cantidad_meta);
            $hoja1->cantidad_beneficiario       = ($request->cantidad_beneficiario == "") ? null : str_replace(",", "", $request->cantidad_beneficiario);
            $hoja1->fecha_captura               = date('Y-m-d H:i:s');
            $hoja1->vida_proyecto               = $request->vida_proyecto;
            $hoja1->id_grupo_social             = $request->id_grupo_social;
            $hoja1->duracion_anios              = $request->duracion_anios;
            $hoja1->duracion_meses              = $request->duracion_meses;
            $hoja1->jfactibilidad_legal         = $factibilidad_legal;
            $hoja1->jfactibilidad_ambiental     = $factibilidad_ambiental;
            $hoja1->jfactibilidad_tecnica       = $factibilidad_tecnica;
            $hoja1->id_usuario                  = \Auth::user()->id;

            $hoja1->save();

            if ($bNuevo) {
                //Guardamos la relacion del Anexo 1 a la tabla estudio socioeconomuico
                $estudio_socioeconomico                       = new P_Estudio_Socioeconomico;
                //$estudio_socioeconomico->ejercicio            = $request->ejercicio;
                $estudio_socioeconomico->id_anexo_uno_estudio = $hoja1->id;
                $estudio_socioeconomico->id_estatus           = 1;
                $estudio_socioeconomico->fecha_registro       = date('Y-m-d H:i:s');
                $estudio_socioeconomico->id_usuario           = \Auth::user()->id;
                $estudio_socioeconomico->save();

                $id_estudio_socioeconomico = $estudio_socioeconomico->id;

                //Creamos nueva relación en Rel_Estudio_Expediente_Obra
                $rel_estudio_expediente_obra                            = new Rel_Estudio_Expediente_Obra;
                $rel_estudio_expediente_obra->id_estudio_socioeconomico = $id_estudio_socioeconomico;
                //$rel_estudio_expediente_obra->ejercicio                 = $request->ejercicio;
                $rel_estudio_expediente_obra->id_usuario                = \Auth::user()->id;
                $rel_estudio_expediente_obra->save();

            } else {
                //obtener el id del estudio que se quiere actualizar
                $estudio_socioeconomico             = P_Estudio_Socioeconomico::find($request->estudio_socioeconomico);
                $estudio_socioeconomico->id_usuario = \Auth::user()->id;
                $estudio_socioeconomico->save();
            }
            // dd($id_estudio_socioeconomico);
            // Guardado de la relacion de fuentes con el estudio
            $syncArray = array();
            if (isset($request->fuente_federal[0])) {
                foreach ($request->fuente_federal as $key => $value) {
                    $syncArray[$value] = array('id_estudio_socioeconomico' => $estudio_socioeconomico->id,
                        'monto'                                                => str_replace(",", "", $request->monto_fuente_federal[$key]),
                        'tipo_fuente'                                          => 'F');
                }
            }

            if (isset($request->fuente_estatal[0])) {
                foreach ($request->fuente_estatal as $key => $value) {
                    $syncArray[$value] = array('id_estudio_socioeconomico' => $estudio_socioeconomico->id,
                        'monto'                                                => str_replace(",", "", $request->monto_fuente_estatal[$key]),
                        'tipo_fuente'                                          => 'E');
                }
            }
            // dd($syncArray);

            $estudio_socioeconomico->fuentes_monto()->sync($syncArray);

            //Guardado de la relacion de acuerdos con el estudio
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
                $estudio_socioeconomico->acuerdos()->sync($acciones);
            } else {
                $estudio_socioeconomico->acuerdos()->detach();
            }

            DB::commit();

            $estudio['id_anexo_uno_estudio']      = $hoja1->id;
            $estudio['id_estudio_socioeconomico'] = $estudio_socioeconomico->id;
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

    public function guardar_hoja_2(Request $request)
    {
        $estudio      = array();
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
            $estudio['microlocalizacion'] = asset('/uploads/' . $nombre);
            $bNuevaImagen                 = true;
        }

        if ($request->id_hoja_dos != "") {
            $bNuevo = false;
        } else {
            $bNuevo = true;
        }

        DB::beginTransaction();
        try {

            if ($bNuevo) {
                $hoja2 = new P_Anexo_Dos_Estudiosocioeconomico;
            } else {
                $hoja2 = P_Anexo_Dos_Estudiosocioeconomico::find($request->id_hoja_dos);
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
            $estudio_socioeconomico = P_Estudio_Socioeconomico::find($request->id_estudio_socioeconomico);

            if (isset($request->id_region)) {
                $estudio_socioeconomico->regiones()->sync($request->id_region);
            } else {
                $estudio_socioeconomico->regiones()->detach();
            }

            if (isset($request->id_municipio)) {
                $estudio_socioeconomico->municipios()->sync($request->id_municipio);
            } else {
                $estudio_socioeconomico->municipios()->detach();
            }

            //Guardamos la relacion del Anexo 2 a la tabla estudio socioeconomuico
            if ($bNuevo) {
                $estudio_socioeconomico->id_anexo_dos_estudio = $hoja2->id;
                $estudio_socioeconomico->id_usuario           = \Auth::user()->id;
                $estudio_socioeconomico->save();
            }

            if (isset($imagen_anterior)) {
                \Storage::disk('uploads')->delete($imagen_anterior);
            }

            //indicamos que queremos guardar un nuevo archivo en el disco local

            DB::commit();

            $estudio['id_anexo_dos_estudio']      = $hoja2->id;
            $estudio['id_estudio_socioeconomico'] = $estudio_socioeconomico->id;

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

    public function eliminar_imagen(Request $request)
    {
        $hoja1 = P_Anexo_Dos_Estudiosocioeconomico::find($request->id_hoja_dos);
        if ($hoja1->microlocalizacion) {
            \Storage::disk('uploads')->delete($hoja1->microlocalizacion);
            $hoja1->microlocalizacion = null;
            $hoja1->save();
        }
    }

    public function enviar_dictaminar(Request $request)
    {
        DB::beginTransaction();

        try {
            $estudio_socioeconomico             = P_Estudio_Socioeconomico::find($request->id_estudio_socioeconomico);
            $estudio_socioeconomico->id_estatus = 2;
            $estudio_socioeconomico->touch();
            $estudio_socioeconomico->save();

            $id_mov_banco = $this->genera_movimiento($estudio_socioeconomico->id);
            DB::commit();
            return ($id_mov_banco);
        } catch (\Exception $e) {
            DB::rollback();
            $estudio            = array();
            $estudio['message'] = $e->getMessage();
            $estudio['trace']   = $e->getTrace();
            $estudio['error']   = "Aviso: Ocurrió un error al enviar a dictaminar.";
            return ($estudio);
        }
    }

    public function genera_movimiento($id_estudio_socioeconomico)
    {

        $movimiento_banco                            = new P_Movimiento_Banco;
        $movimiento_banco->id_estudio_socioeconomico = $id_estudio_socioeconomico;
        $movimiento_banco->fecha_movimiento          = date('Y-m-d H:i:s');
        $movimiento_banco->id_tipo_movimiento        = 2;
        $movimiento_banco->status                    = 'bloqueado';
        $movimiento_banco->save();
        return $movimiento_banco->id;
    }

    public function ficha_tecnica($id_estudio_socioeconomico)
    {
        $estudio       = P_Estudio_Socioeconomico::with(['hoja1.sector', 'hoja1.unidad_ejecutora', 'hoja2', 'acuerdos', 'fuentes_monto', 'regiones', 'municipios'])->findOrFail($id_estudio_socioeconomico);
        $arrayAcuerdos = array();
        foreach ($estudio->acuerdos as $key => $value) {
            array_push($arrayAcuerdos, $value->id_acuerdo);
        }
        // dd($arrayAcuerdos);
        $acuerdos_federales = Cat_Acuerdo::whereIn('id', $arrayAcuerdos)->where('id_tipo', '=', 4)->get();
        $acuerdos_estatales = Cat_Acuerdo::whereIn('id', $arrayAcuerdos)->whereIn('id_tipo', array(1, 2))->get();
        // dd($acuerdos_estatales);

        $pdf = \PDF::loadView('PDF/ficha_tecnica', compact('estudio', 'acuerdos_federales', 'acuerdos_estatales'));
        return $pdf->stream('ficha_tecnica_' . $id_estudio_socioeconomico . '.pdf');
    }

}
