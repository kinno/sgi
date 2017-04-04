<?php

namespace App\Http\Controllers\Administracion\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Cat_Tipo_Usuario;
use App\Cat_Sector;
use App\Cat_Unidad_Ejecutora;
use App\Cat_Area;
use App\Cat_Departamento;
use App\Rel_Usuario_Sector;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;

//use Illuminate\Database\Eloquent\Relations\Relation;

class UsuarioController extends Controller
{
    public $rules0 = [
            'id_tipo_usuario' => 'not_in:0',
            'username' => 'required|min:6|unique:users',
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    public $rules1 = [
            'id_tipo_usuario' => 'not_in:0',
            'id_unidad_ejecutora' => 'not_in:0',
            'username' => 'required|min:6|unique:users',
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    public $rules2 = [
    		'id_tipo_usuario' => 'not_in:0',
    		'id_departamento' => 'not_in:0',
            'username' => 'required|min:6|unique:users',
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users',
            'iniciales' => 'required',
            'password' => 'required|min:6|confirmed'
        ];

    protected $messages = [
            'id_tipo_usuario.not_in'	    => 'Seleccione Tipo de Usuario',
            'id_departamento.not_in'	    => 'Seleccione Departamento',
            'id_unidad_ejecutora.not_in'    => 'Seleccione Unidad Ejecutora',
            'username.required'             => 'Introduzca clave del Usuario',
            'username.min'	             	=> 'Clave debe contener por lo menos 6 caracteres',
            'username.unique'             	=> 'Clave ya se encuentra registrada',
            'name.required'  	     	    => 'Introduzca nombre del Usuario',
            'email.required' 	     	    => 'Introduzca correo electrónico',
            'email.email'	 	     	    => 'Correo electrónico no valido',
            'email.unique'	 	     	    => 'Correo electrónico ya se encuentra registrado',
            'password.required'  	        => 'Introduzca contraseña',
            'password.min'	  	     	  	=> 'Contraseña debe contener por lo menos 6 caracteres',
            'password.confirmed'     	  	=> 'Confirme contraseña',
            'iniciales.required'            => 'Introduzca iniciales del Usuario'
        ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $usuarios = User::search($request->name)->orderBy('name', 'ASC')->paginate(8);
        $usuarios->each(function($usuarios){
            $usuarios->tipo_usuario;
        });
        //dd ($usuarios);
        return view('Administracion.Usuario.index')
            ->with('usuarios', $usuarios);
    }

    public function create()
    {
        $tipo_usuarios = Cat_Tipo_Usuario::all()->toArray();
        $opciones_tipo_usuario = $this->llena_combo($tipo_usuarios);

        $sectores = Cat_Sector::where('bactivo', 1)->orderBy('nombre', 'ASC')->get()->toArray();
        //dd($sectores);
        $opciones_sector = $this->llena_combo($sectores);
        $areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
        //dd($areas);
        $opciones_area = $this->llena_combo($areas);
        //dd($opciones);
        return view('Administracion.Usuario.create')
        	->with('opciones_tipo_usuario', $opciones_tipo_usuario)
        	->with('opciones_sector', $opciones_sector)
            ->with('opciones_area', $opciones_area);
    }

    public function store(Request $request)
    {
        $externo = false;
        if ($request->id_tipo_usuario == 0)
        	$rules = $this->rules0;
        else if ($request->id_tipo_usuario == 1) {
        	$externo = true;
        	$rules = $this->rules1;
        }
        else
        	$rules = $this->rules2;
        $validator = \Validator::make($request->all(), $rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            $usuario  = new User($request->only(['id_tipo_usuario', 'id_unidad_ejecutora', 'id_departamento', 'username',  	'name', 'email', 'password', 'iniciales', 'bactivo']));
            $usuario_sector = new Rel_Usuario_Sector($request->only(['id_sector']));
            DB::transaction(function () use ($usuario, $usuario_sector, $externo) {
                $usuario->save();
                if ($externo) {
                	$usuario_sector->id_usuario = $usuario->id;
                	$usuario_sector->save();
                }
            });
            $data['mensaje'] = "Datos guardados correctamente: ".$usuario->name;
            $data['error'] = 1;
            //$data['usuario'] = $usuario->toArray();
            //$data['request'] = $request->toArray();
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        $tipo_usuarios = Cat_Tipo_Usuario::all()->toArray();
        $opciones_tipo_usuario = $this->llena_combo($tipo_usuarios, $usuario->id_tipo_usuario);
        $sectores = Cat_Sector::where('bactivo', 1)->orderBy('nombre', 'ASC')->get()->toArray();
        if ($usuario->id_unidad_ejecutora > 0) {
	        $ejecutora = Cat_Unidad_Ejecutora::find($usuario->id_unidad_ejecutora);
	        $opciones_sector = $this->llena_combo($sectores, $ejecutora->id_sector);
	        $sector = $ejecutora->sector;
	        $ejecutoras = $sector->unidad_ejecutoras->toArray();
	        $opciones_unidad_ejecutora = $this->llena_combo($ejecutoras, $usuario->id_unidad_ejecutora);
        }
	    else {
	    	$opciones_sector = $this->llena_combo($sectores);
	    	$opciones_unidad_ejecutora = $this->llena_combo(array());
	    }
	    $areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
	    if ($usuario->id_departamento > 0) {
	        $departamento = Cat_Departamento::find($usuario->id_departamento);
	        $opciones_area = $this->llena_combo($areas, $departamento->id_area);
	        $area = $departamento->area;
	        $departamentos = $area->departamentos->toArray();
	        $opciones_departamento = $this->llena_combo($departamentos, $usuario->id_departamento);
	    }
	    else {
	    	$opciones_area = $this->llena_combo($areas);
	    	$opciones_departamento = $this->llena_combo(array());
	    }
        //dd($opciones_departamento);
        //dd($areas);
        return view('Administracion.Usuario.edit')
            ->with('usuario', $usuario)
            ->with('opciones_tipo_usuario', $opciones_tipo_usuario)
        	->with('opciones_sector', $opciones_sector)
            ->with('opciones_unidad_ejecutora', $opciones_unidad_ejecutora)
            ->with('opciones_area', $opciones_area)
            ->with('opciones_departamento', $opciones_departamento);
    }

    public function update(Request $request, $id)
    {
        $externo = false;
        if ($request->id_tipo_usuario == 0)
        	$rules = $this->rules0;
        else if ($request->id_tipo_usuario == 1) {
        	$externo = true;
        	$rules = $this->rules1;
        }
        else
        	$rules = $this->rules2;
        array_pop($rules);
        $rules['username'] = [
                'required',
                'min:6',
                Rule::unique('users')->ignore($id)
            ];
        $rules['email'] = [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($id)
            ];
        $validator = \Validator::make($request->all(), $rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        //return $data;
        try {
            $usuario = User::find($id);
            $anterior = $usuario->id_tipo_usuario;
            $usuario->id_tipo_usuario = $request->id_tipo_usuario;
            $usuario->id_unidad_ejecutora = $request->id_unidad_ejecutora;
            $usuario->id_departamento = $request->id_departamento;
            $usuario->username = $request->username;
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->iniciales = $request->iniciales;
            $usuario->bactivo = $request->bactivo;
            $id_sector = $request->id_sector;
            DB::transaction(function () use ($usuario, $externo, $anterior, $id_sector) {
                if ($anterior == 1 && $externo) {
	            	$usuario->sectores()->sync([$id_sector]);
                    // falta mejorar
	            }
	            else if ($anterior == 1 && !$externo) {
		        	$usuario->sectores()->detach();
	            }
	            else if ($anterior == 2 && $externo)
	            	$usuario->sectores()->sync([$id_sector]);
                $usuario->save();
            });

            $data['mensaje'] = "Datos guardados correctamente: ".$usuario->nombre;
            $data['error'] = 1;
            $data['request'] = $request->toArray();
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        
        return ($data);
        //return redirect()->route('Sector.index');
    }

    public function destroy($id)
    {
        $data = array();
        try {
            $usuario = User::find($id);
            $externo = false;
            if ($usuario->id_tipo_usuario == 1)
                $externo = true;
            // agregar validación con obras
            if ((count($usuario->sectores) <= 1 && $externo) || (count($usuario->sectores) == 0 && !$externo)) {
                DB::transaction(function () use ($usuario, $externo) {
                    if ($externo)
                        $usuario->sectores()->detach();
                    $usuario->delete();
                });
                $data['mensaje'] = "Usuario eliminado correctamente: ".$usuario->nombre;
                $data['error'] = 1;
            }
            else {
                $data['mensaje'] = "Usuario tiene asociado sectores.<br/>No se puede eliminar";
                $data['error'] = 2;
            }

        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al eliminar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }


    public function dropdown (Request $request)
    {
        //return array('uno' => 'si');
        $sector = Cat_Sector::find($request->id);
        $ejecutoras = $sector->unidad_ejecutoras->toArray();
        $opciones = $this->llena_combo($ejecutoras);
        return $opciones;
    }

    public function llena_combo ($arreglo, $valor = 0, $name = 'nombre', $id = 'id')
    {
        $n = count($arreglo);
        $vacio = '<option value="0" selected="selected">- Selecciona</option>';
        $vacio1 = '<option value="0">- Selecciona</option>';
        $i = 0;
        $salida = "";
        $opciones = "";
        foreach ($arreglo as $key => $rows) {
            if ($valor == $rows[$id])
                $opciones .= '<option value="'.$rows[$id].'" selected="selected">'.$rows[$name].'</option>';
            else
                $opciones .= '<option value="'.$rows[$id].'">'.$rows[$name].'</option>';
            if ($i == 0)
                $tmp = '<option value="'.$rows[$id].'" selected="selected">'.$rows[$name].'</option>';
        }
        if ($n == 0)
            $salida = $vacio;
        else if ($n == 1)
            $salida = $tmp;
        else
            $salida = $vacio1.$opciones;
        return $salida;
    }
}
