<?php

namespace App\Http\Controllers\AutorizacionPago;

use App\Cat_Ejercicio;
use App\Cat_Empresa;
use App\Cat_Tipo_Ap;
use App\Http\Controllers\Controller;
use App\P_Autorizacion_Pago;
use App\Rel_Estudio_Expediente_Obra;
use DB;
use Illuminate\Http\Request;

class AutorizacionPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        $barraMenu = array(
            'botones' => array([
                'id'    => 'limpiar',
                'tipo'  => 'btn-warning btn-sm',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ], [
                'id'    => 'guardar',
                'tipo'  => 'btn-success btn-sm',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
            ]));
        $ejercicios     = Cat_Ejercicio::orderBy('ejercicio', 'DESC')->get();
        $tipoMovimiento = Cat_Tipo_Ap::whereIn('id', [1, 2, 4])->get();
        return view('AutorizacionPago.crear_index', compact('ejercicios', 'tipoMovimiento', 'barraMenu'));
        // return view('Oficios.crear_index', compact('tipoSolicitud', 'ejercicios', 'barraMenu', 'fuentes', 'unidad_ejecutora'));
    }

    public function buscar_obra(Request $request)
    {
        // dd(\Auth::user()->id_unidad_ejecutora);
        $relacion = Rel_Estudio_Expediente_Obra::with('expediente.contrato.d_contrato', 'expediente.contrato.empresa', 'obra.unidad_ejecutora', 'obra.sector', 'obra.modalidad_ejecucion', 'obra.fuentes')
            ->where('id_det_obra', $request->id_obra)
            ->first();
        // dd($relacion);
        if ($relacion) {
            if ($relacion->obra->id_unidad_ejecutora == \Auth::user()->id_unidad_ejecutora) {
                return $relacion;
            } else {
                $relacion          = array();
                $relacion['error'] = "No existe la Obra";
                return ($relacion);
            }

        } else {
            $relacion          = array();
            $relacion['error'] = "No existe la Obra";
            return ($relacion);
        }

    }

    public function buscar_folio(Request $request)
    {

        $ap = P_Autorizacion_Pago::with('contrato', 'empresa', 'obra.relacion.expediente.contrato.d_contrato', 'obra.relacion.expediente.contrato.empresa', 'obra.unidad_ejecutora', 'obra.sector', 'obra.modalidad_ejecucion', 'obra.fuentes')
            ->where('clave', $request->folio)
            ->where('ejercicio', $request->ejercicio)
            ->where('id_unidad_ejecutora', \Auth::user()->id_unidad_ejecutora)
        // ->where('id_estatus',)
            ->first();

        if ($ap) {
            return $ap;
        } else {
            $relacion          = array();
            $relacion['error'] = "No existe la Autorización de Pago";
            return ($relacion);
        }

    }

    public function guardar_ap(Request $request)
    {

        //     //ANTICIPO CONTRATOS
        $arrayIds = array();

        DB::beginTransaction();
        try {
            foreach ($request->data as $value) {
                $validator = \Validator::make($value, [
                    'rfc' => 'required',
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();
                    return array('error_validacion' => $errors);

                }

                if (isset($value['bnueva_empresa'])) {
                    // PARA AP POR ADMINISTRACION
                    $empresa                       = new Cat_Empresa;
                    $empresa->rfc                  = $value['rfc'];
                    $empresa->nombre               = $value['nombre'];
                    $empresa->padron_contratista   = $value['padron_contratista'];
                    $empresa->nombre_representante = $value['nombre_representante'];
                    $empresa->cargo_representante  = $value['cargo_representante'];
                    $empresa->save();
                    $value['id_empresa'] = $empresa->id;
                }

                if (isset($value['id'])) {
                    $ap = P_Autorizacion_Pago::find($value['id']);
                } else {
                    $ap        = new P_Autorizacion_Pago;
                    $folio     = $this->genera_folio();
                    $ap->clave = $folio;
                }

                $ap->id_tipo_ap             = $value['id_tipo_ap'];
                $ap->id_estatus             = 4;
                $ap->id_obra                = $value['id_obra'];
                $ap->ejercicio              = $value['ejercicio'];
                $ap->id_fuente              = $value['id_fuente'];
                $ap->id_contrato            = (isset($value['id_contrato'])) ? $value['id_contrato'] : null;
                $ap->id_empresa             = $value['id_empresa'];
                $ap->id_unidad_ejecutora    = $value['id_unidad_ejecutora'];
                $ap->id_sector              = $value['id_sector'];
                $ap->observaciones          = (isset($value['observaciones'])) ? $value['observaciones'] : null;
                $ap->monto                  = str_replace(",", "", $value['monto']);
                $ap->monto_amortizacion     = (isset($value['monto_amortizacion'])) ? str_replace(",", "", $value['monto_amortizacion']) : null;
                $ap->monto_iva_amortizacion = (isset($value['monto_iva_amortizacion'])) ? str_replace(",", "", $value['monto_iva_amortizacion']) : null;
                $ap->id_ap_amortizacion     = (isset($value['id_ap_amortizacion'])) ? $value['id_ap_amortizacion'] : null;
                $ap->folio_amortizacion     = (isset($value['folio_amortizacion'])) ? $value['folio_amortizacion'] : null;
                $ap->iva                    = (isset($value['iva'])) ? str_replace(",", "", $value['iva']) : 0.00;
                $ap->icic                   = (isset($value['icic'])) ? str_replace(",", "", $value['icic']) : 0.00;
                $ap->cmic                   = (isset($value['cmic'])) ? str_replace(",", "", $value['cmic']) : 0.00;
                $ap->supervision            = (isset($value['supervision'])) ? str_replace(",", "", $value['supervision']) : 0.00;
                $ap->ispt                   = (isset($value['ispt'])) ? str_replace(",", "", $value['ispt']) : 0.00;
                $ap->otro                   = (isset($value['otro'])) ? str_replace(",", "", $value['otro']) : 0.00;
                $ap->federal_1              = (isset($value['federal_1'])) ? str_replace(",", "", $value['federal_1']) : 0.00;
                $ap->federal_2              = (isset($value['federal_2'])) ? str_replace(",", "", $value['federal_2']) : 0.00;
                $ap->federal_5              = (isset($value['federal_5'])) ? str_replace(",", "", $value['federal_5']) : 0.00;
                $ap->id_usuario             = \Auth::user()->id;
                $ap->fecha_creacion         = date('Y-m-d H:i:s');
                $ap->save();

                array_push($arrayIds, [$ap->id, $ap->clave]);

                DB::commit();
                return $arrayIds;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $ap            = array();
            $ap['message'] = $e->getMessage();
            $ap['trace']   = $e->getTrace();
            $ap['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($ap);
        }

        // }
    }

    public function genera_folio()
    {
        try {
            $ap = P_Autorizacion_Pago::whereDate('fecha_creacion', '=', date('Y-m-d'))
                ->orderBy('id', 'desc')
                ->first();

            if ($ap) {
                $folioViejo = substr($ap->clave, -3);
                $folioViejo = (int) $folioViejo + 1;
                switch (strlen($folioViejo)) {
                    case 1:$folioViejo = '00' . $folioViejo;
                        break;
                    case 2:$folioViejo = '0' . $folioViejo;
                        break;
                }
                return (date("ymd") . $folioViejo);
            } else {
                return (date("ymd") . "001");
            }

        } catch (\Exception $e) {
            DB::rollback();
            $ap            = array();
            $ap['message'] = $e->getMessage();
            $ap['trace']   = $e->getTrace();
            $ap['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($ap);
        }

    }

    public function buscar_ap_anticipo_contrato(Request $request)
    {
        $ap = P_Autorizacion_Pago::where('id_contrato', $request->id_contrato)
            ->where('id_tipo_ap', 2)
            ->first();

        if ($ap) {
            if ($ap->id_estatus == "2") {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }

    }

    public function buscar_monto_fuente(Request $request)
    {
        // dd($request->all());
        $montoTotalCapturado = 0.00;
        $ap                  = P_Autorizacion_Pago::where('id_obra', $request->id_obra)
            ->where('id_fuente', $request->id_fuente)
            ->where('id_tipo_ap', $request->id_tipo_ap)
            ->where('id', '!=', (isset($request->id_ap) ? $request->id_ap : null))
            ->get();
        foreach ($ap as $value) {
            // dd($value);
            $montoTotalCapturado += $value->monto;
        }

        return $montoTotalCapturado;
    }

    public function buscar_folios_amortizacion(Request $request)
    {
        $folios = P_Autorizacion_Pago::where('id_tipo_ap', 2)
            ->where('id_obra', $request->id_obra)
            ->where('ejercicio', $request->ejercicio)
            ->where('id_contrato', $request->id_contrato ? $request->id_contrato : null)
            ->get();

        return $folios;
    }

    public function buscar_monto_amortizacion(Request $request)
    {
        // dd($request->all());
        $montoTotalAmortizado = 0.00;
        $montoPorAmortizar = 0.00;
        $montoAnticipo = 0.00;
        $ap                   = P_Autorizacion_Pago::where('folio_amortizacion', $request->folio_amortizar)
            ->where('id', '!=', (isset($request->id_ap) ? $request->id_ap : null))
            ->where('id_obra', $request->id_obra)
            ->get();
        $ap_anticipo = P_Autorizacion_Pago::where('clave', $request->folio_amortizar)
            ->first();
        foreach ($ap as $value) {
            $montoTotalAmortizado += ($value->monto_amortizacion + $value->monto_iva_amortizacion);
        }
        $montoAnticipo = $ap_anticipo->monto;
        $montoPorAmortizar = $montoAnticipo - $montoTotalAmortizado;
        return array($montoPorAmortizar,$ap_anticipo->id_fuente);
    }
}
