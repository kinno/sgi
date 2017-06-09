@extends('layouts.master')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Firma de Oficios</strong></h3>
	</div>
	<div class="panel-body">
		<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Firma_Oficios">
			{{ csrf_field() }}
			<input type="hidden" id="id_exp_tec" name="id_exp_tec"/>
			<input type="hidden" id="id_det_obra" name="id_det_obra"/>
			
				<!-- <div id="div_buscar">
					<button class="btn btn-default btn-sm" id="btnBuscar">Buscar&nbsp;
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</button>
				</div> -->

			<div class="form-group form-group-sm" id="div_clave">
				<label for="clave" class="col-md-2 control-label">Oficio:</label>
				<div class="col-md-2">
					<input type="text" class="form-control input-sm numero" id="clave" name="clave" readonly="readonly" />
				</div>
			</div>
			<div class="form-group form-group-sm" id="div_tipo_solicitud">
				<label for="solicitud_presupuesto" class="col-md-2 control-label">Tipo de Solicitud:</label>
				<div class="col-md-4">
					<input type="text" class="form-control input-sm" id="solicitud_presupuesto" name="solicitud_presupuesto" readonly="readonly" />
				</div>
			</div>
			<div class="form-group form-group-sm">
				<div id="div_fecha_oficio">
					<label for="fecha_oficio" class="col-md-2 control-label">Fecha:</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="fecha_oficio" name="fecha_oficio" readonly="readonly" />
					</div>
				</div>
				<div id="div_fecha_firma">
					<label for="fecha_firma" class="col-md-2 control-label"><span class="obligatorio">*</span>Firma:</label>
					<div class="col-md-2">
						<input type="text" class="form-control fecha" id="fecha_firma" name="fecha_firma" readonly="readonly" />
						<span id="err_fecha_firma" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
			</div>
			<div class="form-group form-group-sm" id="div_id_estatus">
				<label for="id_estatus" class="col-md-2 control-label"><span class="obligatorio">*</span>Estado:</label>
				<div class="col-md-2">
					<select name="id_estatus" id="id_estatus" class="form-control">
						{!! $opciones['estatus_oficio'] !!}
					</select>
					<span id="err_id_estatus" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: -7px"></span>
				</div>
			</div>
			<br />
			<table class="table table-striped tabla-condensada table-responsive">
				<thead>
					<tr>
						<th width="8%">Obra</th>
						<th width="34%">Fuente</th>
						<th width="34%">Ejecutor</th>
						<th width="12%">Asignado</th>
						<th width="12%">Autorizado</th>
					</tr>
				</thead>
				<tbody id="detObras">
					<tr>
						<td colspan="5" class="text-center"></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script src="{{ asset('js/Oficios/main_firma_oficios.js') }}"></script>
@endsection
