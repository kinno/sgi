<?php

namespace App\Http\Controllers\Catalogo\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\P_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    use Funciones;

    protected $rules = [
            'nombre'    => 'required',
            'orden'     => 'required|numeric|min:1',
            'ruta'      => 'required'
        ];
    protected $messages = [
            'nombre.required'           => 'Introduzca nombre del Menú',
            'orden.required'            => 'Introduzca orden del Menu',
            'orden.min'                 => 'Introduzca orden del Menu',
            'ruta.required'             => 'Introduzca ruta del Menú'
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
    protected $barraMenu2 = array(
            'botones' => array([
                'id'    => 'btnLimpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Actualizar pantalla',
                'texto' => 'Actualizar'
            ] ));

    public function __construct()
    {
        $this->middleware(['auth','verifica.notificaciones']);
    }


    public function index(Request $request)
    {
        $menus = P_Menu::leftjoin('p_menu As t2', 'p_menu.id_menu_padre', '=', 't2.id')->select('P_Menu.*')->search($request)->orderBy(DB::raw('(CASE p_menu.id_menu_padre WHEN 0 THEN p_menu.orden * 10 ELSE t2.orden * 10 + p_menu.orden END)'), 'ASC')->paginate(8);
        //$menus_padre = P_Menu::where('id_menu_padre', 0)->orderBy('orden', 'ASC')->get()->toArray();
        //$opciones = $this->llena_combo($menus_padre, $request->id_menu_padre);
        $opciones = $this->opcionesMenu($request->id_menu_padre);
        //dd ($menus);
        return view('Catalogo.Menu.index')
            ->with('menus', $menus)
            ->with('opciones_menu', $opciones)
            ->with('request', $request)
            ->with('barraMenu', $this->barraMenu2);;
    }

    
    public function create()
    {
        //$menus = P_Menu::where('id_menu_padre', 0)->orderBy('orden', 'ASC')->get()->toArray();
        //$opciones = $this->llena_combo($menus);
        $opciones = $this->opcionesMenu();
        //dd($opciones);
        return view('Catalogo.Menu.create')
            ->with('opciones_menu', $opciones)
            ->with('barraMenu', $this->barraMenu);
    }

    
    public function store(Request $request)
    {
        //return ($request->all());
        if ($request->id_menu_padre == 0) {
            array_pop($this->rules);
            $blink = 0;
            $ruta = '';
        }
        else {
            $blink = 1;
            $ruta = $request->ruta;
        }
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }

        $data = array();
        try {
            $menu  = new P_Menu($request->only(['id_menu_padre', 'nombre', 'descripcion', 'orden']));
            $menu->blink = $blink;
            $menu->ruta = $ruta;
            $menu->save();
            $data['mensaje'] = "Datos guardados correctamente: ".$menu->nombre;
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
        //dd($menus);
        $menu = P_Menu::find($id);
        //$menus = P_Menu::where('id_menu_padre', 0)->where('id', '<>', $id)->orderBy('nombre', 'ASC')->get()->toArray();
        //$opciones = $this->llena_combo($menus, $menu->id_menu_padre);
        $opciones = $this->opcionesMenu($menu->id_menu_padre);
        $tiene_sub = 0;
        if ($menu->id_menu_padre == 0) {
            $otro = P_Menu::where('id_menu_padre', $menu->id)->first();
            if (count($otro) > 0)
                $tiene_sub = 1;
        }
        return view('Catalogo.Menu.edit')
            ->with('menu', $menu)
            ->with('opciones_menu', $opciones)
            ->with('tiene_sub', $tiene_sub)
            ->with('barraMenu', $this->barraMenu);
    }

    
    public function update(Request $request, $id)
    {
        if (isset($request->id_menu_padre))
            $id_menu_padre = $request->id_menu_padre;
        else
            $id_menu_padre = 0;
        if ($id_menu_padre == 0) {
            array_pop($this->rules);
            $blink = 0;
            $ruta = '';
        }
        else {
            $blink = 1;
            $ruta = $request->ruta;
        }
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            $menu = P_Menu::find($id);
            $menu->id_menu_padre = $id_menu_padre;
            $menu->nombre = $request->nombre;
            $menu->descripcion = $request->descripcion;
            $menu->orden = $request->orden;
            $menu->blink = $blink;
            $menu->ruta = $ruta;
            $menu->save();
            $data['mensaje'] = "Datos guardados correctamente: ".$menu->nombre;
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
            $menu = P_Menu::find($id);
            $submenus = $menu->submenus;
            if (count($submenus) == 0) {
                $usuarios = $menu->usuarios;
                $n = count($usuarios); 
                if ($n == 0) {
                    $menu->delete();
                    $data['mensaje'] = "Menu eliminado correctamente: ".$menu->nombre;
                    $data['error'] = 1;
                }
                else {
                    $data['mensaje'] = "Menu tiene asociado usuarios.<br/>No se puede eliminar";
                    $data['error'] = 2;
                }
            }
            else {
                $data['mensaje'] = "Menu tiene asociado submenues.<br/>No se puede eliminar";
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
