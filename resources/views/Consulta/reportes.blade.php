@extends('layouts.master')
@section('content')
<link href="/css/jquery-ui.css" rel="stylesheet"/>
<script src="/js/jquery-ui.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css"/>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>
<script type="text/javascript" src="{{ asset('js/Consulta/reportes.js') }}"></script>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Reportes</strong></h3>
	</div>
	<div class="panel-body">
		<div id="tabs" >
			<ul>
				<li><a href="#tabs-1">Reportes</a></li>
				<li><a href="#tabs-2">Catálogos</a></li>
				<li><a href="#tabs-3">Fechas</a></li>
				<li><a href="#tabs-4">Montos</a></li>
			</ul>
		  
			<!--Reportes-->
			<div id="tabs-1">
				<form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="Obra">
				{{ csrf_field() }}
				<div class="form-group form-group-sm">
					<label for="id_tipo_reporte" class="col-md-2 control-label">Tipo de reporte:</label>
					<div class="col-md-2">
						<select name="id_tipo_reporte" id="id_tipo_reporte" class="form-control">
							{!! $opciones['tipo_reporte'] !!}
						</select>
					</div>
				</div>
				<div class="error form-group1" id="eRpt">
				   <div class="col-sm-10"><span class="oculto">* Seleccione un reporte</span>
				   </div>
				</div>
				<table class="table table-hover table-bordered tabla-condensada" id="reportes">
					<thead>
						<tr class="header-tabla">
							<th style="width: 12%" class="text-center">Tipo</th>
							<th style="width: 18%" class="text-center">Reporte</th>
							<th style="width: 70%">Descripción</th>
						</tr>
					</thead>
					<tbody class="tabla-seleccionar">
						<tr>
							<td colspan="3"></td>
						</tr>
					</tbody>
				</table>
				<br>
				<div class="form-group form-group-sm">
					<label class="col-md-1 control-label">Titulo:</label>
					<label for="titulo" class="col-md-1 control-label">1a linea</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="titulo" id="titulo" maxlength="150"/>
					</div>
				</div>
				<div class="form-group form-group-sm" style="margin-top: -10px">
					<label for="titulo2" class="col-md-2 control-label">2a linea</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="titulo2" id="titulo2" maxlength="150" />
					</div>
				</div>
				</form>
			</div>

			<!--Catálogos-->
			<div id="tabs-2" style="height: 370px; overflow: auto">
				<!-- <div class="error form-group">
					<div class="col-sm-10"><span class="oculto1" id="eEje">* Seleccione un ejercicio</span>
					</div>
				</div> -->
				<div id="catalogos">
					<h3><strong>Ejercicio: </strong><span id="txt-ejercicio"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="ejercicio">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Ejercicio</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Fuente: </strong><span id="txt-fuente"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="fuente">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="10%">Clave</th>
									<th width="20%">Nombre</th>
									<th width="60%">Descripción</th>
									<th width="7%">Tipo</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Inversión: </strong><span id="txt-inversion"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="inversion">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Recurso: </strong><span id="txt-recurso"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="recurso">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Clasificación de la Obra: </strong><span id="txt-clasificacion"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="clasificacion">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Sector: </strong><span id="txt-sector"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="sector">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="92%">Nombre</th>
									<th width="5%" class="text-center">Activo</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>U. Ejecutora: </strong><span id="txt-ejecutora"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="ejecutora">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="55%">Nombre</th>
									<th width="27%">Sector</th>
									<th width="10%" class="text-center">Clave</th>
									<th width="5%" class="text-center">Activo</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Municipio: </strong><span id="txt-municipio"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="municipio">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Estado AP: </strong><span id="txt-estadoAP"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="estadoAP">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Estado Oficio: </strong><span id="txt-estadoOf"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="estadoOf">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Tipo AP: </strong><span id="txt-tipoAP"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="tipoAP">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Tipo Oficio: </strong><span id="txt-tipoOf"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="tipoOf">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Programa EP: </strong><span id="txt-programa"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="programa">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="7%" class="text-center">Ejercicio</th>
									<th width="82%">Nombre</th>
									<th width="8%" class="text-center">Clave</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Proyecto EP: </strong><span id="txt-proyecto"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="proyecto">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="7%" class="text-center">Ejercicio</th>
									<th width="79%">Nombre</th>
									<th width="11%" class="text-center">Clave</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Grupo Social: </strong><span id="txt-grupo"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="grupo">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<h3><strong>Modalidad Ejecución: </strong><span id="txt-ejecucion"></span></h3>
					<div>
						<table class="table table-hover tabla-condensada" id="ejecucion">
							<thead>
								<tr class="header-tabla">
									<th width="3%"><input type="checkbox" name="chkTodo" id="chkTodo"></th>
									<th width="97%">Nombre</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<br>
			</div>

			<!--Fechas-->
			<div id="tabs-3">
				
			</div>

			<!--Montos-->
			<div id="tabs-4">
			</div>

			
				<!-- <table class="table table-striped table-bordered tabla-condensada" id="pagos">
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
				</table> -->
			

		</div>

	</div>
</div>
@endsection
