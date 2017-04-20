@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Editar Menu</strong></h3>
	</div>
	<div class="panel-body">
    	<br/>
    	<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Menu">
    		{{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="id" value="{{ $menu->id }}">
    		<div class="form-group">
            	<label for="id_menu_padre" class="col-md-2 control-label input-sm">Menu Padre: </label>
              	<div class="col-md-6">
                	<select name="id_menu_padre" id="id_menu_padre" class="form-control input-sm" {{ ( $tiene_sub ) ? 'disabled="disabled"' : '' }} >
                    	{!! $opciones_menu !!}
                 	</select>
              	</div>
			</div>
    		<div class="form-group" id="div_nombre">
            	<label for="nombre" class="col-md-2 control-label input-sm">Nombre:<span class="obligatorio"> *</span></label>
            	<div class="col-md-6">
                	<input type="text" class="form-control input-sm" name="nombre" id="nombre" maxlength="100" value="{{ $menu->nombre }}">
                    <span id="err_nombre" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
            
           	<div class="form-group">
            	<label for="descripcion" class="col-md-2 control-label input-sm">Descripción:</label>
            	<div class="col-md-10">
                	<input type="text" class="form-control input-sm" name="descripcion" id="descripcion" maxlength="255" value="{{ $menu->descripcion }}">
              	</div>
           	</div>
           	<div class="form-group" id="div_orden">
            	<label for="orden" class="col-md-2 control-label input-sm">Orden:<span class="obligatorio"> *</span></label>
            	<div class="col-md-2">
                	<input type="text" class="form-control input-sm numero" name="orden" id="orden" value="{{ $menu->orden }}">
                    <span id="err_orden" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group" id="div_ruta">
            	<label for="ruta" class="col-md-2 control-label input-sm">Ruta:<span class="obligatorio"> *</span></label>
            	<div class="col-md-8">
                	<input type="text" class="form-control input-sm" name="ruta" id="ruta" value="{{ $menu->ruta }}">
                    <span id="err_ruta" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           <br/>
		</form>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('Menu.index') }}"class="btn btn-success btn-sm">Regresar</a>
            </div>
        </div>
		
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Menu/menu-update.js') }}"></script>
@endsection