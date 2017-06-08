<?php

namespace App\Http\Controllers\ExpedienteTecnico;

use App\Cat_Ejercicio;
use App\D_Obra;
use App\P_Expediente_Tecnico;
use App\Http\Controllers\Controller;
use App\Rel_Estudio_Expediente_Obra;
use Illuminate\Http\Request;
use P_Anexo_Uno;

class AutorizacionExpedienteController extends Controller
{
    protected $barraMenu;

    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        $barraMenu = array(
            'botones' => array([
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
        $ejercicios = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
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
        return view('ExpedienteTecnico/Autorizacion.index', compact('barraMenu', 'ejercicios'));

    }

    public function buscar_obra(Request $request)
    {

        $obra = D_Obra::with(array('sector', 'unidad_ejecutora', 'modalidad_ejecucion', 'relacion.expediente.tipoSolicitud'))
            ->where('ejercicio', '=', $request->ejercicio)->find($request->id_obra);
        // dd($obra);
        if ($obra) {
            if ($obra->asignado > 0.00) {
                if ($obra->relacion->expediente->id_tipo_solicitud !== 1 && $obra->relacion->expediente->id_tipo_solicitud !== 2) {
                    $obra          = array();
                    $obra['error'] = "La Solicitud actual de la Obra debe ser de Asignación para realizar la Solicitud de Autorización.";
                    return ($obra);
                } else {
                    return ($obra);
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

    public function generar_autorizacion(Request $request)
    {

        $relacion = Rel_Estudio_Expediente_Obra::with(array('expediente.hoja1', 'expediente.hoja2', 'expediente.acuerdos', 'expediente.fuentes_monto', 'expediente.regiones', 'expediente.municipios', 'expediente.conceptos', 'expediente.programas', 'expediente.avance_financiero', 'expediente.hoja5', 'expediente.hoja6'))->where('id_det_obra', '=', $request->id_obra)
            ->first();

        dd($relacion);

        $hoja1                              = new P_Anexo_Uno;
        $hoja1->id_tipo_solicitud           = $request->id_tipo_solicitud;
        $hoja1->bevaluacion_socioeconomica  = $request->bevaluacion_socioeconomica;
        $hoja1->bestudio_socioeconomico     = $request->bestudio_socioeconomico;
        $hoja1->bproyecto_ejecutivo         = $request->bproyecto_ejecutivo;
        $hoja1->bderecho_via                = $request->bderecho_via;
        $hoja1->bimpacto_ambiental          = $request->bimpacto_ambiental;
        $hoja1->bobra                       = $request->bobra;
        $hoja1->baccion                     = $request->baccion;
        $hoja1->botro                       = $request->botro;
        $hoja1->descripcion_botro           = $request->descripcion_botro;
        $hoja1->ejercicio                   = $request->ejercicio;
        $hoja1->nombre_obra                 = $request->nombre_obra;
        $hoja1->id_tipo_obra                = $request->id_tipo_obra;
        $hoja1->id_modalidad_ejecucion      = $request->id_modalidad_ejecucion;
        $hoja1->id_unidad_ejecutora         = $request->id_unidad_ejecutora;
        $hoja1->id_sector                   = $request->id_sector;
        $hoja1->justificacion_obra          = $request->justificacion_obra;
        $hoja1->monto                       = $request->monto;
        $hoja1->monto_municipal             = $request->monto_municipal;
        $hoja1->fuente_municipal            = $request->fuente_municipal;
        $hoja1->principales_caracteristicas = $request->principales_caracteristicas;
        $hoja1->id_meta                     = $request->id_meta;
        $hoja1->cantidad_meta               = $request->cantidad_meta;
        $hoja1->id_beneficiario             = $request->id_beneficiario;
        $hoja1->cantidad_beneficiario       = $request->cantidad_beneficiario;
        $hoja1->save();

        $expediente_tecnico                    = new P_Expediente_Tecnico;
        $expediente_tecnico->ejercicio         = $request->ejercicio;
        $expediente_tecnico->id_anexo_uno      = $hoja1->id;
        $expediente_tecnico->id_estatus        = 1;
        $expediente_tecnico->fecha_creacion    = date('Y-m-d H:i:s');
        $expediente_tecnico->id_usuario        = \Auth::user()->id;
        $expediente_tecnico->id_tipo_solicitud = $request->id_tipo_solicitud;
        $expediente_tecnico->save();
        
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
