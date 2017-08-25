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

<!-- obra, ejercicio de cada tab -->
<script id="obra-template" type="text/x-handlebars-template">
	<div class="row">
		<label class="col-md-2 label-lectura">No. de Obra:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura numero" readonly="readonly" value="@{{id_obra}}"/>
		</div>
		<label class="col-md-1 label-lectura">Ejercicio:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{ejercicio}}"/>
		</div>
	</div>
</script>

<!-- detalle de obras (montos) -->
<script id="montos-template" type="text/x-handlebars-template">
	<br />
	<span class="label label-default">Obra: @{{id_obra}}</span>
	<br />
	<table class="table table-bordered table-striped tabla-condensada2" style="margin-bottom: 0 !important">
		<thead>
			<tr class="label-default">
				<th style="width: 10%" class="text-center">Asignado</th>
				<th style="width: 10%" class="text-center">Autorizado</th>
				<th style="width: 10%" class="text-center">Ejercido</th>
				<th style="width: 10%" class="text-center">Por Ejercer</th>
				<th style="width: 10%" class="text-center">Anticipo</th>
				<th style="width: 10%" class="text-center">Retenciones</th>
				<th style="width: 10%" class="text-center">Comprobado</th>
				<th style="width: 10%" class="text-center">Por comprobar</th>
				<th style="width: 10%" class="text-center">Pagado</th>
				<th style="width: 10%" class="text-center">Por pagar</th>
			</tr>
		</thead>
		<tr class="numeroDecimal">
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
	<span class="label label-default">Fuente: @{{clave}} - @{{descripcion}}</span>
	<table class="table table-bordered table-striped tabla-condensada2" style="margin-bottom: 0 !important">
		<tr class="numeroDecimal">
			<td style="width: 10%">@{{pivot.asignado }}</td>
			<td style="width: 10%">@{{pivot.autorizado}}</td>
			<td style="width: 10%">@{{pivot.ejercido}}</td>
			<td style="width: 10%">@{{pivot.por_ejercer}}</td>
			<td style="width: 10%">@{{pivot.anticipo}}</td>
			<td style="width: 10%">@{{pivot.retenciones}}</td>
			<td style="width: 10%">@{{pivot.comprobado}}</td>
			<td style="width: 10%">@{{pivot.por_comprobar}}</td>
			<td style="width: 10%">@{{pivot.pagado}}</td>
			<td style="width: 10%">@{{pivot.por_pagar}}</td>
		</tr>
	</table>
	@{{/each}}
	<br />
</script>

<!-- detalle de oficios -->
<script id="oficios-template" type="text/x-handlebars-template">
	<div class="row" style="margin-top: 3px">
		<label class="col-md-2 label-lectura">Firma:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_firma}}"/>
		</div>
		<label class="col-md-2 label-lectura">TAT:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{tarjeta_turno}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-2 label-lectura">Titular:</label>
		<div class="col-md-9">
			<textarea class="form-lectura" rows="1" readonly="readonly">@{{titular}}
			</textarea>
		</div>
	</div>
	<span class="label label-default">Detalle del Oficio</span>
	<table id="det-oficios-@{{id}}" class="table table-bordered table-striped tabla-condensada2">
		<thead>
			<tr class="label-default">
				<th style="width: 30%" class="text-center">Unidad Ejecutora</th>
				<th style="width: 20%" class="text-center">Fuente</th>
				<th style="width: 20%" class="text-center">Tipo</th>
				<th style="width: 15%" class="numeroDecimal">Asignado</th>
				<th style="width: 15%" class="numeroDecimal">Autorizado</th>
			</tr>
		</thead>
	</table>
	<br />
</script>

<!-- detalle de aps -->
<script id="aps-template" type="text/x-handlebars-template">

	<span class="label label-default">Detalle de la Autorización de Pago: @{{clave}}</span>
	<br />
	@{{#if contrato}}
		<div class="row">
			<label class="col-md-2 label-lectura">No. Estimación:</label>
			<div class="col-md-2">
				<input type="text" class="form-lectura" readonly="readonly" value="@{{numero_estimacion}}"/>
			</div>
		</div>    	
	@{{/if}}
	<div class="row">
		<label class="col-md-2 label-lectura">Unidad Ejecutora:</label>
		<div class="col-md-9">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{unidad_ejecutora.nombre}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-2 label-lectura">Sector:</label>
		<div class="col-md-5">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{sector.nombre}}"/>
		</div>
	</div>
	@{{#if contrato}}
		<div class="row">
			<label class="col-md-2 label-lectura">Contrato:</label>
			<div class="col-md-4">
				<input type="text" class="form-lectura" readonly="readonly" value="@{{contrato.numero_contrato}}"/>
			</div>
		</div>    	
	@{{/if}}
	<div class="row">
		<label class="col-md-2 label-lectura">Beneficiario:</label>
		<div class="col-md-9">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{empresa.nombre}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-2 label-lectura">Creación:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_creacion}}"/>
		</div>
		<label class="col-md-2 label-lectura">Recepción:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_recepcion}}"/>
		</div>
		<label class="col-md-1 label-lectura">Validación:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_validacion}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-2 label-lectura">Envío:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_envio}}"/>
		</div>
		<label class="col-md-2 label-lectura">Recepción Tesorería:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_recepcion_tesoreria}}"/>
		</div>
		<label class="col-md-1 label-lectura">Programación:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_programacion_tesoreria}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-2 label-lectura">Entrega:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{fecha_entrega}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-2 label-lectura">Observaciones:</label>
		<div class="col-md-9">
			<textarea class="form-lectura" rows="1" readonly="readonly">@{{observaciones}}
			</textarea>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">Importe sin IVA:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{importe_sin_iva}}"/>
		</div>
		<label class="col-md-3 label-lectura">0.2% I.C.I.C.:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{icic}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">Amortización de anticipo:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{monto_amortizacion}}"/>
		</div>
		<label class="col-md-3 label-lectura">0.5% C.M.I.C:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{cmic}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">Subtotal:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{subtotal}}"/>
		</div>
		<label class="col-md-3 label-lectura">2% de supervisión:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{supervision}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">I.V.A.:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{iva}}"/>
		</div>
		<label class="col-md-3 label-lectura">ISPT:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{ispt}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">Importe de la afectación presupuestal:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{monto}}"/>
		</div>
		<label class="col-md-3 label-lectura">Federal (0.1%):</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{federal_1}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">Retenciones:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{retenciones}}"/>
		</div>
		<label class="col-md-3 label-lectura">Federal (0.2%):</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{federal_2}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-3 label-lectura">Neto:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{neto}}"/>
		</div>
		<label class="col-md-3 label-lectura">Federal (0.5%):</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{federal_5}}"/>
		</div>
	</div>
	<div class="row">
		<label class="col-md-offset-5 col-md-3 label-lectura">Otro:</label>
		<div class="col-md-2">
			<input type="text" class="form-lectura" readonly="readonly" value="@{{otro}}"/>
		</div>
	</div>
	
	<br />
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
									<label for="nombre_search" class="col-md-3 control-label">Nombre de la Obra:</label>
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

				<table class="table table-striped table-bordered tabla-condensada" id="obras">
					<thead>
						<tr class="header-tabla">
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
				<div id="obra-3">
				</div>
				<table class="table table-striped table-bordered tabla-condensada" id="oficios">
					<thead>
						<tr class="header-tabla">
							<th style="width: 4%"></th>
							<th style="width: 10%" class="text-center">Oficio</th>
							<th style="width: 10%" class="text-center">Fecha</th>
							<th style="width: 10%" class="text-center">Estado</th>
							<th style="width: 26%" class="text-center">Tipo</th>
							<th style="width: 10%" class="text-center">Recurso</th>
							<th style="width: 15%" class="numeroDecimal">Asignado</th>
							<th style="width: 15%" class="numeroDecimal">Autorizado</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th colspan="8" class="text-center" style="font-weight: unset">No existe información</th>
						</tr>
					</tbody>
				</table>
			</div>

			<!--APs-->
			<div id="tabs-4">
				<div id="obra-4">
				</div>
				<table class="table table-striped table-bordered tabla-condensada" id="aps">
					<thead>
						<tr class="header-tabla">
							<th style="width: 3%"></th>
							<th style="width: 7%" class="text-center">AP</th>
							<th style="width: 7%" class="text-center">Referencia</th>
							<th style="width: 10%" class="text-center">Tipo</th>
							<th style="width: 9%" class="text-center">Estado</th>
							<th style="width: 15%" class="text-center">Fuente</th>
							<th style="width: 12%" class="numeroDecimal">Afectación</th>
							<th style="width: 12%" class="numeroDecimal">Amortización</th>
							<th style="width: 13%" class="numeroDecimal">Iva Amortización</th>
							<th style="width: 12%" class="numeroDecimal">Pagado</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th colspan="10" class="text-center" style="font-weight: unset">No existe información</th>
						</tr>
					</tbody>
				</table>
			</div>

			<!--Pagos-->
			<div id="tabs-5">
				<div id="obra-5">
				</div>
				<table class="table table-striped table-bordered tabla-condensada" id="pagos">
					<thead>
						<tr class="header-tabla">
							<th style="width: 10%" class="text-center">AP</th>
							<th style="width: 25%" class="text-center">Fuente</th>
							<th style="width: 8%" class="text-center">Serie</th>
							<th style="width: 8%" class="text-center">Adefa</th>
							<th style="width: 15%" class="text-center">Cheque</th>
							<th style="width: 15%" class="text-center">Fecha</th>
							<th style="width: 19%" class="numeroDecimal">Monto</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th colspan="6" class="text-center" style="font-weight: unset">No existe información</th>
						</tr>
					</tbody>
				</table>
			</div>

			<!--Contratos-->
			<div id="tabs-6">
			</div>

			<!--Datos-->
			<div id="tabs-7">
				<form class="form-horizontal" role="form" id="datos">
				<div class="row">
					<label for="id_obra" class="col-md-2 label-lectura">No. de Obra:</label>
					<div class="col-md-2">
						<input type="text" class="form-lectura numero" id="id_obra" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="modalidad_ejecucion" class="col-md-2 label-lectura">Modalidad de Ejecución:</label>
					<div class="col-md-2">
						<input type="text" class="form-lectura" id="modalidad_ejecucion" readonly="readonly" />
					</div>
					<label for="ejercicio" class="col-md-2 label-lectura">Ejercicio:</label>
					<div class="col-md-2">
						<input type="text" class="form-lectura" id="ejercicio" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="clasificacion_obra" class="col-md-2 label-lectura">Clasificación de la Obra:</label>
					<div class="col-md-2">
						<input type="text" class="form-lectura" id="clasificacion_obra" readonly="readonly" />
					</div>
					<label for="tipo_obra" class="col-md-2 label-lectura">Tipo de Obra:</label>
					<div class="col-md-2">
						<input type="text" class="form-lectura" id="tipo_obra" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="sector" class="col-md-2 label-lectura">Sector:</label>
					<div class="col-md-4">
						<input type="text" class="form-lectura" id="sector" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="unidad_ejecutora" class="col-md-2 label-lectura">Unidad Ejecutora:</label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="unidad_ejecutora" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="nombre" class="col-md-2 label-lectura">Nombre de la Obra:</label>
					<div class="col-md-10">
						<textarea class="form-lectura" id="nombre" rows="1" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="row">
					<label for="justificacion" class="col-md-2 label-lectura">Justificación:</label>
					<div class="col-md-10">
						<textarea class="form-lectura" id="justificacion" rows="1" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="row">
					<label for="caracteristicas" class="col-md-2 label-lectura">Características:</label>
					<div class="col-md-10">
						<textarea class="form-lectura" id="caracteristicas" rows="1" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="row" id="div_cobertura">
					<label for="cobertura" class="col-md-2 label-lectura">Cobertura: </label>
					<div class="col-md-3">
						<input type="text" class="form-lectura" id="cobertura" readonly="readonly" />
					</div>
				</div>
				<div class="row" id="div_region"  style="display:none;">
					<label for="region" class="col-md-2 label-lectura">Regiones: </label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="region" readonly="readonly" />
					</div>
				</div>
				<div class="row" id="div_municipio" style="display:none;">
					<label for="municipio" class="col-md-2 label-lectura">Municipios: </label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="municipio" readonly="readonly" />
					</div>
				</div>
				<div class="row" id="div_localidad">
					<label for="localidad" class="col-md-2 label-lectura">Localidad:</label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="localidad" readonly="readonly" />
					</div>
				</div>

				<div class="row" id="por_asignar">
					<label class="col-md-2 label-lectura">Para Oficio:</label>
					<div class="col-md-8">
						<table class="table table-striped table-bordered tabla-condensada" id="fuentes">
							<thead>
								<tr class="label-default">
									<th style="width: 20%">Monto</th>
									<th style="width: 35%" class="text-center">Fuente</th>
									<th style="width: 10%">Partida</th>
									<th style="width: 35%">No. Cuenta</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th colspan="4" class="text-center" style="font-weight: unset">No existe información</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="row">
					<label for="programa" class="col-md-2 label-lectura">Programa EP:</label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="programa" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="proyecto_ep" class="col-md-2 label-lectura">Proyecto EP:</label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="proyecto_ep" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<label for="acuerdo_est" class="col-md-2 label-lectura">Acciones de Gobierno Estatal: </label>
					<div class="col-md-10">
						<textarea class="form-lectura" rows="1" id="acuerdo_est" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="row">
					<label for="acuerdo_fed" class="col-md-2 label-lectura">Acciones de Gobierno Federal:</label>
					<div class="col-md-10">
						<textarea class="form-lectura" rows="1" id="acuerdo_fed" readonly="readonly"></textarea>
					</div>
				</div>
				<div class="row">
					<label for="grupo_social" class="col-md-2 label-lectura">Grupo Social:</label>
					<div class="col-md-10">
						<input type="text" class="form-lectura" id="grupo_social" readonly="readonly" />
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
