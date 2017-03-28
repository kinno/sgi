@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Agregar Sector</strong></h3>
	</div>
	<div class="panel-body">
    	<br/>
    	<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Sector">
    		{{ csrf_field() }}
    		<div class="form-group">
            	<label for="id_area" class="col-md-2 control-label input-sm">Area</label>
              	<div class="col-md-6">
                	<select name="id_area" id="id_area" class="form-control input-sm">
                    	{!! $opciones_area !!}
                 	</select>
              	</div>
			</div>
			<div class="form-group" id="div_id_departamento">
            	<label for="id_departamento" class="col-md-2 control-label input-sm">Departamento<span class="obligatorio"> *</span></label>
              	<div class="col-md-6">
                	<select name="id_departamento" id="id_departamento" class="form-control input-sm">
                    	<option value="0">- Selecciona </option>
                 	</select>
                    <span id="err_id_departamento" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
			</div>
    		<div class="form-group" id="div_nombre">
            	<label for="nombre" class="col-md-2 control-label input-sm">Sector:<span class="obligatorio"> *</span></label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="nombre" id="nombre" maxlength="40">
                    <span id="err_nombre" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group" id="div_titulo">
            	<label for="titulo" class="col-md-2 control-label input-sm">Titulo:<span class="obligatorio"> *</span></label>
            	<div class="col-md-6">
                	<input type="text" class="form-control input-sm" name="titulo" id="titulo" maxlength="60">
                    <span id="err_titulo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group" id="div_titular">
            	<label for="titular" class="col-md-2 control-label input-sm">Titular:<span class="obligatorio"> *</span></label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="titular" id="titular" maxlength="30">
                    <span id="err_titular" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group" id="div_apellido">
            	<label for="apellido" class="col-md-2 control-label input-sm">Apellidos:<span class="obligatorio"> *</span></label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="apellido" id="apellido" maxlength="40">
                    <span id="err_apellido" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group" id="div_cargo">
            	<label for="cargo" class="col-md-2 control-label input-sm">Cargo:<span class="obligatorio"> *</span></label>
            	<div class="col-md-6">
                	<input type="text" class="form-control input-sm" name="cargo" id="cargo" maxlength="100">
                    <span id="err_cargo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group">
    			<div class="col-md-offset-2 col-m2-3">
      				<div class="checkbox">
        				<label>
          				<input type="checkbox" name="bactivo" id="bactivo" checked> Activo
        				</label>
      				</div>
    			</div>
  			</div>
           <br/>
           	
		</form>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button class="btn btn-success btn-sm" id="btnGuardar">Registrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('Sector.index') }}"class="btn btn-success btn-sm">Regresar</a>
            </div>
        </div>
		
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Sector/sector-guardar.js') }}"></script>
@endsection
