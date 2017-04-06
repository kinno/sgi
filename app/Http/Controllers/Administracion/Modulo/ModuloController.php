<?php

namespace App\Http\Controllers\Administracion\Modulo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\User;

class ModuloController extends Controller
{
    use Funciones;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permisos ()
    {
    	$usuarios = User::where('bactivo', 1)->orderBy('name', 'ASC')->get()->toArray();
    	$opciones_usuario = $this->llena_combo($usuarios, 0, 'name');
        
    	return view('Administracion.Modulo.permisos')
            ->with('opciones_usuario', $opciones_usuario);
    }


}
