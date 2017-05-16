@extends('layouts.master')
@section('content')

{{-- <script type="text/javascript" src="contenido_SGI/view/js/Oficios/funcionesOficiosObras.js"></script> --}}
{{-- <script src="contenido_SGI/view/js/nl.js" type="text/javascript"></script> --}}
<style>
    .number{
        text-align: right;
    }
</style>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Oficios</strong></h3>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">    

        <div class="row form-inline">            
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">Clave de Oficio</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="cveOficio" name="cveOficio"/>
                </div>                    
            </div>                
            <div class="col-md-2">
                <button class="btn btn-success" id="mostrarOficio">Mostrar Datos</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" id="limpiar">Limpiar</button>
            </div>
        </div>           

    </div>
</div>
<div class="panel panel-default" >
    <div class="panel-heading" id="infoGral" style="cursor: pointer">
        <h3 class="panel-title"><strong>Informaci&oacute;n de Oficio</strong></h3>
    </div>
    <div class="panel-body" id="infoGralChild">
        <div class="col-md-12 ">            
            <div class="row form-inline">                
                <div>                                      
                    <label class="text-right col-md-2">Tipo de Solicitud: </label>                
                    <select class="form-control col-md-1" name="id_tipo_solicitud" id="id_tipo_solicitud">
                        @foreach ($tipoSolicitud as $element)
                            <option value="{{$element->id}}">{{$element->nombre_solicitud}}</option>
                        @endforeach
                    </select>                                        

                    <label class="text-right col-md-1">Ejercicio: </label>                
                    <select class="form-control col-md-1" name="ejercicio" id="ejercicio">
                        @foreach ($ejercicios as $element)
                           <option value="{{$element->Ejercicio}}">{{$element->Ejercicio}}</option>
                        @endforeach
                    </select>                                        

                    <label class="col-md-1 text-right">Monto: </label>                
                    <input type="text" id="monto" name="monto" value="" readonly="" class="form-control col-md-3" />
                </div>
            </div>
        </div>                       
        <div class="col-md-12 ">&nbsp;</div>   
        <div class="col-md-12">
            <div class="row form-group">
                <div class="col-md-2 text-right "> 
                    <label>No.&nbsp;Obra: </label>                    
                </div>    
                <div class="col-md-2 text-right ">
                    <input type="text" id="numObra" name="numObra" value="" class="form-control" />
                </div>
                <div class="col-md-2 "> 
                    <button type="button" class="btn btn-default" id="agregarObra" name="agregarObra">+</button>                    
                </div> 
            </div>
            <div class="row form-group">
                 <div class="col-md-12 "> 
                    <input type="text" id="obra" name="obra" value="" readonly="" class="form-control"/>
                </div>    
                 
            </div>
        </div>
              
    </div>    
</div>    

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Obras en el Oficio</strong></h3>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row form-group">
                <table id="tablaObras" class="table table-bordered">
                    <thead>
                        <tr>
                            <th >No. Obra</th>
                            <th >VerExp</th>
                            <th >Nombre de Obra</th>
                            <th >Monto</th>
                            <th >Tipo Obra</th>
                            <th >Mod. Ejecuci&oacute;n</th>
                            <th >objFtes</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row form-group">
                <div class="col-md-2 col-md-offset-10"> 
                    <button type="button" class="btn btn-success" id="btnGuardar" name="">Crear/Ver Oficio</button>                    
                </div>
            </div>
        </div>

<!--        <table border="1" id="infoObras" width="100%">
     <thead>
         <tr>
             <th >No. Obra</th>
             <th >Nombre de Obra</th>
             <th >Monto</th>
             <th >Tipo Obra</th>
             <th >Mod. Ejecuci&oacute;n</th>
             <th></th>
         </tr>
     </thead>
     <tbody id='infoObrasBody'></tbody>
 </table>
 <br />
 <br />
 <div class="col-md-12 ">            
     <div class="row form-inline">                                
         <div class="col-md-11 text-right "> 
             <button type="button" class="btn btn-success" id="btnGuardar" name="">Crear Oficio</button>                    
         </div>
         
         <div class="col-md-1 text-right "> 
             <button type="button" class="btn btn-default" id="btnOficio" name="">Crear Oficio</button>                    
         </div>
     </div>    
 </div>-->


    </div>        

</div>

<div id="modalFuentes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></span>
                <h4 class="modal-title" id="myModalLabel">Fuentes de Financiamiento de la Obra: <span id="obraFte"></span></h4>
            </div>        
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-lg-12">
                        <table id="tablaFuentes" class="table table-bordered" style="font-size: 11px;">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>idFte</td>
                                    <td>Fuente</td>
                                    <td>Tipo</td>
                                    <td style='text-align:right;'>Cuenta</td>
                                    <td style='text-align:right;'>Monto</td>
                                    <td style='width:1%'>% de Inversi&oacute;n</td>
                                    <td>Partida Presupuestal</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row form-group">
                    <div class="col-lg-12">
                        <span class="btn btn-success" onclick="seleccionarFuentes()">Aceptar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="DocumentoF">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cuerpo del Oficio</h4>
            </div>
            <div class="modal-body">
                <form name="postPdf" id="postPdf" method="post" action="contenido_SGI/view/oficios/pdfOficio.php" target="_blank" accept-charset="utf-8">
                    <table id="tblOficio" cellspacing="1" width="100%">
                        <tr>
                            <td style="vertical-align: top"><label class="label1">Fuente:</label></td>
                            <td colspan="3" style="vertical-align: top"><select class="form-control col-md-1" name="idFteTemplate" id="idFteTemplate" onchange="loadTemplateFte()"></select></td>                    
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td style="vertical-align: top;"><label class="label1">Titular: </label></td>
                            <td style="vertical-align: top;"><textarea class="form-control" rows="3" cols="30" id="titular" name="titular"></textarea></td>
                            <td style="vertical-align: top;"><label class="label1 top">Asunto: </label></td>
                            <td style="vertical-align: top;"><textarea class="form-control" rows="3" cols="30" id="asunto" name="asunto"></textarea></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td style="vertical-align: top"><label class="label1">C.c.p: </label></td>
                            <td style="vertical-align: top"><textarea class="form-control" rows="5" cols="30" id="ccp" name="ccp"></textarea></td>
                            <td style="vertical-align: top"></td>
                            <td>
                                <div>                    
                                    <label class="label1">Prefijo: </label>                     
                                    <input type="text" class="form-control input-sm" id="prefijo" size="31" name="prefijo">                                                                
                                </div>                
                                <div style="height: 5px;">&nbsp;</div> 
                                <div>                    
                                    <label class="label1">Refer: </label>                     
                                    <input type="text" class="form-control input-sm" id="refer" size="31" name="refer">                                                                
                                </div>
                                <div style="height: 5px;">&nbsp;</div>                
                                <div>                    
                                    <label class="label1">T.A.T.: </label>                     
                                    <input type="text" class="form-control input-sm" id="tat" size="31" name="tat">
                                </div>
                            </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td style="vertical-align: top">
                                <label class="label1">Texto:</label>                
                            </td>
                            <td colspan="3">
                                <textarea class="form-control textareaLong" rows="4" id="texto" size='70' name="texto"></textarea>                                                                    
                            </td>
                        </tr>
                        <tr><td>
                                <input type="hidden" id='idSolPdf' name="idSolPdf" value=""/>
                                <input type="hidden" id='idFtePdf' name="idFtePdf" value=""/>
                                <input type="hidden" id='oficioGeneral' name="oficioGeneral" value=""/>

                            </td></tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <span class="btn btn-default" onclick="guardarOficio();" id="button-guardar">Guardar Oficio</span>
                <span class="btn btn-default" onclick="verPdf();" id="button-pdf">PDF</span>
                <span class="btn btn-default" onclick="verWord();" id="button-word">Word</span>               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="contenidoFormPdf" style="display: none">
    <form name="viewPdf" id="viewPdf" method="post" action="contenido_SGI/view/Oficios/pdfOficio.php" target="_blank">
        <input type="hidden" name="idOficioPdf" id="idOficioPdf" value="" />        
    </form>

    <form name="viewWord" id="viewWord" method="post" action="contenido_SGI/libs/phpWord/write/oficio.php" target="_blank">
        <input type="hidden" name="idOficioWord" id="idOficioWord" value="" />        
    </form>
</div>    


<style type="text/css">
    #infoObras th{
        font-weight: bold;
        font-size: 13px;
        min-width: 100px;        
    }

    #infoObras td{
        padding: 3px;        
        min-width: 100px;        
    }

    #button-cerrar, #button-guardar, #button-pdf, #button-word{
        font-size: 12px;
    }

    .montosGrid{
        text-align: right;        
        padding-right: 8px;
        width: 100px
    }
</style>
@endsection
