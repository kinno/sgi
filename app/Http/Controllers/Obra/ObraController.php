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
use App\Rel_Estudio_Expediente_Obra;
use App\P_Expediente_Tecnico;
use App\P_Techo;
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
            'cuenta_federal.*'			=> 'required_with:fuente_federal.*|required_with:monto_federal.*',
            'monto_estatal.*'			=> 'required_with:fuente_estatal.*',
            'fuente_estatal.*'			=> 'required_with:monto_estatal.*',
            'cuenta_estatal.*'			=> 'required_with:fuente_estatal.*|required_with:monto_estatal.*'
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
            'monto_estatal.*.required_with'		=> 'Introduzca monto Estatal',
            'fuente_estatal.*.required_with'	=> 'Seleccione Fuente Estatal',
            'cuenta_estatal.*.required_with'	=> 'Introduzca No. de cuenta Estatal',
        ];

	public function __construct()
    {
        $this->middleware(['auth','verifica.notificaciones']);
    }


    public function index(Request $request)
    {
        $barraMenu = array(
            'botones' => array([
                'id'    => 'btnGuardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
                'texto' => 'Guardar'
            ], [
                'id'    => 'btnLimpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
                'texto' => 'Limpiar'
            ], ));
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
            ->with('opciones_grupo', $opciones_grupo)
            ->with('barraMenu', $barraMenu);
    }

    public function buscar_expediente(Request $request)
    {
        //return array('uno' => $request->toArray());
        try {
        	$expediente = P_Expediente_Tecnico::with(['hoja1', 'hoja2', 'acuerdos', 'fuentes_monto', 'regiones', 'municipios'])->where('id', $request->id_expediente_tecnico)->first();
        	if (count($expediente) == 0) {
        		$expediente = array();
        		$expediente['error'] = "No existe Expediente Técnico";
        		return ($expediente);
        	}
        	// Aceptado, verificar id = 2
        	if ($expediente->id_estatus != 2) {
        		$expediente = array();
        		$expediente['error'] = "Expediente Técnico no tiene estatus de Aceptado";
        		return ($expediente);
        	}
        	$relacion = $expediente->relacion;
        	//$relacion = Rel_Estudio_Expediente_Obra::where('id_expediente_tecnico', $request->id_expediente_tecnico)->first();
        	if (count($relacion) == 0) {
        		$expediente = array();
        		$expediente['error'] = "Con este Expediente Técnico no se puede crear la obra";
        		return ($expediente);
        	}
        	if ($relacion->id_det_obra != 0) {
        		$expediente = array();
        		$expediente['error'] = "Este expediente, ya tiene relacionada una obra";
        		return ($expediente);
        	}
            $ejecutoras = $expediente->hoja1->sector->unidad_ejecutoras->toArray();
	        $opciones = $this->llena_combo($ejecutoras, $expediente->hoja1->id_unidad_ejecutora);
	        $expediente['opciones_ue'] = $opciones;
	        $programas = Cat_Estructura_Programatica::where('ejercicio', $expediente->ejercicio)->where('tipo', 'P')->orderBy('clave','ASC')->get()->toArray();
        	$opciones = $this->llena_combo($programas, 0, 'clave,nombre');
        	$expediente['opciones_programa'] = $opciones;
            return ($expediente);
        } 
        catch (\Exception $e) {
            $expediente = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Error general";
            return ($expediente);
        }
    }

    public function buscar_obra(Request $request)
    {
        try {
            $obra = D_Obra::with(['acuerdos', 'fuentes', 'regiones', 'municipios', 'relacion'])->where('id_obra', $request->id_obra)->where('ejercicio', $request->ejercicio)->firstOrFail();
            $ejecutoras = $obra->sector->unidad_ejecutoras->toArray();
	        $opciones = $this->llena_combo($ejecutoras, $obra->id_unidad_ejecutora);
	        $obra['opciones_ue'] = $opciones;
	        $proyecto = $obra->proyecto;	        
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
        //return $request->all();
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = $this->validaMonto($request, 'F', 0);
        if (count($data) > 0)
            return $data;
        $data = $this->validaMonto($request, 'E', 0);
        if (count($data) > 0)
            return $data;
        $data = array();
        try {
            $d_obra  = new D_Obra($request->only(['id_modalidad_ejecucion', 'ejercicio', 'id_clasificacion_obra', 'id_sector', 'id_unidad_ejecutora', 'nombre', 'justificacion', 'caracteristicas', 'id_cobertura', 'localidad', 'id_proyecto_ep', 'id_grupo_social']));
            if ($request->id_cobertura <= 2)
            	$d_obra->id_municipio = $request->id_cobertura;
            else if (count($request->id_municipio) > 1)
            	$d_obra->id_municipio = 3;
            else
            	$d_obra->id_municipio = $request->id_municipio[0] + 3;
            if ($request->accion == 1) {
            	$relacion = Rel_Estudio_Expediente_Obra::where('id_expediente_tecnico', $request->id_exp_tec)->first();
            	$relacion->id_usuario = \Auth::user()->id;
            }
            else
            	$relacion = new Rel_Estudio_Expediente_Obra();
            $p_obra = new P_Obra();
            DB::transaction(function () use ($p_obra, $d_obra, $relacion, $request) {
                $p_obra->save();
                $d_obra->id_obra = $p_obra->id;
                $d_obra->id_usuario = \Auth::user()->id;
                $d_obra->save();
                $relacion->id_det_obra = $d_obra->id;
                $relacion->save();
                
                // fuentes
                $syncArray = array();
                if (isset($request->fuente_federal[0]) && $request->fuente_federal[0] > 0)
	                foreach ($request->fuente_federal as $key => $value) {
	                   $syncArray[$value] = array('id_det_obra' => $d_obra->id,
	                        'monto' => $request->monto_federal[$key],
	                        'cuenta' => $request->cuenta_federal[$key],
	                        'tipo_fuente' => 'F');
	                }
                if (isset($request->fuente_estatal[0]) && $request->fuente_estatal[0] > 0)
	                foreach ($request->fuente_estatal as $key => $value) {
	                    $syncArray[$value] = array('id_det_obra' => $d_obra->id,
	                    'monto' => $request->monto_estatal[$key],
	                    'cuenta' => $request->cuenta_estatal[$key],
	                    'tipo_fuente' => 'E' );
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
            $data['mensaje'] = "Datos guardados correctamente, Obra No: ".$p_obra->id;
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function update (Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = $this->validaMonto($request, 'F', $request->id_det_obra);
        if (count($data) > 0)
            return $data;
        $data = $this->validaMonto($request, 'E', $request->id_det_obra);
        if (count($data) > 0)
            return $data;
        $data = array();
        try {
            $d_obra = D_Obra::find($request->id_det_obra);
            $d_obra->id_modalidad_ejecucion = $request->id_modalidad_ejecucion;
            $d_obra->ejercicio = $request->ejercicio;
            $d_obra->id_clasificacion_obra = $request->id_clasificacion_obra;
            $d_obra->id_sector = $request->id_sector;
            $d_obra->id_unidad_ejecutora = $request->id_unidad_ejecutora;
            $d_obra->nombre = $request->nombre;
            $d_obra->justificacion = $request->justificacion;
            $d_obra->caracteristicas = $request->caracteristicas;
            $d_obra->id_cobertura = $request->id_cobertura;
            $d_obra->localidad = $request->localidad;
            $d_obra->id_proyecto_ep = $request->id_proyecto_ep;
            $d_obra->id_grupo_social = $request->id_grupo_social;
            if ($request->id_cobertura <= 2)
            	$d_obra->id_municipio = $request->id_cobertura;
            else if (count($request->id_municipio) > 1)
            	$d_obra->id_municipio = 3;
            else
            	$d_obra->id_municipio = $request->id_municipio[0] + 3;
            DB::transaction(function () use ($d_obra, $request) {
                $d_obra->save();
                // fuentes
                $syncArray = array();
                if (isset($request->fuente_federal[0]) && $request->fuente_federal[0] > 0)
	                foreach ($request->fuente_federal as $key => $value) {
	                   $syncArray[$value] = array('id_det_obra' => $d_obra->id,
	                        'monto' => $request->monto_federal[$key],
	                        'cuenta' => $request->cuenta_federal[$key],
	                        'tipo_fuente' => 'F');
	                }
                if (isset($request->fuente_estatal[0]) && $request->fuente_estatal[0] > 0)
	                foreach ($request->fuente_estatal as $key => $value) {
	                    $syncArray[$value] = array('id_det_obra' => $d_obra->id,
	                    'monto' => $request->monto_estatal[$key],
	                    'cuenta' => $request->cuenta_estatal[$key],
	                    'tipo_fuente' => 'E' );
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
            $data['mensaje'] = "Datos guardados correctamente, Obra No: ".$d_obra->id_obra;
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function asignado ($request, $fuente, $tipo, $id_det_obra)
    {
        $asignado = DB::table('d_obra')
            ->join('rel_obra_fuente', 'd_obra.id', '=', 'rel_obra_fuente.id_det_obra')
            ->where('ejercicio', $request->ejercicio)
            ->where('id_unidad_ejecutora', $request->id_unidad_ejecutora)
            ->where('id_proyecto_ep', $request->id_proyecto_ep)
            ->where('id_fuente', $fuente)
            ->where('tipo_fuente', $tipo)
            ->where('id_det_obra', '<>', $id_det_obra)
            ->sum(DB::raw('CASE WHEN rel_obra_fuente.asignado > 0 THEN rel_obra_fuente.asignado ELSE rel_obra_fuente.monto END'));
        return $asignado;

    }

    public function techo ($request, $fuente, $tipo)
    {
        $techo = P_Techo::select('techo')
            ->where('ejercicio', $request->ejercicio)
            ->where('id_unidad_ejecutora', $request->id_unidad_ejecutora)
            ->where('id_proyecto_ep', $request->id_proyecto_ep)
            ->where('id_fuente', $fuente)
            ->where('id_tipo_fuente', $tipo)->first();
        if (count($techo) > 0)
            return $techo['techo'];
        else
            return 0;

    }

    public function validaMonto($request, $tipo, $id_det_obra)
    {
        $data = array();
        if ($tipo == 'F') {
            $fuente = $request->fuente_federal;
            $monto = $request->monto_federal;
            $id_tipo = 2;
        }
        else {
            $fuente = $request->fuente_estatal;
            $monto = $request->monto_estatal;
            $id_tipo = 1;
        }
        foreach ($fuente as $key => $value) {
            if ($value != null) {
                $asignado = $this->asignado($request, $value, $tipo, $id_det_obra);
                $techo = $this->techo($request, $value, $id_tipo);
                if ($asignado + $monto[$key] * 1 > $techo) {
                    $fuente = Cat_Fuente::find($value);
                    $data['mensaje'] = "Está rebasando el techo financiero para la fuente: ".$fuente->nombre.'<br>Techo: '.number_format($techo,2).'<br>Asignado: '.number_format($asignado, 2).'<br>A registrar: '.number_format($monto[$key], 2);
                    $data['error'] = 2;
                    return $data;
                }
            }
        }
        return $data;
    }
}
