<?php

namespace App\Http\Controllers\AutorizacionPago;

use App\Http\Controllers\Controller;
use App\P_Autorizacion_Pago;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

class ListadoAutorizacionPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        return view('AutorizacionPago.listado_index');
    }

    public function get_data_listado()
    {
        $ap = P_Autorizacion_Pago::with('unidad_ejecutora', 'estatus', 'tipo_ap')->where('id_unidad_ejecutora', \Auth::user()->id_unidad_ejecutora);

        return Datatables::of($ap)
            ->make(true);
    }

    public function ver_detalle_ap_listado(Request $request)
    {
        $ap = P_Autorizacion_Pago::with('tipo_ap', 'unidad_ejecutora', 'contrato', 'empresa', 'obra', 'obra.modalidad_ejecucion', 'fuente')
            ->where('id', $request->id)
            ->where('id_unidad_ejecutora', \Auth::user()->id_unidad_ejecutora)
        // ->where('id_estatus',)
            ->first();
        return view('AutorizacionPago.listado_detalle_ap', compact('ap'));
    }

    public function eliminar_ap(Request $request)
    {
         DB::beginTransaction();
        try {   
                P_Autorizacion_Pago::destroy($request->id);
                DB::commit();
                return $request->id;
            
        } catch (\Exception $e) {
            DB::rollback();
            $ap            = array();
            $ap['message'] = $e->getMessage();
            $ap['trace']   = $e->getTrace();
            $ap['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($ap);
        }
    }
}
