<?php

namespace App\Http\Controllers\Oficios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cat_Ejercicio;
use App\Cat_Solicitud_Presupuesto;
use App\Cat_Fuente;
use DB;

class TextoOficiosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verifica.notificaciones']);
    }

    public function index()
    {
        // $this->dispatch(new VerificarNotificaciones());
        // $user              = \Auth::user()->load('unidad_ejecutora')->load('sectores');
        $ejercicios        = Cat_Ejercicio::orderBy('Ejercicio', 'DESC')->get();
        $tipoSolicitud     = Cat_Solicitud_Presupuesto::all();
        // $fuentes = DB::table('cat_fuente')->whereRaw("tipo like ");
        $fuentes = Cat_Fuente::where('tipo','=','F')
        	->orWhere('tipo','=','E')
        	->get();
        // $accionesFederales = Cat_Acuerdo::where('id_tipo_acuerdo', '=', 4)->get();
        // $accionesEstatales = Cat_Acuerdo::where('id_tipo_acuerdo', '=', 1)
        //     ->orWhere('id_tipo_acuerdo', '=', 2)
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
        return view('Oficios.textos_index',compact('tipoSolicitud','ejercicios','fuentes'));
    }
}
