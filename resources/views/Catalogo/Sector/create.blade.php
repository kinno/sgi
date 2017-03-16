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
		<h3 class="panel-title text-center"><strong>Agregar Sector</strong></h3>
	</div>
	<div class="panel-body">
    	<br/>
    	<form class="form-horizontal" role="form" method="POST" action="{{ route('Sector.store') }}">
    		{{ csrf_field() }}
    		<div class="form-group">
            	<label for="id_area" class="col-md-2 control-label input-sm">Area<span class="obligatorio"> *</span></label>
              	<div class="col-md-6">
                	<select name="id_area" id="id_area" class="form-control input-sm">
                    	{!! $opciones_area !!}
                 	</select>
              	</div>
			</div>
			<div class="form-group {{ $errors->has('id_departamento') ? ' has-error' : '' }}">
            	<label for="id_departamento" class="col-md-2 control-label input-sm">Departamento<span class="obligatorio"> *</span></label>
              	<div class="col-md-6">
                	<select name="id_departamento" id="id_departamento" class="form-control input-sm">
                    	<option value="0">- Selecciona </option>
                 	</select>
                    @if ($errors->has('id_departamento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('id_departamento') }}</strong>
                        </span>
                    @endif
              	</div>
			</div>
    		<div class="form-group">
            	<label for="nombre" class="col-md-2 control-label input-sm">Sector:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="nombre" id="nombre">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="titulo" class="col-md-2 control-label input-sm">Titulo:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="titulo" id="titulo">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="titular" class="col-md-2 control-label input-sm">Titular:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="titular" id="titular">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="apellido" class="col-md-2 control-label input-sm">Apellidos:</label>
            	<div class="col-md-4">
                	<input type="text" class="form-control input-sm" name="apellido" id="apellido">
              	</div>
           	</div>
           	<div class="form-group">
            	<label for="cargo" class="col-md-2 control-label input-sm">Cargo:</label>
            	<div class="col-md-6">
                	<input type="text" class="form-control input-sm" name="cargo" id="cargo">
              	</div>
           	</div>
           	<div class="form-group">
    			<div class="col-md-offset-2 col-m2-3">
      				<div class="checkbox">
        				<label>
          				<input type="checkbox" name="bactivo" id="bactivo"> Activo
        				</label>
      				</div>
    			</div>
  			</div>
           <br/>
           	<div class="form-group">
	           	<div class="col-md-6 col-md-offset-2">
	            	<button type="submit" class="btn btn-success btn-sm">Registrar</button>
	            </div>
        	</div>
		</form>
		
  	</div>
</div>
<script src="{{ asset('js/Catalogo/Sector/sector.js') }}">
	
</script>
@endsection
