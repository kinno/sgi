@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Actualizar permisos de Usuarios</strong></h3>
	</div>
	<div class="panel-body">
    	<br/>
    	<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Permisos">
    		{{ csrf_field() }}
    		<div class="form-group" id="div_id_usuario">
            	<label for="id_usuario" class="col-md-2 control-label input-sm">Usuario: <span class="obligatorio"> *</span></label>
              	<div class="col-md-6">
                	<select name="id_usuario" id="id_usuario" class="form-control input-sm">
                    	{!! $opciones_usuario !!}
                 	</select>
                    <span id="err_id_usuario" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
			</div>
			<div class="form-group" id="div_id_modulo">
            	<label for="id_modulo" class="col-md-2 control-label input-sm">Modulos: <span class="obligatorio"> *</span></label>
              	<div class="col-md-6">
                	<select name="id_modulo[]" id="id_modulo" class="form-control input-sm" multiple="multiple">
                    	<option value='0'>Selecciona</option>
                    	<option value='1'>Selecciona1</option>
                    	
                 	</select>
                    <span id="err_id_modulo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
			</div>
            
           <br/>
		</form>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <a href="{{ route('Ejecutora.index') }}" class="btn btn-success btn-sm" id="btnGuardar">Guardar</a>
            </div>
        </div>
		
  	</div>
</div>
<script src="{{ asset('js/Administracion/Modulo/permisos.js') }}"></script>
@endsection
