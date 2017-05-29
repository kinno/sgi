@extends('layouts.master')
@section('content')
{{-- <div  class="container"> --}}
<form class="form-horizontal" id="form_texto_oficios" role="form">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Control de Textos de Oficios</strong></h3>
        </div>
        <div class="panel-body">
            <div class="row form-inline">            
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">Tipo: </span>
                         <select class="form-control input-trigger" name="id_solicitud_presupuesto" id="id_solicitud_presupuesto" aria-describedby="basic-addon1">
                            @foreach ($tipoSolicitud as $element)
                                <option value="{{$element->id}}">{{$element->nombre}}</option>
                            @endforeach
                        </select>   
                    </div>                    
                </div>                
                <div class="col-sm-3">
                   <div class="input-group input-group-sm">
                        <span class="input-group-addon">Ejercicio: </span>               
                        <select class="form-control input-sm input-trigger" id="ejercicio" name="ejercicio">
                            @foreach ($ejercicios as $element)
                                <option value="{{$element->ejercicio}}">{{$element->ejercicio}}</option>
                            @endforeach              
                        </select>
                    </div>  
                </div>
                <div class="col-md-5">
                 <div class="input-group input-group-sm">
                    <span class="input-group-addon">Fuente: </span>     
                    <select class="form-control input-sm input-trigger" id="id_fuente" name="id_fuente">
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
                        <textarea class="form-control" id="asunto" name="asunto"></textarea>
                    </div>  
                </div>
            </div>                    
           <div class="form-group row">
                <div class="col-sm-12">
                   <div class="input-group">
                        <span class="input-group-addon">Prefijo: </span>               
                        <textarea class="form-control" id="prefijo" name="prefijo"></textarea>
                    </div>  
                </div>
            </div>                                                                
            <div class="form-group row">
                <div class="col-sm-12">
                   <div class="input-group">
                        <span class="input-group-addon">Texto:</span>               
                        <textarea class="form-control" id="texto" name="texto" rows="10"></textarea>
                    </div>  
                </div>
            </div>    
            
            <div class="row">
                <div class="col-md-2">                    
                    <p><button type="button" class="btn btn-default" id="etiquetaTotal">Agregar Total</button></p>
                </div>
            </div>    
            
        </div>    
    </div>
</form>
<script src="{{ asset('js/Oficios/main_texto_oficios.js') }}">
</script>
@endsection