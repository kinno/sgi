<?php

namespace App\Http\Controllers\Administracion\Modulo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\User;
use App\P_Menu;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;

class ModuloController extends Controller
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
			$ids = $this->getIds($id_usuario);
		$filas = $this->tabla($ids);
		//dd($filas);
		return view('Administracion.Modulo.permisos')
			->with('opciones', $opciones)
			->with('filas', $filas)
			->with('barraMenu', $this->barraMenu);
	}

	public function dropdownUsuario (Request $request)
	{
		$ids = $this->getIds($request->id);
		$filas = $this->tabla($ids);
		return $filas;
	}

	public function guarda_permisos (Request $request)
	{
		// return ($request->all());
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
					$usuario->menus()->detach();
				else
					$usuario->menus()->sync($request->ids);
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

	public function getIds ($id)
	{
		$usuario = User::find($id);
		$menus = $usuario->menus;
		$arreglo_ids = [];
		foreach ($menus as $menu)
			$arreglo_ids[] =  $menu->id;
		return $arreglo_ids;
	}

	public function tabla ($ids = [])
	{
		$menus = P_Menu::where('id_menu_padre', 0)->orderBy('orden', 'ASC')->get();
		// dd($menus);
		if (count($menus) > 0) {
			$x = 1;
			$todo = true;
			$salida = '';
			foreach ($menus as $menu) {
				$y = 0;
				$submenus = $menu->submenus;
				//if ($x == 2) dd($menu);
				$padre = true;
				$opciones = '';
				foreach ($submenus as $submenu) {
					if (in_array($submenu->id, $ids))
						$checked = ' checked="checked"';
					else {
						$checked = '';
						$padre = false;
						$todo = false;
					}
					$y++;
					$opciones .= '<tr>
									<td><input type="checkbox" name="Menu'.$x.'" id="chkMenu" data-id="'.$submenu->id.'" data-x="'.$x.'" data-y="'.$y.'"'.$checked.'></td>
									<td>'.$submenu->nombre.'</td>
								</tr>';
				}
				if ($padre)
					$checked = ' checked="checked"';
				else
					$checked = '';
				$salida .= '<tr class="menu_padre">
								<td><input type="checkbox" name="Menu'.$x.'" id="chkMenu" data-x="'.$x.'" data-y="0"'.$checked.'></td>
								<td>'.$menu->nombre.'</td>
							</tr>'.$opciones;
				$x++;
			}
			if ($todo)
				$checked = ' checked="checked"';
			else
				$checked = '';
			$salida = '<tr class="menu_padre">
							<td width="3%" ><input type="checkbox" name="Menu0" id="chkMenu" data-x="0" data-y="0"'.$checked.'></td>
							<td width="97%">Todo</td>
						</tr>'.$salida;
		}
		else
			$salida = '<tr class="menu_padre">
						<td colspan"2">NO EXISTEN MENUS REGISTRADOS</td>
					</tr>';
		return $salida;
	}


}
