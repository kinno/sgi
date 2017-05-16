<?php

namespace App\Http\Controllers\Oficios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cat_Ejercicio;
use App\Cat_Solicitud_Presupuesto;
use App\Cat_Fuente;
use App\Cat_Texto_Oficio;
use DB;

class TextoOficiosController extends Controller
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
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Limpiar pantalla',
            ],[
                'id'    => 'guardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
            ]));

        
        $ejercicios        = Cat_Ejercicio::orderBy('Ejercicio', 'DESC')->get();
        $tipoSolicitud     = Cat_Solicitud_Presupuesto::all();
        $fuentes = Cat_Fuente::where('tipo','=','F')
        	->orWhere('tipo','=','E')
        	->get();
        return view('Oficios.textos_index',compact('tipoSolicitud','ejercicios','fuentes','barraMenu'));
    }

    public function guardar_texto(Request $request){
        $validator = \Validator::make($request->all(), [
            'id_solicitud_presupuesto'           => 'required',
            'ejercicio'  => 'required',
            'id_fuente'  => 'required',
            'asunto'  => 'required',
            'prefijo'  => 'required',
            'texto'  => 'required',
            
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('error_validacion' => $errors);

        }

        try {
            DB::transaction(function () use ($request) {
                if($request->id){
                    $texto = Cat_Texto_Oficio::find($request->id);
                }else{
                    $texto = new Cat_Texto_Oficio();
                }
                
                $texto->id_solicitud_presupuesto = $request->id_solicitud_presupuesto;
                $texto->ejercicio = $request->ejercicio;
                $texto->id_fuente = $request->id_fuente;
                $texto->asunto = $request->asunto;
                $texto->prefijo = $request->prefijo;
                $texto->texto = $request->texto;
                $texto->save();
            });
        } catch (Exception $e) {
            $expediente            = array();
            $expediente['message'] = $e->getMessage();
            $expediente['trace']   = $e->getTrace();
            $expediente['error']   = "Aviso: Ocurrió un error al guardar.";
            return ($expediente);
        }
    }

    public function buscar_texto(Request $request){
        $texto = Cat_Texto_Oficio::where('id_solicitud_presupuesto','=',$request->id_solicitud_presupuesto)
            ->where('ejercicio','=',$request->ejercicio)
            ->where('id_fuente','=',$request->id_fuente)
            ->first();
         return $texto;   
    }
}
