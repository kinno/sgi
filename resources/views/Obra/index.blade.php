@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Control de Obras</strong></h3>
	</div>
	<div class="panel-body">
		
    	<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Obra">
    		{{ csrf_field() }}
    		<input type="hidden" id="id_exp_tec" name="id_exp_tec"/>
    		<input type="hidden" id="id_det_obra" name="id_det_obra"/>
    		<div class="form-group">
	            <div class="col-md-5 col-md-offset-1">
	                <div class="input-group">
	                    <span class="input-group-addon input-sm">Acción a seguir:</span>
	                    <select class="form-control input-sm" aria-describedby="basic-addon1" id="accion" name="accion">
	                        <option value="0">- Selecciona</option>
	                        <option value="1">Creación de Obra con Expediente</option>
	                        <option value="2">Creación de Obra sin Expediente</option>
	                        <option value="3">Modificación de Obra</option>
	                    </select>
	                </div>
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-md-3 col-md-offset-1" id="div_id_expediente_tecnico">
	                <div class="input-group">
	                    <span class="input-group-addon input-sm">No. Expediente:</span>
	                    <input type="text" class="form-control input-sm numero" aria-describedby="basic-addon1" id="id_expediente_tecnico" name="id_expediente_tecnico" placeholder="0" />
	                </div>
	            </div>
	            <div class="col-md-3 col-md-offset-1" id="div_id_obra1">
	                <div class="input-group">
	                    <span class="input-group-addon input-sm">No. de Obra:</span>
	                    <input type="text" class="form-control input-sm numero" aria-describedby="basic-addon1" id="id_obra1" name="id_obra1" placeholder="0" />
	                </div>
	            </div>
	            <div class="col-md-3" id="div_ejercicio_obra">
	                <div class="input-group">
	                    <span class="input-group-addon input-sm">Ejercicio:</span>
	                    <select name="ejercicio_obra" id="ejercicio_obra" class="form-control input-sm">
	                    	{!! $opciones_ejercicio !!}
	                 	</select>
	                </div>
	            </div>
	            <div id="div_buscar">
	            	<button class="btn btn-default btn-sm" id="btnBuscar">Buscar&nbsp;
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
	            </div>
	        </div>
	        <br/>

    		<div class="form-group form-group-sm" id="div_id_obra">
            	<label for="id_obra" class="col-md-2 control-label">No. de Obra:</label>
              	<div class="col-md-2">
                	<input type="text" class="form-control input-sm numero" aria-describedby="basic-addon1" id="id_obra" name="id_obra" placeholder="0" readonly="readonly" />
              	</div>
			</div>
    		<div class="form-group form-group-sm">
            	<div id="div_id_modalidad_ejecucion">
	            	<label for="id_modalidad_ejecucion" class="col-md-2 control-label"><span class="obligatorio">*</span>Modalidad de Ejecución:</label>
	              	<div class="col-md-2">
	                	<select name="id_modalidad_ejecucion" id="id_modalidad_ejecucion" class="form-control">
	                    	{!! $opciones_modalidad !!}
	                 	</select>
	                 	<span id="err_id_modalidad_ejecucion" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
	              	</div>
              	</div>
            	<div id="div_ejercicio">
	            	<label for="ejercicio" class="col-md-1 control-label"><span class="obligatorio">*</span>Ejercicio:</label>
	              	<div class="col-md-2">
	                	<select name="ejercicio" id="ejercicio" class="form-control">
	                    	{!! $opciones_ejercicio !!}
	                 	</select>
	                 	<span id="err_ejercicio" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
	              	</div>
              	</div>
              	<div id="div_id_clasificacion_obra">
	              	<label for="id_clasificacion_obra" class="col-md-2 control-label"><span class="obligatorio">*</span>Clasificación de la Obra:</label>
	              	<div class="col-md-2">
	                	<select name="id_clasificacion_obra" id="id_clasificacion_obra" class="form-control">
	                    	{!! $opciones_clasificacion !!}
	                 	</select>
	                 	<span id="err_id_clasificacion_obra" class="glyphicon glyphicon-remove form-control-feedback"  aria-hidden="true" style="right: -7px"></span>
	              	</div>
              	</div>
			</div>
			<div class="form-group form-group-sm" id="div_id_sector">
            	<label for="id_sector" class="col-md-2 control-label"><span class="obligatorio">*</span>Sector:</label>
              	<div class="col-md-4">
                	<select name="id_sector" id="id_sector" class="form-control">
                    	{!! $opciones_sector !!}
                 	</select>
                 	<span id="err_id_sector" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
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
			<div class="form-group form-group-sm" id="div_nombre">
            	<label for="nombre" class="col-md-2 control-label"><span class="obligatorio">*</span>Nombre de la Obra:</label>
            	<div class="col-md-9">
                	<textarea class="form-control" name="nombre" id="nombre" maxlength="1000" rows="1"></textarea>
                    <span id="err_nombre" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
              	</div>
           	</div>
           	<div class="form-group form-group-sm" id="div_justificacion">
            	<label for="justificacion" class="col-md-2 control-label">Justificación:</label>
            	<div class="col-md-9">
                	<textarea class="form-control" name="justificacion" id="justificacion" maxlength="1000" rows="1"></textarea>
              	</div>
           	</div>
           	<div class="form-group form-group-sm" id="div_caracteristicas">
            	<label for="caracteristicas" class="col-md-2 control-label">Características:</label>
            	<div class="col-md-9">
                	<textarea class="form-control" name="caracteristicas" id="caracteristicas" maxlength="1000" rows="1"></textarea>
              	</div>
           	</div>

           	<div class="form-group form-group-sm" id="div_id_cobertura">
                <label for="id_cobertura" class="col-md-2 control-label">
                    <span class="obligatorio">*</span>Tipo de Cobertura:
                </label>
                <div class="col-md-3">
                    <select class="form-control" name="id_cobertura" id="id_cobertura">
                        {!! $opciones_cobertura !!}
                    </select>
                    <span id="err_id_cobertura" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>

            <div class="form-group form-group-sm" id="div_id_region" style="display:none;">
            	<label class="col-md-2 control-label">
                    <span class="obligatorio">*</span>Regiones:
                </label>
                <div class="col-md-9">
                    <select class="form-control" name="id_region[]" id="id_region" multiple="multiple">
                        {!! $opciones_region !!}
                    </select>
                    <span id="err_id_region" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_municipio" style="display:none;">
                <label class="col-md-2 control-label">
                    <span class="obligatorio">*</span>Municipios:
                </label>
                <div class="col-md-9">
                    <select class="form-control" name="id_municipio[]" id="id_municipio" multiple="multiple">
                        {!! $opciones_municipio !!}
                    </select>
                    <span id="err_id_municipio" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
                </div>
            </div>
           	<div class="form-group form-group-sm" id="div_localidad">
            	<label for="localidad" class="col-md-2 control-label">Localidad:</label>
            	<div class="col-md-9">
                	<input type="text" class="form-control" name="localidad" id="localidad" maxlength="150">
              	</div>
           	</div>

            <div class="form-group form-group-sm" id="div_monto">
                <label for="monto" class="col-md-2 control-label"><span class="obligatorio">*</span>Monto de la Inversión: </label>
                <div class="col-md-3">
                    <input type="text" class="form-control numeroDecimal" id="monto" name="monto" placeholder="0.00" readonly/>
                    <span id="err_monto" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>

            <div class="fuente_federal monto_federal cuenta_federal">
	            <div class="form-group form-group-sm">
	                <div id="div_monto_federal">
	                    <label for="monto_federal" class="col-md-2 control-label"><span class="obligatorio">*</span>Federal: </label>
	                    <div class="col-md-3">
	                        <input type="text" id="monto_federal" class="form-control monfed numeroDecimal" name="monto_federal[]" value="" placeholder="0.00" />
	                        <span id="err_monto_federal" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
	                    </div>
	                </div>
	                <div id="div_fuente_federal">
	                    <label for="fuente_federal" class="col-md-1 control-label"><span class="obligatorio">*</span>Fuente:</label>
	                    <div class="col-md-5">
	                        <select id="fuente_federal" name="fuente_federal[]" class="form-control numftef">
	                         	{!! $opciones_fuente_federal !!}
	                        </select>
	                        <span id="err_fuente_federal" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
	                    </div>
	                </div>
	                <input class="bt_ftefed input-sm" type="button" value="+"/>
	            </div>
	            <div class="form-group form-group-sm" id="div_cuenta_federal">
	                <label for="cuenta_federal" class="col-md-2 col-md-offset-4 control-label"><span class="obligatorio">*</span>No. cuenta: </label>
	                <div class="col-md-3">
	                    <input type="text" class="form-control numcta" id="cuenta_federal" name="cuenta_federal[]" maxlength="40" />
	                    <span id="err_cuenta_federal" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
	                </div>
	            </div>
            </div>

            <div class="fuente_estatal monto_estatal cuenta_estatal">
	            <div class="form-group form-group-sm">
	            	<div id="div_monto_estatal">
	                    <label for="monto_estatal" class="col-md-2 control-label"><span class="obligatorio">*</span>Rec Fiscales (Estatal): </label>
	                    <div class="col-md-3">
	                        <input type="text" id="monto_estatal" class="form-control monest numeroDecimal" name="monto_estatal[]" value="" placeholder="0.00" />
	                        <span id="err_monto_estatal" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
	                    </div>
	                </div>
	                <div id="div_fuente_estatal">
	                    <label for="fuente_estatal" class="col-md-1 control-label"><span class="obligatorio">*</span>Fuente:</label>
	                    <div class="col-md-5">
	                        <select id="fuente_estatal" name="fuente_estatal[]" class="form-control numftee">
	                        	{!! $opciones_fuente_estatal !!}
	                        </select>
	                        <span id="err_fuente_estatal" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
	                    </div>
	                </div>
	                <input class="bt_fteest input-sm" type="button" value="+" />
	            </div>
	            <div class="form-group form-group-sm" id="div_cuenta_estatal">
	                <label for="cuenta_estatal" class="col-md-2 col-md-offset-4 control-label"><span class="obligatorio">*</span>No. cuenta: </label>
	                <div class="col-md-3">
	                    <input type="text" class="form-control numcta" id="cuenta_estatal" name="cuenta_estatal[]" maxlength="40" />
	                    <span id="err_cuenta_estatal" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
	                </div>
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
			<div class="form-group form-group-sm" id="div_id_acuerdo_est">
                <label class="col-md-2 control-label">Acciones de Gobierno Estatal: </label>
                <div class="col-md-9">
                    <select name="id_acuerdo_est[]" id="id_acuerdo_est" class="form-control" multiple="multiple">
                        {!! $opciones_acuerdo_estatal !!}
                    </select>
                </div>
            </div>
			<div class="form-group form-group-sm" id="div_id_acuerdo_fed">
                <label class="col-md-2 control-label">Acciones de Gobierno Federal:</label>
                <div class="col-md-9">
                    <select name="id_acuerdo_fed[]" id="id_acuerdo_fed" class="form-control" multiple="multiple">
                        {!! $opciones_acuerdo_federal !!}
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_grupo_social">
                <label class="col-md-2 control-label">Grupo Social:</label>
                <div class="col-md-9">
                    <select name="id_grupo_social" id="id_grupo_social" class="form-control">
                        {!! $opciones_grupo !!}
                    </select>
                </div>
            </div>
    		
           <br/>
		</form>

        <!-- <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-sm" id="btnLimpiar">Limpiar</button>
            </div>
        </div> -->
  	</div>
</div>
<script src="{{ asset('js/Obra/obra.js') }}"></script>
@endsection
