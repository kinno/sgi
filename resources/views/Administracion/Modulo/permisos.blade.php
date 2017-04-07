@extends('layouts.master')
@section('content')
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
			<div class="form-group">
				<label class="col-md-2 control-label input-sm">Opciones:</label>
				<div class="col-md-6" style="display: block; overflow: auto; height: 300px">
					<table class="table table-hover table-condensed" id="opciones_menu">
						<tbody id="opciones_menu1">
							{!! $filas !!}
						</tbody>
					</table>
				</div>
			</div>
           <br/>
		</form>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
            </div>
        </div>
		
  	</div>
</div>
<script src="{{ asset('js/Administracion/Modulo/permisos.js') }}"></script>
@endsection
