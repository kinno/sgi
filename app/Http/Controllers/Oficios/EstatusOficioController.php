<?php

namespace App\Http\Controllers\Oficios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;

class EstatusOficioController extends Controller
{
    use Funciones;

    protected $barraMenu = array(
    		'input' => array('id' => 'clave_oficio_search', 'class' => 'text-right num', 'title' => 'Oficio:'),
			'botones' => array([
				'id'    => 'btnBuscar',
				'tipo'  => 'btn-default',
				'icono' => 'fa fa-search',
				'title' => 'Buscar'
				//'texto' => 'Guardar'
			], [
				'id'    => 'btnGuardar',
				'tipo'  => 'btn-success',
				'icono' => 'fa fa-save',
				'title' => 'Guardar',
				'texto' => 'Guardar'
			], [
				'id'    => 'btnLimpiar',
				'tipo'  => 'btn-warning',
				'icono' => 'fa fa-eraser',
				'title' => 'Limpiar pantalla',
				'texto' => 'Limpiar'
			] ));
    public function __construct()
	{
		$this->middleware(['auth','verifica.notificaciones']);
	}

    public function index(Request $request)
	{   
		$opciones = array ();
		//$ids_Sector = $this->getIdsSectores();
		$opciones['estatus_oficio'] = $this->opcionesEstadoOficio();
		return view('Oficios.firma_index')
			->with('opciones', $opciones)
			->with('barraMenu', $this->barraMenu);
	}
}
