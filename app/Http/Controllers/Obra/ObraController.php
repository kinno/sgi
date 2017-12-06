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
use App\User;
use App\Cat_Unidad_Ejecutora;
use Illuminate\Support\Facades\DB;

class ObraController extends Controller
{
	use Funciones;

	public $rules = [
		'id_modalidad_ejecucion'	=> 'not_in:0',
		'ejercicio'					=> 'not_in:0',
		'id_clasificacion_obra'		=> 'not_in:0',
		'id_tipo_obra'				=> 'not_in:0',
		'id_sector'					=> 'not_in:0',
		'id_unidad_ejecutora'		=> 'not_in:0',
		'nombre'					=> 'required',
		'id_cobertura'				=> 'not_in:0',
		'monto'						=> 'required|numeric|not_in:0',
		'id_proyecto_ep'			=> 'not_in:0',
		'id_region'					=> 'required_if:id_cobertura,2',
		'id_municipio'				=> 'required_if:id_cobertura,3',
		'monto_federal.*'	=> 'required_with:fuente_federal.*|required_with:partida_federal.*|required_with:cuenta_federal.*',
		'fuente_federal.*'	=> 'required_with:monto_federal.*|required_with:partida_federal.*|required_with:cuenta_federal.*',
		'partida_federal.*'	=> 'required_with:monto_federal.*|required_with:fuente_federal.*|required_with:cuenta_federal.*',
		'cuenta_federal.*'	=> 'required_with:monto_federal.*|required_with:fuente_federal.*|required_with:partida_federal.*',
		'monto_estatal.*'	=> 'required_with:fuente_estatal.*|required_with:partida_estatal.*|required_with:cuenta_estatal.*',
		'fuente_estatal.*'	=> 'required_with:monto_estatal.*|required_with:partida_estatal.*|required_with:cuenta_estatal.*',
		'partida_estatal.*'	=> 'required_with:monto_estatal.*|required_with:fuente_estatal.*|required_with:cuenta_estatal.*',
		'cuenta_estatal.*'	=> 'required_with:monto_estatal.*|required_with:fuente_estatal.*|required_with:partida_estatal.*'
		];
	protected $messages = [
			'id_modalidad_ejecucion.not_in'		=> 'Seleccione Modalidad de Ejecución',
			'ejercicio.not_in'					=> 'Seleccione Ejercicio',
			'id_clasificacion_obra.not_in'		=> 'Seleccione Clasificación de la Obra',
			'id_tipo_obra.not_in'				=> 'Seleccione Tipo de Obra',
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
			'partida_federal.*.required_with'	=> 'Introduzca Partida',
			'cuenta_federal.*.required_with'	=> 'Introduzca No. de cuenta Federal',
			'monto_estatal.*.required_with'		=> 'Introduzca monto Estatal',
			'fuente_estatal.*.required_with'	=> 'Seleccione Fuente Estatal',
			'partida_estatal.*.required_with'	=> 'Introduzca Partida',
			'cuenta_estatal.*.required_with'	=> 'Introduzca No. de cuenta Estatal',
		];
	protected $barraMenu = array(
			'botones' => array([
				'id'    => 'btnGuardar',
				'tipo'  => 'btn-success',
				'icono' => 'fa fa-save',
				'title' => 'Guardar',
				'texto' => 'Guardar'
			], [
				'id'    => 'btnLimpiar',
				'tipo'  => 'btn-warning',
				'icono' => 'fa fa-eraser',
				'title' => 'Limpiar pantalla',
				'texto' => 'Limpiar'
			] ));

	public function __construct()
	{
		$this->middleware(['auth','verifica.notificaciones']);
	}


	public function index(Request $request)
	{   
		$opciones = array ();
		$ids_Sector = $this->getIdsSectores();
		$opciones += $this->opcionesEjercicio();
		$opciones['modalidad'] = $this->opcionesModalidadEjecucion();
		$opciones['clasificacion'] = $this->opcionesClasificacion();
		$opciones['tipo_obra'] = $this->opcionesTipoObra();
		$opciones += $this->opcionesSector(0, 0, true, $ids_Sector, true);
		$opciones['cobertura'] = $this->opcionesCobertura();
		$opciones['region'] = $this->opcionesRegion();
		$opciones['municipio'] = $this->opcionesMunicipio();
		$opciones['fuente_federal'] = $this->opcionesFuente(2);
		$opciones['fuente_estatal'] = $this->opcionesFuente(1);
		$opciones['acuerdo_estatal'] = $this->opcionesAcuerdo('E');
		$opciones['acuerdo_federal'] = $this->opcionesAcuerdo('F');
		$opciones['grupo'] = $this->opcionesGrupoSocial();
		return view('Obra.index')
			->with('opciones', $opciones)
			->with('barraMenu', $this->barraMenu);
	}

	public function buscar_expediente(Request $request)
	{
		$error = array();
		$ids_Sector = $this->getIdsSectores();
		try {
			$expediente = P_Expediente_Tecnico::with(['hoja1.sector', 'hoja2', 'acuerdos', 'fuentes_monto', 'regiones', 'municipios', 'relacion'])->where('id', $request->id_expediente_tecnico)->first();
			if (count($expediente) == 0) {
				$error['error'] = "No existe Expediente Técnico";
				return ($error);
			}
			// Aceptado
			if ($expediente->id_estatus != 6) {
				$error['error'] = "Expediente Técnico no tiene estatus de Aceptado";
				return ($error);
			}
			//$relacion = $expediente->relacion;
			if (count($expediente->relacion) == 0) {
				$error['error'] = "Con este Expediente Técnico no se puede crear la obra";
				return ($error);
			}
			if ($expediente->relacion->id_det_obra != 0) {
				$error['error'] = "Este expediente ya tiene relacionada una obra";
				return ($error);
			}
			if (!in_array($expediente->hoja1->id_sector, $ids_Sector)) {
				$error['error'] = "Este expediente no te corresponde.<br>Pertenece al sector: ".$expediente->hoja1->sector->nombre;
				return ($error);
			}
			//$ejecutoras = $expediente->hoja1->sector->unidad_ejecutoras->toArray();
			//$expediente['opciones_ue'] = $this->llena_combo($ejecutoras, $expediente->hoja1->id_unidad_ejecutora);
			$expediente['opciones'] = array ('ue' => $this->opcionesUnidadEjecutora($expediente->hoja1->id_sector, $expediente->hoja1->id_unidad_ejecutora, true));
			$expediente['opciones'] += $this->opcionesPrograma($expediente->ejercicio);
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
		$error = array();
		$ids_Sector = $this->getIdsSectores();
		try {
			$obra = D_Obra::with(['acuerdos', 'fuentes', 'regiones', 'municipios', 'relacion', 'sector'])->where('id_obra', $request->id_obra)->where('ejercicio', $request->ejercicio)->first();
			$obra['has_oficios'] = $this->hasOficios($obra);
			if (count($obra) == 0) {
				$error['error'] = 'No existe Obra '.$request->id_obra.' en ejercicio '.$request->ejercicio;
				return $error;
			}
			if (!in_array($obra->id_sector, $ids_Sector)) {
				$error['error'] = "Este obra no te corresponde.<br>Pertenece al sector: ".$obra->sector->nombre;
				return $error;
			}
			$obra['opciones'] = array('ue' => $this->opcionesUnidadEjecutora($obra->id_sector, $obra->id_unidad_ejecutora));
			$programa = Cat_Estructura_Programatica::where('ejercicio', $obra->ejercicio)->where('tipo', 'P')->where('clave', 'like', substr($obra->proyecto->clave, 0, 8).'%')->get()->first();
			$obra['opciones'] += $this->opcionesPrograma($obra->ejercicio, $programa->id, $obra->id_proyecto_ep);
			return $obra;
		} 
		catch (\Exception $e) {
			$obra            = array();
			$obra['message'] = $e->getMessage();
			$obra['trace']   = $e->getTrace();
			//$obra['error']   = "No existe Obra";
			return $obra;
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
		// $data = $this->validaMonto($request, 'F', 0);
		// if (count($data) > 0)
		// 	return $data;
		// $data = $this->validaMonto($request, 'E', 0);
		// if (count($data) > 0)
		// 	return $data;
		$data = array();
		try {
			$d_obra  = new D_Obra($request->only(['id_modalidad_ejecucion', 'ejercicio', 'id_clasificacion_obra', 'id_tipo_obra', 'id_sector', 'id_unidad_ejecutora', 'nombre', 'justificacion', 'caracteristicas', 'id_cobertura', 'localidad', 'id_proyecto_ep', 'id_grupo_social']));
			$id_usuario = \Auth::user()->id;
			return $request->all();
			if ($request->id_cobertura <= 2)
				$d_obra->id_municipio = $request->id_cobertura;
			else if (count($request->id_municipio) > 1)
				$d_obra->id_municipio = 3;
			else
				$d_obra->id_municipio = $request->id_municipio[0] + 3;
			if ($request->accion == 1)
				$relacion = Rel_Estudio_Expediente_Obra::where('id_expediente_tecnico', $request->id_exp_tec)->first();
			else {
				$relacion = new Rel_Estudio_Expediente_Obra();
				$relacion->id_usuario = $id_usuario;
			}
			$p_obra = new P_Obra();
			DB::transaction(function () use ($p_obra, $d_obra, $relacion, $request, $id_usuario) {
				$p_obra->save();
				$d_obra->id_obra = $p_obra->id;
				$d_obra->id_usuario = $id_usuario;
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
							'partida' => $request->partida_federal[$key],
							'tipo_fuente' => 'F');
					}
				if (isset($request->fuente_estatal[0]) && $request->fuente_estatal[0] > 0)
					foreach ($request->fuente_estatal as $key => $value) {
						$syncArray[$value] = array('id_det_obra' => $d_obra->id,
						'monto' => $request->monto_estatal[$key],
						'cuenta' => $request->cuenta_estatal[$key],
						'partida' => $request->partida_estatal[$key],
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
		/*
		$data = $this->validaMonto($request, 'F', $request->id_det_obra);
		if (count($data) > 0)
			return $data;
		$data = $this->validaMonto($request, 'E', $request->id_det_obra);
		if (count($data) > 0)
			return $data;
		*/
		$data = array();
		try {
			$d_obra = D_Obra::find($request->id_det_obra);
			$has_oficios = $this->hasOficios($obra);			
			$d_obra->id_clasificacion_obra = $request->id_clasificacion_obra;
			$d_obra->id_tipo_obra = $request->id_tipo_obra;
			$d_obra->id_grupo_social = $request->id_grupo_social;
			if (!$has_oficios) {
				$d_obra->id_modalidad_ejecucion = $request->id_modalidad_ejecucion;
				$d_obra->ejercicio = $request->ejercicio;
				$d_obra->id_sector = $request->id_sector;
				$d_obra->id_unidad_ejecutora = $request->id_unidad_ejecutora;
				$d_obra->nombre = $request->nombre;
				$d_obra->justificacion = $request->justificacion;
				$d_obra->caracteristicas = $request->caracteristicas;
				$d_obra->id_cobertura = $request->id_cobertura;
				$d_obra->localidad = $request->localidad;
				$d_obra->id_proyecto_ep = $request->id_proyecto_ep;
				if ($request->id_cobertura <= 2)
					$d_obra->id_municipio = $request->id_cobertura;
				else if (count($request->id_municipio) > 1)
					$d_obra->id_municipio = 3;
				else
					$d_obra->id_municipio = $request->id_municipio[0] + 3;
			}
			DB::transaction(function () use ($d_obra, $request, $has_oficios) {
				$d_obra->save();
				if (!$has_oficios) {
					// fuentes
					$syncArray = array();
					if (isset($request->fuente_federal[0]) && $request->fuente_federal[0] > 0)
						foreach ($request->fuente_federal as $key => $value) {
						   $syncArray[$value] = array('id_det_obra' => $d_obra->id,
								'monto' => $request->monto_federal[$key],
								'cuenta' => $request->cuenta_federal[$key],
								'partida' => $request->partida_federal[$key],
								'tipo_fuente' => 'F');
						}
					if (isset($request->fuente_estatal[0]) && $request->fuente_estatal[0] > 0)
						foreach ($request->fuente_estatal as $key => $value) {
							$syncArray[$value] = array('id_det_obra' => $d_obra->id,
							'monto' => $request->monto_estatal[$key],
							'cuenta' => $request->cuenta_estatal[$key],
							'partida' => $request->partida_estatal[$key],
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
				}
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

	public function hasOficios($obra)
	{
		if ($obra->asignado == 0) {
			$respuesta = false;
			if (count($obra->detalles_oficio) > 0) 
				$respuesta = true;
		}
		else
			$respuesta = true;
		return $respuesta;
	}
}
