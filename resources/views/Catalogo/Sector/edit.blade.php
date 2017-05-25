@extends('layouts.master')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Editar Sector</strong></h3>
	</div>
	<div class="panel-body">
		<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Sector">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" id="id" value="{{ $sector->id }}">
			<input type="hidden" id="page" name="page" value="{{ $page }}">
			<div class="form-group">
				<label for="id_area" class="col-md-2 control-label input-sm">Area</label>
				<div class="col-md-6">
					<select name="id_area" id="id_area" class="form-control input-sm">
						{!! $opciones['area'] !!}
					</select>
				</div>
			</div>
			<div class="form-group" id="div_id_departamento">
				<label for="id_departamento" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Departamento</label>
				<div class="col-md-6">
					<select name="id_departamento" id="id_departamento" class="form-control input-sm">
						{!! $opciones['departamento'] !!}
					</select>
					<span id="err_id_departamento" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
				</div>
			</div>
			<div class="form-group" id="div_nombre">
				<label for="nombre" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Sector:</label>
				<div class="col-md-4">
					<input type="text" class="form-control input-sm" name="nombre" id="nombre" maxlength="40" value="{{ $sector->nombre }}">
					<span id="err_nombre" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_clave">
				<label for="clave" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Clave:</label>
				<div class="col-md-2">
					<input type="text" class="form-control input-sm" name="clave" id="clave" maxlength="10" value="{{ $sector->clave }}">
					<span id="err_clave" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_unidad_responsable">
				<label for="unidad_responsable" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Unidad Responsable:</label>
				<div class="col-md-6">
					<input type="text" class="form-control input-sm" name="unidad_responsable" id="unidad_responsable" maxlength="80" value="{{ $sector->unidad_responsable }}">
					<span id="err_unidad_responsable" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_titulo">
				<label for="titulo" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Titulo:</label>
				<div class="col-md-6">
					<input type="text" class="form-control input-sm" name="titulo" id="titulo" maxlength="60" value="{{ $titular->titulo }}">
					<span id="err_titulo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_titular">
				<label for="titular" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Titular:</label>
				<div class="col-md-4">
					<input type="text" class="form-control input-sm" name="titular" id="titular" maxlength="30" value="{{ $titular->nombre }}">
					<span id="err_titular" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_apellido">
				<label for="apellido" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Apellidos:</label>
				<div class="col-md-4">
					<input type="text" class="form-control input-sm" name="apellido" id="apellido" maxlength="40" value="{{ $titular->apellido }}">
					<span id="err_apellido" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_cargo">
				<label for="cargo" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Cargo:</label>
				<div class="col-md-6">
					<input type="text" class="form-control input-sm" name="cargo" id="cargo" maxlength="100" value="{{ $titular->cargo }}">
					<span id="err_cargo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-3">
					<div class="checkbox">
						<label>
							@if($sector->bactivo == 'si')
								<input type="checkbox" name="bactivo" checked="checked"> Activo
							@else
								<input type="checkbox" name="bactivo"> Activo
							@endif
						</label>
					</div>
				</div>
			</div>
		</form>	
		<!-- <div class="form-group">
			<div class="col-md-2 col-md-offset-2">
				<button class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
			</div>
			<div class="col-md-2">
				<a href="{{ route('Sector.index') }}"class="btn btn-success btn-sm">Regresar</a>
			</div>
		</div>	 -->
	</div>
</div>
<script src="{{ asset('js/Catalogo/Sector/sector-update.js') }}"></script>
@endsection
