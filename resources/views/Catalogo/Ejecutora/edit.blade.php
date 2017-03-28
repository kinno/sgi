@extends('layouts.master')
@section('content')
<br/>  
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title text-center"><strong>Editar Unidad Ejecutora</strong></h3>
	</div>
	<div class="panel-body">
   	    <br/>
        <form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Ejecutora">
   		    {{ csrf_field() }}
   		    <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="id" value="{{ $ejecutora->id }}">
            <div class="form-group" id="div_id_sector">
                <label for="id_sector" class="col-md-2 control-label input-sm">Sector: <span class="obligatorio"> *</span></label>
                <div class="col-md-6">
                    <select name="id_sector" id="id_sector" class="form-control input-sm">
                        {!! $opciones_sector !!}
                    </select>
                    <span id="err_id_sector" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="form-group" id="div_clave">
                <label for="clave" class="col-md-2 control-label input-sm">Clave:<span class="obligatorio"> *</span></label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" name="clave" id="clave" maxlength="10" value="{{ $ejecutora->clave }}">
                    <span id="err_clave" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="form-group" id="div_nombre">
                <label for="nombre" class="col-md-2 control-label input-sm">Ejecutora:<span class="obligatorio"> *</span></label>
                <div class="col-md-10">
                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" maxlength="150" value="{{ $ejecutora->nombre }}">
                    <span id="err_nombre" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div id="div_grupo_titular">
            <div class="form-group" id="div_titulo">
                <label for="titulo" class="col-md-2 control-label input-sm">Titulo:<span class="obligatorio"> *</span></label>
                <div class="col-md-6">
                    <input type="text" class="form-control input-sm" name="titulo" id="titulo" maxlength="60" value="{{ $titular->titulo }}">
                    <span id="err_titulo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="form-group" id="div_titular">
                <label for="titular" class="col-md-2 control-label input-sm">Titular:<span class="obligatorio"> *</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control input-sm" name="titular" id="titular" maxlength="30" value="{{ $titular->nombre }}">
                    <span id="err_titular" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="form-group" id="div_apellido">
                <label for="apellido" class="col-md-2 control-label input-sm">Apellidos:<span class="obligatorio"> *</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" maxlength="40" value="{{ $titular->apellido }}">
                    <span id="err_apellido" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="form-group" id="div_cargo">
                <label for="cargo" class="col-md-2 control-label input-sm">Cargo:<span class="obligatorio"> *</span></label>
                <div class="col-md-6">
                    <input type="text" class="form-control input-sm" name="cargo" id="cargo" maxlength="100" value="{{ $titular->cargo }}">
                    <span id="err_cargo" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            </div>

           	<div class="form-group">
    			<div class="col-md-offset-2 col-md-3">
      				<div class="checkbox">
        				<label>
                            @if($ejecutora->bactivo == 'si')
                                <input type="checkbox" name="bactivo" checked="checked"> Activo
                            @else
                                <input type="checkbox" name="bactivo"> Activo
                            @endif
        				</label>
      				</div>
    			</div>
  			</div>
            <br/>
		</form>	
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('Ejecutora.index') }}"class="btn btn-success btn-sm">Regresar</a>
            </div>
        </div>	
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Ejecutora/ejecutora-update.js') }}"></script>
@endsection
