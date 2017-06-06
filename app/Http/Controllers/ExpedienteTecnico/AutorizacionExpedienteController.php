<?php

namespace App\Http\Controllers\ExpedienteTecnico;

use App\D_Obra;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutorizacionExpedienteController extends Controller
{
    protected $barraMenu;

    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        $barraMenu = array('input' => array('id' => 'id_obra_search', 'class' => 'text-right num', 'title' => 'Obra:'),
            'botones'                  => array([
                'id'    => 'buscar',
                'tipo'  => 'btn-default',
                'icono' => 'fa fa-search',
                'title' => 'Buscar Solicitud',
            ], [
                'id'    => 'limpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ], [
                'id'    => 'enviar_revision',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-share-square',
                'title' => 'Enviar a la DGI para revisión',
            ], [
                'id'    => 'imprimir_expediente',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-file-pdf-o',
                'title' => 'Imprimir Expediente Técnico',
            ]));
        // $user              = \Auth::user()->load('unidad_ejecutora')->load('sectores');
        // $ejercicios        = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
        // $tipoSolicitud     = Cat_Solicitud_Presupuesto::whereIn('id', array(1, 10, 11, 8))->get();
        // $accionesFederales = Cat_Acuerdo::where('id_tipo', '=', 4)->get();
        // $accionesEstatales = Cat_Acuerdo::where('id_tipo', '=', 1)
        //     ->orWhere('id_tipo', '=', 2)
        //     ->get();
        // $coberturas     = Cat_Cobertura::where('id', '>', 0)->get();
        // $localidades    = Cat_Tipo_Localidad::where('id', '>', 0)->get();
        // $regiones       = Cat_Region::where('id', '>', 0)->get();
        // $municipios     = Cat_Municipio::where('id', '>', 0)->get();
        // $metas          = Cat_Meta::where('id', '>', 0)->get();
        // $beneficiarios  = Cat_Beneficiario::where('id', '>', 0)->get();
        // $fuentesFederal = Cat_Fuente::where('tipo', '=', 'F')->get();
        // $fuentesEstatal = Cat_Fuente::where('tipo', '=', 'E')->get();
        // $ue             = array('id' => $user->unidad_ejecutora->id, 'nombre' => $user->unidad_ejecutora->nombre);
        // $sector         = array('id' => $user->sectores[0]->id, 'nombre' => $user->sectores[0]->nombre);
        // return view('ExpedienteTecnico/Asignacion.index', compact('ejercicios', 'tipoSolicitud', 'accionesFederales', 'accionesEstatales', 'coberturas', 'localidades', 'regiones', 'municipios', 'metas', 'beneficiarios', 'fuentesFederal', 'fuentesEstatal', 'ue', 'sector', 'barraMenu'));
        return view('ExpedienteTecnico/Autorizacion.index', compact('barraMenu'));

    }

    public function buscar_obra(Request $request)
    {

        $obra = D_Obra::with(array('sector','unidad_ejecutora','modalidad_ejecucion','relacion.expediente.tipoSolicitud'))->find($request->id_obra);
        // dd($obra);
        if ($obra) {
            if ($obra->asignado > 0.00) {
                if ($obra->relacion->expediente->id_tipo_solicitud !== 1 && $obra->relacion->expediente->id_tipo_solicitud !== 2) {
                    $obra          = array();
                    $obra['error'] = "La Solicitud actual de la Obra debe ser de Asignación para realizar la Solicitud de Autorización.";
                    return ($obra);
                }else{
                    return($obra);
                }
            } else {
                $obra          = array();
                $obra['error'] = "La Obra no tiene recursos Asignados.";
                return ($obra);
            }
        } else {
            $obra          = array();
            $obra['error'] = "La Obra no existe.";
            return ($obra);
        }
    }

    public function generar_autorizacion(Request $request){
        dd($request);
    }

    public function crear_contrato()
    {
        $barraMenu = array(
            'botones' => array([
                'id'    => 'guardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
            ], [
                'id'    => 'btnRegresar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-arrow-left',
                'title' => 'Regresar',
                'texto' => 'Regresar',
            ]));
        return view('ExpedienteTecnico/Autorizacion.detalle_contrato')
            ->with('barraMenu', $barraMenu);
    }
}
