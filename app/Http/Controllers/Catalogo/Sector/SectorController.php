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

    public $rules = [
            'id_departamento' => 'not_in:0',
            'nombre' => 'required|unique:Cat_Sector',
            'titulo' => 'required',
            'titular' => 'required',
            'apellido' => 'required',
            'cargo' => 'required'
        ];
    protected $messages = [
            'id_departamento.not_in'    => 'Seleccione departamento',
            'nombre.required'           => 'Introduzca nombre del sector',
            'nombre.unique'             => 'Sector ya se encuentra registrado',
            'titulo.required'           => 'Introduzca titulo del titular',
            'titular.required'          => 'Introduzca nombre del titular',
            'apellido.required'         => 'Introduzca apellidos del titular',
            'cargo.required'            => 'Introduzca cargo del titular'
        ];

    public function __construct()
    {
        $this->middleware(['auth','verifica.notificaciones']);
    }


    public function index(Request $request)
    {
        $sectores = Cat_Sector::search($request->nombre)->orderBy('nombre', 'ASC')->paginate(8);
        $sectores->each(function($sectores){
            $sectores->titular;
        });
        //dd ($sectores);
        return view('Catalogo.Sector.index')
            ->with('sectores', $sectores);
    }

    
    public function create()
    {
        $areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
        //dd($areas);
        $opciones = $this->llena_combo($areas);
        //dd($opciones);
        return view('Catalogo.Sector.create')
            ->with('opciones_area', $opciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }

        $data = array();
        try {
            $titular  = new Cat_Titular($request->only(['titulo', 'apellido', 'cargo']));
            $titular->nombre = $request->titular;
            $sector  = new Cat_Sector($request->only(['nombre', 'bactivo', 'id_departamento']));
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
        //return redirect()->route('Sector.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $areas = Cat_Area::join('Cat_Departamento', 'Cat_Area.id', '=', 'Cat_Departamento.id_area')->select('Cat_Area.*')->distinct()->get()->toArray();
        //dd($areas);
        $sector = Cat_Sector::find($id);
        if (strtoupper($sector->nombre) == 'AYUNTAMIENTOS')
            $titular = new Cat_Titular(['titulo' => '', 'nombre' => '', 'apellido' => '', 'cargo' => '']);
        else
            $titular =Cat_Titular::find($sector->id_titular);
        $area = $sector->departamento->area;
        $opciones_area = $this->llena_combo($areas, $area->id);
        $departamentos = $area->departamentos->toArray();
        $opciones_departamento = $this->llena_combo($departamentos, $sector->id_departamento);
        //dd($titular);
        return view('Catalogo.Sector.edit')
            ->with('sector', $sector)
            ->with('titular',$titular)
            ->with('opciones_area', $opciones_area)
            ->with('opciones_departamento', $opciones_departamento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ayuntamiento = false;
        if (trim(strtoupper($request->nombre)) == 'AYUNTAMIENTOS') {
            $ayuntamiento = true;
            for ($i = 0; $i < 4; $i++) {
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
        try {
            $sector = Cat_Sector::find($id);
            $sector->nombre = $request->nombre;
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
        //return redirect()->route('Sector.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
