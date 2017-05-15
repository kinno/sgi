<?php

namespace App\Http\Controllers\Banco;

use App\Cat_Ppi;
use App\Cat_Punto;
use App\Cat_Tipo_Evaluacion;
use App\Http\Controllers\Controller;
use App\P_Estudio_Socioeconomico;
use App\P_Evaluacion_Estudio;
use App\P_Indicadores_Rentabilidad;
use App\P_Movimiento_Banco;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verifica.notificaciones']);
    }
    

    public function index()
    {
        $tipoEvaluacion = Cat_Tipo_Evaluacion::where('bactivo', '=', 1)
            ->where('id', '>', 0)->get();
        $tipoPpi = Cat_Ppi::all();

        // dump($tipoPpi);
        return View("Banco.dictaminacion", compact('tipoEvaluacion', 'tipoPpi'));
    }

    public function obtener_tipo_evaluacion(Request $request)
    {
        $idElem                 = 0;
        $arrayIncisosSubincisos = Cat_Punto::where('id_tipo_evaluacion', '=', $request->idTipEva)
            ->where('activo', '=', '1')
            ->with('inciso.subinciso')
            ->get();

        // dd($arrayIncisosSubincisos);
        $tablaincisos = "";
        foreach ($arrayIncisosSubincisos as $punto) {
            $tablaincisos .= '<tr><td class="col-sm-12 text-center" colspan="12"><b>' . $punto->nombre_punto . '</b></td></tr>';
            foreach ($punto->inciso as $inciso) {
                $etiqueta = !empty($inciso->etiqueta) ? $inciso->etiqueta . '. ' : '';
                $tablaincisos .= '  <tr><td class="col-sm-12 text-left" colspan="12"><b>' . $etiqueta . '</b>&nbsp;' . $inciso->nombre_inciso . '</td></tr>';
                if (count($inciso->subinciso) > 0) {
                    foreach ($inciso->subinciso as $subinciso) {
                        $etiqueta = isset($subinciso->etiqueta) ? $subinciso->etiqueta : '';
                        $tablaincisos .= '<tr id="row_' . $subinciso->id . '" class="' . $idElem . '">
                                    <td colspan="3" class="col-sm-4 text-left">' . $etiqueta . '&nbsp;' . $subinciso->nombre_subinciso . '</td>
                                    <td colspan="2" class="col-sm-2">
                                    <div class="text-center">
                                       <label class="radio-inline">
                                       <input type="hidden" name="subInc_' . $idElem . '" id="subInc_' . $idElem . '" value="' . $subinciso->id . '" />
                                       <input type="radio" name="idResp_' . $idElem . '" id="idResp1_' . $idElem . '" value="1" class="radio_send" onclick="changeRadio(0, ' . $idElem . ')"/>Si
                                       </label>
                                       <label class="radio-inline">
                                       <input type="radio" name="idResp_' . $idElem . '" id="idResp2_' . $idElem . '" value="2" class="radio_send" onclick="changeRadio(1, ' . $idElem . ')"/>No
                                       </label>
                                       <label class="radio-inline">
                                       <input type="radio" name="idResp_' . $idElem . '" id="idResp3_' . $idElem . '" value="3" class="radio_send" checked="checked" onclick="changeRadio(0, ' . $idElem . ')" />NA
                                       </label>
                                    </div>
                                    </td>
                                    <td class="col-sm-2">
                                       <div>
                                           <input type="text" name="taPag_' . $idElem . '" id="taPag_' . $idElem . '" class="form-control input-sm text_send" readonly />
                                       </div>
                                    </td>
                                    <td class="col-sm-4">
                                       <div>
                                           <textarea name="taObs_' . $idElem . '" id="taObs_' . $idElem . '" class="form-control input-sm area_send" rows="1" maxlength="1000" readonly></textarea>
                                       </div>
                                    </td>
                                </tr>';
                        $idElem++;
                    }
                }
            }

        }
        return $tablaincisos;
    }

    public function buscar_estudio(Request $request)
    {
        try {

            // $estudio_socioeconomico = P_Estudio_Socioeconomico::with(['hoja1', 'hoja2', 'fuentes_monto.detalle_fuentes', 'indicadores.evaluaciones', 'movimientos'])->findOrFail($request->id_estudio_socioeconomico);
            $estudio_socioeconomico = P_Estudio_Socioeconomico::with(['hoja1.sector', 'hoja1.unidad_ejecutora', 'hoja2', 'fuentes_monto', 'movimientos'])
                ->with('indicadores.evaluaciones')
                ->with(array('indicadores' => function ($query) {
                    $query->orderBy('id', 'desc');
                }))
                ->findOrFail($request->id_estudio_socioeconomico);

            if ($estudio_socioeconomico->id_estatus == 2 || $estudio_socioeconomico->id_estatus == 3 || $estudio_socioeconomico->id_estatus == 4 || $estudio_socioeconomico->id_estatus == 6) {
                return $estudio_socioeconomico;
            } else {
                $estudio_socioeconomico          = array();
                $estudio_socioeconomico['error'] = "El Estudio Socioeconómico no ha sido enviado para dictaminación";
                return $estudio_socioeconomico;
            }

        } catch (\Exception $e) {
            $estudio_socioeconomico            = array();
            $estudio_socioeconomico['message'] = $e->getMessage();
            $estudio_socioeconomico['error']   = "No existe ese número de Estudio Socioeconomico";
            return ($estudio_socioeconomico);
        }

    }

    public function guardar_evaluacion(Request $request)
    {
        // dd($request->all());

        $estatus_estudio = \DB::table('p_estudio_socioeconomico')->where('id', $request->generales['id_estudio_socioeconomico'])->value('id_estatus');
        \DB::beginTransaction();
        try {
            //Verificamos si es sólo ingreso físico
            if (isset($request->generales['IngresoFisico'])) {
                if ($request->generales['IngresoFisico'] !== "false" && $request->generales['IngresoFisico'] !== "") {

                    // 4. Ingreso
                    $data = array('id_estudio_socioeconomico' => $request->generales['id_estudio_socioeconomico'], 'status' => '3', 'FecIng' => $request->generales['IngresoFisico'], 'observaciones' => $request->generales['observaciones']);
                    $this->actualizar_estatus($data);
                    $dataResponse['ingresoFisico'] = true;
                }
            }

            if ($request->generales['AccionSeguir'] === "1" || $request->generales['AccionSeguir'] === "2") {
                //update con el tipo de evaluacion en la tabla psolicitud
                $estudio_socioeconomico                     = P_Estudio_Socioeconomico::find($request->generales['id_estudio_socioeconomico']);
                $estudio_socioeconomico->id_tipo_evaluacion = $request->generales['id_evaluacion'];
                $estudio_socioeconomico->save();

                $idEva = 0;

                if (count($request->observaciones) > 0) {
                    $banderaNuevo = true;

                    //guarda la informacion de las observaciones, recupera el IdEva
                    if ($estatus_estudio === 4) {
                        $banderaNuevo = false;
                    }

                    $idEva = $this->genera_evaluacion($request->generales['id_estudio_socioeconomico'], $request->observaciones, $banderaNuevo);

                    //Guarda la informaicon de Indicadores de rentailidad
                    $this->guardar_indicadores_rentabilidad($request->datos, $request->generales['observaciones'], $idEva, false);
                }

                //Dependiendo el tipo de accion a seguir se guarda un status u otro
                //si es el caso 1 = Guardar el status de movBco se cambia a 4
                if ($request->generales['AccionSeguir'] === "1") {
                    // 4 REVISION DE DIRECCION
                    $data = array('id_estudio_socioeconomico' => $request->generales['id_estudio_socioeconomico'], 'status' => '4', 'observaciones' => utf8_decode($request->generales['observaciones']));
                    $this->actualizar_estatus($data);
                    $dataResponse['ingresoFisico'] = false;
                }
                //si es el caso 2 = Enviar observaciones a dependencia el status de movBco se cambia a 5
                else if ($request->generales['AccionSeguir'] === "2") {
                    // 5. ENVIO A DEPENDENCIA PARA REVISIÓN
                    $data = array('id_estudio_socioeconomico' => $request->generales['id_estudio_socioeconomico'], 'status' => '5', 'observaciones' => utf8_decode($request->generales['observaciones']));
                    $this->actualizar_estatus($data);
                    $dataResponse['ingresoFisico'] = false;
                }

                $dataResponse['observaciones']             = true;
                $dataResponse['id_estudio_socioeconomico'] = $request->generales['id_estudio_socioeconomico'];
                $dataResponse['idEva']                     = $idEva;
                $dataResponse['AccionSeguir']              = $request->generales['AccionSeguir'];
            } else if ($request->generales['AccionSeguir'] === "3") {
                // dd($request->observaciones);
                if (count($request->observaciones) > 0) {

                    $banderaNuevo = true;
                    if ($estatus_estudio === 4) {
                        //REVISION DE DIRECCION
                        $banderaNuevo = false;
                    }

                    $idEva = $this->genera_evaluacion($request->generales['id_estudio_socioeconomico'], $request->observaciones, $banderaNuevo);
                    $this->guardar_indicadores_rentabilidad($request->datos, $request->generales['observaciones'], $idEva, false);
                }

                // 6. Aceptado

                $data = array('id_estudio_socioeconomico' => $request->generales['id_estudio_socioeconomico'], 'status' => '6', 'observaciones' => utf8_decode($request->generales['observaciones']));
                $this->actualizar_estatus($data);
                $numDictamen = $this->get_max_dictamen();

                //UPDATE DEL DICTAMEN DE P_ESTUDIO_SOCIOECONOMICO
                $estudio_socioeconomico                     = P_Estudio_Socioeconomico::find($request->generales['id_estudio_socioeconomico']);
                $estudio_socioeconomico->id_tipo_evaluacion = $request->generales['id_evaluacion'];
                $estudio_socioeconomico->dictamen           = $numDictamen;
                $estudio_socioeconomico->save();

                $dataResponse['dictamen']                  = $numDictamen;
                $dataResponse['id_estudio_socioeconomico'] = $request->generales['id_estudio_socioeconomico'];
            }

            \DB::commit();
            return $dataResponse;

        } catch (\Exception $e) {
            \DB::rollback();
            $estudio_socioeconomico            = array();
            $estudio_socioeconomico['message'] = $e->getMessage() . " Linea: " . $e->getLine();
            $estudio_socioeconomico['trace']   = $e->getTrace();
            // dd($e->getTrace());
            $estudio_socioeconomico['error'] = "Hubo un error al guardar la evaluación";
            return ($estudio_socioeconomico);
        }
    }

    public function actualizar_estatus($data)
    {

        if ($data['status'] == "7") {
            $status = "cancelado";
        } else if ($data['status'] == "3" || $data['status'] == "4" || $data['status'] == "6") {
            $status = "bloqueado";
        } else {
            $status = "activo";
        }

        if ($data['status'] !== "4") {
            //DIFERENTE DE REVISIÓN DE DIRECCIÓN
            $this->genera_movimiento($data['id_estudio_socioeconomico'], $data['status'], $status);
        }

        $estudio_socioeconomico = P_Estudio_Socioeconomico::find($data['id_estudio_socioeconomico']);
        if ($data['status'] === "6" || $data['status'] === "5" || $data['status'] === "4" || $data['status'] === "3") {
            $estudio_socioeconomico->id_estatus = $data['status'];
        }
        if ($data['status'] == "3") {
            //INGRESO FISICO
            // dd(Carbon::parse($data['FecIng']));
            $estudio_socioeconomico->fecha_ingreso = Carbon::parse($data['FecIng']);

        }
        if ($data['status'] == "5") {
            //DEVOLUCION CON OBSERVACIONES, SE BORRA LA FECHA DE INGRESO FISICO
            $estudio_socioeconomico->fecha_ingreso = null;
        }

        $estudio_socioeconomico->save();

    }

    public function genera_movimiento($id_estudio_socioeconomico, $id_tipo_movimiento, $estatus)
    {

        $movimiento_banco                            = new P_Movimiento_Banco;
        $movimiento_banco->id_estudio_socioeconomico = $id_estudio_socioeconomico;
        $movimiento_banco->fecha_movimiento          = date('Y-m-d H:i:s');
        $movimiento_banco->id_tipo_movimiento        = $id_tipo_movimiento;
        $movimiento_banco->status                    = $estatus;
        $movimiento_banco->save();

    }

    public function genera_evaluacion($id_estudio_socioeconomico, $observaciones, $banderaNuevo)
    {

        if ($banderaNuevo) {

            // $id_max_eva = P_Evaluacion_Estudio::whereRaw('id_evaluacion_estudio = (select  max(\'id_evaluacion_estudio\') from p_evaluacion_estudio)')->value('id_evaluacion_estudio');
            $id_max_eva = \DB::table('p_evaluacion_estudio')->max('id_evaluacion_estudio');

            $id_max_eva++;
            // dd($id_max_eva);

            $idEva = ($id_max_eva) ? $id_max_eva : 1;
            foreach ($observaciones as $obs) {
                $p_evaluacion_estudio                        = new P_Evaluacion_Estudio;
                $p_evaluacion_estudio->id_evaluacion_estudio = $idEva;
                $p_evaluacion_estudio->id_sub_indice         = $obs['id_sub_indice'];
                $p_evaluacion_estudio->brespuesta            = $obs['brespuesta'];
                $p_evaluacion_estudio->observaciones         = $obs['observacion'];
                $p_evaluacion_estudio->pagina                = $obs['pagina'];
                $p_evaluacion_estudio->save();
            }
        } else {

            $id_max_eva = \DB::table('p_indicadores_rentabilidad')->where('id_estudio_socioeconomico', $id_estudio_socioeconomico)
                ->orderBy('id', 'desc')
                ->value('id_evaluacion');

            $id_max_eva;
            $idEva = $id_max_eva;
            // dd($idEva);
            if (!isset($idEva) || $idEva === "") {

                $id_max_eva = \DB::table('p_evaluacion_estudio')->max('id_evaluacion_estudio');
                $id_max_eva++;
                $idEva = ($id_max_eva) ? $id_max_eva : 1;
                foreach ($observaciones as $obs) {
                    $p_evaluacion_estudio                        = new P_Evaluacion_Estudio;
                    $p_evaluacion_estudio->id_evaluacion_estudio = $idEva;
                    $p_evaluacion_estudio->id_sub_indice         = $obs['id_sub_indice'];
                    $p_evaluacion_estudio->brespuesta            = $obs['brespuesta'];
                    $p_evaluacion_estudio->observaciones         = $obs['observacion'];
                    $p_evaluacion_estudio->pagina                = $obs['pagina'];
                    $p_evaluacion_estudio->save();
                }
            } else {

                foreach ($observaciones as $obs) {
                    $p_evaluacion_estudio = P_Evaluacion_Estudio::where('id_evaluacion_estudio', '=', $idEva)->where('id_sub_indice', '=', $obs['id_sub_indice'])->first();

                    $p_evaluacion_estudio->brespuesta    = $obs['brespuesta'];
                    $p_evaluacion_estudio->observaciones = $obs['observacion'];
                    $p_evaluacion_estudio->pagina        = $obs['pagina'];
                    $p_evaluacion_estudio->save();
                }
            }
        }
        return $idEva;
    }

    public function guardar_indicadores_rentabilidad($indicadores, $observaciones, $id_evaluacion, $banderaNuevo)
    {

        $p_indicadores_rentabilidad = P_Indicadores_Rentabilidad::where('id_estudio_socioeconomico', '=', $indicadores['id_estudio_socioeconomico'])->where('id_evaluacion', '=', $id_evaluacion)->first();

        if (count($p_indicadores_rentabilidad) > 0) {
            // dd($p_indicadores_rentabilidad);
            $p_indicadores_rentabilidad->id_tipo_ppi           = $indicadores['IdTipInf'];
            $p_indicadores_rentabilidad->fecha                 = date('Y-m-d H:i:s');
            $p_indicadores_rentabilidad->tasa_social_descuento = ($indicadores['tasa_social_descuento']) ? $indicadores['tasa_social_descuento'] : 0.00;
            $p_indicadores_rentabilidad->van                   = ($indicadores['van']) ? $indicadores['van'] : 0.00;
            $p_indicadores_rentabilidad->tir                   = ($indicadores['tir']) ? $indicadores['tir'] : 0.00;
            $p_indicadores_rentabilidad->tri                   = ($indicadores['tri']) ? $indicadores['tri'] : 0.00;
            $p_indicadores_rentabilidad->vacpta                = ($indicadores['vacpta']) ? $indicadores['vacpta'] : 0.00;
            $p_indicadores_rentabilidad->caepta                = ($indicadores['caepta']) ? $indicadores['caepta'] : 0.00;
            $p_indicadores_rentabilidad->vacalt                = ($indicadores['vacalt']) ? $indicadores['vacalt'] : 0.00;
            $p_indicadores_rentabilidad->caealt                = ($indicadores['caealt']) ? $indicadores['caealt'] : 0.00;
            $p_indicadores_rentabilidad->observaciones         = $observaciones;
            $p_indicadores_rentabilidad->save();
        } else {
            $p_indicadores_rentabilidad                            = new P_Indicadores_Rentabilidad;
            $p_indicadores_rentabilidad->id_estudio_socioeconomico = $indicadores['id_estudio_socioeconomico'];
            $p_indicadores_rentabilidad->id_evaluacion             = $id_evaluacion;
            $p_indicadores_rentabilidad->id_tipo_ppi               = $indicadores['IdTipInf'];
            $p_indicadores_rentabilidad->fecha                     = date('Y-m-d H:i:s');
            $p_indicadores_rentabilidad->tasa_social_descuento     = ($indicadores['tasa_social_descuento']) ? $indicadores['tasa_social_descuento'] : 0.00;
            $p_indicadores_rentabilidad->van                       = ($indicadores['van']) ? $indicadores['van'] : 0.00;
            $p_indicadores_rentabilidad->tir                       = ($indicadores['tir']) ? $indicadores['tir'] : 0.00;
            $p_indicadores_rentabilidad->tri                       = ($indicadores['tri']) ? $indicadores['tri'] : 0.00;
            $p_indicadores_rentabilidad->vacpta                    = ($indicadores['vacpta']) ? $indicadores['vacpta'] : 0.00;
            $p_indicadores_rentabilidad->caepta                    = ($indicadores['caepta']) ? $indicadores['caepta'] : 0.00;
            $p_indicadores_rentabilidad->vacalt                    = ($indicadores['vacalt']) ? $indicadores['vacalt'] : 0.00;
            $p_indicadores_rentabilidad->caealt                    = ($indicadores['caealt']) ? $indicadores['caealt'] : 0.00;
            $p_indicadores_rentabilidad->observaciones             = $observaciones;
            $p_indicadores_rentabilidad->save();
        }

    }

    public function get_max_dictamen()
    {
        $max_dictamen = \DB::table('p_estudio_socioeconomico')
            ->select(\DB::raw('left(now(),4) ejercicio, right(MAX(dictamen), 4) dictamen'))
            ->where(\DB::raw('left(dictamen, 2) = right(left(NOW(), 4),2)'))
            ->get()
            ->toArray();

        $row   = end($max_dictamen);
        $clave = substr($row->ejercicio, -2) . substr("000" . (int) ($row->dictamen + 1), -4);
        return $clave;
    }

    public function imprime_dictamen($id_estudio_socioeconomico,$dictamen)
    {
        if($id_estudio_socioeconomico!=='0'){
        $estudio = P_Estudio_Socioeconomico::with(['hoja1.sector', 'hoja1.unidad_ejecutora','hoja2', 'fuentes_monto'])
            ->with(['indicadores.evaluaciones','indicadores.tipo_ppi'])
            ->with(array('indicadores' => function ($query) {
                $query->orderBy('id', 'desc');
            }))
            ->with(array('movimientos' => function ($query) {
                $query->orderBy('id', 'desc');
            }))
            ->findOrFail($id_estudio_socioeconomico);
            // dd($estudio);
        }else{
            $estudioCollection = P_Estudio_Socioeconomico::where('dictamen','=',$dictamen)
            ->with(['hoja1.sector', 'hoja1.unidad_ejecutora','hoja2', 'fuentes_monto'])
            ->with(['indicadores.evaluaciones','indicadores.tipo_ppi'])
            ->with(array('indicadores' => function ($query) {
                $query->orderBy('id', 'desc');
            }))
            ->with(array('movimientos' => function ($query) {
                $query->orderBy('id', 'desc');
            }))->get()
            ;
            $estudio = $estudioCollection->first();
            // dd($estudio);
        }
         $puntos = Cat_Punto::where('id_tipo_evaluacion', '=', $estudio->id_tipo_evaluacion)
            ->where('activo', '=', '1')
            ->with('inciso.subinciso')
            ->get();
        $pdf = \PDF::loadView('PDF/dictamen', compact('estudio','puntos'));
        return $pdf->stream('Dictamen_' . $estudio->dictamen . '.pdf');
    }

}
