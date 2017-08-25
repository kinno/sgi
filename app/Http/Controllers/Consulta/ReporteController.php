<?php

namespace App\Http\Controllers\Consulta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use Yajra\Datatables\Datatables;
use App\Cat_Reporte;
use App\Cat_Ejercicio;
use App\Cat_Fuente;
use App\Cat_Inversion;
use App\Cat_Recurso;
use App\Cat_Clasificacion_Obra;
use App\Cat_Sector;
use App\Cat_Unidad_Ejecutora;
use App\Cat_Municipio_Reporte;
use App\Cat_Estatus_Ap;
use App\Cat_Estatus_Oficio;
use App\Cat_Tipo_Ap;
use App\Cat_Tipo_Oficio;
use App\Cat_Estructura_Programatica;
use App\Cat_Grupo_Social;
use App\Cat_Modalidad_Ejecucion;
use App\User;
use App\D_Obra;
use App\P_Autorizacion_Pago;
use Carbon\Carbon;

class ReporteController extends Controller
{
	use Funciones;

	protected $barraMenu = array(
			'botones' => array([
				'id'    => 'btnImprimir',
				'tipo'  => 'btn-success',
				'icono' => 'fa fa-file-pdf-o',
				'title' => 'Imprimir',
				'texto' => 'Imprimir'
			], [
				'id'    => 'btnExportar',
				'tipo'  => 'btn-success',
				'icono' => 'fa fa-file-excel-o',
				'title' => 'Exportar',
				'texto' => 'Exportar'
			], [
				'id'    => 'btnLimpiar',
				'tipo'  => 'btn-warning',
				'icono' => 'fa fa-eraser',
				'title' => 'Limpiar pantalla',
				'texto' => 'Limpiar'
			] ));
	protected $id_catalogos = ['ejercicio' => 'd_obra.ejercicio', 'fuente' => 'd_oficio.id_fuente', 'inversion' => 'cat_tipo_fuente.id', 'recurso' => 'p_oficio.id_recurso', 'clasificacion' => 'd_obra.id_clasificacion_obra', 'sector' => 'd_obra.id_sector', 'ejecutora' => 'd_oficio.id_unidad_ejecutora', 'municipio' => 'd_obra.id_municipio', 'estadoOf' => 'p_oficio.id_estatus', 'tipoOf' => 'p_oficio.id_solicitud_presupuesto', 'proyecto' => 'd_obra.id_proyecto_ep', 'grupo' => 'd_obra.id_grupo_social', 'ejecucion' => 'd_obra.id_modalidad_ejecucion'];
	//protected $grupos = [null, 'ejercicio', 'sector', 'ue', 'id_obra', ['fuente', 'inversion']];
	protected $grupos = [];
	protected $valor_grupo = [];

	public function __construct()
	{
		$this->middleware(['auth','verifica.notificaciones']);
	}

	public function index(Request $request)
	{
		$opciones = array ();
		$opciones['tipo_reporte'] = $this->opcionesTipoReporte();
		return view('Consulta.reportes')
			->with('opciones', $opciones)
			->with('barraMenu', $this->barraMenu);
	}

	public function getAnio()
	{
		sleep(1);
		return (date('Y'));
	}

	public function getDataReportes(Request $request)
	{
		$reportes = Cat_Reporte::select(['id', 'id_tipo_reporte', 'nombre', 'descripcion'])
			->with('tipo_reporte')
			->orderBy('id_tipo_reporte', 'ASC')
			->orderBy('nombre', 'ASC');
		return Datatables::of($reportes)
			->filter(function ($query) use ($request) {
				if ($request->id_tipo_reporte > 0) {
					$query->where('id_tipo_reporte', $request->id_tipo_reporte);
				}
			})
			->make(true);
	}

	public function getDataCatalogo(Request $request)
	{
		switch ($request->catalogo) {
			case 'ejercicio':
				$ejercicios = Cat_Ejercicio::select(['ejercicio'])
					->orderBy('ejercicio', 'DESC');
				return Datatables::of($ejercicios)
					->addColumn('action', function ($ejercicio) {
						return '<input type="checkbox" name="chkCat" id="chkCat" data-id="'.$ejercicio->ejercicio.'" value="'.$ejercicio->ejercicio.'">';
					})
					->make(true);
				break;

			case 'fuente':
				$registros = Cat_Fuente::select(['id', 'clave', 'nombre', 'descripcion', 'tipo'])
					->where('nivel', '>=', 4)
					->orderBy('tipo', 'ASC')
					->orderBy('nombre', 'ASC');
				break;

			case 'inversion':
				$registros = Cat_Inversion::select(['id', 'nombre'])
					->orderBy('nombre', 'ASC');
				break;

			case 'recurso':
				$registros = Cat_Recurso::select(['id', 'nombre'])
					->orderBy('nombre', 'ASC');
				break;

			case 'clasificacion':
				$registros = Cat_Clasificacion_Obra::select(['id', 'nombre'])
					->orderBy('nombre', 'ASC');
				break;

			case 'sector':
				$ids_Sector = $this->getIdsSectores();
				$registros = Cat_Sector::select(['id', 'nombre', 'bactivo'])
					->whereIn('id', $ids_Sector)
					->orderBy('bactivo', 'DESC')
					->orderBy('nombre', 'ASC');
				break;

			case 'ejecutora':
				$ids_Sector = $this->getIdsSectores();
				$registros = Cat_Unidad_Ejecutora::select(['id', 'id_sector', 'nombre', 'clave', 'bactivo'])
					->with('sector')
					->whereIn('id_sector', $ids_Sector)
					->orderBy('bactivo', 'DESC')
					->orderBy('nombre', 'ASC');
				break;

			case 'municipio':
				$registros = Cat_Municipio_Reporte::select(['id', 'nombre'])
					->orderBy('id', 'ASC');
				break;

			case 'estadoAP':
				$registros = Cat_Estatus_Ap::select(['id', 'nombre'])
					->orderBy('id', 'ASC');
				break;

			case 'estadoOf':
				$registros = Cat_Estatus_Oficio::select(['id', 'nombre'])
					->orderBy('id', 'ASC');
				break;

			case 'tipoAP':
				$registros = Cat_Tipo_Ap::select(['id', 'nombre'])
					->orderBy('id', 'ASC');
				break;

			case 'tipoOf':
				$registros = Cat_Tipo_Oficio::select(['id', 'nombre'])
					->orderBy('id', 'ASC');
				break;

			case 'programa':
				$registros = Cat_Estructura_Programatica::select(['id', 'ejercicio', 'nombre', 'clave'])
					->where('tipo', 'P')
					->orderBy('ejercicio', 'DESC')
					->orderBy('clave', 'ASC');
				break;

			case 'proyecto':
				$registros = Cat_Estructura_Programatica::select(['id', 'ejercicio', 'nombre', 'clave'])
					->where('tipo', 'PRY')
					->orderBy('ejercicio', 'DESC')
					->orderBy('clave', 'ASC');
				break;

			case 'grupo':
				$registros = Cat_Grupo_Social::select(['id', 'nombre'])
					->orderBy('nombre', 'ASC');
				break;

			case 'ejecucion':
				$registros = Cat_Modalidad_Ejecucion::select(['id', 'nombre'])
					->orderBy('nombre', 'ASC');
				break;
		}
		return Datatables::of($registros)
			->addColumn('action', function ($registro) {
				return '<input type="checkbox" name="chkCat" id="chkCat" data-id="'.$registro->id.'" value="'.$registro->nombre.'">';
			})
			->make(true);
		
	}

	public function impresionPDf(Request $request)
	{
		//dd($request);
		$ids_Sector = $this->getIdsSectores();
		$titulo = str_replace(chr(10), '', $request->titulo);
		if ($request->titulo2 != '')
			$titulo .= '<br>1'.str_replace(chr(10), '', $request->titulo2);
		$usuario = \Auth::user();
		$fecha = date('d/m/Y H:i');
		$periodo = 'Todo';
		$fechas = true;
		$pdf = \PDF::setPaper('legal', 'landscape')->setOptions(['isPhpEnabled' => true]);
		switch ($request->reporte) {
			case 'dSecDepInv':
				//$obras = new D_Obra();
				$this->grupos = [null, 'ejercicio', 'sector', 'ue', 'id_obra', ['fuente', 'inversion']];
				$obras = D_Obra::select('d_obra.id', 'id_obra', 'd_obra.nombre', 'd_obra.ejercicio', 'localidad', 'cat_sector.nombre as sector', 'cat_clasificacion_obra.nombre as clasificacion', 'cat_municipio_reporte.nombre as municipio', 'cat_unidad_ejecutora.nombre as ue', 'cat_fuente.id as id_fuente', 'cat_fuente.nombre as fuente', 'cat_tipo_fuente.nombre as inversion', 'd_oficio.asignado as asignado', 'd_oficio.autorizado as autorizado', 'cat_solicitud_presupuesto.factor', 'p_oficio.clave as oficio', 'fecha_firma')
					->join('cat_sector', 'd_obra.id_sector', '=', 'cat_sector.id')
					->join('cat_clasificacion_obra', 'd_obra.id_clasificacion_obra', '=', 'cat_clasificacion_obra.id')
					->join('cat_municipio_reporte', 'd_obra.id_municipio', '=', 'cat_municipio_reporte.id')
					->join('d_oficio', 'd_obra.id', '=', 'd_oficio.id_det_obra')
					->join('p_oficio', 'd_oficio.id_oficio', '=', 'p_oficio.id')
					->join('cat_unidad_ejecutora', 'd_oficio.id_unidad_ejecutora', '=', 'cat_unidad_ejecutora.id')
					->join('cat_fuente', 'd_oficio.id_fuente', '=', 'cat_fuente.id')
					->join('cat_tipo_fuente', 'cat_fuente.tipo', '=', 'cat_tipo_fuente.clave')
					->join('cat_solicitud_presupuesto', 'd_oficio.id_solicitud_presupuesto', '=', 'cat_solicitud_presupuesto.id');
				$this->opcionesCatalogo($obras, $request);
				$obras = $obras->whereIn('d_obra.id_sector', $ids_Sector);
				$obras = $obras->orderBy('d_obra.ejercicio', 'ASC')->orderBy('sector', 'ASC')->orderBy('ue', 'ASC')->orderBy('id_obra', 'ASC')->orderBy('fuente', 'ASC')->orderBy('inversion', 'ASC')->get()
					->toArray();
				$tabla = $this->tabla_dSecDepInv($obras, $request);
				$pdf = $pdf->loadView('PDF/Reportes/'.$request->reporte, compact('usuario','fecha', 'periodo', 'titulo', 'tabla'));
				return $pdf->stream($request->reporte.'.pdf');
				break;
		}
	}

	public function opcionesCatalogo(&$query, $request)
	{
		$opc_request = $request->only(array_keys($this->id_catalogos));
		foreach ($opc_request as $key => $valor) {
			if ($valor) {
				$arreglo = explode(",", $valor);
				$query = $query->whereIn($this->id_catalogos[$key], $arreglo);
			}
		}
		if ($request->programa) {
			$arreglo = explode(",", $request->programa);
			$proyectos = [];
			foreach ($arreglo as $id) {
				$programa = Cat_Estructura_Programatica::select('ejercicio', 'clave')->find($id);
				$proys = Cat_Estructura_Programatica::select('id')->where('ejercicio', $programa->ejercicio)->where('tipo', 'PRY')->where('clave', 'like', $programa->clave.'%')->get()->toArray();
				$proyectos = array_merge($proyectos, $proys);
			}
			$proyectos = array_flatten($proyectos);
			$query = $query->whereIn('d_obra.id_proyecto_ep', $proyectos);
		}
	}

	public function tabla_dSecDepInv($datos, $request)
	{
		$this->valor_grupo = array_fill(1, 5, null);
		$tabla = array();
		$montos = ['asignado', 'autorizado', 'ejercido', 'por_ejercer', 'anticipo', 'retenciones', 'comprobado', 'por_comprobar', 'pagado', 'por_pagar'];
		$keys = array('grupo', 'obras', 'av_fin', 'asignado', 'autorizado', 'ejercido', 'por_ejercer', 'anticipo', 'retenciones', 'comprobado', 'por_comprobar', 'pagado', 'por_pagar', 'oficio', 'firma', 'asignado1', 'autorizado1', 'AP', 'tipo', 'envio', 'afectacion', 'pagado1', 'clase_row', 'n_grupo');
		$total = array_fill(1, 5, null);
		$ren = array_fill(1, 5, -1);
		$n_obras = array_fill(1, 5, -1);
		$i = 0;
		reset($datos);
		$fila = current($datos);
		while ($fila) {
			// checar primero
			for ($grupo = 1; $grupo <= 5; $grupo++) { 
				if ($this->checa($fila, $grupo, 'primero')) {
					$tabla[] = array_fill_keys($keys, '');
					$total[$grupo] = array_fill_keys($montos, 0);
					$tabla[$i]['n_grupo'] = $grupo;
					if ($grupo <= 3) {
						$tabla[$i]['clase_row'] = "class=grupo".$grupo;
						$n_obras[$grupo] = 0;
					}
					else {
						if ($n_obras[3] % 2 == 0)
							$tabla[$i]['clase_row'] = "class=par";
						else
							$tabla[$i]['clase_row'] = "class=impar";
						if ($grupo == 5) {
							$detalle = $this->detalleAP($fila, $request);
							//dd($detalle);
							$tabla[$i]['obras'] = $fila['fuente'].' '.$fila['inversion'];
							$fuente = $fila['fuente'].'_'.$fila['inversion'];
							for ($j = 1; $j <= 5 ; $j++) { 
								if (!isset($total[$j]['fuentes'][$fuente])) {
									$total[$j]['fuentes'][$fuente] = array_fill_keys($montos, 0);
									$total[$j]['fuentes'][$fuente]['nombre'] = $fila['fuente'].' '.$fila['inversion'];
								}
							}
						}
					}
					$ren[$grupo] = $i;
					$tabla[$i]['grupo'] = $this->valorGrupo($fila, $grupo);
					if ($grupo != 5) $i++;
				}
			}
			// detalle
			// montos parciales de c/detalle
			$detalle['parcial']['asignado'] += $fila['asignado'] * $fila['factor'];
			$detalle['parcial']['autorizado'] += $fila['autorizado'] * $fila['factor'];
			if ($tabla[$i]['oficio'] == '')
				$tabla[$i]['oficio'] = $fila['oficio'];
			else
				$tabla[$i]['oficio'] .= '<br>'.$fila['oficio'];
			if ($tabla[$i]['firma'] == '')
				$tabla[$i]['firma'] = Carbon::parse($fila['fecha_firma'])->format('d-m-Y');
			else
				$tabla[$i]['firma'] .= '<br>'.Carbon::parse($fila['fecha_firma'])->format('d-m-Y');
			if ($fila['factor'] == 1)
				$signo = '';
			else
				$signo = '- ';
			if ($tabla[$i]['asignado1'] == '')
				$tabla[$i]['asignado1'] = $signo.number_format($fila['asignado'], 2);
			else
				$tabla[$i]['asignado1'] .= '<br>'.$signo.number_format($fila['asignado'],2);
			if ($tabla[$i]['autorizado1'] == '')
				$tabla[$i]['autorizado1'] = $signo.number_format($fila['autorizado'], 2);
			else
				$tabla[$i]['autorizado1'] .= '<br>'.$signo.number_format($fila['autorizado'],2);
			
			$fila = next($datos);
			// checar último
			for ($grupo = 5; $grupo >= 1; $grupo--) { 
				if ($this->checa($fila, $grupo, 'ultimo')) {
					if ($grupo == 5) {
						foreach ($detalle['det_ap'] as $key => $valor) {
							$tabla[$i][$key] = $valor;
						}
						$tabla[$i]['av_fin'] = number_format(floor($detalle['parcial']['ejercido'] / $detalle['parcial']['autorizado'] * 100), 0);
						foreach ($detalle['parcial'] as $key => $valor) {
							for ($j = 1; $j <= 4; $j++) {
								// grupo
								$total[$j][$key] += $valor;
								// fuentes
								$total[$j]['fuentes'][$fuente][$key] += $valor;
							}
							$tabla[$i][$key] = number_format($valor, 2);
						}
						$i++;
					}
					else {
						$total[$grupo]['por_ejercer'] = $total[$grupo]['autorizado'] - $total[$grupo]['ejercido'];
						$total[$grupo]['por_comprobar'] = $total[$grupo]['anticipo'] - $total[$grupo]['comprobado'];
						$total[$grupo]['por_pagar'] = $total[$grupo]['ejercido'] - $total[$grupo]['retenciones'] - $total[$grupo]['pagado'];
						foreach ($total[$grupo] as $key => $valor) {
							if (!($key == 'fuentes'))
								$tabla[$ren[$grupo]][$key] = number_format($valor, 2);
						}
						$tabla[$ren[$grupo]]['av_fin'] = number_format(floor($tabla[$ren[$grupo]]['ejercido'] / $tabla[$ren[$grupo]]['autorizado'] * 100), 0);
						if ($grupo <= 3) {
							foreach ($total[$grupo]['fuentes'] as &$fte) {
								$fte['por_ejercer'] = $fte['autorizado'] - $fte['ejercido'];
								$fte['por_comprobar'] = $fte['anticipo'] - $fte['comprobado'];
								$fte['por_pagar'] = $fte['ejercido'] - $fte['retenciones'] - $fte['pagado'];
								foreach ($fte as $key => $valor) {
									if (!($key == 'nombre'))
										$fte[$key] = number_format($valor, 2);
								}
								$fte['av_fin'] = number_format(floor($fte['ejercido'] / $fte['autorizado'] * 100), 0);
							}
							$tabla[$ren[$grupo]]['obras'] = $n_obras[$grupo];
							$tabla[$ren[$grupo]]['fuentes'] = $total[$grupo]['fuentes'];
						}
						else
							for ($j = 1; $j <= 3 ; $j++) { 
								$n_obras[$j]++;
							}
					}
				}
			}
		}
		return $tabla;
	}

	public function checa($fila, $n, $checa)
	{
		$opcion = false;
		if ($checa == 'ultimo' && !$fila)
			$opcion = true;
		else {
			$valor = '';
			for ($i = 1; $i <= $n; $i++) {
				if (is_array($this->grupos[$i]))
					foreach ($this->grupos[$i] as $grupo)
						$valor .= $fila[$grupo];
				else
					$valor .= $fila[$this->grupos[$i]];
			}
			if ($this->valor_grupo[$n] != $valor)
				$opcion = true;
		}
		if ($checa == 'primero')
			$this->valor_grupo[$n] = $valor;
		return $opcion;
	}

	public function valorGrupo($fila, $n)
	{
		$valor = '';
		$val_grupo = '';
		if (is_array($this->grupos[$n]))
			foreach ($this->grupos[$n] as $grupo)
				$val_grupo .= $grupo;
		else
			$val_grupo = $this->grupos[$n];
		switch ($val_grupo) {
			case 'ejercicio':
				$valor = '<b>'.$fila['ejercicio'].'</b>';
				break;
			case 'sector':
				$valor = '<b>'.$fila['sector'].'</b>';
				break;
			case 'ue':
				$valor = '<b>'.$fila['ue'].'</b>';
				break;
			case 'id_obra':
				$valor = '<b>'.$fila['id_obra'].'</b> - '.$fila['clasificacion'].'<br>'.$fila['nombre'].'<br>'.'Loc: '.$fila['localidad'].'. '.$fila['municipio'];
				break;
			case 'fuenteinversion':
				// checar para otros reportes
				$valor = '';
				break;
		}
		return $valor;
	}

	public function detalleAP ($fila, $request)
	{
		$keys_det = ['AP', 'tipo', 'envio', 'afectacion', 'pagado1'];
		$montos = ['asignado', 'autorizado', 'ejercido', 'por_ejercer', 'anticipo', 'retenciones', 'comprobado', 'por_comprobar', 'pagado', 'por_pagar'];
		$aps = P_Autorizacion_Pago::select('p_autorizacion_pago.id', 'p_autorizacion_pago.clave', 'cat_tipo_ap.clave as clave_ap', 'cat_tipo_ap.nombre as tipo_ap', 'fecha_envio', 'monto', 'monto_amortizacion', 'monto_iva_amortizacion', 'icic', 'cmic', 'supervision', 'ispt', 'otro', 'federal_1', 'federal_2', 'federal_5')
			->join('cat_tipo_ap', 'p_autorizacion_pago.id_tipo_ap', '=', 'cat_tipo_ap.id')
			->with('pagos')
			->where('id_det_obra', $fila['id'])
			->where('id_fuente', $fila['id_fuente']);
		if ($request->estadoAP) {
			$arreglo = explode(",", $request->estadoAP);
			$aps = $aps->whereIn('id_estatus', $arreglo);
		}
		if ($request->tipoAP) {
			$arreglo = explode(",", $request->tipoAP);
			$aps = $aps->whereIn('id_tipo_AP', $arreglo);
		}
		$aps = $aps->get()->toArray();
		$det_ap = array_fill_keys($keys_det, '');
		$parcial = array_fill_keys($montos, 0);
		foreach ($aps as $ap) {
			if ($ap['clave_ap'] == 'D') {
				$parcial['ejercido'] -= $ap['monto'];
				$afectacion = '- '.number_format($ap['monto'], 2);
			}
			else {
				$parcial['ejercido'] += $ap['monto'];
				$afectacion = number_format($ap['monto'], 2);
			}
			$parcial['comprobado'] += $ap['monto_amortizacion'] + $ap['monto_iva_amortizacion'];
			$parcial['retenciones'] += $ap['icic'] + $ap['cmic'] + $ap['supervision'] + + $ap['ispt'] + + $ap['otro'] + $ap['federal_1'] + $ap['federal_2'] + $ap['federal_5'];
			if ($ap['clave_ap'] == 'A')
				$parcial['anticipo'] += $ap['monto'];
			
			$espacios = str_repeat('<br>', count($ap['pagos']));
			if ($det_ap['AP'] == '')
				$det_ap['AP'] = $ap['clave'];
			else
				$det_ap['AP'] .= '<br>'.$ap['clave'];
			if ($det_ap['tipo'] == '')
				$det_ap['tipo'] = substr($ap['tipo_ap'], 0, 3);
			else
				$det_ap['tipo'] .= '<br>'.$espacios.substr($ap['tipo_ap'], 0 ,3);
			if ($det_ap['envio'] == '')
				$det_ap['envio'] = Carbon::parse($ap['fecha_envio'])->format('d-m-Y');
			else
				$det_ap['envio'] .= '<br>'.Carbon::parse($ap['fecha_envio'])->format('d-m-Y');
			if ($det_ap['afectacion'] == '')
				$det_ap['afectacion'] = $afectacion;
			else
				$det_ap['afectacion'] .= '<br>'.$afectacion;
			if ($det_ap['pagado1'] == '')
				$det_ap['pagado1'] = 'pagado';
			else
				$det_ap['pagado1'] .= '<br>'.'pagado';
			if (count($ap['pagos']) > 0) {
				$pagado_ap = 0;
				foreach ($ap['pagos'] as $pago) {
					$parcial['pagado'] += $pago['monto'];
					$pagado_ap += $pago['monto'];
					$det_ap['AP'] .= '<br>'.$pago['serie'];
					$det_ap['envio'] .= '<br>'.Carbon::parse($pago['fecha_pago'])->format('d-m-Y');
					if ($pago['cheque'] == 0)
						$det_ap['afectacion'] .= '<br>SPEI';
					else
						$det_ap['afectacion'] .= '<br>'.$pago['cheque'];
					$det_ap['pagado1'] .= '<br>'.number_format($pago['monto'], 2);
				}
				$det_ap['pagado1'] = str_replace('pagado', number_format($pagado_ap, 2), $det_ap['pagado1']);
			}

			
		}
		return array('parcial' => $parcial, 'det_ap' => $det_ap);
	}

}
