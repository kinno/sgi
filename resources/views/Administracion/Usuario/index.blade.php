@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Catálogo de Usuarios</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
    			<a href="{{ route('Usuario.create') }}" class="btn btn-success btn-sm">Registrar Usuario</a>
    		</div>
    		<div class="col-md-4 col-md-offset-6">
		    	<form method="GET" action="{{ route('Usuario.index') }}">
		    		<div class="input-group input-group-sm">
						<input type="text" name="name" class="form-control" placeholder="Buscar Usuario . . . " maxlength="255">
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
  					<th>Nombre</th>
  					<th>Correo</th>
  					<th>Tipo</th>
  					<th class="text-center">Activo</th>
  					<th class="text-center">Acción</th>
  				</tr>
  			</thead>
  			<tbody>
  				@forelse ($usuarios as $usuario)
	  				<tr>
	  					<td>{{ $usuario->id }}</td>
	  					<td>{{ $usuario->username }}</td>
	  					<td>{{ $usuario->name }}</td>
	  					<td>{{ $usuario->email }}</td>
	  					<td>{{ $usuario->tipo_usuario->nombre }}</td>
	  					<td class="text-center">{{ $usuario->bactivo }}</td>
	  					<td class="text-center">
	  						<a href="{{ route('Usuario.edit', $usuario->id ) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
	  						<button id='btnEliminar' data-id="{{ $usuario->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
	  					</td>
	  				</tr>
	  			@empty
	  				<tr>
	  					<td colspan="8" class="text-center">NO EXISTEN USUARIOS</td>
	  				</tr>
  				@endforelse
  				
  			</tbody>
		</table>
		{{ $usuarios->links() }}
  	</div>
</div>
<script src="{{ asset('js/Administracion/Usuario/usuario-eliminar.js') }}"></script>
@endsection
