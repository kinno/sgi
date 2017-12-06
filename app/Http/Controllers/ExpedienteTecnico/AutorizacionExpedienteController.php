<?php

namespace App\Http\Controllers\ExpedienteTecnico;

use App\Cat_Ejercicio;
use App\Cat_Empresa;
use App\Cat_Modalidad_Adjudicacion_Contrato;
use App\Cat_Tipo_Contrato;
use App\Cat_Tipo_Obra_Contrato;
use App\D_Contrato;
use App\D_Obra;
use App\Http\Controllers\Controller;
use App\P_Anexo_Cinco;
use App\P_Anexo_Dos;
use App\P_Anexo_Seis;
use App\P_Anexo_Uno;
use App\P_Avance_Financiero;
use App\P_Avance_Financiero_Contrato;
use App\P_Contrato;
use App\P_Expediente_Tecnico;
use App\P_Historial_Obra_Expediente;
use App\P_Presupuesto_Obra;
use App\P_Programa;
use App\P_Programa_Contrato;
use App\Rel_Estudio_Expediente_Obra;
use App\Rel_Obra_Fuente;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Jobs\CrearNotificacion;

class AutorizacionExpedienteController extends Controller
{
    protected $barraMenu;

    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index($id_obra = null)
    {
        $barraMenu = array(
            'botones' => array([
                'id'    => 'limpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ], [
                'id'    => 'observaciones',
                'tipo'  => 'btn-danger',
                'icono' => 'fa fa-exclamation-triangle',
                'title' => 'Ver observaciones',

            ], [
                'id'    => 'enviar_revision',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-share-square',
                'title' => 'Enviar a la DGI para revisión',
            ], [
                'id'    => 'imprimir_contrato',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-file-pdf-o',
                'title' => 'Imprimir Anexo 5',
            ]));

        $ejercicios = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
        return view('ExpedienteTecnico/Autorizacion.index', compact('barraMenu', 'ejercicios', 'id_obra'));

    }

    public function buscar_obra(Request $request)
    {

        $obra = D_Obra::with(array('sector', 'unidad_ejecutora', 'modalidad_ejecucion', 'relacion.expediente.tipoSolicitud'))
            ->with(array('relacion.expediente.observaciones' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }))
            ->with('relacion.expediente.fuentes_monto')
            ->where('ejercicio', '=', $request->ejercicio)
            ->where('id_obra','=',$request->id_obra)
            ->where('id_unidad_ejecutora',\Auth::user()->id_unidad_ejecutora)
            ->first();
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
            $obra['error'] = "La Obra no existe o no pertenece a la Unidad Ejecutora.";
            return ($obra);
        }
    }

    public function generar_autorizacion(Request $request)
    {

        $relacion = Rel_Estudio_Expediente_Obra::with(array('expediente.hoja1', 'expediente.hoja2', 'expediente.acuerdos', 'expediente.fuentes_monto', 'expediente.regiones', 'expediente.municipios', 'expediente.conceptos', 'expediente.programas', 'expediente.avance_financiero', 'expediente.hoja5', 'expediente.hoja6'))->where('id_det_obra', '=', $request->id_obra)
            ->first();

        // dd($relacion->expediente->fuentes_monto);
        DB::beginTransaction();
        try {
            $historial                           = new P_Historial_Obra_Expediente;
            $historial->id_expediente_tecnico    = $relacion->expediente->id;
            $historial->id_det_obra              = $relacion->id_det_obra;
            $historial->id_solicitud_presupuesto = $relacion->expediente->id_tipo_solicitud;
            $historial->monto                    = $relacion->expediente->hoja1->monto;
            $historial->id_usuario               = \Auth::user()->id;
            $historial->save();

            $hoja1                              = new P_Anexo_Uno;
            $hoja1->id_tipo_solicitud           = 2;
            $hoja1->bevaluacion_socioeconomica  = $relacion->expediente->hoja1->bevaluacion_socioeconomica;
            $hoja1->bestudio_socioeconomico     = $relacion->expediente->hoja1->bestudio_socioeconomico;
            $hoja1->bproyecto_ejecutivo         = $relacion->expediente->hoja1->bproyecto_ejecutivo;
            $hoja1->bderecho_via                = $relacion->expediente->hoja1->bderecho_via;
            $hoja1->bimpacto_ambiental          = $relacion->expediente->hoja1->bimpacto_ambiental;
            $hoja1->bobra                       = $relacion->expediente->hoja1->bobra;
            $hoja1->baccion                     = $relacion->expediente->hoja1->baccion;
            $hoja1->botro                       = $relacion->expediente->hoja1->botro;
            $hoja1->descripcion_botro           = $relacion->expediente->hoja1->descripcion_botro;
            $hoja1->ejercicio                   = $relacion->expediente->hoja1->ejercicio;
            $hoja1->nombre_obra                 = $relacion->expediente->hoja1->nombre_obra;
            $hoja1->id_tipo_obra                = $relacion->expediente->hoja1->id_tipo_obra;
            $hoja1->id_modalidad_ejecucion      = $relacion->expediente->hoja1->id_modalidad_ejecucion;
            $hoja1->id_unidad_ejecutora         = $relacion->expediente->hoja1->id_unidad_ejecutora;
            $hoja1->id_sector                   = $relacion->expediente->hoja1->id_sector;
            $hoja1->justificacion_obra          = $relacion->expediente->hoja1->justificacion_obra;
            $hoja1->monto                       = $relacion->expediente->hoja1->monto;
            $hoja1->monto_municipal             = $relacion->expediente->hoja1->monto_municipal;
            $hoja1->fuente_municipal            = $relacion->expediente->hoja1->fuente_municipal;
            $hoja1->principales_caracteristicas = $relacion->expediente->hoja1->principales_caracteristicas;
            $hoja1->id_meta                     = $relacion->expediente->hoja1->id_meta;
            $hoja1->cantidad_meta               = $relacion->expediente->hoja1->cantidad_meta;
            $hoja1->id_beneficiario             = $relacion->expediente->hoja1->id_beneficiario;
            $hoja1->cantidad_beneficiario       = $relacion->expediente->hoja1->cantidad_beneficiario;
            $hoja1->save();

            $hoja2                            = new P_Anexo_Dos;
            $hoja2->id_cobertura              = $relacion->expediente->hoja2->id_cobertura;
            $hoja2->nombre_localidad          = $relacion->expediente->hoja2->nombre_localidad;
            $hoja2->id_tipo_localidad         = $relacion->expediente->hoja2->id_tipo_localidad;
            $hoja2->bcoordenadas              = $relacion->expediente->hoja2->bcoordenadas;
            $hoja2->observaciones_coordenadas = $relacion->expediente->hoja2->observaciones_coordenadas;
            $hoja2->latitud_inicial           = $relacion->expediente->hoja2->latitud_inicial;
            $hoja2->longitud_inicial          = $relacion->expediente->hoja2->longitud_inicial;
            $hoja2->latitud_final             = $relacion->expediente->hoja2->latitud_final;
            $hoja2->longitud_final            = $relacion->expediente->hoja2->longitud_final;
            $hoja2->microlocalizacion         = $relacion->expediente->hoja2->microlocalizacion;
            $hoja2->save();

            if ($relacion->expediente->hoja5) {
                $hoja5                                 = new P_Anexo_Cinco;
                $hoja5->observaciones_unidad_ejecutora = $relacion->expediente->hoja5->observaciones_unidad_ejecutora;
                $hoja5->save();
            }

            if ($relacion->expediente->hoja6) {
                $hoja6                             = new P_Anexo_Seis;
                $hoja6->criterios_sociales         = $relacion->expediente->hoja6->criterios_sociales;
                $hoja6->unidad_ejecutora_normativa = $relacion->expediente->hoja6->unidad_ejecutora_normativa;
                $hoja6->save();
            }

            $expediente_tecnico                    = new P_Expediente_Tecnico;
            $expediente_tecnico->ejercicio         = $relacion->expediente->ejercicio;
            $expediente_tecnico->id_anexo_uno      = $hoja1->id;
            $expediente_tecnico->id_anexo_dos      = $hoja2->id;
            $expediente_tecnico->id_anexo_cinco    = (isset($hoja5)) ? $hoja5->id : null;
            $expediente_tecnico->id_anexo_seis     = (isset($hoja6)) ? $hoja6->id : null;
            $expediente_tecnico->id_estatus        = 1;
            $expediente_tecnico->fecha_creacion    = date('Y-m-d H:i:s');
            $expediente_tecnico->id_usuario        = \Auth::user()->id;
            $expediente_tecnico->id_tipo_solicitud = 2;
            $expediente_tecnico->save();

            $syncArray = array();

            foreach ($relacion->expediente->fuentes_monto as $value) {
                $syncArray[$value->id] = array('id_expediente_tecnico' => $expediente_tecnico->id,
                    // 'id_fuente' => $value->id,
                    'monto'                                                => $value->pivot->monto,
                    'tipo_fuente'                                          => $value->tipo);
            }

            $expediente_tecnico->fuentes_monto()->sync($syncArray);

            $syncArray = array();
            foreach ($relacion->expediente->acuerdos as $value) {
                $syncArray[$value->id] = array('id_expediente_tecnico' => $expediente_tecnico->id);

            }
            $expediente_tecnico->acuerdos()->sync($syncArray);

            $syncArray = array();
            foreach ($relacion->expediente->municipios as $value) {
                $syncArray[$value->id] = array('id_expediente_tecnico' => $expediente_tecnico->id);
            }
            $expediente_tecnico->municipios()->sync($syncArray);

            $syncArray = array();
            foreach ($relacion->expediente->regiones as $value) {
                $syncArray[$value->id] = array('id_expediente_tecnico' => $expediente_tecnico->id);

            }
            $expediente_tecnico->regiones()->sync($syncArray);

            foreach ($relacion->expediente->conceptos as $value) {
                $conceptos                        = new P_Presupuesto_Obra;
                $conceptos->id_expediente_tecnico = $expediente_tecnico->id;
                $conceptos->clave_objeto_gasto    = $value->clave_objeto_gasto;
                $conceptos->concepto              = $value->concepto;
                $conceptos->unidad_medida         = $value->unidad_medida;
                $conceptos->cantidad              = $value->cantidad;
                $conceptos->precio_unitario       = $value->precio_unitario;
                $conceptos->importe               = $value->importe;
                $conceptos->iva                   = $value->iva;
                $conceptos->total                 = $value->total;
                $conceptos->save();
            }

            foreach ($relacion->expediente->programas as $value) {
                $programa                        = new P_Programa;
                $programa->id_expediente_tecnico = $expediente_tecnico->id;
                $programa->concepto              = $value->concepto;
                $programa->porcentaje_enero      = $value->porcentaje_enero;
                $programa->porcentaje_febrero    = $value->porcentaje_febrero;
                $programa->porcentaje_marzo      = $value->porcentaje_marzo;
                $programa->porcentaje_abril      = $value->porcentaje_abril;
                $programa->porcentaje_mayo       = $value->porcentaje_mayo;
                $programa->porcentaje_junio      = $value->porcentaje_junio;
                $programa->porcentaje_julio      = $value->porcentaje_julio;
                $programa->porcentaje_agosto     = $value->porcentaje_agosto;
                $programa->porcentaje_septiembre = $value->porcentaje_septiembre;
                $programa->porcentaje_octubre    = $value->porcentaje_octubre;
                $programa->porcentaje_noviembre  = $value->porcentaje_noviembre;
                $programa->porcentaje_diciembre  = $value->porcentaje_diciembre;
                $programa->porcentaje_total      = $value->porcentaje_total;
                $programa->save();
            }

            $p_avance                        = new P_Avance_Financiero;
            $p_avance->id_expediente_tecnico = $expediente_tecnico->id;
            $p_avance->enero                 = $relacion->expediente->avance_financiero->enero;
            $p_avance->febrero               = $relacion->expediente->avance_financiero->febrero;
            $p_avance->marzo                 = $relacion->expediente->avance_financiero->marzo;
            $p_avance->abril                 = $relacion->expediente->avance_financiero->abril;
            $p_avance->mayo                  = $relacion->expediente->avance_financiero->mayo;
            $p_avance->junio                 = $relacion->expediente->avance_financiero->junio;
            $p_avance->julio                 = $relacion->expediente->avance_financiero->julio;
            $p_avance->agosto                = $relacion->expediente->avance_financiero->agosto;
            $p_avance->septiembre            = $relacion->expediente->avance_financiero->septiembre;
            $p_avance->octubre               = $relacion->expediente->avance_financiero->octubre;
            $p_avance->noviembre             = $relacion->expediente->avance_financiero->noviembre;
            $p_avance->diciembre             = $relacion->expediente->avance_financiero->diciembre;
            $p_avance->save();

            $relacion->id_expediente_tecnico = $expediente_tecnico->id;
            $relacion->save();

            DB::commit();

            $expediente['id'] = $expediente_tecnico->id;
            return $expediente;

        } catch (\Exception $e) {
            DB::rollback();
            $expediente            = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($expediente);
        }

    }

    public function get_data_contratos($id_expediente_tecnico)
    {
        $contratos = P_Contrato::
            where('id_expediente_tecnico', '=', $id_expediente_tecnico);

        return \Datatables::of($contratos)
            ->make(true);
    }

    public function get_data_conceptos_contrato($id_contrato)
    {
        $conceptos = P_Presupuesto_Obra::
            where('id_contrato', '=', $id_contrato);

        return \Datatables::of($conceptos)
            ->make(true);
    }

    public function buscar_rfc(Request $request)
    {
        try {
            $empresa = Cat_Empresa::where('rfc', '=', $request->rfc)->first();
            return $empresa;
        } catch (\Exception $e) {
            DB::rollback();
            $empresa            = array();
            $empresa['message'] = $e->getMessage();
            $empresa['trace']   = $e->getTrace();
            $empresa['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($empresa);
        }
    }

    public function buscar_contrato(Request $request)
    {
        try {
            $contrato = P_Contrato::with('d_contrato', 'empresa', 'avance_financiero')->where('id', '=', $request->id_contrato)->where('id_usuario', '=', \Auth::user()->id)->first();
            return $contrato;
        } catch (\Exception $e) {
            DB::rollback();
            $contrato            = array();
            $contrato['message'] = $e->getMessage();
            $contrato['trace']   = $e->getTrace();
            $contrato['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($contrato);
        }
    }

    public function crear_contrato($id_obra, $id_contrato)
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
        $relacion = Rel_Estudio_Expediente_Obra::with('obra.detalles_oficio.oficio', 'obra.unidad_ejecutora')->where('id_det_obra', '=', $id_obra)
            ->first();
        $empresa                = Cat_Empresa::all();
        $tipo_contrato          = Cat_Tipo_Contrato::all();
        $modalidad_adjudicacion = Cat_Modalidad_Adjudicacion_Contrato::all();
        $tipo_obra_contrato     = Cat_Tipo_Obra_Contrato::all();
        return view('ExpedienteTecnico/Autorizacion.detalle_contrato', compact('barraMenu', 'relacion', 'empresa', 'tipo_contrato', 'modalidad_adjudicacion', 'tipo_obra_contrato', 'id_contrato'));
    }

    public function guardar_datos_generales(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'numero_contrato'                    => 'required',
            'fecha_celebracion'                  => 'required',
            'descripcion'                        => 'required',
            'rfc'                                => 'required',
            'padron_contratista'                 => 'required_if:bnueva_empresa,1',
            'nombre'                             => 'required_if:bnueva_empresa,1',
            'nombre_representante'               => 'required_if:bnueva_empresa,1',
            'cargo_representante'                => 'required_if:bnueva_empresa,1',
            'id_tipo_contrato'                   => 'required',
            'id_modalidad_adjudicacion_contrato' => 'required',
            'fecha_inicio'                       => 'required',
            'fecha_fin'                          => 'required',
            'bdisponibilidad_inmueble'           => 'required',
            'motivo_no_disponible'               => 'required_if:bdisponibilidad_inmueble,0',
            'fecha_disponibilidad'               => 'required_if:bdisponibilidad_inmueble,0',
            'id_tipo_obra_contrato'              => 'required',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }
        //CREAR CONTRATO
        // dd($request->all());
        DB::beginTransaction();
        try {
            if ($request->bnueva_empresa) {
                $empresa                       = new Cat_Empresa;
                $empresa->rfc                  = $request->rfc;
                $empresa->nombre               = $request->nombre;
                $empresa->padron_contratista   = $request->padron_contratista;
                $empresa->nombre_representante = $request->nombre_representante;
                $empresa->cargo_representante  = $request->cargo_representante;
                $empresa->save();
                $request->id_empresa = $empresa->id;
            }
            if ($request->id_contrato) {
                $contrato   = P_Contrato::find($request->id_contrato);
                $d_contrato = D_Contrato::where('id_contrato', '=', $contrato->id)->first();
            } else {
                $contrato   = new P_Contrato;
                $d_contrato = new D_Contrato;
            }

            $contrato->id_expediente_tecnico = $request->id_expediente_tecnico;
            $contrato->numero_contrato       = $request->numero_contrato;
            $contrato->fecha_celebracion     = Carbon::parse($request->fecha_celebracion)->format('Y-m-d H:i:s');
            $contrato->id_empresa            = $request->id_empresa;
            $contrato->id_usuario            = \Auth::user()->id;
            $contrato->save();

            $d_contrato->id_contrato                        = $contrato->id;
            $d_contrato->descripcion                        = $request->descripcion;
            $d_contrato->fecha_inicio                       = Carbon::parse($request->fecha_inicio)->format('Y-m-d H:i:s');
            $d_contrato->fecha_fin                          = Carbon::parse($request->fecha_fin)->format('Y-m-d H:i:s');
            $d_contrato->dias_calendario                    = $request->dias_calendario;
            $d_contrato->bdisponibilidad_inmueble           = $request->bdisponibilidad_inmueble;
            $d_contrato->motivo_no_disponible               = $request->motivo_no_disponible;
            $d_contrato->fecha_disponibilidad               = ($request->fecha_disponibilidad) ? Carbon::parse($request->fecha_disponibilidad)->format('Y-m-d H:i:s') : null;
            $d_contrato->id_tipo_contrato                   = $request->id_tipo_contrato;
            $d_contrato->id_modalidad_adjudicacion_contrato = $request->id_modalidad_adjudicacion_contrato;
            $d_contrato->id_tipo_obra_contrato              = $request->id_tipo_obra_contrato;
            $d_contrato->save();
            DB::commit();
            return ($contrato->id);
        } catch (Exception $e) {
            DB::rollback();
            $contrato            = array();
            $contrato['message'] = $e->getMessage();
            $contrato['trace']   = $e->getTrace();
            $contrato['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($contrato);
        }

    }

    public function guardar_conceptos_contrato(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $arrayIds = array();
            foreach ($request->conceptosPresupuesto as $value) {
                if ($value['id']) {
                    //ID
                    $conceptos = P_Presupuesto_Obra::find($value['id']);
                } else {
                    $conceptos = new P_Presupuesto_Obra;
                }
                $conceptos->id_expediente_tecnico = $request->id_expediente_tecnico;
                $conceptos->clave_objeto_gasto    = $value['clave_objeto_gasto'];
                $conceptos->concepto              = $value['concepto'];
                $conceptos->unidad_medida         = $value['unidad_medida'];
                $conceptos->cantidad              = $value['cantidad'];
                $conceptos->precio_unitario       = $value['precio_unitario'];
                $conceptos->importe               = $value['importe'];
                $conceptos->iva                   = $value['iva'];
                $conceptos->total                 = $value['total'];
                $conceptos->id_contrato           = $request->id_contrato;
                $conceptos->save();
                array_push($arrayIds, $conceptos->id);

            }

            if (isset($request->conceptosEliminados)) {
                P_Presupuesto_Obra::destroy($request->conceptosEliminados);
            }

            $contrato        = P_Contrato::find($request->id_contrato);
            $contrato->monto = $request->montoTotal;
            $contrato->save();
            DB::commit();
            return $arrayIds;
        } catch (\Exception $e) {
            DB::rollback();
            $conceptos            = array();
            $conceptos['message'] = $e->getMessage();
            $conceptos['trace']   = $e->getTrace();
            $conceptos['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($conceptos);
        }
    }

    public function guardar_contrato_garantias(Request $request)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            // 'folio_garantia'                      => 'required',
            'fecha_emision_garantia'              => 'required_with:folio_garantia',
            'importe_garantia'                    => 'required_with:folio_garantia',
            'fecha_inicio_garantia'               => 'required_with:folio_garantia',
            'fecha_fin_garantia'                  => 'required_with:folio_garantia',
            'importe_anticipo'                    => 'required_with:folio_garantia',
            'porcentaje_anticipo'                 => 'required_with:importe_anticipo',
            'forma_pago_anticipo'                 => 'required_with:importe_anticipo',
            // 'folio_garantia_cumplimiento'         => 'required',
            'fecha_emision_garantia_cumplimiento' => 'required_with:folio_garantia_cumplimiento',
            'importe_garantia_cumplimiento'       => 'required_with:folio_garantia_cumplimiento',
            'fecha_inicio_garantia_cumplimiento'  => 'required_with:folio_garantia_cumplimiento',
            'fecha_fin_garantia_cumplimiento'     => 'required_with:folio_garantia_cumplimiento',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }
        //CREAR CONTRATO
        // dd($request->all());
        DB::beginTransaction();
        try {
            $d_contrato                                      = D_Contrato::where('id_contrato', '=', $request->id_contrato)->first();
            $d_contrato->folio_garantia                      = $request->folio_garantia;
            $d_contrato->fecha_emision_garantia              = Carbon::parse($request->fecha_emision_garantia)->format('Y-m-d H:i:s');
            $d_contrato->importe_garantia                    = str_replace(",", "", $request->importe_garantia);
            $d_contrato->fecha_inicio_garantia               = Carbon::parse($request->fecha_inicio_garantia)->format('Y-m-d H:i:s');
            $d_contrato->fecha_fin_garantia                  = Carbon::parse($request->fecha_fin_garantia)->format('Y-m-d H:i:s');
            $d_contrato->importe_anticipo                    = str_replace(",", "", $request->importe_anticipo);
            $d_contrato->porcentaje_anticipo                 = $request->porcentaje_anticipo;
            $d_contrato->forma_pago_anticipo                 = $request->forma_pago_anticipo;
            $d_contrato->folio_garantia_cumplimiento         = $request->folio_garantia_cumplimiento;
            $d_contrato->fecha_emision_garantia_cumplimiento = Carbon::parse($request->fecha_emision_garantia_cumplimiento)->format('Y-m-d H:i:s');
            $d_contrato->importe_garantia_cumplimiento       = str_replace(",", "", $request->importe_garantia_cumplimiento);
            $d_contrato->fecha_inicio_garantia_cumplimiento  = Carbon::parse($request->fecha_inicio_garantia_cumplimiento)->format('Y-m-d H:i:s');
            $d_contrato->fecha_fin_garantia_cumplimiento     = Carbon::parse($request->fecha_fin_garantia_cumplimiento)->format('Y-m-d H:i:s');

            $d_contrato->save();
            DB::commit();
            return ($d_contrato->id_contrato);
        } catch (Exception $e) {
            DB::rollback();
            $contrato            = array();
            $contrato['message'] = $e->getMessage();
            $contrato['trace']   = $e->getTrace();
            $contrato['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($contrato);
        }
    }

    public function get_data_programa($id_contrato)
    {

        $conceptos = P_Programa_Contrato::
            where('id_contrato', '=', $id_contrato);

        return \Datatables::of($conceptos)
            ->make(true);
    }

    public function guardar_programa_contrato(Request $request)
    {
        $arrayIds = array();
        DB::beginTransaction();
        try {
            foreach ($request->calendarizadoPrograma as $value) {
                if ($value['id']) {
                    //ID
                    $programa = P_Programa_Contrato::find($value['id']);
                } else {
                    $programa = new P_Programa_Contrato;
                }
                $programa->id_contrato           = $request->id_contrato;
                $programa->concepto              = $value['concepto'];
                $programa->porcentaje_enero      = $value['porcentaje_enero'];
                $programa->porcentaje_febrero    = $value['porcentaje_febrero'];
                $programa->porcentaje_marzo      = $value['porcentaje_marzo'];
                $programa->porcentaje_abril      = $value['porcentaje_abril'];
                $programa->porcentaje_mayo       = $value['porcentaje_mayo'];
                $programa->porcentaje_junio      = $value['porcentaje_junio'];
                $programa->porcentaje_julio      = $value['porcentaje_julio'];
                $programa->porcentaje_agosto     = $value['porcentaje_agosto'];
                $programa->porcentaje_septiembre = $value['porcentaje_septiembre'];
                $programa->porcentaje_octubre    = $value['porcentaje_octubre'];
                $programa->porcentaje_noviembre  = $value['porcentaje_noviembre'];
                $programa->porcentaje_diciembre  = $value['porcentaje_diciembre'];
                $programa->porcentaje_total      = $value['porcentaje_total'];

                $programa->save();
                array_push($arrayIds, $programa->id);
            }

            if (isset($request->programasEliminados)) {
                P_Programa_Contrato::destroy($request->programasEliminados);
            }
            DB::commit();
            return $arrayIds;
        } catch (\Exception $e) {
            DB::rollback();
            $hoja4            = array();
            $hoja4['message'] = $e->getMessage();
            $hoja4['trace']   = $e->getTrace();
            $hoja4['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($hoja4);
        }
    }

    public function guardar_avance_financiero_contrato(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $p_avance = P_Avance_Financiero_Contrato::where('id_contrato', '=', $request->id_contrato)
                ->first();
            // dd($p_avance);
            if (!$p_avance) {
                $p_avance = new P_Avance_Financiero_Contrato;
            }

            $p_avance->id_contrato = $request->id_contrato;
            $p_avance->enero       = $request->avance_financiero['enero'];
            $p_avance->febrero     = $request->avance_financiero['febrero'];
            $p_avance->marzo       = $request->avance_financiero['marzo'];
            $p_avance->abril       = $request->avance_financiero['abril'];
            $p_avance->mayo        = $request->avance_financiero['mayo'];
            $p_avance->junio       = $request->avance_financiero['junio'];
            $p_avance->julio       = $request->avance_financiero['julio'];
            $p_avance->agosto      = $request->avance_financiero['agosto'];
            $p_avance->septiembre  = $request->avance_financiero['septiembre'];
            $p_avance->octubre     = $request->avance_financiero['octubre'];
            $p_avance->noviembre   = $request->avance_financiero['noviembre'];
            $p_avance->diciembre   = $request->avance_financiero['diciembre'];
            $p_avance->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $hoja4            = array();
            $hoja4['message'] = $e->getMessage();
            $hoja4['trace']   = $e->getTrace();
            $hoja4['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($hoja4);
        }
    }

    public function eliminar_contrato(Request $request)
    {
        DB::beginTransaction();
        try {
            P_Contrato::destroy($request->id_contrato);
            D_Contrato::where('id_contrato', '=', $request->id_contrato)->delete();
            P_Avance_Financiero_Contrato::where('id_contrato', '=', $request->id_contrato)->delete();
            P_Programa_Contrato::where('id_contrato', '=', $request->id_contrato)->delete();
            P_Presupuesto_Obra::where('id_contrato', '=', $request->id_contrato)->delete();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $hoja4            = array();
            $hoja4['message'] = $e->getMessage();
            $hoja4['trace']   = $e->getTrace();
            $hoja4['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($hoja4);
        }
    }

    public function imprime_contrato($id_expediente_tecnico)
    {
        $relacion = Rel_Estudio_Expediente_Obra::with('expediente.contrato.d_contrato.adjudicacion', 'expediente.contrato.d_contrato.tipo_contrato', 'expediente.contrato.d_contrato.tipo_obra_contrato', 'expediente.contrato.empresa', 'expediente.contrato.avance_financiero', 'expediente.contrato.avance_fisico', 'expediente.contrato.conceptos', 'obra.unidad_ejecutora', 'obra.municipio_reporte')->where('id_expediente_tecnico', '=', $id_expediente_tecnico)
            ->first();
        $oficioAsignacion = DB::table('p_oficio')
            ->join('d_oficio', 'p_oficio.id', '=', 'd_oficio.id_oficio')
            ->join('cat_fuente', 'd_oficio.id_fuente', '=', 'cat_fuente.id')
            ->select('p_oficio.clave', 'p_oficio.fecha_oficio', 'cat_fuente.descripcion', 'd_oficio.asignado')
            ->where('p_oficio.id_solicitud_presupuesto', '=', 1)
            ->where('id_det_obra', '=', $relacion->obra->id)
            ->get();

        $pdf = \PDF::loadView('PDF/contrato', compact('relacion', 'oficioAsignacion'));
        // return $pdf->stream('Anexo5_Expediente_' . $relacion->id_expediente_tecnico . '.pdf');
        return $pdf->stream('Contrato_General_Expediente_' . $relacion->id_expediente_tecnico . '.pdf');
    }

    public function asignar_autorizado_fuentes(Request $request)
    {
        DB::beginTransaction();
        try {
            $expediente = P_Expediente_Tecnico::with('fuentes_monto', 'contrato','hoja1')
                ->find($request->id_expediente_tecnico);
            $montoTotal        = 0.00;
            $montoTotalFuentes = 0.00;

            foreach ($expediente->contrato as $value) {
                $montoTotal += floatval($value->monto);
            }
            foreach ($expediente->fuentes_monto as $value) {
                $montoTotalFuentes += $value->pivot->monto;

            }

            $syncArray = array();
            //sacando el porcentaje de las fuentes
            foreach ($expediente->fuentes_monto as $value) {
                $porcentajeFuente      = floatval((($value->pivot->monto) * 100) / $montoTotalFuentes);
                $montoFuente           = floatval(($porcentajeFuente * $montoTotal) / 100);
                $syncArray[$value->id] = array('id_expediente_tecnico' => $expediente->id,
                    'monto'                                                => $montoFuente,
                    'tipo_fuente'                                          => $value->tipo);

                $rel_obra_fuente = Rel_Obra_Fuente::where('id_det_obra', $request->id_obra)->where('id_fuente', $value->id)->first();
                $rel_obra_fuente->monto = $montoFuente; 
                $rel_obra_fuente->save();
            }
            $expediente->fuentes_monto()->sync($syncArray);

            $expediente->fecha_envio = date('Y-m-d H:i:s');
            $expediente->id_estatus=2;
            
            foreach (\Auth::user()->sectores()->get() as $value) {
                $sectorUser = $value->id;
            };
            $detalle = "La dependencia " . \Auth::user()->name . " ha enviado el Expediente Técnico: " . $expediente->id . " para su revisión y aprobación.";
            // dd($detalle);
            dispatch(new CrearNotificacion(null, \Auth::user()->id, $sectorUser, $detalle));

            $expediente->save();
            $expediente->hoja1->monto = $montoTotal;
            $expediente->hoja1->save();
            DB::commit();
            $expediente['id_expediente_tecnico'] = $expediente->id;
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
