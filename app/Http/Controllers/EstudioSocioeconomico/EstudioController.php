<?php

namespace App\Http\Controllers\EstudioSocioeconomico;

use App\Cat_Cobertura;
use App\Cat_Tipo_Localidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cat_Ejercicio;
use App\Cat_Acuerdo;
use App\Cat_Grupo_Social;
use App\Cat_Meta;
use App\Cat_Beneficiario;
use App\Cat_Fuente;


class EstudioController extends Controller
{
    public function index()
    {
        $ejercicios = Cat_Ejercicio::orderBy('Ejercicio','DESC')->get();
        $accionesFederales = Cat_Acuerdo::where('id_tipo_acuerdo','=',4)->get();
        $accionesEstatales = Cat_Acuerdo::where('id_tipo_acuerdo','=',1)
            ->orWhere('id_tipo_acuerdo','=',2)
            ->get();
        $grupoSocial = Cat_Grupo_Social::All();
        $coberturas = Cat_Cobertura::where('id','>',0)->get();
        $localidades = Cat_Tipo_Localidad::where('id','>',0)->get();
        $metas = Cat_Meta::where('id','>',0)->get();
        $beneficiarios = Cat_Beneficiario::where('id','>',0)->get();
        $fuentesFederal = Cat_Fuente::where('tipo','=','F')->get();
        $fuentesEstatal = Cat_Fuente::where('tipo','=','E')->get();

       // dump($beneficiarios);
        return view('EstudioSocioeconomico.index',compact('ejercicios','accionesFederales','accionesEstatales','grupoSocial','coberturas','localidades','metas','beneficiarios','fuentesFederal','fuentesEstatal'));
    }
}
