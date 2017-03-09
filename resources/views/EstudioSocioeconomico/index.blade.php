@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.9.46/autoNumeric.js">
</script>
<div class="panel">
	<div class="row">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<p class="navbar-text">
						No. Banco de Proyectos:
					</p>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input class="form-control text-right num" id="numerobanco" name="numerobanco" placeholder="Buscar" type="text" value="">
						</input>
					</div>
					<button class="btn btn-primary" data-target="#modalMostrarD" data-toggle="modal" id="mostraredit">
						Mostrar Datos
					</button>
					<button class="btn btn-primary" id="btnRefresh" type="button">
						Limpiar
					</button>
					<button class="btn btn-primary" id="btnGuardar" type="button">
						Guardar
					</button>
				</form>
			</div>
		</div>
	</nav>
	<input type="text" id="hojaActual" name="hojaActual" value="1">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="active" id="panel1">
			<a data-toggle="tab" href="#h1" role="tab">
				Hoja 1
			</a>
		</li>
		<li id="panel2">
			<a data-toggle="tab" href="#h2" role="tab">
				Hoja 2
			</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="h1">
			<div class="content">
				@include('EstudioSocioeconomico.hoja1_estudio_socioeconomico')
			</div>
		</div>
		<div class="tab-pane" id="h2">
			<div class="content">
				@include('EstudioSocioeconomico.hoja2_estudio_socioeconomico')
			</div>
		</div>
	</div>
</div>
</div>
{{--
<div id="containerBotones" style="width: 400px;height: 50px;padding: 5px;position: fixed; bottom:50px; right: 50px;opacity: 0.4;background-color: #DFF0D8;z-index: 99;">
	--}}
    {{--
    <span class="btn btn-default" id="btnAtras" style="display:none;">
        << Anterior
    </span>
    --}}
    {{--
    <span class="btn btn-default" id="btnSiguiente">
        Siguiente >>
    </span>
    --}}
    {{--
    <span class="btn btn-default" id="btnGuardarParcial">
        Guardar
    </span>
    --}}
    {{--
    <span class="btn btn-default" id="btnFirmar">
        Enviar para dictaminar
    </span>
    --}}
    {{--
    <span class="btn btn-default" id="btnImpIngreso" onclick="">
        Imprimir ficha de ingreso
    </span>
    --}}
    {{--
    <input id="pagSiguiente" type="hidden">
    --}}
    {{--
    </input>
</div>
--}}
<script src="{{ asset('js/estudio_socioeconomico/main_estudio_socioeconomico.js') }}"/>
<script src="{{ asset('js/estudio_socioeconomico/hoja1_estudio_socioeconomico.js') }}">
</script>
<script src="{{ asset('js/estudio_socioeconomico/hoja2_estudio_socioeconomico.js') }}">
</script>
@endsection
