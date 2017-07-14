<?php

namespace App\Http\Controllers\Consulta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use Yajra\Datatables\Datatables;
use App\D_Obra;
use App\Cat_Estructura_Programatica;
use App\D_Oficio;
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
			->groupBy('clave')
			->orderBy('clave', 'DESC');
		return Datatables::of($oficios)
			->editColumn('fecha_oficio', function ($oficio) {
				return Carbon::parse($oficio->fecha_oficio)->format('d-m-Y');
			})
			->editColumn('fecha_firma', function ($oficio) {
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

	public function buscar_obra(Request $request)
	{
		try {
			$obra = D_Obra::with(['acuerdos', 'fuentes', 'regiones', 'municipios', 'sector', 'modalidad_ejecucion', 'clasificacion_obra', 'tipo_obra', 'unidad_ejecutora', 'cobertura', 'proyecto', 'grupo_social'])->where('id', $request->id)->first();
			$obra['programa'] = Cat_Estructura_Programatica::where('ejercicio', $obra->ejercicio)->where('tipo', 'P')->where('clave', 'like', substr($obra->proyecto->clave, 0, 8).'%')->get()->first();
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
}
