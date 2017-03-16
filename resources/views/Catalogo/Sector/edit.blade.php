@extends('layouts.master')
@section('content')
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.9.46/autoNumeric.js">
</script> -->
<br/>  
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title text-center"><strong>Editar Sector</strong></h3>
	</div>
	<div class="panel-body">
   	    <br/>
   	    <form class="form-horizontal" method="POST" action="{{ route('Sector.update', $sector->id) }}">
   		    {{ csrf_field() }}
   		    <div class="form-group">
       	    <input type="hidden" name="_method" value="PUT">
                <label for="nombre" class="col-md-2 control-label input-sm">Nombre:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="nombre" id="nombre" value="{{ $sector->nombre }}">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="titulo" class="col-md-2 control-label input-sm">Titulo:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="titulo" id="titulo" value="{{ $titular->titulo }}">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="titular" class="col-md-2 control-label input-sm">Titular:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="titular" id="titular" value="{{ $titular->nombre }}">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="apellido" class="col-md-2 control-label input-sm">Apellidos:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="apellido" id="apellido" value="{{ $titular->apellido }}">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="cargo" class="col-md-2 control-label input-sm">Cargo:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="cargo" id="cargo" value="{{ $titular->cargo }}">
              	</div>
           	</div>
           	<div class="form-group">
    			<div class="col-md-offset-2 col-m2-3">
      				<div class="checkbox">
        				<label>
                            @if($sector->bactivo == 'si')
                                <input type="checkbox" name="bactivo" checked="checked"> Activo
                            @else
                                <input type="checkbox" name="bactivo"> Activo
                            @endif
        				</label>
      				</div>
    			</div>
  			</div>
  			<div class="form-group">
            	<label for="id_departamento" class="col-md-2 control-label input-sm">Departamento<span class="obligatorio"> *</span></label>
              	<div class="col-md-2">
                	<select name="id_departamento" id="id_departamento" class="form-control input-sm">
                    	<option value="1">Depto 1</option>
                 	</select>
              	</div>
            </div>
            <br/>
            <div class="form-group">
               	<div class="col-md-2 col-md-offset-2">
                	<button type="submit" class="btn btn-success btn-sm">Guardar</button>
                </div>
            </div>
		</form>		
  	</div>
</div>
@endsection
