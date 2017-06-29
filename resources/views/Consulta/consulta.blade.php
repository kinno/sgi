@extends('layouts.master')
@section('content')
<link href="/css/jquery-ui.css" rel="stylesheet"/>
<script src="/js/jquery-ui.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css"/>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>
<script type="text/javascript" src="{{ asset('js/Consulta/consulta.js') }}"></script>
<script id="montos-template" type="text/x-handlebars-template">
	<div class="label label-success">Obra: @{{id_obra}}</div>
	<br />
	<table class="table table-bordered table-striped tabla-condensada2" style="margin-bottom: 0 !important">
		<tr style="text-align: center;">
			<td style="width: 10%">Asignado</td>
			<td style="width: 10%">Autorizado</td>
			<td style="width: 10%">Ejercido</td>
			<td style="width: 10%">Por Ejercer</td>
			<td style="width: 10%">Anticipo</td>
			<td style="width: 10%">Retenciones</td>
			<td style="width: 10%">Comprobado</td>
			<td style="width: 10%">Por comprobar</td>
			<td style="width: 10%">Pagado</td>
			<td style="width: 10%">Por pagar</td>
		</tr>
		<tr style="text-align: right;">
			<td>@{{asignado}}</td>
			<td>@{{autorizado}}</td>
			<td>@{{ejercido}}</td>
			<td>@{{por_ejercer}}</td>
			<td>@{{anticipo}}</td>
			<td>@{{retenciones}}</td>
			<td>@{{comprobado}}</td>
			<td>@{{por_comprobar}}</td>
			<td>@{{pagado}}</td>
			<td>@{{por_pagar}}</td>
		</tr>
	</table>
	
	@{{#each fuentes}}
	<div class="label label-success">Fuente: @{{clave}} - @{{descripcion}}</div>
	<table class="table table-bordered table-striped tabla-condensada2" style="margin-bottom: 0 !important">
		<tr>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.asignado }}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.autorizado}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.ejercido}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.por_ejercer}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.anticipo}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.retenciones}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.comprobado}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.por_comprobar}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.pagado}}</td>
			<td style="width: 10%" class="numeroDecimal">@{{pivot.por_pagar}}</td>
		</tr>
	</table>
	@{{/each}}
</script>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Consulta de Obras</strong></h3>
	</div>
	<div class="panel-body">
		<!-- <input type="hidden" id="id_exp_tec" name="id_exp_tec"/> -->
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Listado</a></li>
				<li><a href="#tabs-2">Montos</a></li>
				<li><a href="#tabs-3">Oficios</a></li>
				<li><a href="#tabs-4">APs</a></li>
				<li><a href="#tabs-5">Pagos</a></li>
				<li><a href="#tabs-6">Contratos</a></li>
				<li><a href="#tabs-7">Datos</a></li>
				<li><a href="#tabs-8">Estudio</a></li>
				<li><a href="#tabs-9">Expediente</a></li>
			</ul>
		  
			<!--Datos-->
			<!--Listado-->
			<div id="tabs-1">
				<div id="Criterios">
					<h3>Búsqueda personalizada</h3>
					<div>
						<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Consulta">
							{{ csrf_field() }}
							<div class="form-group form-group-sm">
								<div id="div_id_obra_search">
									<label for="id_obra_search" class="col-md-2 control-label">No. de Obra:</label>
									<div class="col-md-2">
										<input type="text" class="form-control numero" id="id_obra_search" name="id_obra_search" placeholder="0" />
									</div>
								</div>
								<div id="div_nombre_search">
									<label for="nombre_search" class="col-md-3 control-label"></span>Nombre de la Obra:</label>
									<div class="col-md-4">
										<input type="text" class="form-control" id="nombre_search" name="nombre_search" />
									</div>
								</div>
							</div>
							<div class="form-group form-group-sm">
								<div id="div_ejercicio_search">
									<label for="ejercicio_search" class="col-md-2 control-label">Ejercicio:</label>
									<div class="col-md-2">
										<select name="ejercicio_search" id="ejercicio_search" class="form-control">
											{!! $opciones['ejercicio'] !!}
										</select>
									</div>
								</div>
								<div id="div_id_municipio_search">
									<label for="id_municipio_search" class="col-md-3 control-label"></span>Municipio:</label>
									<div class="col-md-4">
										<select name="id_municipio_search" id="id_municipio_search" class="form-control">
											{!! $opciones['municipio'] !!}
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-group-sm" id="div_id_sector_search">
								<label for="id_sector_search" class="col-md-2 control-label">Sector:</label>
								<div class="col-md-4">
									<select name="id_sector_search" id="id_sector_search" class="form-control">
										{!! $opciones['sector'] !!}
									</select>
								</div>
							</div>
							<div class="form-group form-group-sm" id="div_id_unidad_ejecutora_search">
								<label for="id_unidad_ejecutora_search" class="col-md-2 control-label"></span>Unidad Ejecutora:</label>
								<div class="col-md-8">
									<select name="id_unidad_ejecutora_search" id="id_unidad_ejecutora_search" class="form-control">
										{!! $opciones['ue'] !!}
									</select>
								</div>
							</div>
							<div class="form-group form-group-sm" id="div_id_clasificacion_obra_search">
								<label for="id_clasificacion_obra_search" class="col-md-2 control-label"></span>Clasificación Obra:</label>
								<div class="col-md-3">
									<select name="id_clasificacion_obra_search" id="id_clasificacion_obra_search" class="form-control">
										{!! $opciones['clasificacion'] !!}
									</select>
								</div>
							</div>
							<div class="form-group form-group-sm" id="div_id_grupo_social_search">
								<label for="id_grupo_social_search" class="col-md-2 control-label"></span>Grupo Social:</label>
								<div class="col-md-8">
									<select name="id_grupo_social_search" id="id_grupo_social_search" class="form-control">
										{!! $opciones['grupo'] !!}
									</select>
								</div>
							</div>
							
						</form>
					</div>
				</div>
				<br />

				<table class="table table-striped tabla-condensada" id="obras">
					<thead>
						<tr>
							<th style="width: 3%"></th>
							<th style="width: 7%">Obra</th>
							<th style="width: 7%">Ejercicio</th>
							<th style="width: 17%">Municipio</th>
							<th style="width: 61%">Nombre Obra</th>
							<th style="width: 5%"></th>
						</tr>
					</thead>
				</table>
			</div>

			<!--Montos-->
			<div id="tabs-2">
			</div>

			<!--Oficios-->
			<div id="tabs-3">
			</div>

			<!--APs-->
			<div id="tabs-4">
			</div>

			<!--Pagos-->
			<div id="tabs-5">
			</div>

			<!--Contratos-->
			<div id="tabs-6">
			</div>

			<!--Datos-->
			<div id="tabs-7">
				<form class="form-horizontal" role="form" id="datos">
				<div class="form-group form-group-sm" id="div_id_obra">
					<label for="id_obra" class="col-md-2 control-label">No. de Obra:</label>
					<div class="col-md-2">
						<input type="text" class="form-control numero" id="id_obra" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<div id="div_modalidad_ejecucion">
						<label for="modalidad_ejecucion" class="col-md-2 control-label">Modalidad de Ejecución:</label>
						<div class="col-md-2">
							<input type="text" class="form-control" id="modalidad_ejecucion" readonly="readonly" />
						</div>
					</div>
					<div id="div_ejercicio">
						<label for="ejercicio" class="col-md-2 control-label">Ejercicio:</label>
						<div class="col-md-2">
							<input type="text" class="form-control" id="ejercicio" readonly="readonly" />
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<div id="div_clasificacion_obra">
						<label for="clasificacion_obra" class="col-md-2 control-label">Clasificación de la Obra:</label>
						<div class="col-md-2">
							<input type="text" class="form-control" id="clasificacion_obra" readonly="readonly" />
						</div>
					</div>
					<div id="div_tipo_obra">
						<label for="tipo_obra" class="col-md-2 control-label">Tipo de Obra:</label>
						<div class="col-md-2">
							<input type="text" class="form-control" id="tipo_obra" readonly="readonly" />
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_sector">
					<label for="sector" class="col-md-2 control-label">Sector:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="sector" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_unidad_ejecutora">
					<label for="unidad_ejecutora" class="col-md-2 control-label">Unidad Ejecutora:</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="unidad_ejecutora" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_nombre">
					<label for="nombre" class="col-md-2 control-label">Nombre de la Obra:</label>
					<div class="col-md-10">
						<textarea class="form-control" id="nombre" rows="1" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_justificacion">
					<label for="justificacion" class="col-md-2 control-label">Justificación:</label>
					<div class="col-md-10">
						<textarea class="form-control" id="justificacion" rows="1" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_caracteristicas">
					<label for="caracteristicas" class="col-md-2 control-label">Características:</label>
					<div class="col-md-10">
						<textarea class="form-control" id="caracteristicas" rows="1" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_cobertura">
					<label for="cobertura" class="col-md-2 control-label">Cobertura: </label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="cobertura" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_region"  style="display:none;">
					<label for="region" class="col-md-2 control-label">Regiones: </label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="region" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_municipio" style="display:none;">
					<label for="municipio" class="col-md-2 control-label">Municipios: </label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="municipio" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_localidad">
					<label for="localidad" class="col-md-2 control-label">Localidad:</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="localidad" readonly="readonly" />
					</div>
				</div>


				<div class="form-group form-group-sm" id="div_programa">
					<label for="programa" class="col-md-2 control-label">Programa EP:</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="programa" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_proyecto_ep">
					<label for="proyecto_ep" class="col-md-2 control-label">Proyecto EP:</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="proyecto_ep" readonly="readonly" />
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_acuerdo_est">
					<label for="acuerdo_est" class="col-md-2 control-label">Acciones de Gobierno Estatal: </label>
					<div class="col-md-10">
						<textarea class="form-control" rows="1" id="acuerdo_est" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_acuerdo_fed">
					<label for="acuerdo_fed" class="col-md-2 control-label">Acciones de Gobierno Federal:</label>
					<div class="col-md-10">
						<textarea class="form-control" rows="1" id="acuerdo_fed" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="form-group form-group-sm" id="div_grupo_social">
					<label for="grupo_social" class="col-md-2 control-label">Grupo Social:</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="grupo_social" readonly="readonly" />
					</div>
				</div>
				</form>
			</div>

			<!--Estudio-->
			<div id="tabs-8">
			</div>

			<!--Expediente-->
			<div id="tabs-9">
			</div>
		</div>

	</div>
</div>
@endsection
