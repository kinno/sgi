<?php

namespace App\Http\Controllers\Oficios;

use App\Cat_Ejercicio;
use App\Cat_Fuente;
use App\Cat_Sector;
use App\Cat_Servidor_Publico;
use App\Cat_Solicitud_Presupuesto;
use App\Cat_Texto_Oficio;
use App\Cat_Unidad_Ejecutora;
use App\D_Obra;
use App\D_Oficio;
use App\Http\Controllers\Controller;
use App\P_Oficio;
use App\Rel_Obra_Fuente;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class OficiosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        $barraMenu = array('input' => array('id' => 'clave', 'class' => 'text-right num input-sm', 'title' => 'Oficio: '),
            'botones'                  => array([
                'id'    => 'buscar',
                'tipo'  => 'btn-default btn-sm',
                'icono' => 'fa fa-search',
                'title' => 'Buscar oficio',
            ], [
                'id'    => 'limpiar',
                'tipo'  => 'btn-warning btn-sm',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ], [
                'id'    => 'guardar',
                'tipo'  => 'btn-success btn-sm',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
            ], [
                'id'    => 'imprimir_expediente',
                'tipo'  => 'btn-success btn-sm',
                'icono' => 'fa fa-file-pdf-o',
                'title' => 'Imprimir Expediente Técnico',
            ]));
        $ejercicios    = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
        $tipoSolicitud = Cat_Solicitud_Presupuesto::all();
        $unidad_ejecutora = Cat_Unidad_Ejecutora::all();
        $fuentes       = Cat_Fuente::where('tipo', '=', 'F')
            ->orWhere('tipo', '=', 'E')
            ->get();

        // $iniciales .= $departamento->area->responsable->iniciales . "/".$departamento->responsable->iniciales;

        return view('Oficios.crear_index', compact('tipoSolicitud', 'ejercicios', 'barraMenu', 'fuentes','unidad_ejecutora'));
    }

    public function buscar_oficio(Request $request)
    {
        $oficio = P_Oficio::where('clave', '=', $request->clave)
        // ->with('detalle.obras')
            ->first();

        if ($oficio) {
            return $oficio;
        } else {
            $oficio          = array();
            $oficio['error'] = "No existe el Oficio.";
            return ($oficio);
        }

    }

    public function buscar_obra(Request $request)
    {
        // dd($request->all());
        if (isset($request->id_sector)) {
            $obra = D_Obra::with('relacion.expediente')
                ->with('fuentes')
                ->where('id_obra', '=', $request->id_obra)
                ->where('id_sector', '=', $request->id_sector)
                ->first();
        } else if (isset($request->id_unidad_ejecutora)) {
            $obra = D_Obra::with('relacion.expediente')
                ->with('fuentes')
                ->where('id_obra', '=', $request->id_obra)
                ->where('id_unidad_ejecutora', '=', $request->id_unidad_ejecutora)
                ->first();
        } else {
            $obra = D_Obra::with('relacion.expediente')
                ->with('fuentes')
                ->where('id_obra', '=', $request->id_obra)
                ->first();
        }

        if ($obra) {
            if ((!isset($obra->relacion->expediente) && ($request->id_tipo_solicitud == 1 || $request->id_tipo_solicitud == 9 || $request->id_tipo_solicitud == 10 || $request->id_tipo_solicitud == 11))) {
                return $obra;
            } else if ($obra->relacion->expediente->id_tipo_solicitud == (int) $request->id_tipo_solicitud) {
                return $obra;
            } else {
                $obra          = array();
                $obra['error'] = "La solicitud de presupuesto actual de la Obra no corresponde al tipo de solicitud seleccionado.";
                return ($obra);
            }
        } else {
            $obra          = array();
            $obra['error'] = "No existe la Obra o el Sector o Unidad Ejecutora (Sector Ayuntamiento) es diferente de las Obras del Oficio";
            return ($obra);
        }
    }

    public function get_data_fuentes($id_det_obra)
    {

        $fuentes = Rel_Obra_Fuente::with('fuentes')
            ->where('id_det_obra', '=', $id_det_obra);
        return \Datatables::of($fuentes)
            ->make(true);
    }

    public function get_data_obras($id_oficio)
    {

        $obras = D_Oficio::with('fuentes', 'principal_oficio.tipo_solicitud','unidad_ejecutora')
            ->where('id_oficio', '=', $id_oficio);

        return \Datatables::of($obras)
        ->editColumn('monto', '{{$asignado + $autorizado}}')
            ->make(true);
    }

    public function cargar_texto(Request $request)
    {
        // dd($request->all());
        $texto = Cat_Texto_Oficio::where('id_solicitud_presupuesto', '=', $request->id_solicitud_presupuesto)
            ->where('ejercicio', '=', $request->ejercicio)
            ->where('id_fuente', '=', $request->id_fuente)
            ->first();
        $SPPDGI = Cat_Servidor_Publico::where('clave', '=', 'spp')
            ->orWhere('clave', '=', 'dgi')
            ->where('bactivo', '=', 1)
            ->get();
        $iniciales = "";

        $cpp        = "";
        $claveArray = array('gem', 'sf', 'scem', 'sscec', 'dgi', 'dgids', 'uaag');
        $i          = 0;
        foreach ($claveArray as $value) {
            if ($i > 0) {
                $tab = "\t";
            } else {
                $tab = "";
            }
            $servidor = Cat_Servidor_Publico::where('clave', '=', $value)
                ->first();
            $cpp .= $tab . $servidor->nombre . ".- " . $servidor->cargo . ".\n";
            $i++;
        }

        if (isset($request->id_sector)) {
            $titular_sector = Cat_Sector::with('titular')
                ->find($request->id_sector);
        } else {
            $titular_sector = Cat_Unidad_Ejecutora::with('titular')
                ->find($request->id_unidad_ejecutora);
        }
        $titular = $titular_sector->titular->titulo . "\n" . $titular_sector->titular->nombre . " " . $titular_sector->titular->apellido . "\n" . $titular_sector->titular->cargo;

        foreach ($SPPDGI as $value) {
            $iniciales .= strtoupper($value->iniciales) . "/";
        }

        // foreach ($servidores as $value) {
        //     $cpp .= $value->nombre . ".- " . $value->cargo . ".\n";
        // }

        $iniciales .= strtoupper(\Auth::user()->departamento->area->responsable->iniciales) . "/" . strtoupper(\Auth::user()->departamento->responsable->iniciales) . "/" . strtolower(\Auth::user()->iniciales);

        $textos = array('texto' => $texto, 'iniciales' => $iniciales, 'ccp' => $cpp, 'titular' => $titular);
        return $textos;
    }

    public function guardar(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();
        try {

            if (!$request->id) {
                //NUEVO
                $p_oficio        = new P_Oficio;
                $folio           = $this->ultimo_folio($request->fecha_oficio);
                $p_oficio->clave = $folio;
            } else {
                //ACTUALIZACION
                $p_oficio = P_Oficio::find($request->id);
            }

            $p_oficio->id_solicitud_presupuesto = $request->id_solicitud_presupuesto;
            $p_oficio->id_usuario               = \Auth::user()->id;
            $p_oficio->id_estatus               = 3;
            $p_oficio->ejercicio                = $request->ejercicio;
            $p_oficio->id_sector                = $request->id_sector;
            $p_oficio->id_unidad_ejecutora      = $request->id_unidad_ejecutora;
            $p_oficio->fecha_oficio             = Carbon::parse($request->fecha_oficio)->format('Y-m-d H:i:s');
            $p_oficio->titular                  = $request->titular;
            $p_oficio->asunto                   = $request->asunto;
            $p_oficio->ccp                      = $request->ccp;
            $p_oficio->prefijo                  = $request->prefijo;
            $p_oficio->iniciales                = $request->iniciales;
            $p_oficio->tarjeta_turno            = $request->tarjeta_turno;
            $p_oficio->texto                    = $request->texto;
            $p_oficio->save();

            $ids              = $this->guardarDetalle($p_oficio->id, $p_oficio->id_solicitud_presupuesto, $request->obras, $request->obras_eliminadas);
            $ids['clave']     = $p_oficio->clave;
            $ids['id_oficio'] = $p_oficio->id;
            DB::commit();
            return $ids;
        } catch (\Exception $e) {
            DB::rollback();
            $oficios            = array();
            $oficios['message'] = $e->getMessage();
            $oficios['trace']   = $e->getTrace();
            $oficios['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($oficios);
        }

    }

    public function guardarDetalle($id_oficio, $tipo, $obras, $obrasEliminadas)
    {
        $arrayIds = array();
        foreach ($obras as $value) {
            if ($value['id']) {
                //ID
                $d_oficio = D_Oficio::find($value['id']);
            } else {
                $d_oficio = new D_Oficio;
            }

            $d_oficio->id_oficio   = $id_oficio;
            $d_oficio->id_det_obra = $value['id_det_obra'];
            $d_oficio->id_fuente   = $value['id_fuente'];
            $d_oficio->id_unidad_ejecutora   = $value['id_unidad_ejecutora'];
            if ($tipo == 1 || $tipo == 9) {
                $d_oficio->asignado = $value['monto'];
            } else if ($tipo == 2) {
                $d_oficio->autorizado = $value['monto'];
            } else {
                $d_oficio->asignado = $value['monto'];
                $d_oficio->autorizado = $value['monto'];
            }
            
            $d_oficio->save();
            array_push($arrayIds, $d_oficio->id);
        }
        if (isset($obrasEliminadas)) {
            D_Oficio::destroy($obrasEliminadas);
        }

        return $arrayIds;
    }

    public function ultimo_folio($fecha_oficio)
    {
        // $fecha = Carbon::parse($fecha_oficio);
        $año = Carbon::parse($fecha_oficio)->format('y');
        $mes  = Carbon::parse($fecha_oficio)->format('m');
        // dd($año);
        $clave = \DB::table('p_oficio')
            ->select(\DB::raw('right(MAX(clave),4) as clave'))
            ->where(\DB::raw('LEFT(clave,4)'), '=', $año . $mes)
            ->first();
        $consecutivo = $clave->clave + 1;
        $nueva_clave = $año . $mes . substr("000" . $consecutivo, -4);
        return $nueva_clave;
    }

    public function imprime_oficio($id_oficio)
    {
        $oficio = P_Oficio::with('detalle')
            ->with('frase_ejercicio')
            ->find($id_oficio);

        $pdf = \PDF::loadView('PDF/oficio', compact('oficio'));

        return $pdf->stream('Oficio_' . $oficio->clave . '.pdf');

        return view('PDF/oficio', compact('oficio'));
    }
}
