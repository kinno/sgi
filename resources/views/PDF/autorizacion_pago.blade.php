
<html>
<head>
  <style>
      @font-face {
        font-family: gotham-book;
        src: url({{ asset('fonts/Gotham-Book.ttf') }}) format("truetype");
        
        }
        @font-face {
           
            font-family: gotham-medium;
            src: url({{ asset('fonts/GothamHTF-Bold.ttf') }}) format("truetype");
        }
    @page { margin: 70px 10px; }
    html{
    font-family: gotham-book ;

    }
    .header,
    .footer {
        width: 100%;
        text-align: center;
        position: fixed;
    }
    .header {
        top: -50px;
    }
    .footer {
        bottom: 50px;
    }
   table {border-collapse: collapse; font-size: 10px;}
    .blank{ height: 10px;}
    .negrita{font-family: gotham-medium !important;}
    .head,.cifras{background-color: #aaa7a7; text-align:center;}
    .formulas{text-align: right;}
  </style>
</head>
<body>
 <div class="header">
   <table border="0" style="width: 100%;">
        <tr>
            <td><img src="{{URL::asset('/images/gem_hztl.jpg')}}" width="150" /></td>
        <td></td>
       
            <td valign="top" class="negrita" style="text-align: right;">SECRETARÍA DE FINANZAS<br>SUBSECRETARÍA DE PLANEACIÓN Y PRESUPUESTO<br>DIRECCIÓN GENERAL DE INVERSIÓN</td>
        </tr>
    </table> 
</div>
<div class="footer">
    <table border="1"   style="width: 100%; text-align: center;" cellpadding="5">
        <tr>
            <td style="width: 33%">BENEFICIARIO<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td>
            <td style="width: 33%">AUTORIZ&Oacute; LA DEPENDENCIA EJECUTORA<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td>
            <td style="width: 34%">Vo. Bo. DE LA SECRETAR&Iacute;A DE FINANZAS<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td>
        </tr>
    </table>
</div>
 
  <main class="main">
    <div>
        <table border="0" style="width: 100%;" cellpadding="5">
            <tbody>
                <tr>
                    <td colspan="2">
                        <table width="100%" class="head"><tr><td style="font-size: 14;text-align: center !important;">Programa de Acciones para el Desarollo - Autorización de Pago</td></tr></table>
                        <br>

                        <table border="1" style="width:100%; text-align: center;">
                            <tr>
                                <td style="width:15%">EJERCICIO FISCAL <br> {{$ap->ejercicio}} </td>
                                <td style="width:65%">UNIDAD EJECUTORA <br>{{$ap->unidad_ejecutora->nombre}}</td>
                                <td colspan="4" style="text-align:left !important; width:20%">FOLIO: {{$ap->clave}}</td>
                            </tr>
                            <tr>
                                <td rowspan="2">N&Uacute;MERO DE OBRA <br>{{$ap->id_obra}}</td>
                                <td rowspan="2">NOMBRE DE LA OBRA O ACCI&Oacute;N <br>{{$ap->obra->nombre}}</td>
                                <td class="head">FECHA</td><td class="head">D&Iacute;A</td>
                                <td class="head">MES</td>
                                <td class="head">A&Ntilde;O</td>
                            </tr>
                            <tr>
                                <td >INGRESO</td>
                                <td colspan="3"><p></p></td>
                            </tr>
                        </table>                        
                    </td>
                </tr>
                <tr>
                    {{-- Izquierda --}}
                    <td style="width: 50%;" valign="top">
                        
                           
                        <table border="1" style="width: 100%; text-align: center;" cellpadding="5">
                            <tr>
                                <td colspan="4" class="head">{{-- PARTIDA PRESUPUESTAL:   --}} SECTOR: {{$ap->sector->nombre}}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center">CONCEPTO DE PAGO: {{$ap->tipo_ap->nombre}}</td>
                                <td colspan="2" style="text-align:center">PRESPUESTO AUTORIZADO: ${{number_format($ap->obra->autorizado,2)}}</td>
                            </tr>

                            <tr>
                                <td colspan="4" class="head negrita">LISTADO DE MOVIMIENTOS</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table style="width:100%; text-align: center;" cellpadding="5">
                                        <tr><td>FUENTE</td><td>CUENTA</td></tr>
                                        <tr><td>{{$ap->fuente->descripcion}}</td><td>--</td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td  border="1" style="width:100%" colspan="4">OBRA EJECUTADA POR: <span class="negrita">{{$ap->obra->modalidad_ejecucion->nombre}}</span></td>
                            </tr>
                            <tr>
                                <td  border="1" style="width:40%">No. DE CONTRATO</td>
                                <td  border="1" style="width:10%">INICIO</td>
                                <td  border="1" style="width:10%">FIN</td>
                                <td  border="1" style="width:40%">IMPORTE</td>
                            </tr>
                            <tr>
                                <td  border="0" >
                                    @if ($ap->id_contrato)
                                        {{$ap->contrato->numero_contrato}}   
                                    @endif
                                </td>
                                <td  border="0" >
                                   @if ($ap->id_contrato)
                                    {{Carbon\Carbon::parse($ap->contrato->d_contrato->fecha_inicio)->format('d-m-Y')}}
                                    @endif</td>
                                <td  border="0" >
                                    @if ($ap->id_contrato)
                                      {{Carbon\Carbon::parse($ap->contrato->d_contrato->fecha_fin)->format('d-m-Y')}}
                                    @endif</td>
                                <td  border="0" >
                                    @if ($ap->id_contrato)
                                     ${{number_format($ap->contrato->monto,2)}}
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <br>
                        @if ($ap->folio_amortizacion)
                            <table border="1" style="width:100%" cellpadding="5">
                                <tr class="head negrita">
                                    <td >AMORTIZACIÓN</td>
                                </tr>
                            </table>
                            <table border="1" style="width:100%; text-align: center;" cellpadding="5">
                                <tr>
                                    <td>FOLIO QUE AMORTIZA</td>
                                    <td>I.V.A. DE LA AMORTIZACIÓN</td>
                                </tr>
                                <tr>
                                    <td>{{$ap->folio_amortizacion}}</td>
                                    <td>${{ number_format($ap->monto_iva_amortizacion,2)}}</td>
                                </tr>
                            </table>'
                        @endif
                       
                        <table  border="1" style="width: 100%;"" cellpadding="5">
                            <tr><td class="head" colspan="2" >DATOS DE BENEFICIARIO</td></tr>
                            <tr><td  style="width:70%">NOMBRE: {{$ap->empresa->nombre}}</td><td style="width:30%">R.F.C.: {{$ap->empresa->rfc}}</td></tr>
                            <tr><td class="head" colspan="2" >OBSERVACIONES</td></tr>
                            <tr><td colspan="2" style="font-size:6.5px;" >{{$ap->observaciones}}</td></tr>
                        </table>
                        <br>

                        <table class="conBorde" border="1" style="width: 100%;" cellpadding="5">
                            <tr>
                                <td rowspan="2">RECIBI&Oacute;<p class="info">&nbsp;</p></td>
                                <td rowspan="2">ANALIZ&Oacute;<p class="info">&nbsp;</p></td>
                                <td rowspan="2">REVIS&Oacute;<p class="info">&nbsp;</p></td>
                                <td colspan="4">RELACI&Oacute;N DE ENV&Iacute;O</td>
                            </tr>
                            <tr>
                                <td>No.</td>
                                <td>D&Iacute;A</td>
                                <td>MES</td>
                                <td>A&Ntilde;O</td>
                            </tr>
                        </table>
                       
                    </td>
                    {{-- Derecha --}}
                    @php
                        $totalRetenciones = $ap->icic + $ap->cmic + $ap->supervision + $ap->ispt + $ap->otro + $ap->federal_1 + $ap->federal_2 + $ap->federal_5;
                        $subTotal = (($ap->importe_sin_iva) - ($ap->monto_amortizacion));
                        // $amortizacion =$ap->monto_amortizacion + $ap->monto_iva_amortizacion;
                        $amortizacion =$ap->monto_amortizacion;
                        $afectacion = $subTotal + $ap->iva;
                        $importNeto = $afectacion-$totalRetenciones;
                    @endphp
                    <td style="width: 50%;" valign="top">
                        <table class="aplicacion conBorde" border="1" style="width: 100%" cellpadding="5">
                            <tr>
                                <td colspan="3" class="head">APLICACI&Oacute;N PRESUPUESTAL</td>
                            </tr>
                            <tr>
                                <td style="width:50%">IMPORTE SIN IVA</td>
                                <td class="formulas">(A)</td>
                                <td style="width:30%; text-align:right" class="cifras">${{number_format($ap->importe_sin_iva,2)}}</td>
                            </tr>
                            <tr>
                                <td>AMORTIZACI&Oacute;N DE ANTICIPO</td>
                                <td class="formulas">(B)</td>
                                <td style="text-align:right" class="cifras">${{number_format($amortizacion,2)}}</td>
                            </tr>
                            <tr>
                                <td>SUBTOTAL</td>
                                <td class="formulas">(C)=(A-B)</td>
                                <td style="text-align:right" class="cifras">${{number_format($subTotal,2)}}</td>
                            </tr>
                            <tr>
                                <td>I.V.A.</td>
                                <td class="formulas">(D)</td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->iva,2)}}</td>
                            </tr>
                            <tr>
                                <td>AFECTACI&Oacute;N PRESUPUESTAL</td>
                                <td class="formulas">(E)=(C+D)</td>
                                <td style="text-align:right" class="cifras">${{number_format($afectacion,2)}}</td>
                            </tr>
                            <tr>
                                <td>RETENCIONES</td>
                                <td class="formulas">(F)</td>
                                <td style="text-align:right" class="cifras">${{number_format($totalRetenciones,2)}}</td>
                            </tr>
                            <tr>
                                <td>0.2% I.C.I.C.</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->icic,2)}}</td>
                            </tr>
                            <tr>
                                <td>0.5% C.M.I.C.</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->cmic,2)}}</td>
                            </tr>
                            <tr>
                                <td>2% DE SUPERVISI&Oacute;N</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->supervision,2)}}</td>
                            </tr>
                            <tr>
                                <td>ISPT</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->ispt,2)}}</td>
                            </tr>
                            <tr>
                                <td>0.1% FEDERAL</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->federal_1,2)}}</td>
                            </tr>
                            <tr>
                                <td>0.2% FEDERAL</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->federal_2,2)}}</td>
                            </tr>
                            <tr>
                                <td>0.5% FEDERAL</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->federal_5,2)}}</td>
                            </tr>
                            <tr>
                                <td>OTRO</td>
                                <td class="formulas"></td>
                                <td style="text-align:right" class="cifras">${{number_format($ap->otro,2)}}</td>
                            </tr>
                        </table>
                   
                    <table class="aplicacion conBorde" border="1" style="width: 100%; margin-top:10px;" cellpadding="5">
                        <tr>
                            <td  style="width:50%">IMPORTE NETO A PAGAR (PESOS)</td>
                            <td class="formulas">(G)=(E-F)</td>
                            <td style="width:30%; text-align:right;" class="cifras">${{number_format($importNeto,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="head" style="text-align:left">CANTIDAD CON LETRA: <span class="negrita">{{NumeroALetras::convertir($importNeto, 'de pesos', 'centimos')}}</span></td>
                        </tr>
                    </table>
                    <p></p>
                    
                    </td>
                </tr>
                {{-- <tr> --}}
                    {{-- firmas --}}
                    {{-- <td colspan="2"> --}}
                        {{-- <table border="1"   style="width: 100%; text-align: center;" cellpadding="5">
                            <tr>
                                <td style="width: 33%">BENEFICIARIO<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td>
                                <td style="width: 33%">AUTORIZ&Oacute; LA DEPENDENCIA EJECUTORA<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td>
                                <td style="width: 34%">Vo. Bo. DE LA SECRETAR&Iacute;A DE FINANZAS<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td>
                            </tr>
                        </table> --}}
                    {{-- </td> --}}
                {{-- </tr> --}}
            </tbody>
        </table>
    </div>
    </main>
</body>
</html>
@php
     // dd($ap);
 @endphp
