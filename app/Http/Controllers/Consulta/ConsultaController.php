<?php

namespace App\Http\Controllers\Consulta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use Yajra\Datatables\Datatables;
use App\D_Obra;
use App\Cat_Estructura_Programatica;
use App\D_Oficio;
use App\P_Autorizacion_Pago;
use App\P_Pagos;
use App\Rel_Obra_Fuente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
	use Funciones;

	protected $barraMenu = array(
			'botones' => array([
				'id'    => 'btnBuscar',
				'tipo'  => 'btn-default',
				'icono' => 'fa fa-search',
				'title' => 'Buscar',
				'texto' => 'Buscar'
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
		$opciones['clasificacion'] = $this->opcionesClasificacion();
		$opciones += $this->opcionesSector(0, 0, true, $ids_Sector, true);
		$opciones['municipio'] = $this->opcionesMunicipioReporte();
		$opciones['grupo'] = $this->opcionesGrupoSocial();
		return view('Consulta.index')
			->with('opciones', $opciones)
			->with('barraMenu', $this->barraMenu);
	}

	public function getDataObra(Request $request)
	{

		//$obras = D_Obra::orderBy('id_obra','DESC')->with('municipio');
		$obras = D_Obra::select(['id', 'id_obra', 'ejercicio', 'nombre', 'asignado', 'autorizado', 'ejercido', 'anticipo', 'retenciones', 'comprobado', 'pagado', 'id_municipio'])
			->with(['municipio', 'fuentes'])
			->orderBy('ejercicio', 'DESC')
			->orderBy('id_obra', 'DESC');
		return Datatables::of($obras)
			->editColumn('asignado', function ($obra) {
				return number_format($obra->asignado, 2);
			})
			->editColumn('autorizado', function ($obra) {
				return number_format($obra->autorizado, 2);
			})
			->editColumn('ejercido', function ($obra) {
				return number_format($obra->ejercido, 2);
			})
			->editColumn('anticipo', function ($obra) {
				return number_format($obra->anticipo, 2);
			})
			->editColumn('retenciones', function ($obra) {
				return number_format($obra->retenciones, 2);
			})
			->editColumn('comprobado', function ($obra) {
				return number_format($obra->comprobado, 2);
			})
			->editColumn('pagado', function ($obra) {
				return number_format($obra->pagado, 2);
			})
			->addColumn('por_ejercer', function ($obra) {
				return number_format(bcsub($obra->autorizado, $obra->ejercido), 2);
			})
			->addColumn('por_comprobar', function ($obra) {
				return number_format(bcsub($obra->anticipo, $obra->comprobado), 2);
			})
			->addColumn('por_pagar', function ($obra) {
				return number_format(bcsub(bcsub($obra->ejercido, $obra->retenciones), $obra->pagado), 2);
			})
			/*
			->addColumn('fuentes.pivot.por_ejercer', function ($obra) {
				return $obra->fuentes->map(function ($fuente) {
					return $fuente->pivot->asignado;
				});
			})*/
			->addColumn('action', function ($obra) {
				return '<a class="btn btn-xs btn-success2" data-id="'.$obra->id.'" id="btnInfo"><i class="glyphicon glyphicon-info-sign"></i> Info</a>';
			})
			->filter(function ($query) use ($request) {
				if ($request->has('id_obra')) {
					$query->where('id_obra', $request->id_obra);
				}
				if ($request->has('nombre')) {
					$query->where('nombre', 'like', '%'.$request->nombre.'%');
				}
				if ($request->ejercicio > 0) {
					$query->where('ejercicio', $request->ejercicio);
				}
				if ($request->id_municipio > 0) {
					$query->where('id_municipio', $request->id_municipio);
				}
				if ($request->id_sector > 0) {
					$query->where('id_sector', $request->id_sector);
				}
				if ($request->id_unidad_ejecutora > 0) {
					$query->where('id_unidad_ejecutora', $request->id_unidad_ejecutora);
				}
				if ($request->id_clasificacion_obra > 0) {
					$query->where('id_clasificacion_obra', $request->id_clasificacion_obra);
				}
				if ($request->id_grupo_social > 0) {
					$query->where('id_grupo_social', $request->id_grupo_social);
				}
			})
			->make(true);
	}

	public function getDataOficios(Request $request)
	{
		$oficios = D_Oficio::select(DB::raw('p_oficio.id, p_oficio.clave, fecha_oficio, cat_estatus_oficio.nombre as estado, cat_solicitud_presupuesto.nombre as solicitud, SUM(asignado) as asignado, SUM(autorizado) as autorizado, cat_recurso.nombre as recurso, titular, fecha_firma, tarjeta_turno'))
			->join('p_oficio', 'd_oficio.id_oficio', '=', 'p_oficio.id')
			->join('cat_estatus_oficio', 'p_oficio.id_estatus', '=', 'cat_estatus_oficio.id')
			->join('cat_solicitud_presupuesto', 'p_oficio.id_solicitud_presupuesto', '=', 'cat_solicitud_presupuesto.id')
			->join('cat_recurso', 'p_oficio.id_recurso', '=', 'cat_recurso.id')
			->where('id_det_obra', $request->id)
			->orderBy('clave', 'DESC');
		return Datatables::of($oficios)
			->editColumn('fecha_oficio', function ($oficio) {
				if (!is_null($oficio->fecha_oficio))
					return Carbon::parse($oficio->fecha_oficio)->format('d-m-Y');
			})
			->editColumn('fecha_firma', function ($oficio) {
				if (!is_null($oficio->fecha_firma))
					return Carbon::parse($oficio->fecha_firma)->format('d-m-Y');
			})
			->editColumn('asignado', function ($oficio) {
				return number_format($oficio->asignado, 2);
			})
			->editColumn('autorizado', function ($oficio) {
				return number_format($oficio->autorizado, 2);
			})
			->make(true);
	}

	public function getDataDetalleOficios(Request $request)
	{
		$det_oficios = D_Oficio::select(['id', 'id_unidad_ejecutora', 'id_fuente', 'id_solicitud_presupuesto', 'asignado', 'autorizado'])
			->with(['unidad_ejecutora', 'fuentes', 'tipo_solicitud'])
			->where('id_oficio', $request->id);
		return Datatables::of($det_oficios)
			->editColumn('asignado', function ($oficio) {
				return number_format($oficio->asignado, 2);
			})
			->editColumn('autorizado', function ($oficio) {
				return number_format($oficio->autorizado, 2);
			})
			->make(true);
	}

	public function getDataAps(Request $request)
	{
		$aps = P_Autorizacion_Pago::select(['id', 'clave', 'id_tipo_ap', 'id_estatus', 'id_fuente', 'id_contrato', 'id_empresa', 'id_unidad_ejecutora', 'id_sector', 'observaciones', 'monto', 'monto_amortizacion', 'monto_iva_amortizacion', 'folio_amortizacion', 'importe_sin_iva', 'iva', 'icic', 'cmic', 'supervision', 'ispt', 'otro', 'federal_1', 'federal_2', 'federal_5', 'id_relacion_envio', 'id_turno', 'fecha_creacion', 'fecha_entrega', 'fecha_envio', 'fecha_recepcion', 'fecha_validacion', 'numero_estimacion', 'fecha_recepcion_tesoreria', 'fecha_programacion_tesoreria'])
			->with(['contrato', 'empresa', 'unidad_ejecutora', 'estatus', 'tipo_ap', 'fuente', 'sector', 'pagos'])
			->where('id_det_obra', $request->id)
			->orderBy('clave', 'DESC');

		return Datatables::of($aps)
			->editColumn('fecha_creacion', function ($ap) {
				if (!is_null($ap->fecha_creacion))
					return Carbon::parse($ap->fecha_creacion)->format('d-m-Y');
			})
			->editColumn('fecha_entrega', function ($ap) {
				if (!is_null($ap->fecha_entrega))
					return Carbon::parse($ap->fecha_entrega)->format('d-m-Y');
			})
			->editColumn('fecha_envio', function ($ap) {
				if (!is_null($ap->fecha_envio))
					return Carbon::parse($ap->fecha_envio)->format('d-m-Y');
			})
			->editColumn('fecha_recepcion', function ($ap) {
				if (!is_null($ap->fecha_recepcion))
					return Carbon::parse($ap->fecha_recepcion)->format('d-m-Y');
			})
			->editColumn('fecha_validacion', function ($ap) {
				if (!is_null($ap->fecha_validacion))
					return Carbon::parse($ap->fecha_validacion)->format('d-m-Y');
			})
			->editColumn('fecha_recepcion_tesoreria', function ($ap) {
				if (!is_null($ap->fecha_recepcion_tesoreria))
					return Carbon::parse($ap->fecha_recepcion_tesoreria)->format('d-m-Y');
			})
			->editColumn('fecha_programacion_tesoreria', function ($ap) {
				if (!is_null($ap->fecha_programacion_tesoreria))
					return Carbon::parse($ap->fecha_programacion_tesoreria)->format('d-m-Y');
			})
			->editColumn('monto', function ($ap) {
				return number_format($ap->monto, 2);
			})
			->editColumn('monto_amortizacion', function ($ap) {
				return number_format($ap->monto_amortizacion, 2);
			})
			->editColumn('monto_iva_amortizacion', function ($ap) {
				return number_format($ap->monto_iva_amortizacion, 2);
			})
			->editColumn('importe_sin_iva', function ($ap) {
				return number_format($ap->importe_sin_iva, 2);
			})
			->editColumn('iva', function ($ap) {
				return number_format($ap->iva, 2);
			})
			->editColumn('icic', function ($ap) {
				return number_format($ap->icic, 2);
			})
			->editColumn('cmic', function ($ap) {
				return number_format($ap->cmic, 2);
			})
			->editColumn('supervision', function ($ap) {
				return number_format($ap->supervision, 2);
			})
			->editColumn('ispt', function ($ap) {
				return number_format($ap->ispt, 2);
			})
			->editColumn('otro', function ($ap) {
				return number_format($ap->otro, 2);
			})
			->editColumn('federal_1', function ($ap) {
				return number_format($ap->federal_1, 2);
			})
			->editColumn('federal_2', function ($ap) {
				return number_format($ap->federal_2, 2);
			})
			->editColumn('federal_5', function ($ap) {
				return number_format($ap->federal_5, 2);
			})
			->addColumn('retenciones', function ($ap) {
				return number_format($ap->icic + $ap->cmic + $ap->supervision + $ap->ispt + $ap->otro + $ap->federal_1 + $ap->federal_2 + $ap->federal_5, 2);
			})
			->addColumn('subtotal', function ($ap) {
				return number_format($ap->monto - $ap->iva, 2);
			})
			->addColumn('neto', function ($ap) {
				return number_format($ap->monto - $ap->icic - $ap->cmic - $ap->supervision - $ap->ispt - $ap->otro - $ap->federal_1 - $ap->federal_2 - $ap->federal_5, 2);
			})
			->addColumn('pagado', function ($ap) {
				return number_format($ap->pagos->sum('monto'),2);
			})
			->make(true);
	}

	public function getDataPagos(Request $request)
	{
		$pagos = P_Pagos::select(['id', 'id_autorizacion_pago', 'serie', 'adefa', 'cheque', 'fecha_pago', 'monto'])
			->with('autorizacion_pago.fuente')
			->where('id_det_obra', $request->id)
			->orderBy('id_autorizacion_pago', 'DESC')
			->orderBy('serie', 'ASC');
		return Datatables::of($pagos)
			->editColumn('adefa', function ($pago) {
				if ($pago->adefa == 1)
					return "si";
				else
					return "no";
			})
			->editColumn('cheque', function ($pago) {
				if ($pago->cheque == "0")
					return "SPEI";
				else
					return $pago->cheque;
			})
			->editColumn('fecha_pago', function ($pago) {
				if (!is_null($pago->fecha_pago))
					return Carbon::parse($pago->fecha_pago)->format('d-m-Y');
			})
			->editColumn('monto', function ($pago) {
				return number_format($pago->monto, 2);
			})
			->make(true);
	}

	public function buscar_obra(Request $request)
	{
		try {
			$obra = D_Obra::with(['acuerdos', 'regiones', 'municipios', 'sector', 'modalidad_ejecucion', 'clasificacion_obra', 'tipo_obra', 'unidad_ejecutora', 'cobertura', 'proyecto', 'grupo_social'])->where('id', $request->id)->first();
			$obra['programa'] = Cat_Estructura_Programatica::where('ejercicio', $obra->proyecto->ejercicio)->where('tipo', 'P')->where('clave', 'like', substr($obra->proyecto->clave, 0, 8).'%')->get()->first();
			return $obra;
		} 
		catch (\Exception $e) {
			$obra            = array();
			$obra['message'] = $e->getMessage();
			$obra['trace']   = $e->getTrace();
			return $obra;
		}
	}

	public function getDataFuentes(Request $request)
	{
		$pagos = Rel_Obra_Fuente::select(['id', 'id_fuente', 'monto', 'partida', 'cuenta'])
			->with('fuentes')
			->where('id_det_obra', $request->id)
			->where('id_unidad_ejecutora', 0)
			->orderBy('id_fuente', 'DESC');
		return Datatables::of($pagos)
			->editColumn('monto', function ($pago) {
				return number_format($pago->monto, 2);
			})
			->make(true);
	}
}
