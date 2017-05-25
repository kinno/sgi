<?php

namespace App\Http\Controllers\Catalogo\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Cat_Sector;
use App\Cat_titular;
use App\Cat_Area;
use App\Cat_Departamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class SectorController extends Controller
{
    use Funciones;

    protected $rules = [
            'id_departamento' => 'not_in:0',
            'nombre' => 'required|unique:Cat_Sector',
            'clave' => 'required|size:10',
            'unidad_responsable' => 'required',
            'titulo' => 'required',
            'titular' => 'required',
            'apellido' => 'required',
            'cargo' => 'required'
        ];
    protected $messages = [
            'id_departamento.not_in'    => 'Seleccione departamento',
            'nombre.required'           => 'Introduzca nombre del sector',
            'nombre.unique'             => 'Sector ya se encuentra registrado',
            'clave.required'            => 'Introduzca clave del sector',
            'clave.size'                => 'La clave debe contener 10 caracteres',
            'unidad_responsable.required'   => 'Introduzca nombre de la unidad responsable',
            'titulo.required'           => 'Introduzca titulo del titular',
            'titular.required'          => 'Introduzca nombre del titular',
            'apellido.required'         => 'Introduzca apellidos del titular',
            'cargo.required'            => 'Introduzca cargo del titular'
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
        $sectores = Cat_Sector::with('titular')->search($request->nombre)->orderBy('nombre', 'ASC')->paginate(10);
        //dd ($sectores);
        return view('Catalogo.Sector.index')
            ->with('sectores', $sectores)
            ->with('request', $request);
    }

    
    public function create()
    {
        /*$areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
        $opciones = $this->llena_combo($areas);
        */
        $opciones = $this->opcionesArea();
        return view('Catalogo.Sector.create')
            ->with('opciones', $opciones)
            ->with('barraMenu', $this->barraMenu);
    }


    public function store(Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
            $titular  = new Cat_Titular($request->only(['titulo', 'apellido', 'cargo']));
            $titular->nombre = $request->titular;
            $sector  = new Cat_Sector($request->only(['nombre', 'clave', 'unidad_responsable' ,'bactivo', 'id_departamento']));
            DB::transaction(function () use ($titular, $sector) {
                $titular->save();
                $sector->id_titular = $titular->id;
                $sector->save();
            });
            $data['mensaje'] = "Datos guardados correctamente: ".$sector->nombre;
            $data['error'] = 1;
        }
        catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['mensaje'] = "Error al guardar.<br/> Intente nuevamente";
            $data['error'] = 3;
        }
        return ($data);
    }


    public function edit($id, $page)
    {
        $sector = Cat_Sector::with(['titular', 'departamento.area.departamentos'])->find($id);
        if ($sector->id_titular == 0)
            $titular = new Cat_Titular(['titulo' => '', 'nombre' => '', 'apellido' => '', 'cargo' => '']);
        else
            $titular = $sector->titular;
        //dd($sector);
        $opciones = $this->opcionesArea($sector->departamento->id_area, $sector->departamento->id);
        return view('Catalogo.Sector.edit')
            ->with('sector', $sector)
            ->with('titular',$titular)
            ->with('opciones', $opciones)
            ->with('page', $page)
            ->with('barraMenu', $this->barraMenu);
    }

    
    public function update(Request $request, $id)
    {
        $ayuntamiento = false;
        if (trim(strtoupper($request->nombre)) == 'AYUNTAMIENTOS') {
            $ayuntamiento = true;
            for ($i = 0; $i < 6; $i++) {
                array_pop($this->rules);
            }
        }
        $this->rules['nombre'] =[
                'required',
                Rule::unique('Cat_Sector')->ignore($id)
            ];
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        $data['page'] = $request->page;
        try {
            $sector = Cat_Sector::find($id);
            $sector->nombre = $request->nombre;
            $sector->clave = $request->clave;
            $sector->unidad_responsable = $request->unidad_responsable;
            $sector->bactivo = $request->bactivo;
            $sector->id_departamento = $request->id_departamento;
            if ($ayuntamiento)
                $titular = new Cat_Titular;
            else {
                $titular =Cat_Titular::find($sector->id_titular);
                $titular->titulo = $request->titulo;
                $titular->nombre = $request->titular;
                $titular->apellido = $request->apellido;
                $titular->cargo = $request->cargo;
            }
            DB::transaction(function () use ($titular, $sector, $ayuntamiento) {
                if (!$ayuntamiento)
                    $titular->save();
                $sector->save();
            });
            $data['mensaje'] = "Datos guardados correctamente: ".$sector->nombre;
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
            $sector = Cat_Sector::find($id);
            $ayuntamiento = false;
            if (strtoupper($sector->nombre) == 'AYUNTAMIENTOS') {
                $ayuntamiento = true;
                $titular = new Cat_Titular;
            }
            else
                $titular =Cat_Titular::find($sector->id_titular);
            $ues = $sector->unidad_ejecutoras;
            if (count($ues) == 0) {
                DB::transaction(function () use ($titular, $sector, $ayuntamiento) {
                    if (!$ayuntamiento)
                        $titular->delete();
                    $sector->delete();
                });
                $data['mensaje'] = "Sector eliminado correctamente: ".$sector->nombre;
                $data['error'] = 1;
            }
            else {
                $data['mensaje'] = "Sector tiene asociado unidades ejecutoras.<br/>No se puede eliminar";
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
