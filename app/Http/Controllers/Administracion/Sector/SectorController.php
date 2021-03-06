<?php

namespace App\Http\Controllers\Administracion\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\User;
use App\Cat_Departamento;
use App\Cat_Sector;
use Illuminate\Support\Facades\DB;


class SectorController extends Controller
{
	use Funciones;

	protected $rules = [
			'id_usuario' => 'not_in:0'
		];
	protected $messages = [
			'id_usuario.not_in'	    => 'Seleccione Tipo de Usuario',
		];
	protected $barraMenu = array(
			'botones' => array([
				'id'    => 'btnGuardar',
				'tipo'  => 'btn-success',
				'icono' => 'fa fa-save',
				'title' => 'Guardar',
				'texto' => 'Guardar'
			]));

	public function __construct()
	{
		$this->middleware(['auth','verifica.notificaciones']);
	}

	public function permisos ()
	{
		$opciones = array();
		$opciones['usuario'] = $this->opcionesUsuario($id_usuario);
		$ids = [];
		if ($id_usuario > 0)
			$ids = $this->getIdsSectores($id_usuario);
		$filas = $this->tabla($ids);
		//dd($filas);
		return view('Administracion.Sector.permisos')
			->with('opciones', $opciones)
			->with('filas', $filas)
			->with('barraMenu', $this->barraMenu);
	}

	public function dropdownUsuario (Request $request)
	{
		$ids = $this->getIdsSectores($request->id);
		$filas = $this->tabla($ids);
		return $filas;
	}

	public function guarda_permisos (Request $request)
	{
		$validator = \Validator::make($request->all(), $this->rules, $this->messages);
		if ($validator->fails()) {
			$errors = $validator->errors()->toArray();
			return array('errores' => $errors);
		}
		$data = array();
		try {
			$usuario = User::find($request->id_usuario);
			DB::transaction(function () use ($usuario, $request) {
				if (count($request->ids) == 0)
					$usuario->sectores()->detach();
				else
					$usuario->sectores()->sync($request->ids);
			});
			$data['mensaje'] = "Datos guardados correctamente: ".$usuario->name;
			$data['error'] = 1;
		}
		catch (\Exception $e) {
			$data['message'] = $e->getMessage();
			$data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
			$data['error'] = 3;
		}        
		return ($data);
	}

	public function tabla ($ids = [])
	{
		$departamentos = Cat_Departamento::get();
		if (count($departamentos) > 0) {
			$x = 1;
			$todo = true;
			$salida = '';
			foreach ($departamentos as $departamento) {
				$y = 0;
				$sectores = $departamento->sectores;
				//if ($x == 2) dd($menu);
				$padre = true;
				$opciones = '';
				foreach ($sectores as $sector) {
					$espacios = '';
					$clase = '';
					if ($sector->bactivo == 'no') {
						$clase = ' class=inactivo';
						$espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(inactivo) ';
					}
					if (in_array($sector->id, $ids))
						$checked = ' checked="checked"';
					else {
						$checked = '';
						$padre = false;
						$todo = false;
					}
					$y++;
					$opciones .= '<tr'.$clase.'>
									<td><input type="checkbox" name="Sector'.$x.'" id="chkSector" data-id="'.$sector->id.'" data-x="'.$x.'" data-y="'.$y.'"'.$checked.'></td>
									<td>'.$sector->nombre.$espacios.'</td>
								</tr>';
				}
				if (count($sectores) == 0) $padre = false;
				if ($padre)
					$checked = ' checked="checked"';
				else
					$checked = '';
				if (count($sectores) > 0) {
					$salida .= '<tr class="menu_padre">
									<td><input type="checkbox" name="Sector'.$x.'" id="chkSector" data-x="'.$x.'" data-y="0"'.$checked.'></td>
									<td>'.$departamento->nombre.'</td>
								</tr>'.$opciones;
					$x++;
				}
			}
			if ($todo)
				$checked = ' checked="checked"';
			else
				$checked = '';
			$salida = '<tr class="menu_padre">
							<td width="3%" ><input type="checkbox" name="Sector0" id="chkSector" data-x="0" data-y="0"'.$checked.'></td>
							<td width="97%">Todo</td>
						</tr>'.$salida;
		}
		else
			$salida = '<tr class="menu_padre">
						<td colspan"2">NO EXISTEN SECTORES REGISTRADOS</td>
					</tr>';
		return $salida;
	}


}
