<?php

namespace App\Http\Controllers\Oficios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\P_Oficio;
use App\Rel_obra_Fuente;
use App\D_Obra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstatusOficioController extends Controller
{
	use Funciones;

	protected $rules = [
		'fecha_firma'	=> 'required_if:id_estatus,1',
		'id_estatus'	=> 'not_in:0'
		];
	protected $messages = [
			'fecha_firma.required_if'		=> 'Seleccione Fecha de Firma',
			'id_estatus.not_in'				=> 'Seleccione Estado'
		];

	protected $barraMenu = array(
			'input' => array('id' => 'clave_oficio_search', 'class' => 'text-right numero', 'title' => 'Oficio:'),
			'botones' => array([
				'id'    => 'btnBuscar',
				'tipo'  => 'btn-default',
				'icono' => 'fa fa-search',
				'title' => 'Buscar'
				//'texto' => 'Buscar'
			], [
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
		//$ids_Sector = $this->getIdsSectores();
		$opciones['estatus_oficio'] = $this->opcionesEstadoOficio();
		return view('Oficios.firma_index')
			->with('opciones', $opciones)
			->with('barraMenu', $this->barraMenu);
	}

	public function buscar_oficio(Request $request)
	{
		//return $request->toArray();
		$error = array();
		$ids_Sector = $this->getIdsSectores();
		try {
			$oficio = P_Oficio::with(['detalle','tipo_solicitud'])->where('clave', $request->clave)->first();
			if (count($oficio) == 0) {
				$error['error'] = "No existe el Oficio.";
				return $error;
			}
			foreach ($oficio->detalle as $detalle) {
				if (!in_array($detalle->obras->id_sector, $ids_Sector)) {
					$error['error'] = 'Este oficio contiene contiene obras que no te corresponden.<br>Obra: '.$detalle->obras->id_obra.'<br>Sector: '.$detalle->obras->sector->nombre;
					return $error;
				}
			}
			$oficio['tabla'] = $this->tabla($oficio);
			//$oficio->fecha_oficio = substr($oficio->fecha_oficio, 8, 2).'-'.substr($oficio->fecha_oficio, 5, 2).'-'.substr($oficio->fecha_oficio, 0, 4);
			$oficio->fecha_oficio = Carbon::parse($oficio->fecha_oficio)->format('d-m-Y');
			if ($oficio->id_estatus == 1)
				$oficio->fecha_firma = Carbon::parse($oficio->fecha_firma)->format('d-m-Y');
			//substr($oficio->fecha_firma, 8, 2).'-'.substr($oficio->fecha_firma, 5, 2).'-'.substr($oficio->fecha_firma, 0, 4);
			return $oficio;
		} 
		catch (\Exception $e) {
			$error['message'] = $e->getMessage();
			$error['trace']   = $e->getTrace();
			return $error;
		}
	}

	public function guardar (Request $request)
	{
		$validator = \Validator::make($request->all(), $this->rules, $this->messages);
		if ($validator->fails()) {
			$errors = $validator->errors()->toArray();
			return array('errores' => $errors);
		}
		$data = array();
		try {
			//$p_oficio  = new P_Oficio($request->only(['id_estatus']));
			$oficio = P_Oficio::where('clave', $request->clave)->first();
			$id_estatus_anterior = $oficio->id_estatus;
			$oficio->id_estatus = $request->id_estatus;
			// Aceptado
			if ($request->id_estatus == 1) {
				$oficio->fecha_firma = Carbon::parse($request->fecha_firma)->format('Y-m-d');
				if ($id_estatus_anterior == 1)
					$operador = 0;
				else
					$operador = 1;
			}
			// Cancelado
			else {
				$oficio->fecha_firma = null;
				if ($id_estatus_anterior == 3)	// Proceso
					$operador = 0;
				else
					$operador = -1;
			}
			$estado = $oficio->estado;
			//return array ('uno' => $oficio);
			DB::transaction(function () use ($oficio, $operador) {
				$oficio->save();
				if ($operador != 0) {
					foreach ($oficio->detalle as $detalle) {
						$d_obra = $detalle->obras;
						$rel_obra_fuente = Rel_Obra_Fuente::where('id_det_obra', $detalle->id_det_obra)->where('id_fuente', $detalle->id_fuente)->first();
						$d_obra->asignado += $detalle->asignado * $operador;
						$d_obra->autorizado += $detalle->autorizado * $operador;
						$rel_obra_fuente->asignado += $detalle->asignado * $operador;
						$rel_obra_fuente->autorizado += $detalle->autorizado * $operador;
						$d_obra->save();
						$rel_obra_fuente->save();
					}
				}
			});
			$data['mensaje'] = "Oficio No: ".$oficio->clave.' '.$estado->nombre;
			$data['error'] = 1;
		}
		catch (\Exception $e) {
			$data['message'] = $e->getMessage();
			$data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
			$data['error'] = 3;
		}
		return ($data);
	}

	public function tabla ($oficio)
	{
		if (count($oficio->detalle) > 0) {
			$salida = '';
			foreach ($oficio->detalle as $detalle) {
				$salida .= '<tr">
								<td>'.$detalle->obras->id_obra.'</td>
								<td>'.$detalle->fuentes->descripcion.'</td>
								<td>'.$detalle->unidad_ejecutora->nombre.'</td>
								<td>'.$detalle->asignado.'</td>
								<td>'.$detalle->autorizado.'</td>
							</tr>';
			}
		}
		else
			$salida = '<tr>
						<td colspan"5">NO EXISTEN OBRAS REGISTRADAS</td>
					</tr>';
		return $salida;
	}
}
