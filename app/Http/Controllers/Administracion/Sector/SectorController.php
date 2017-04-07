<?php

namespace App\Http\Controllers\Administracion\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\User;
use App\Cat_Departamento;
use App\Cat_Sector;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;

class SectorController extends Controller
{
    use Funciones;

    public $rules = [
    		'id_usuario' => 'not_in:0'
        ];

    protected $messages = [
            'id_usuario.not_in'	    => 'Seleccione Tipo de Usuario',
        ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permisos ()
    {
    	$usuarios = User::where('bactivo', 1)->orderBy('name', 'ASC')->get()->toArray();
    	$ids =[];
    	if (count($usuarios) == 1)
    		$ids = $this->getIds($usuarios[0]['id']);
    	$opciones_usuario = $this->llena_combo($usuarios, 0, 'name');
		$filas = $this->tabla($ids);
    	//dd($filas);
    	return view('Administracion.Sector.permisos')
            ->with('opciones_usuario', $opciones_usuario)
            ->with('filas', $filas);
    }

    public function dropdownUsuario (Request $request)
    {
    	$ids = $this->getIds($request->id);
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

    public function getIds ($id)
    {
    	$usuario = User::find($id);
    	$sectores = $usuario->sectores->toArray();
    	$arreglo_ids = [];
    	foreach ($sectores as $sector)
    		array_push($arreglo_ids, $sector['id']);
    	return $arreglo_ids;
    }

    public function tabla ($ids = [])
    {
    	$departamentos = Cat_Departamento::get();
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
    			if (in_array($sector->id, $ids))
    				$checked = ' checked="checked"';
    			else {
    				$checked = '';
    				$padre = false;
    				$todo = false;
    			}
    			$y++;
    			$opciones .= '<tr>
								<td><input type="checkbox" name="Sector'.$x.'" id="chkSector" data-id="'.$sector->id.'" data-x="'.$x.'" data-y="'.$y.'"'.$checked.'></td>
								<td>'.$sector->nombre.'</td>
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
        return $salida;
    }


}
