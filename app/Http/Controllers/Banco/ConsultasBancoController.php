<?php

namespace App\Http\Controllers\Banco;

use App\Http\Controllers\Controller;
use App\P_Estudio_Socioeconomico;
use App\P_Indicadores_Rentabilidad;
use App\P_Evaluacion_Estudio;
use Yajra\Datatables\Datatables;

class ConsultasBancoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verifica.notificaciones']);
    }
    
    public function index()
    {
        // $this->getData();
        return View("Banco.consultas_banco");
    }

    public function getData()
    {

        $estudio = P_Estudio_Socioeconomico::
        	 orderBy('id','DESC')
        	->with('hoja1.unidad_ejecutora')
            ->with(array('movimientos' => function ($query) {
                $query->orderBy('id', 'desc');
                $query->take(1);

            }))
           ;
        
        return Datatables::of($estudio)
            ->addColumn('url_movimientos', function ($estudio) {
                return url('/Banco/get_datos_movimientos/' . $estudio->id);
            })
            ->editColumn('id', '{{$id}}')
            ->make(true);
    }

    public function getDetailsData($id)
    {
        $movimientos = P_Indicadores_Rentabilidad::where('id_estudio_socioeconomico', '=', $id)
        				->orderBy('fecha','desc');

        return Datatables::of($movimientos)->make(true);
    }

    public function getComentariosDetail($id_evaluacion){
    	$comentarios = P_Evaluacion_Estudio::
    	 where('id_evaluacion_estudio','=',$id_evaluacion)
    	->where('brespuesta','=',2)
    	->with('sub_inciso');
    	
    	return Datatables::of($comentarios)->make(true);
    }
}
