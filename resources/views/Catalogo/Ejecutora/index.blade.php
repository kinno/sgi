@extends('layouts.master')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Catálogo de Unidades Ejecutoras</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
    			<a href="{{ route('Ejecutora.create') }}" class="btn btn-success btn-sm">Registrar Ejecutora</a>
    		</div>
    		<div class="col-md-8 col-md-offset-2">
		    	<form class="form-horizontal" method="GET" action="{{ route('Ejecutora.index') }}">
		    		<div class="form-group form-group-sm">
			    		<label for="id_sector" class="col-md-1 control-label">Sector:</label>
						<div class="col-md-5">
							<select name="id_sector" id="id_sector" class="form-control input-sm">
								{!! $opciones['sector'] !!}
							</select>
						</div>
			    		<div class="col-md-4">
							<input type="text" name="nombre" class="form-control" placeholder="Buscar Ejecutora . . . " maxlength="150" value="{{ $request->nombre }}">
						</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-default btn-sm">Buscar&nbsp;&nbsp;<span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
						</div>
					</div>
    			</form>
    		</div>
    	</div>
    	<hr>
    	<table class="table table-striped tabla-condensada">
  			<thead>
  				<tr>
  					<th>ID</th>
  					<th>Clave</th>
  					<th style="width: 30%">Ejecutora</th>
  					<th style="width: 15%">Sector</th>
  					<th style="width: 30%">Titular</th>
  					<th class="text-center">Activo</th>
  					<th class="text-center" style="width: 8%">Acción</th>
  				</tr>
  			</thead>
  			<tbody>
  				@forelse ($ejecutoras as $ejecutora)
	  				<tr{{ ($ejecutora->bactivo == 'no')?' class=inactivo':'' }}>
	  					<td>{{ $ejecutora->id }}</td>
	  					<td>{{ $ejecutora->clave }}</td>
	  					<td>{{ $ejecutora->nombre }}</td>
	  					<td>{{ $ejecutora->sector->nombre }}</td>
	  					<td>
	  						@if ($ejecutora->id_titular > 0 ) 
	  							{{ $ejecutora->titular->titulo . ' ' . $ejecutora->titular->nombre . ' ' . $ejecutora->titular->apellido }}
	  						@endif
	  					</td>
	  					<td class="text-center">{{ $ejecutora->bactivo }}</td>
	  					<td class="text-center">
	  						<a href="{{ route('Ejecutora.edit', ['id' => $ejecutora->id, 'page' => $ejecutoras->currentPage()] ) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
	  						<button id='btnEliminar' data-id="{{ $ejecutora->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
	  					</td>
	  				</tr>
	  			@empty
	  				<tr>
	  					<td colspan="7" class="text-center">NO EXISTEN EJECUTORAS</td>
	  				</tr>
  				@endforelse
  			</tbody>
		</table>
		@if ($request->nombre != '' || $request->id_sector > 0)
			{{ $ejecutoras->appends(['id_sector' => $request->id_sector, 'nombre' => $request->nombre])->links() }}
		@else
			{{ $ejecutoras->links() }}
		@endif
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Ejecutora/ejecutora-eliminar.js') }}"></script>
@endsection
