<?php

namespace App\Http\Controllers\Catalogo\Ejecutora;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Cat_Sector;
use App\Cat_Unidad_Ejecutora;
use App\Cat_titular;
use Illuminate\Support\Facades\DB;

class EjecutoraController extends Controller
{
    use Funciones;

    protected $rules = [
            'id_sector' => 'not_in:0',
            'clave' => 'required|size:10',
            'nombre' => 'required'
        ];
    protected $rules_ayuntamiento = [
            'id_sector' => 'not_in:0',
            'nombre' => 'required',
            'titulo' => 'required',
            'titular' => 'required',
            'apellido' => 'required',
            'cargo' => 'required'
        ];
    protected $messages = [
            'id_sector.not_in'		    => 'Seleccione sector',
            'clave.required'	        => 'Introduzca clave de la Ejecutora',
            'clave.size'	        	=> 'La clave debe contener 10 caracteres',
            'nombre.required'           => 'Introduzca nombre de la Ejecutora',
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
    protected $barraMenu2 = array(
            'botones' => array([
                'id'    => 'btnLimpiar',
                'tipo'  => 'btn-warning',
                'icono' => 'fa fa-refresh',
                'title' => 'Actualizar pantalla',
                'texto' => 'Actualizar'
            ] ));
    
    public function index(Request $request)
    {
        $ejecutoras = Cat_Unidad_Ejecutora::with(['titular', 'sector'])->search($request)->orderBy('nombre', 'ASC')->paginate(8);
        $sectores = Cat_Sector::where('bactivo', 1)->orderBy('nombre', 'ASC')->get()->toArray();
        $opciones = $this->llena_combo($sectores, $request->id_sector);
        //dd ($ejecutoras);
        return view('Catalogo.Ejecutora.index')
            ->with('ejecutoras', $ejecutoras)
            ->with('opciones_sector', $opciones)
            ->with('request', $request)
            ->with('barraMenu', $this->barraMenu2);
    }

    public function create()
    {
        $sectores = Cat_Sector::where('bactivo', 1)->orderBy('nombre', 'ASC')->get()->toArray();
        //dd($sectores);
        $opciones = $this->llena_combo($sectores);
        return view('Catalogo.Ejecutora.create')
            ->with('opciones_sector', $opciones)
            ->with('barraMenu', $this->barraMenu);
    }

    public function store(Request $request)
    {
        if ($request->id_sector == 4) {
        	$ayuntamiento = true;
        	$validator = \Validator::make($request->all(), $this->rules_ayuntamiento, $this->messages);
        }
        else {
        	$ayuntamiento = false;
        	$validator = \Validator::make($request->all(), $this->rules, $this->messages);
        }
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        try {
        	$ejecutora  = new Cat_Unidad_Ejecutora($request->only(['clave', 'nombre', 'bactivo', 'id_sector']));
        	$titular  = new Cat_Titular($request->only(['titulo', 'apellido', 'cargo']));
        	$titular->nombre = $request->titular;
            if (!$ayuntamiento)
        		$ejecutora->id_titular = 0;
            DB::transaction(function () use ($titular, $ejecutora, $ayuntamiento) {
                if ($ayuntamiento) {
	                $titular->save();
	                $ejecutora->id_titular = $titular->id;
            	}
                $ejecutora->save();
            });
            $data['mensaje'] = "Datos guardados correctamente: ".$ejecutora->nombre;
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
        $ejecutora = Cat_Unidad_Ejecutora::with('titular')->find($id);
        $sectores = Cat_Sector::where('bactivo', 1)->orderBy('nombre', 'ASC')->get()->toArray();
        $opciones = $this->llena_combo($sectores, $ejecutora->id_sector);
        //dd($ejecutora);
        // ayuntamientos
        if ($ejecutora->id_sector == 4)
            $titular = $ejecutora->titular;
        else
        	$titular = new Cat_Titular(['titulo' => '', 'nombre' => '', 'apellido' => '', 'cargo' => '']);
        return view('Catalogo.Ejecutora.edit')
            ->with('ejecutora', $ejecutora)
            ->with('titular', $titular)
            ->with('opciones_sector', $opciones)
            ->with('page', $page)
            ->with('barraMenu', $this->barraMenu);
    }

    public function update(Request $request, $id)
    {
         if ($request->id_sector == 4) {
        	$ayuntamiento = true;
        	$validator = \Validator::make($request->all(), $this->rules_ayuntamiento, $this->messages);
        }
        else {
        	$ayuntamiento = false;
        	$validator = \Validator::make($request->all(), $this->rules, $this->messages);
        }
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return array('errores' => $errors);
        }
        $data = array();
        $data['page'] = $request->page;
        try {
            $ejecutora = Cat_Unidad_Ejecutora::find($id);
            $ejecutora->nombre = $request->nombre;
            $ejecutora->bactivo = $request->bactivo;
            $ejecutora->id_sector = $request->id_sector;
            if ($ejecutora->id_titular == 0)
            	$titular = new Cat_Titular;
            else
            	$titular = $ejecutora->titular;
            if (!$ayuntamiento)
                $ejecutora->clave = $request->clave;
            else {
                $ejecutora->clave = null;
                $titular->titulo = $request->titulo;
                $titular->nombre = $request->titular;
                $titular->apellido = $request->apellido;
                $titular->cargo = $request->cargo;
            }
            DB::transaction(function () use ($titular, $ejecutora, $ayuntamiento) {
                if ($ayuntamiento) {
                    $titular->save();
                    $ejecutora->id_titular = $titular->id;
                }
                else if ($ejecutora->id_titular > 0) {
                	$titular->delete();
                	$ejecutora->id_titular = 0;
                }
                $ejecutora->save();
            });
            $data['mensaje'] = "Datos guardados correctamente: ".$ejecutora->nombre;
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
            $ejecutora = Cat_Unidad_Ejecutora::find($id);
            if ($ejecutora->id_sector == 4) {
                $ayuntamiento = true;
                $titular = $ejecutora->titular;
            }
            else {
                $ayuntamiento = false;
                $titular = new Cat_Titular;
            }
            //$estudio = $e->unidad_ejecutoras;
            //$estudio = ['si' => 'uno'];
            $estudio = array();
            if (count($estudio) == 0) {
                DB::transaction(function () use ($titular, $ejecutora, $ayuntamiento) {
                    if ($ayuntamiento)
                        $titular->delete();
                    $ejecutora->delete();
                });
                $data['mensaje'] = "U. Ejecutora eliminada correctamente: ".$ejecutora->nombre;
                $data['error'] = 1;
            }
            else {
                $data['mensaje'] = "U. Ejecutora tiene asociado Estudios.<br/>No se puede eliminar";
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
