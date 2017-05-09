<?php

namespace App\Http\Controllers\ExpedienteTecnico;

use App\Http\Controllers\Controller;
use App\P_Evaluacion_Expediente;
use App\P_Expediente_Tecnico;
use App\Rel_Estudio_Expediente_Obra;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RevisionExpedienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return View("ExpedienteTecnico.revision_expediente_tecnico");
    }

    public function get_data_revision()
    {

        $expediente = Rel_Estudio_Expediente_Obra::
            orderBy('id', 'DESC')
            ->with(['expediente', 'expediente.hoja1.unidad_ejecutora', 'expediente.tipoSolicitud'])
            ->whereExists(function ($query) {
                $query->select()
                    ->from('p_expediente_tecnico')
                    ->whereRaw('p_expediente_tecnico.id = rel_estudio_expediente_obra.id_expediente_tecnico')
                    ->whereRaw('p_expediente_tecnico.id_estatus = 2');;
            })
        ;

        return Datatables::of($expediente)
            ->make(true);
    }

    public function regresar_observaciones(Request $request)
    {

        DB::beginTransaction();
        try {
            $evaluacion                        = new P_Evaluacion_Expediente;
            $evaluacion->id_expediente_tecnico = $request->id_expediente_tecnico;
            $evaluacion->fecha_observacion     = date('Y-m-d H:i:s');
            $evaluacion->observaciones         = $request->observaciones;
            $evaluacion->id_usuario    = \Auth::user()->id;
            $evaluacion->save();

            $expediente_tecnico             = P_Expediente_Tecnico::find($request->id_expediente_tecnico);
            $expediente_tecnico->id_estatus = 5;
            $expediente_tecnico->fecha_evaluacion = date('Y-m-d H:i:s');
            
            $expediente_tecnico->save();
            DB::commit();
            $expediente['id_expediente_tecnico'] = $expediente_tecnico->id;
            return ($expediente);

        } catch (Exception $e) {
            DB::rollback();
            $expediente            = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($expediente);
        }

    }
}
