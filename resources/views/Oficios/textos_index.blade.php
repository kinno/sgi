@extends('layouts.master')
@section('content')
{{-- <div  class="container"> --}}
<form class="form-horizontal" id="form_anexo_uno" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Control de Textos de Oficios</strong></h3>
        </div>
        <div class="panel-body">
            <div class="row form-inline">            
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Tipo: </span>
                         <select class="form-control" name="id_tipo_solicitud" id="id_tipo_solicitud" aria-describedby="basic-addon1">
                            @foreach ($tipoSolicitud as $element)
                                <option value="{{$element->id}}">{{$element->nombre_solicitud}}</option>
                            @endforeach
                        </select>   
                    </div>                    
                </div>                
                <div class="col-sm-3">
                   <div class="input-group">
                        <span class="input-group-addon">Ejercicio: </span>               
                        <select class="form-control input-sm" id="ejercicio" name="ejercicio">
                            @foreach ($ejercicios as $element)
                                <option value="{{$element->Ejercicio}}">{{$element->Ejercicio}}</option>
                            @endforeach              
                        </select>
                    </div>  
                </div>
                <div class="col-md-5">
                 <div class="input-group">
                    <span class="input-group-addon">Fuente: </span>     
                    <select class="form-control input-sm" id="fuente" name="fuente">
                        <option>Seleccione...</option>
                         @foreach ($fuentes as $element)
                                <option value="{{$element->id}}">{{$element->descripcion}}</option>
                            @endforeach              
                    </select>
                    </div>
                </div>
            </div>                
            <div class="row">&nbsp;</div>

            <div class="form-group row">
                <div class="col-sm-12">
                   <div class="input-group">
                        <span class="input-group-addon">Asunto: </span>               
                        <textarea class="form-control"></textarea>
                    </div>  
                </div>
            </div>                    
           <div class="form-group row">
                <div class="col-sm-12">
                   <div class="input-group">
                        <span class="input-group-addon">Prefijo: </span>               
                        <textarea class="form-control"></textarea>
                    </div>  
                </div>
            </div>                                                                
            <div class="form-group row">
                <div class="col-sm-12">
                   <div class="input-group">
                        <span class="input-group-addon">Texto:</span>               
                        <textarea class="form-control" rows="4"></textarea>
                    </div>  
                </div>
            </div>    
            
            <div class="row">
                <div class="col-md-2">                    
                    <p><button type="button" class="btn btn-default" id="etiquetaTotal">Agregar Total</button></p>
                </div>
                <div class="col-md-4">                    
                    &nbsp;
                </div>    
                <div class="col-md-2 text-right">                    
                    <p><button type="button" class="btn btn-default" id="guardarC">Guardar</button></p>
                </div>
                <div class="col-md-2 text-right">  
                    <p><button type="button" class="btn btn-default" id="salir">Salir</button></p>
                </div>
            </div>    
            
        </div>    
    </div>
</form>
{{-- </div>  --}}
@endsection