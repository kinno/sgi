@extends('layouts.master')
@section('content')
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Catálogo de Menus</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
    			<a href="{{ route('Menu.create') }}" class="btn btn-success btn-sm">Registrar Menu</a>
    		</div>
    		<div class="col-md-4 col-md-offset-6">
		    	<form method="GET" action="{{ route('Menu.index') }}">
		    		<div class="input-group input-group-sm">
						<input type="text" name="nombre" class="form-control" placeholder="Buscar Menu . . . " maxlength="40">
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
  					<th>Menu</th>
  					<th>Submenu</th>
  					<th>Ruta</th>
  					<th class="text-center">Orden</th>
  					<th class="text-center">Acción</th>
  				</tr>
  			</thead>
  			<tbody>
  				@forelse ($menus as $menu)
	  				<tr>
	  					<td>{{ $menu->id }}</td>
	  					<td>
	  						@if ($menu->id_menu_padre == 0)
	  							{{ $menu->nombre }}
	  						@endif
	  					<td>
	  						@if ($menu->id_menu_padre != 0)
	  							{{ $menu->nombre }}
	  						@endif
	  					</td>
	  					<td>
	  						@if ($menu->id_menu_padre != 0)
	  							{{ $menu->ruta }}
	  						@endif
	  					</td>
	  					<td class="text-center">{{ $menu->orden }}</td>
	  					
	  					<td class="text-center">
	  						<a href="{{ route('Menu.edit', $menu->id ) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
	  						<button id='btnEliminar' data-id="{{ $menu->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
	  					</td>
	  				</tr>
	  			@empty
	  				<tr>
	  					<td colspan="5" class="text-center">NO EXISTEN OPCIONES</td>
	  				</tr>
  				@endforelse
  				
  			</tbody>
		</table>
		{{ $menus->links() }}
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Menu/menu-eliminar.js') }}"></script>
@endsection
