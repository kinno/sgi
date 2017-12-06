<style>
    .number{
        text-align: right;
    }
</style>
@php
$totalRetenciones = $ap->icic + $ap->cmic + $ap->supervision + $ap->ispt + $ap->otro + $ap->federal_1 + $ap->federal_2 + $ap->federal_5;
$subTotal = (($ap->importe_sin_iva) - ($ap->monto_amortizacion));
// $amortizacion =$ap->monto_amortizacion + $ap->monto_iva_amortizacion;
$amortizacion =$ap->monto_amortizacion;
$afectacion = $subTotal + $ap->iva;
$importNeto = $afectacion-$totalRetenciones;
@endphp
<div class="row form-group">
    <div class="col-sm-5">
        <div class="input-group">
            <div class="input-group-addon input-sm">Folio de Autorización de Pago:</div>
            <input type="text" class="form-control input-sm" id="folio_ap" readonly="true" value="{{$ap->clave}}" />
        </div>
    </div>
    
    
</div>
<div class="row form-group">                               
</div>
<div class="row form-group">
    <div class="col-sm-2">
        <div class="input-group">
        @if ($ap->tipo_ap->id == 4)
            <div class="input-group-addon input-sm">Estimaci&oacute;n:</div>
            <input type="text" class="form-control input-sm" id="numero_estimacion" readonly="true" value="{{$ap->numero_estimacion}}" />
        @endif 
            
        </div>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Ejecutora:</div>
            <input type="text" class="form-control input-sm" id="ejecutoraAp" readonly="true" value="{{$ap->unidad_ejecutora->nombre}}" />
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-md-6">
        <div id="popRFC" title="RFC no existe">
            <div class="input-group">
                <span class="input-group-addon input-sm">
                    RFC de empresa:
                </span>
                <input class="form-control input-sm" id="rfc" name="rfc" readonly="true" type="text" value="{{$ap->empresa->rfc}}" />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon input-sm">
                Padrón del contratista:
            </span>
            <input class="form-control input-sm" id="padron_contratista" name="padron_contratista" placeholder="" type="text" readonly="true" value="{{$ap->empresa->padron_contratista}}"/>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon input-sm">
                Empresa:
            </span>
            <input class="form-control input-sm" id="nombre" name="nombre" placeholder="" type="text" readonly="true" value="{{$ap->empresa->nombre}}"/>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-8">
        <div class="input-group">
            <span class="input-group-addon input-sm">
               Nombre del respresentante:
            </span>
            <input class="form-control input-sm" id="nombre_representante" name="nombre_representante" placeholder="" type="text" readonly="true" value="{{$ap->empresa->nombre_representante}}"/>
        </div>
    </div>
    <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon input-sm">
                    Cargo:
                </span>
                <input class="form-control input-sm" id="cargo_representante" name="cargo_representante" placeholder="" type="text" readonly="true" value="{{$ap->empresa->cargo_representante}}"/>
            </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-3 ">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Obra:</div>
            <input type="text" class="form-control input-sm" id="tipo_ap" readonly="true" value="{{$ap->id_obra}}" />
        </div>
    </div>
    <div class="col-sm-5">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Modalidad de Ejecución:</div>
             <input type="text" class="form-control input-sm" id="modalidadEjecucion" readonly="true" value="{{$ap->obra->modalidad_ejecucion->nombre}}"/>
        </div>
    </div>
     {{-- <div class="col-sm-3">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Avance F&Iacute;sico:</div>
             <input type="text" class="form-control input-sm" id="avFis" value="value="{{$ap->}}"" />
        </div>
    </div> --}}
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Nombre de la Obra:</div>
             <input type="text" class="form-control input-sm" id="obra" readonly="true" value="{{$ap->obra->nombre}}"/>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Observaciones:</div>
            <textarea class="form-control input-sm" id="observaciones" readonly="true">{{nl2br($ap->observaciones)}}</textarea>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-3 col-md-offset-4">
        <div class="input-group">
            <div class="input-group-addon btn-sm">Tipo:</div>
            <input type="text" class="form-control input-sm" id="tipo_ap" readonly="true" value="{{$ap->tipo_ap->nombre}}" />
        </div>
    </div>
</div>

@if ($ap->obra->modalidad_ejecucion->id == 3)
<div class="row form-group" id="divContratos" style="display:;">
    <div class="col-md-10 col-md-offset-1">
        <div class="input-group">
            <span class="input-group-addon input-sm"><strong>Contrato:</strong></span>
            <input type="text" id="contrato" class="form-control input-sm" readonly="true" value="{{$ap->contrato->numero_contrato}}" />
        </div>
    </div>
</div>
@endif

<div class="row form-group" id="divFuentes" style="display:;">
    <div class="col-md-10 col-md-offset-1">
        <div class="input-group">
            <span class="input-group-addon input-sm"><strong>Fuente:</strong></span>
            <input type="text" id="fuente" class="form-control input-sm" readonly="true" value="{{$ap->fuente->descripcion}}"/>
        </div>
    </div>
</div>

<div id="divAfectacion" style="display: ;">
    <div class="panel panel-default">
        <div class="panel-heading">
            Aplicaci&oacute;n Presupuestal
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group form-group-sm">
                    <div class="col-sm-2 col-md-offset-1">
                        <label for="sinivaAp" class="control-label">Importe sin IVA:</label><input type="text" id="sinivaAp" class="form-control input-sm number" readonly="true" value="{{number_format($ap->importe_sin_iva,2)}}" />
                    </div>
                    <div class="col-sm-2">
                        <label for="amortizacionAp" class="control-label">Amortizaci&oacute;n:</label><input type="text" id="amortizacionAp" class="form-control input-sm number" readonly="true" value="{{number_format($amortizacion,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="icicAp" class="control-label">I.C.I.C (0.2%):</label><input type="text"  id="icicAp" readonly="true" class="form-control input-sm number" value="{{number_format($ap->icic,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="isptAp" class="control-label">ISPT:</label><input type="text" id="isptAp" readonly="true" class="form-control input-sm number" value="{{number_format($ap->ispt,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="isptAp" class="control-label">Federal (0.2%):</label><input type="text" readonly="true" id="federal02Ap" class="form-control input-sm number" value="{{number_format($ap->federal_2,2)}}"/>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-sm-2 col-md-offset-1">
                        <label for="subtotalAp" class="control-label">Subtotal:</label><input type="text" id="subtotalAp" class="form-control input-sm number" readonly="true" value="{{number_format($subTotal,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="ivaAp" class="control-label">IVA:</label><input type="text" id="ivaAp" readonly="true" class="form-control input-sm number" value="{{number_format($ap->iva,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="cmicAp" class="control-label">C.M.I.C (0.5%):</label><input type="text" readonly="true" id="cmicAp" class="form-control input-sm number" value="{{number_format($ap->cmic,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="otroAp" class="control-label">Otro:</label><input type="text" id="otroAp" readonly="true" class="form-control input-sm number" value="{{number_format($ap->otro,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="isptAp" class="control-label">Federal (0.5%):</label><input type="text" readonly="true" id="federal05Ap" class="form-control input-sm number" value="{{number_format($ap->federal_5,2)}}"/>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-sm-2 col-md-offset-1">
                        <label for="afectacionAp" class="control-label" style="font-size: 10px">Afect. Presupuestal:</label><input type="text" id="afectacionAp" class="form-control input-sm number" readonly="true" value="{{number_format($afectacion,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="netoAp" class="control-label">Importe Neto:</label><input type="text" id="netoAp" class="form-control input-sm number" readonly="true" value="{{number_format($importNeto,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="supervisionAp" class="control-label">Supervisi&oacute;n (2%):</label><input type="text" id="supervisionAp" class="form-control input-sm number" readonly="true" value="{{number_format($ap->supervision,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="isptAp" class="control-label">Federal (0.1%):</label><input type="text" id="federal01Ap" class="form-control input-sm number" readonly="true" value="{{number_format($ap->federal_1,2)}}"/>
                    </div>
                    <div class="col-sm-2">
                        <label for="totalAp" class="control-label">Total Retenciones:</label><input type="text" id="totalAp" class="form-control input-sm number" readonly="true" value="{{number_format($totalRetenciones,2)}}"/>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-sm-10 col-md-offset-1">
                        <label for="afectacionAp" class="control-label">Importe Neto con letra:</label>
                        <input type="text" id="letranetoAp" class="form-control input-sm number" readonly="true" value="{{NumeroALetras::convertir(number_format($importNeto, 2, '.', ''), 'pesos', 'centimos')}}"/>
                    </div>
                </div>
                @if ($ap->folio_amortizacion)
                    <div class="form-group form-group-sm" id="divAmortiza">
                        <div class="col-sm-10 col-md-offset-1">
                            <label for="foliosAmortizar" class="col-sm-5 control-label">Folio que amortiza:</label>
                            <div class="col-sm-3">
                                 <input type="text" id="folioAmortiza" class="form-control input-sm number" readonly="true" value="{{$ap->folio_amortizacion}}"/>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> 
{{-- {{dd($ap)}} --}}