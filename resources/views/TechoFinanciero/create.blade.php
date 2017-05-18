@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Registrar Monto del Techo Financiero</strong></h3>
	</div>
	<div class="panel-body">
    	<br/>
    	<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="TechoFinanciero">
    		{{ csrf_field() }}
    		<div class="form-group form-group-sm" id="div_ejercicio">
                <label for="ejercicio" class="col-md-2 control-label"><span class="obligatorio">*</span>Ejercicio:</label>
                <div class="col-md-2">
                    <select name="ejercicio" id="ejercicio" class="form-control">
                        {!! $opciones_ejercicio !!}
                    </select>
                    <span id="err_ejercicio" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_sector">
            	<label for="id_sector" class="col-md-2 control-label">Sector:</label>
              	<div class="col-md-4">
                	<select name="id_sector" id="id_sector" class="form-control">
                    	{!! $opciones_sector !!}
                 	</select>
              	</div>
			</div>
            <div class="form-group form-group-sm" id="div_id_unidad_ejecutora">
                <label for="id_unidad_ejecutora" class="col-md-2 control-label"><span class="obligatorio">*</span>Unidad Ejecutora:</label>
                <div class="col-md-9">
                    <select name="id_unidad_ejecutora" id="id_unidad_ejecutora" class="form-control">
                        <option>- Selecciona</option>
                    </select>
                    <span id="err_id_unidad_ejecutora" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_programa">
                <label for="programa" class="col-md-2 control-label">Programa EP:</label>
                <div class="col-md-9">
                    <select name="programa" id="programa" class="form-control">
                        <option>- Selecciona</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_proyecto_ep">
                <label for="id_proyecto_ep" class="col-md-2 control-label"><span class="obligatorio">*</span>Proyecto EP:</label>
                <div class="col-md-9">
                    <select name="id_proyecto_ep" id="id_proyecto_ep" class="form-control">
                        <option>- Selecciona</option>
                    </select>
                    <span id="err_id_proyecto_ep" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_tipo_fuente">
                <label for="id_tipo_fuente" class="col-md-2 control-label"><span class="obligatorio">*</span>Tipo de Fuente:</label>
                <div class="col-md-2">
                    <select name="id_tipo_fuente" id="id_tipo_fuente" class="form-control">
                        {!! $opciones_tipo_fuente !!}
                    </select>
                    <span id="err_id_tipo_fuente" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_fuente">
                <label for="id_fuente" class="col-md-2 control-label"><span class="obligatorio">*</span>Fuente:</label>
                <div class="col-md-6">
                    <select name="id_fuente" id="id_fuente" class="form-control">
                        <option>- Selecciona</option>
                    </select>
                    <span id="err_id_fuente" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
            <div class="form-group form-group-sm" id="grupo_monto">
            <!-- <div id="div_id_tipo_movimiento">
                <label for="id_tipo_movimiento" class="col-md-2 control-label"><span class="obligatorio">*</span>Movimiento:</label>
                <div class="col-md-2">
                    <select name="id_tipo_movimiento" id="id_tipo_movimiento" class="form-control">
                        $opciones_tipo_movimiento
                    </select>
                    <span id="err_id_tipo_movimiento" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div> -->
            <div id="div_monto">
                <label for="monto" class="col-md-2 control-label"><span class="obligatorio">*</span>Monto:</label>
                <div class="col-md-2">
                    <input type="text" id="monto" class="form-control numeroDecimal" name="monto" value="" placeholder="0.00" />
                    <span id="err_monto" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            </div>
            <div class="form-group form-group-sm" id="div_observaciones">
                <label for="observaciones" class="col-md-2 control-label"><span class="obligatorio">*</span>Observaciones:</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="observaciones" id="observaciones" maxlength="255" rows="1"></textarea>
                    <span id="err_observaciones" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            
           <br/>
		</form>
        <!-- <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button class="btn btn-success btn-sm" id="btnGuardar">Registrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('TechoFinanciero.index') }}"class="btn btn-success btn-sm">Regresar</a>
            </div>
        </div> -->
		
  	</div>
</div>
<script src="{{ asset('js/TechoFinanciero/techofinanciero-guardar.js') }}"></script>
@endsection
