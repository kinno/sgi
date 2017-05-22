@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Catálogo de Sectores</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
    			<a href="{{ route('Sector.create') }}" class="btn btn-success btn-sm">Registrar Sector</a>
    		</div>
    		<div class="col-md-4 col-md-offset-6">
		    	<form method="GET" action="{{ route('Sector.index') }}">
		    		<div class="input-group input-group-sm">
						<input type="text" name="nombre" class="form-control" placeholder="Buscar Sector . . . " maxlength="40" value="{{ $request->nombre }}">
						<span class="input-group-btn">
					    	<button type="submit" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					    </span>
					</div>
				</form>
			</div>
    	</div>
    	<hr>
    	<table class="table table-striped tabla-condensada">
  			<thead>
  				<tr>
  					<th>ID</th>
  					<th>Sector</th>
  					<th>Clave</th>
  					<th>Titular</th>
  					<th class="text-center">Activo</th>
  					<th class="text-center">Acción</th>
  				</tr>
  			</thead>
  			<tbody>
  				@forelse ($sectores as $sector)
	  				<tr>
	  					<td>{{ $sector->id }}</td>
	  					<td>{{ $sector->nombre }}</td>
	  					<td>{{ $sector->clave }}</td>
	  					<td>
	  						@if ($sector->id_titular > 0 ) 
	  							{{ $sector->titular->titulo . ' ' . $sector->titular->nombre . ' ' . $sector->titular->apellido }}
	  						@endif
	  					</td>
	  					<td class="text-center">{{ $sector->bactivo }}</td>
	  					<td class="text-center">
	  						<a href="{{ route('Sector.edit', ['id' => $sector->id, 'page' => $sectores->currentPage()]) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
	  						<button id='btnEliminar' data-id="{{ $sector->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
	  					</td>
	  				</tr>
	  			@empty
	  				<tr>
	  					<td colspan="6" class="text-center">NO EXISTEN SECTORES</td>
	  				</tr>
  				@endforelse
  				
  			</tbody>
		</table>
		@if ($request->nombre != '')
			{{ $sectores->appends('nombre', $request->nombre)->links() }}
		@else
			{{ $sectores->links() }}
		@endif
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Sector/sector-eliminar.js') }}"></script>
@endsection
