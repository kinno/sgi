@extends('layouts.master')
@section('content')
<br/>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Catálogo de Sectores</strong></h3>
	</div>
	<div class="panel-body">
    	<a href="{{ route('Sector.create') }}" class="btn btn-success" >Registrar Sector</a>
    	<hr>
    	<table class="table table-striped table-condensed">
  			<thead>
  				<tr>
  					<th>ID</th>
  					<th>Sector</th>
  					<th>Titular</th>
  					<th class="text-center">Activo</th>
  					<th class="text-center">Acción</th>
  				</tr>
  			</thead>
  			<tbody>
  				@foreach ($sectores as $sector)
	  				<tr>
	  					<td>{{ $sector->id }}</td>
	  					<td>{{ $sector->nombre }}</td>
	  					<td>
	  						@if ($sector->id_titular > 0 ) 
	  							{{ $sector->titular->titulo . ' ' . $sector->titular->nombre . ' ' . $sector->titular->apellido }}
	  						@endif
	  					</td>
	  					<td class="text-center">{{ $sector->bactivo }}</td>
	  					<td class="text-center">
	  						<a href="{{ route('Sector.edit', $sector->id ) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
	  						<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
	  					</td>
	  				</tr>
  				@endforeach
  				
  			</tbody>
		</table>
		{{ $sectores->links() }}
  	</div>
</div>

@endsection
