<?php

namespace App\Http\Controllers\Administracion\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
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

class UsuarioController extends Controller
{
    use Funciones;

    protected $rules0 = [
            'id_tipo_usuario' => 'not_in:0',
            'username' => 'required|min:6|unique:users',
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    protected $rules1 = [
            'id_tipo_usuario' => 'not_in:0',
            'id_unidad_ejecutora' => 'not_in:0',
            'username' => 'required|min:6|unique:users',
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    protected $rules2 = [
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
            'username.min'	             	=> 'Usuario debe contener por lo menos 6 caracteres',
            'username.unique'             	=> 'Usuario ya se encuentra registrado',
            'name.required'  	     	    => 'Introduzca nombre del Usuario',
            'email.required' 	     	    => 'Introduzca correo electrónico',
            'email.email'	 	     	    => 'Correo electrónico no valido',
            'email.unique'	 	     	    => 'Correo electrónico ya se encuentra registrado',
            'password.required'  	        => 'Introduzca contraseña',
            'password.min'	  	     	  	=> 'Contraseña debe contener por lo menos 6 caracteres',
            'password.confirmed'     	  	=> 'Confirme contraseña',
            'iniciales.required'            => 'Introduzca iniciales del Usuario'
        ];
    protected $barraMenu = array(
            'botones' => array([
                'id'    => 'btnGuardar',
                'tipo'  => 'btn-success',
                'icono' => 'fa fa-save',
                'title' => 'Guardar',
                'texto' => 'Guardar'
            ], [
                'id'    => 'btnRegresar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-arrow-left',
                'title' => 'Regresar',
                'texto' => 'Regresar'
            ] ));

    public function __construct()
    {
        $this->middleware(['auth','verifica.notificaciones']);
    }

    public function index(Request $request)
    {
        $usuarios = User::with('tipo_usuario')->search($request->name)->orderBy('name', 'ASC')->paginate(8);
        return view('Administracion.Usuario.index')
            ->with('usuarios', $usuarios);
    }


    public function create()
    {
        $opciones = [];
        $opciones['tipo_usuario'] = $this->opcionesTipoUsuario();
        $opciones += $this->opcionesSector();
        $opciones += $this->opcionesArea();
        return view('Administracion.Usuario.create')
        	->with('opciones', $opciones)
            ->with('barraMenu', $this->barraMenu);
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
        $opciones = [];
        $usuario = User::with(['unidad_ejecutora', 'departamento'])->find($id);
        $opciones['tipo_usuario'] = $this->opcionesTipoUsuario($usuario->id_tipo_usuario);
        if ($usuario->id_unidad_ejecutora > 0)
            $opciones += $this->opcionesSector($usuario->unidad_ejecutora->id_sector, $usuario->id_unidad_ejecutora);
        else
            $opciones += $this->opcionesSector();
        if ($usuario->id_departamento > 0)
            $opciones += $this->opcionesArea($usuario->departamento->id_area, $usuario->id_departamento);
        else
            $opciones += $this->opcionesArea();
        //dd($opciones);
        return view('Administracion.Usuario.edit')
            ->with('usuario', $usuario)
            /*->with('opciones_tipo_usuario', $opciones_tipo_usuario)
        	->with('opciones_sector', $opciones_sector[0])
            ->with('opciones_unidad_ejecutora', $opciones_sector[1])*/
            ->with('opciones', $opciones)
            //->with('opciones_departamento', $opciones_area[1])
            ->with('barraMenu', $this->barraMenu);
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
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
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
}
