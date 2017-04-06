@extends('layouts.master')
@section('content')
<br/>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Catálogo de Unidades Ejecutoras</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
    			<a href="{{ route('Ejecutora.create') }}" class="btn btn-success btn-sm">Registrar Ejecutora</a>
    		</div>
    		<div class="col-md-5 col-md-offset-5">
		    	<form method="GET" action="{{ route('Ejecutora.index') }}">
		    		<div class="input-group input-group-sm">
						<input type="text" name="nombre" class="form-control" placeholder="Buscar Ejecutora . . . " maxlength="150">
						<span class="input-group-btn">
					    	<button type="submit" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					    </span>
					</div>
    			</form>
    		</div>
    	</div>
    	<hr>
    	<table class="table table-striped table-condensed">
  			<thead>
  				<tr>
  					<th>ID</th>
  					<th>Clave</th>
  					<th>Ejecutora</th>
  					<th>Sector</th>
  					<th>Titular</th>
  					<th class="text-center">Activo</th>
  					<th class="text-center">Acción</th>
  				</tr>
  			</thead>
  			<tbody>
  				@forelse ($ejecutoras as $ejecutora)
	  				<tr>
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
	  						<a href="{{ route('Ejecutora.edit', $ejecutora->id ) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
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
		{{ $ejecutoras->links() }}
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Ejecutora/ejecutora-eliminar.js') }}"></script>
@endsection
