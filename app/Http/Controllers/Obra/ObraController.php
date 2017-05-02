<?php

namespace App\Http\Controllers\Obra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Cat_Ejercicio;
use App\Cat_Sector;
use App\Cat_Grupo_Social;
use App\Cat_Modalidad_Ejecucion;
use App\Cat_Clasificacion_Obra;
use App\Cat_Acuerdo;
use App\Cat_Fuente;
use App\Cat_Region;
use App\Cat_Municipio;
use App\Cat_Estructura_Programatica;
use App\Cat_Cobertura;
use App\D_Obra;
use App\P_Obra;
//use App\;
use Illuminate\Support\Facades\DB;

class ObraController extends Controller
{
	use Funciones;

	public $rules = [
            'id_modalidad_ejecucion'	=> 'not_in:0',
            'ejercicio'					=> 'not_in:0',
            'id_clasificacion_obra'		=> 'not_in:0',
            'id_sector'					=> 'not_in:0',
            'id_unidad_ejecutora'		=> 'not_in:0',
            'nombre'					=> 'required',
            'id_cobertura'				=> 'not_in:0',
            'monto'						=> 'required|numeric|not_in:0',
            'id_proyecto_ep'			=> 'not_in:0',
            'id_region'					=> 'required_if:id_cobertura,2',
            'id_municipio'				=> 'required_if:id_cobertura,3',
            'monto_federal.*'			=> 'required_with:fuente_federal.*',
            'fuente_federal.*'			=> 'required_with:monto_federal.*',
            'monto_estatal.*'			=> 'required_with:fuente_estatal.*',
            'cuenta_federal.*'			=> 'required_with:fuente_federal.*',
            'fuente_estatal.*'			=> 'required_with:monto_estatal.*',
            'cuenta_federal.*'			=> 'required_with:fuente_federal.*',
            'cuenta_estatal.*'			=> 'required_with:fuente_estatal.*',
        ];

    protected $messages = [
            'id_modalidad_ejecucion.not_in'		=> 'Seleccione Modalidad de Ejecución',
            'ejercicio.not_in'					=> 'Seleccione Ejercicio',
            'id_clasificacion_obra.not_in'		=> 'Seleccione Clasificación de la Obra',
            'id_sector.not_in'					=> 'Seleccione Sector',
            'id_unidad_ejecutora.not_in'		=> 'Seleccione Unidad Ejecutora',
            'nombre.required'					=> 'Introduzca nombre de la Obra',
            'id_cobertura.not_in'				=> 'Seleccione Cobertura',
            'monto.required'					=> 'Introduzca monto de la Obra',
            'monto.not_in'						=> 'Introduzca monto de la Obra',
            'id_proyecto_ep.not_in'				=> 'Seleccione Proyecto de la EP',
            'id_region.required_if'				=> 'Seleccione al menos una Región',
            'id_municipio.required_if'			=> 'Seleccione al menos un Municipio',
            'monto_federal.*.required_with'		=> 'Introduzac monto Federal',
            'fuente_federal.*.required_with'	=> 'Seleccione Fuente Federal',
            'cuenta_federal.*.required_with'	=> 'Introduzca No. de cuenta Federal',
            'monto_estatal.*.required_with'		=> 'Introduzac monto Estatal',
            'fuente_estatal.*.required_with'	=> 'Seleccione Fuente Estatal',
            'cuenta_estatal.*.required_with'	=> 'Introduzca No. de cuenta Estatal',
        ];

	public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $modalidades 		= Cat_Modalidad_Ejecucion::orderBy('nombre', 'ASC')->get()->toArray();
        $ejercicios 		= Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get()->toArray();
        $clasificaciones 	= Cat_Clasificacion_Obra::get()->toArray();
        $sectores 			= Cat_Sector::where('bactivo', 1)->orderBy('nombre', 'ASC')->get()->toArray();
        $coberturas		 	= Cat_Cobertura::get()->toArray();
        $regiones 			= Cat_Region::orderBy('nombre', 'ASC')->get()->toArray();
        $municipios 		= Cat_Municipio::orderBy('nombre', 'ASC')->get()->toArray();
        $fuentes_federales 	= Cat_Fuente::where('tipo', 'F')->orderBy('descripcion', 'ASC')->get()->toArray();
        $fuentes_estatales 	= Cat_Fuente::where('tipo', 'E')->orderBy('descripcion', 'ASC')->get()->toArray();
        $acuerdos_estatales = Cat_Acuerdo::whereIn('id_tipo_acuerdo',[1, 2])->orderBy('clave_acuerdo', 'ASC')->get()->toArray();
        $acuerdos_federales = Cat_Acuerdo::where('id_tipo_acuerdo', 4)->orderBy('clave_acuerdo', 'ASC')->get()->toArray();
        $grupos 			= Cat_Grupo_Social::orderBy('nombre', 'ASC')->get()->toArray();

        $opciones_ejercicio = $this->llena_combo ($ejercicios, 0, 'ejercicio', 'ejercicio');
        $opciones_sector = $this->llena_combo ($sectores);
        $opciones_cobertura = $this->llena_combo ($coberturas);        
        $opciones_grupo = $this->llena_combo ($grupos);
        $opciones_modalidad = $this->llena_combo ($modalidades);
        $opciones_clasificacion = $this->llena_combo ($clasificaciones);
        $opciones_acuerdo_estatal = $this->llena_combo ($acuerdos_estatales, 0, 'clave_acuerdo,nombre_acuerdo', 'id', false);
        $opciones_acuerdo_federal = $this->llena_combo ($acuerdos_federales, 0, 'clave_acuerdo,nombre_acuerdo', 'id', false);
        $opciones_fuente_estatal = $this->llena_combo ($fuentes_estatales, 0, 'clave,descripcion');
        $opciones_fuente_federal = $this->llena_combo ($fuentes_federales, 0, 'clave,descripcion');
        $opciones_region = $this->llena_combo ($regiones, 0, 'nombre', 'id', false);
        $opciones_municipio = $this->llena_combo ($municipios, 0, 'nombre', 'id', false);
        //dd ($ejercicios);
        return view('Obra.index')
            ->with('opciones_modalidad', $opciones_modalidad)
            ->with('opciones_ejercicio', $opciones_ejercicio)
            ->with('opciones_sector', $opciones_sector)
            ->with('opciones_clasificacion', $opciones_clasificacion)
            ->with('opciones_cobertura', $opciones_cobertura)
            ->with('opciones_region', $opciones_region)
            ->with('opciones_municipio', $opciones_municipio)
            ->with('opciones_acuerdo_federal', $opciones_acuerdo_federal)
            ->with('opciones_acuerdo_estatal', $opciones_acuerdo_estatal)
            ->with('opciones_fuente_federal', $opciones_fuente_federal)
            ->with('opciones_fuente_estatal', $opciones_fuente_estatal)
            ->with('opciones_grupo', $opciones_grupo);
    }

    public function buscar_expediente(Request $request)
    {
        return array('uno' => $request->toArray());
        /*try {
            $estudio = P_Estudio_Socioeconomico::with(['hoja1.sector', 'hoja1.unidad_ejecutora', 'hoja2', 'acuerdos', 'fuentes_monto', 'regiones', 'municipios'])->findOrFail($request->id_estudio_socioeconomico);

            if ($estudio->id_estatus == 1 || $estudio->id_estatus == 5) {
                //*CREACIÓN/EDICION    DEVOLUCIÓN A DEPENDENCIA
                $estudio['rutaReal'] = asset('/uploads/');
                return $estudio;
            } else {
                $estudio          = array();
                $estudio['error'] = "El Estudio Socioeconómico no se puede editar";
                return $estudio;
            }

        } 
        catch (\Exception $e) {
            $estudio            = array();
            $estudio['message'] = $e->getMessage();
            $estudio['trace']   = $e->getTrace();
            $estudio['error']   = "No existe Expediente Técnico";
            return ($estudio);
        }*/
    }

    public function buscar_obra(Request $request)
    {
        try {
            /*$obra = D_Obra::where('id_obra', 0)->where('ejercicio', $request->ejercicio)->count();
            if ($obra == 0)
            	return array('uno' => $request->toArray());*/

            $obra = D_Obra::with(['acuerdos', 'fuentes', 'regiones', 'municipios'])->where('id_obra', $request->id_obra)->where('ejercicio', $request->ejercicio)->firstOrFail();
            $ejecutoras = $obra->sector->unidad_ejecutoras->toArray();
	        $opciones = $this->llena_combo($ejecutoras, $obra->id_unidad_ejecutora);
	        $obra['opciones_ue'] = $opciones;
	        $proyecto = $obra->proyecto;
	        //$obra['proyecto'] = $proyecto;	        
	        $programas = Cat_Estructura_Programatica::where('ejercicio', $obra->ejercicio)->where('tipo', 'P')->orderBy('clave','ASC')->get()->toArray();
	        $programa = Cat_Estructura_Programatica::where('ejercicio', $obra->ejercicio)->where('tipo', 'P')->where('clave', 'like', substr($proyecto->clave, 0, 8).'%')->get()->first();
        	$opciones = $this->llena_combo($programas, $programa->id, 'clave,nombre');
        	$obra['opciones_programa'] = $opciones;
	        $proyectos = Cat_Estructura_Programatica::where('ejercicio', $request->ejercicio)->where('clave', 'like', $programa->clave.'%')->where('tipo', 'PRY')->orderBy('clave','ASC')->get()->toArray();
	        $opciones = $this->llena_combo($proyectos, $proyecto->id, 'clave,nombre');
	        $obra['opciones_proyecto'] = $opciones;

            return $obra;
        } 
        catch (\Exception $e) {
            $obra            = array();
            $obra['message'] = $e->getMessage();
            $obra['trace']   = $e->getTrace();
            $obra['error']   = "No existe Obra";
            return ($obra);
        }
    }

    public function guardar (Request $request)
    {
        $valores = $request->all();
        foreach ($valores['monto_federal'] as $clave => $valor) {
        	if ($valor == 0)
        		$valores['monto_federal'][$clave] = null;
        }
        foreach ($valores['fuente_federal'] as $clave => $valor) {
        	if ($valor == 0)
        		$valores['fuente_federal'][$clave] = null;
        }
        foreach ($valores['monto_estatal'] as $clave => $valor) {
        	if ($valor == 0)
        		$valores['monto_estatal'][$clave] = null;
        }
        foreach ($valores['fuente_estatal'] as $clave => $valor) {
        	if ($valor == 0)
        		$valores['fuente_estatal'][$clave] = null;
        }
        //return array('uno' => $valores);
        $validator = \Validator::make($valores, $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            $d_obra  = new D_Obra($request->only(['id_modalidad_ejecucion', 'ejercicio', 'id_clasificacion_obra', 'id_sector', 'id_unidad_ejecutora', 'nombre', 'justificacion', 'caracteristicas', 'id_cobertura', 'localidad', 'id_proyecto_ep', 'id_grupo_social']));
            if ($request->id_cobertura <= 2)
            	$d_obra->id_municipio = $request->id_cobertura;
            else if (count($valores['id_municipio']) > 1)
            	$d_obra->id_municipio = 3;
            else
            	$d_obra->id_municipio = $valores['id_municipio'][0] + 3;

            $p_obra = new P_Obra();
            DB::transaction(function () use ($p_obra, $d_obra, $request) {
                $p_obra->save();
                $d_obra->id_obra = $p_obra->id;
                $d_obra->id_usuario = \Auth::user()->id;
                $d_obra->save();
                // fuentes
                $syncArray = array();
                if (isset($request->fuente_federal[0]))
	                foreach ($request->fuente_federal as $key => $value) {
	                   $syncArray[$value] = array('id_det_obra'=>$d_obra->id,
	                        'monto'=>str_replace(",", "", $request->monto_federal[$key]),
	                        'cuenta'=>'ejemplo');
	                }
                if (isset($request->fuente_estatal[0]))
	                foreach ($request->fuente_estatal as $key => $value) {
	                    $syncArray[$value] = array('id_det_obra'=>$d_obra->id,
	                    'monto'=>str_replace(",", "", $request->monto_estatal[$key]),
	                    'cuenta'=>'otro');
	                }
	            $d_obra->fuentes()->sync($syncArray);
	            // acuerdos
	            if (isset($request->id_acuerdo_fed) && isset($request->id_acuerdo_est))
	                $acciones = array_merge($request->id_acuerdo_fed, $request->id_acuerdo_est);
	            elseif (isset($request->id_acuerdo_fed) && !isset($request->id_acuerdo_est))
	                $acciones = $request->id_acuerdo_fed;
	            elseif (!isset($request->id_acuerdo_fed) && isset($request->id_acuerdo_est))
	                $acciones = $request->id_acuerdo_est;
	            else
	                $acciones = null;
	            if (isset($acciones))
	                $d_obra->acuerdos()->sync($acciones);
	            else
	                $d_obra->acuerdos()->detach();
	            // regiones
                if (isset($request->id_region))
	                $d_obra->regiones()->sync($request->id_region);
	            else
	                $d_obra->regiones()->detach();
	            // municipios
	            if (isset($request->id_municipio))
	                $d_obra->municipios()->sync($request->id_municipio);
	            else
	                $d_obra->municipios()->detach();
            });
            $data['mensaje'] = "Datos guardados correctamente: ".$p_obra->id;
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }
}
