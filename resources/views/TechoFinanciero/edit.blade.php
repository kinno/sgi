@extends('layouts.master')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><strong>Editar Monto del Techo Financiero</strong></h3>
	</div>
	<div class="panel-body">
    	<!-- <form action="{{ route('TechoFinanciero.update', $d_techo->id) }}" class="form-horizontal" role="form" id="TechoFinanciero" method="POST"> -->
        <form enctype="”multipart/form-data”" class="form-horizontal" role="form" id="TechoFinanciero">
    		{{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" id="id" value="{{ $d_techo->id }}">
            <input type="hidden" name="id_tipo_movimiento" value="{{ $d_techo->id_tipo_movimiento }}">
    		<div class="form-group form-group-sm" id="div_ejercicio">
                <label for="ejercicio" class="col-md-2 control-label">Ejercicio:</label>
                <div class="col-md-2">
                    <input type="text" id="ejercicio" class="form-control" name="ejercicio" value="{{ $d_techo->techo->ejercicio }}" readonly />
                </div>
                <label for="techo" class="col-md-1 control-label">Techo:</label>
                <div class="col-md-2">
                    <input type="text" id="techo" class="form-control numeroDecimal" name="techo" value="{{ $d_techo->techo->techo }}" readonly />
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_sector">
            	<label for="id_sector" class="col-md-2 control-label">Sector:</label>
              	<div class="col-md-4">
                    <input type="text" id="id_sector" class="form-control" name="id_sector" value="{{ $d_techo->techo->unidad_ejecutora->sector->nombre }}" readonly />
              	</div>
			</div>
            <div class="form-group form-group-sm" id="div_id_unidad_ejecutora">
                <label for="id_unidad_ejecutora" class="col-md-2 control-label">Unidad Ejecutora:</label>
                <div class="col-md-9">
                    <input type="text" id="id_unidad_ejecutora" class="form-control" name="id_unidad_ejecutora" value="{{ $d_techo->techo->unidad_ejecutora->nombre }}" readonly />
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_programa">
                <label for="programa" class="col-md-2 control-label">Programa EP:</label>
                <div class="col-md-9">
                    <input type="text" id="programa" class="form-control" name="programa" value="{{ $programa->clave.' '.$programa->nombre }}" readonly />
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_proyecto_ep">
                <label for="id_proyecto_ep" class="col-md-2 control-label">Proyecto EP:</label>
                <div class="col-md-9">
                    <input type="text" id="id_proyecto_ep" class="form-control" name="id_proyecto_ep" value="{{ $d_techo->techo->proyecto->clave.' '.$d_techo->techo->proyecto->nombre }}" readonly />
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_tipo_fuente">
                <label for="id_tipo_fuente" class="col-md-2 control-label">Tipo de Fuente:</label>
                <div class="col-md-2">
                    <input type="text" id="id_tipo_fuente" class="form-control" name="id_tipo_fuente" value="{{ $d_techo->techo->tipo_fuente->nombre }}" readonly />
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_id_fuente">
                <label for="id_fuente" class="col-md-2 control-label">Fuente:</label>
                <div class="col-md-6">
                    <input type="text" id="id_fuente" class="form-control" name="id_fuente" value="{{ $d_techo->techo->fuente->descripcion }}" readonly />
                </div>
            </div>
            <div class="form-group form-group-sm" id="grupo_monto">
                <div id="div_id_tipo_movimiento">
                    <label for="tipo_movimiento" class="col-md-2 control-label">Movimiento:</label>
                    <div class="col-md-2">
                        <input type="text" id="tipo_movimiento" class="form-control" name="tipo_movimiento" value="{{ $d_techo->movimiento->nombre }}" readonly />
                    </div>
                </div>
                <div id="div_monto">
                    <label for="monto" class="col-md-1 control-label"><span class="obligatorio">*</span>Monto:</label>
                    <div class="col-md-2">
                        <input type="text" id="monto" class="form-control numeroDecimal" name="monto" value="{{ $d_techo->monto }}" placeholder="0.00" />
                        <span id="err_monto" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm" id="div_observaciones">
                <label for="observaciones" class="col-md-2 control-label"><span class="obligatorio">*</span>Observaciones:</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="observaciones" id="observaciones" maxlength="255" rows="1">{{ $d_techo->observaciones }}</textarea>
                    <span id="err_observaciones" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
		</form>
        <!-- <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('TechoFinanciero.index') }}" class="btn btn-success btn-sm">Regresar</a>
            </div>
        </div> -->
		
  	</div>
</div>
<script src="{{ asset('js/TechoFinanciero/techofinanciero-update.js') }}"></script>
@endsection
