<?php

namespace App\Http\Controllers\Banco;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Cat_Tipo_Evaluacion;
use App\Cat_Ppi;
use App\Cat_Punto;
use App\Cat_Inciso;
use App\Cat_Subinciso;
use Illuminate\Support\Facades\DB;

class BancoController extends Controller
{
   public function index(){
   		$tipoEvaluacion = Cat_Tipo_Evaluacion::where('bactivo','=',1)
   		->where('id','>',0)->get();
   		$tipoPpi = Cat_Ppi::all();

   		// dump($tipoPpi);
       return View("Banco.index",compact('tipoEvaluacion','tipoPpi'));
   }

   public function obtener_tipo_evaluacion(Request $request){
   		$idElem=0;
		$arrayIncisosSubincisos=  Cat_Punto::where('id_tipo_evaluacion','=',$request->idTipEva)
				   		->where('activo','=','1')
				   		->with('inciso.subinciso')
				   		->get();		   		
   		
   		// dd($arrayIncisosSubincisos);
   		$tablaincisos="";
   		foreach ($arrayIncisosSubincisos as $punto) {
   			$tablaincisos .= '<tr><td class="col-sm-12 text-center" colspan="12"><b>' . $punto->nombre_punto . '</b></td></tr>';
   			foreach ($punto->inciso as $inciso) {
   				$etiqueta = !empty($inciso->etiqueta) ? $inciso->etiqueta. '. ' : '';
   				$tablaincisos .= '  <tr><td class="col-sm-12 text-left" colspan="12"><b>' . $etiqueta . '</b>&nbsp;' . $inciso->nombre_inciso . '</td></tr>';
   				if(count($inciso->subinciso)>0){
   					foreach ($inciso->subinciso as $subinciso) {
   						$etiqueta = isset($subinciso->etiqueta) ? $subinciso->etiqueta : '';
   						$tablaincisos.= '<tr id="row_' . $subinciso->id . '" class="' . $idElem . '">
                                    <td colspan="3" class="col-sm-4 text-left">' . $etiqueta . '&nbsp;' . $subinciso->nombre_subinciso. '</td>
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
}
