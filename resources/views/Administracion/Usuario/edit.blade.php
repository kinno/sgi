@extends('layouts.master')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Editar Usuario</strong></h3>
	</div>
	<div class="panel-body">
		<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Usuario">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" id="id" value="{{ $usuario->id }}">
			<div class="form-group" id="div_id_tipo_usuario">
				<label for="id_tipo_usuario" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Tipo de Usuario:</label>
				<div class="col-md-3">
					<select name="id_tipo_usuario" id="id_tipo_usuario" class="form-control input-sm">
						{!! $opciones_tipo_usuario !!}
					</select>
					<span id="err_id_tipo_usuario" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
				</div>
			</div>
			<div id="div_grupo_ue">
			<div class="form-group">
				<label for="id_sector" class="col-md-2 control-label input-sm">Sector:</label>
				<div class="col-md-6">
					<select name="id_sector" id="id_sector" class="form-control input-sm">
						{!! $opciones_sector !!}
					</select>
				</div>
			</div>
			<div class="form-group" id="div_id_unidad_ejecutora">
				<label for="id_unidad_ejecutora" class="col-md-2 control-label input-sm"><span class="obligatorio"> *</span>Unidad Ejecutora:</label>
				<div class="col-md-6">
					<select name="id_unidad_ejecutora" id="id_unidad_ejecutora" class="form-control input-sm">
						{!! $opciones_unidad_ejecutora !!}
					</select>
					<span id="err_id_unidad_ejecutora" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
				</div>
			</div>
			</div>
			<div id="div_grupo_departamento">
			<div class="form-group">
				<label for="id_area" class="col-md-2 control-label input-sm">Area:</label>
				<div class="col-md-6">
					<select name="id_area" id="id_area" class="form-control input-sm">
						{!! $opciones_area !!}
					</select>
				</div>
			</div>
			<div class="form-group" id="div_id_departamento">
				<label for="id_departamento" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Departamento:</label>
				<div class="col-md-6">
					<select name="id_departamento" id="id_departamento" class="form-control input-sm">
						{!! $opciones_departamento !!}
					</select>
					<span id="err_id_departamento" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
				</div>
			</div>
			</div>
			<div class="form-group" id="div_username">
				<label for="username" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Usuario:</label>
				<div class="col-md-2">
					<input type="text" class="form-control input-sm" name="username" id="username" maxlength="12" value="{{ $usuario->username }}">
					<span id="err_username" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_name">
				<label for="name" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Nombre Usuario:</label>
				<div class="col-md-10">
					<input type="text" class="form-control input-sm" name="name" id="name" maxlength="150" value="{{ $usuario->name }}">
					<span id="err_name" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group" id="div_email">
				<label for="email" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Correo electrónico:</label>
				<div class="col-md-6">
					<input type="email" class="form-control input-sm" name="email" id="email" maxlength="100" value="{{ $usuario->email }}">
					<span id="err_email" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>

			<!-- <div class="form-group" id="div_password">
				<label for="password" class="col-md-2 control-label input-sm">Contraseña:<span class="obligatorio"> *</span></label>
				<div class="col-md-3">
					<input type="password" class="form-control input-sm" name="password" id="password" maxlength="20" value="{{ $usuario->username }}">
					<span id="err_password" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label for="password-confirm" class="col-md-2 control-label input-sm">Confirmar contraseña:</label>
				<div class="col-md-3">
					<input type="password" class="form-control" name="password_confirmation" id="password-confirm" required>
				</div>
			</div> -->
			<div class="form-group" id="div_iniciales">
				<label for="iniciales" class="col-md-2 control-label input-sm"><span class="obligatorio">*</span>Iniciales:</label>
				<div class="col-md-2">
					<input type="text" class="form-control input-sm" name="iniciales" id="iniciales" maxlength="4" value="{{ $usuario->iniciales }}">
					<span id="err_iniciales" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				</div>
			</div> 
			<div class="form-group">
				<div class="col-md-offset-2 col-md-3">
					<div class="checkbox">
						<label>
							@if($usuario->bactivo == 'si')
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
				<a href="{{ route('Usuario.index') }}"class="btn btn-success btn-sm">Regresar</a>
			</div>
		</div> -->
		
	</div>
</div>
<script src="{{ asset('js/Administracion/Usuario/usuario-update.js') }}"></script>
@endsection