@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Techos Financieros</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<a href="{{ route('TechoFinanciero.create') }}" class="btn btn-success btn-sm">Registrar Techo Financiero</a>
			</div>
			<div class="col-md-10">
			<form class="form-horizontal" method="GET" action="{{ asset('TechoFinanciero') }}">
				<div class="form-group form-group-sm">
				<label for="ejercicio" class="col-md-1 col-md-offset-3 control-label">Ejercicio:</label>
				<div class="col-md-2">
					<select name="ejercicio" id="ejercicio" class="form-control">
						{!! $opciones_ejercicio !!}
					</select>
				</div>
				<label for="id_sector" class="col-md-1 control-label">Sector:</label>
				<div class="col-md-3">
					<select name="id_sector" id="id_sector" class="form-control">
						{!! $opciones_sector !!}
					</select>
				</div>
				<div class="col-md-1">
				<button type="submit" class="btn btn-default btn-sm">Buscar&nbsp;&nbsp;<span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
				</div>
				</div>
			</form>
			</div>

		</div>
		<hr>
		<table class="table table-striped table-condensed" style="font-size: 0.85em">
			<thead>
				<tr>
					<th>ID</th>
					<th>Sector - Unidad Ejecutora - Proyecto - Fuente</th>
					<th>Observaciones</th>
					<th>Fecha</th>
					<th>Monto</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($montos as $monto)
					<tr {{ ($monto['clase_row'])? $monto['clase_row'] : ''}}>
						<td>{{ $monto['id'] }}</td>
						<td>{{ $monto['columna'] }}</td>
						<td>{{ $monto['observaciones'] }}</td>
						<td>{{ $monto['created_at'] }}</td>
						<td style="text-align: right;"  
							{{ ($monto['clase_numero'])? $monto['clase_numero'] : ''}}>{{ $monto['monto'] }}
						</td>
						<td class="text-center">
							@if ($monto['id'] != '')
								<a href="{{ route('TechoFinanciero.edit', $monto['id'] ) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
								@if ($monto['id_tipo_movimiento'] == '1')
									<a href="{{ route('TechoFinanciero.agregar', $monto['id'] ) }}" class="btn btn-default btn-xs btn-success"><i class="fa fa-plus"></i></a>
								@endif
								@if ($monto['n_detalle'] == '1' || $monto['id_tipo_movimiento'] != '1')
									<button id='btnEliminar' data-id="{{ $monto['id'] }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
								@endif
							@endif
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="6" class="text-center">NO EXISTEN MONTOS</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
<script src="{{ asset('js/TechoFinanciero/techofinanciero-eliminar.js') }}"></script>
@endsection
