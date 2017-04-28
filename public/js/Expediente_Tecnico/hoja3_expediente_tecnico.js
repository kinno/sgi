//GLOBALES
var fuentes = [];
var idFuentes = [];
var tablaConceptos;
var indiceEditar;
var arrayEliminados = [];
var ftesEliminadas = [];
var ftesActualizadas = [];
var pariPassu = true;
var montosFuentes = [];
var IdEdoSol = 1;
var totalGeneral = 0;
var error = false;
var guardado = false;
var primeraVez = true;
var montoAutorizado = 0;
$(document).ready(function() {
    initDataConceptos();
    $(".number").autoNumeric({
        vMin: '-99999999999999999999999.00',
        vMax: '99999999999999999999999.00'
    });
    $("#abreModal").click(function() {
        $("#actualizarConcepto").hide();
        $("#agregaConcepto").show();
        $(".number").each(function() {
            $(this).val(0.00).focusin().focusout();
        });
        $("#modalConcepto").modal("show");
    });
    $("#actualizarConcepto").click(function() {
        modificarConcepto();
    });
    $("#agregaConcepto").click(function() {
        agregarConcepto();
    });
    $('#cantidad,#preciou').on("change", function() {
        calcularTotal();
    });
    $("#ivaCheck").click(function() {
        calcularTotal();
    });
    $("#cancelarConcepto").click(function() {
        limpiar("modalConcepto");
        $("#totalConcepto").text("0.00");
        $("#ivaCheck").attr('checked', false);
        $("#modalConcepto").modal("hide");
    });
    //verificarTipoSolicitud();
    //verificarEstadoSolicitud();
});

function initDataConceptos(id_expediente_tecnico) {
    if (!id_expediente_tecnico) {
        id_expediente_tecnico = 0;
    }
    tablaConceptos = $('#tablaConceptos').DataTable({
        "ordering": false,
        "searching": false,
        "destroy": true,
        processing: false,
        serverSide: false,
        ajax: '/ExpedienteTecnico/get_data_conceptos/' + id_expediente_tecnico,
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'clave_objeto_gasto',
            name: 'clave_objeto_gasto'
        }, {
            data: 'concepto',
            name: 'concepto'
        }, {
            data: 'unidad_medida',
            name: 'unidad_medida'
        }, {
            data: 'cantidad',
            name: 'cantidad'
        }, {
            data: 'precio_unitario',
            name: 'precio_unitario'
        }, {
            data: 'importe',
            name: 'importe'
        }, {
            data: 'iva',
            name: 'iva'
        }, {
            data: 'total',
            name: 'total'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar concepto" style="cursor:hand;" onClick="editar(this);"></span>'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-danger fa fa-trash" title="Eliminar concepto" style="cursor:hand;" onClick="eliminar(this);"></span>'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            for (var i = 4; i <= 8; i++) {
                var cell = tablaConceptos.cell(nRow, i).node();
                $(cell).addClass('number');
            }
        },
        "drawCallback": function(settings) {
            $(".number").autoNumeric();
            $(".number").autoNumeric("update");
        }
    });
    tablaConceptos.column(0).visible(false); //ID CONCEPTO
    tablaConceptos.on('draw.dt', function() {
        $(".mto").each(function() {
            $(this).autoNumeric({
                aSep: ',',
                mDec: 2,
                vMin: '0.00'
            });
        });
    });
}

function agregarConcepto() {
    var sum = 0.00;
    var totalConcepto = $("#totalConcepto").text().replace(/,/g, "");
    var objConcepto = {
        id:null,
        clave_objeto_gasto:$("#clave").val(),
        concepto:$("#concepto").val(),
        unidad_medida:$("#unidadm").val(),
        cantidad:$("#cantidad").val(),
        precio_unitario:$("#preciou").val(),
        importe:$("#impsiniva").val(),
        iva:$("#iva").val(),
        total:$("#totalConcepto").text()
    }
    // tablaConceptos.row.add([null, $("#clave").val(), $("#concepto").val(), $("#unidadm").val(), $("#cantidad").val(), $("#preciou").val(), $("#impsiniva").val(), $("#iva").val(), $("#totalConcepto").text(), '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar concepto" style="cursor:hand;" onClick="editar(this);"></span>', '<span  class="btn btn-danger fa fa-trash" title="Eliminar concepto" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw('false');
    tablaConceptos.row.add(objConcepto).draw('false');
    actualizaTotales();
    $("#totalConcepto").text("0.00");
    $("#ivaCheck").attr('checked', false);
    limpiar("modalConcepto");
    $("#modalConcepto").modal("hide");
}

function modificarConcepto() {
    //datosGlobalesSolicitud.fuentes = [];
    var tmpBand = true;
    var sum = 0.00;
    var id = tablaConceptos.cell(indiceEditar, 0).data();
    var totalConcepto = $("#totalConcepto").text().replace(/,/g, "");
    if (id != "") {
        id = id;
    } else {
        id = ("");
    }
    var objConcepto = {
        id:id,
        clave_objeto_gasto:$("#clave").val(),
        concepto:$("#concepto").val(),
        unidad_medida:$("#unidadm").val(),
        cantidad:$("#cantidad").val(),
        precio_unitario:$("#preciou").val(),
        importe:$("#impsiniva").val(),
        iva:$("#iva").val(),
        total:$("#totalConcepto").text().replace(/,/g, "")
    }
    tablaConceptos.row(indiceEditar).data(objConcepto).draw();
    // tablaConceptos.row(indiceEditar).data([id, $("#clave").val(), $("#concepto").val(), $("#unidadm").val(), $("#cantidad").val(), $("#preciou").val(), $("#impsiniva").val(), $("#iva").val(), $("#totalConcepto").text().replace(/,/g, ""), '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar concepto" style="cursor:hand;" onClick="editar(this);"></span>', '<span  class="btn btn-danger fa fa-trash" title="Eliminar concepto" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
    tablaConceptos.column(0).visible(false); //ID CONCEPTO
    actualizaTotales();
    $("#totalConcepto").text("0.00");
    $("#ivaCheck").attr('checked', false);
    limpiar("modalConcepto");
    $("#modalConcepto").modal("hide");
    guardado = false; //OBLIGAMOS AL USUARIO A GUARDAR LA HOJA
}

function calcularTotal() {
    var cantidad = $("#cantidad").val().replace(/,/g, "");
    var precio = $("#preciou").val().replace(/,/g, "");
    var importeSinIva = cantidad * precio;
    var iva = 0.00;
    var totalConcepto = 0.00;
    $("#impsiniva").val(importeSinIva);
    $("#impsiniva").autoNumeric("update");
    if ($("#ivaCheck").is(":checked")) {
        iva = importeSinIva * 0.16;
        totalConcepto = importeSinIva + iva;
        $("#iva").val(iva);
        $("#iva").autoNumeric("update");
    } else {
        totalConcepto = importeSinIva;
        $("#iva").val(0.00);
        $("#iva").autoNumeric("update");
    }
    $("#totalConcepto").text(totalConcepto);
    $("#totalConcepto").autoNumeric();
}

function actualizaTotales() {
    var totalSinIva = 0;
    var totalIva = 0;
    var total = 0;
    var arraySinIva = tablaConceptos.column(6).data();
    var arrayIva = tablaConceptos.column(7).data();
    var arrayTotal = tablaConceptos.column(8).data();
    //// console.log(arrayTotal);
    for (var i = 0; i < arrayTotal.length; i++) {
        totalSinIva = parseFloat(totalSinIva) + parseFloat(arraySinIva[i].replace(/,/g, ""));
        totalIva = parseFloat(totalIva) + parseFloat(arrayIva[i].replace(/,/g, ""));
        total = parseFloat(total) + parseFloat(arrayTotal[i].replace(/,/g, ""));
    }
    $("#totalSinIva").text(totalSinIva);
    $("#totalIva").text(totalIva);
    $("#total").text(total);
    $("#totalSinIva,#totalIva,#total").autoNumeric("update");
    // if (total > totalGeneral) {
    //     colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "El monto ha superado el monto inicial\nMonto inicial: $<span class='n'>" + totalGeneral + "</span>");
    //     error = true;
    // } else {
    //     eliminaMensajePop($("#btnGuardarParcialMP"));
    //     error = false;
}

function editar(elem) {
    indiceEditar = tablaConceptos.row($(elem).parent().parent()).index();
    var datosFila = tablaConceptos.row(indiceEditar).data();
    $("#clave").val(datosFila['clave_objeto_gasto']);
    $("#concepto").val(datosFila['concepto']);
    $("#unidadm").val(datosFila['unidad_medida']);
    $("#cantidad").val(datosFila['cantidad']).focusin().focusout();
    $("#preciou").val(datosFila['precio_unitario']).focusin().focusout();
    $("#impsiniva").val(datosFila['importe']).focusin().focusout();
    $("#iva").val(datosFila['iva']);
    if (datosFila[7] > 0) {
        $("#ivaCheck").click();
    }
    $("#totalConcepto").text(datosFila['total']);
    $("#totalConcepto").autoNumeric("update");
    // $("#idContrato").val(datosFila[10]);
    $("#actualizarConcepto").show();
    $("#agregaConcepto").hide();
    $("#modalConcepto").modal("show");
}

function eliminar(elem) {
    // bootbox.confirm("Se eliminar\u00e1 el concepto, \u00BFDesea Continuar?", function(response) {
    if (confirm("Se eliminar\u00e1 el concepto, \u00BFDesea Continuar?")) {
        var indiceEliminar = tablaConceptos.row($(elem).parent().parent()).index();
        var montosCancel = tablaConceptos.cell(indiceEliminar, 8).data();
        var datosFila = tablaConceptos.row(indiceEliminar).data();
        if (datosFila[0] > 0) {
            arrayEliminados.push(datosFila[0]);
        }
        tablaConceptos.row(indiceEliminar).remove().draw();
        actualizaTotales();
    }
    // });
}

function limpiar(limformularios) {
    $("#" + limformularios + " :input").each(function() {
        $(this).val('');
    });
}
// function cargarConceptos(callback) {
//     //    $("#divFtes").empty();
//     var asig = false;
//     //    console.log("datosGlobalesSolicitud");
//     //    console.log(datosGlobalesSolicitud);
//     tablaConceptos.clear().draw();
//     idSol = datosGlobalesSolicitud.idsolicitud;
//     //   if (datosGlobalesSolicitud.psolicitud !== "") {
//     totalGeneral = 0;
//     colocaWaitGeneral();
//     $.ajax({
//         data: {
//             idSol: idSol,
//             accion: "getHoja3"
//         },
//         url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
//         type: 'post',
//         success: function(response) {
//             console.log(response);
//             var dataConceptos = $.parseJSON(response);
//             //            // console.log(dataConceptos);
//             //CARGA DE MONTOS Y PROCENTAJES DE LAS FUENTES
//             fuentes = datosGlobalesSolicitud.fuentes; //[[21, 150000, 17.95332], [22, 250000, 29.92220], [23, 320000, 38.30042], [24, 75500, 9.03651], [25, 40000, 4.78755]];
//             // console.log(fuentes);
//             for (var k = 0; k < datosGlobalesSolicitud.fuentes.length; k++) {
//                 totalGeneral = totalGeneral + parseFloat(datosGlobalesSolicitud.fuentes[k][1]);
//             }
//             //             console.log("TOTAL DE INVERSION:" + totalGeneral);
//             if (dataConceptos['conceptos'].length != 0) {
//                 console.log(dataConceptos.preftes);
//                 if (dataConceptos.preftes.length > 0) { //Si no hay registros es porque se realiza la primera autorizacion
//                     primeraVez = false;
//                     //                    montosFuentes = [];
//                     //                    for (var j = 0; j < dataConceptos.preftes.length; j++) {
//                     //                        montosFuentes.push(dataConceptos.preftes[j]); // Se llenan los montos de fuentes por concepto
//                     //                        for (var l = 0; l < dataConceptos.preftes[j].length; l++) {
//                     //                            for (var k = 0; k < fuentes.length; k++) {
//                     //                                if (fuentes[k][0] == dataConceptos.preftes[j][l][0]) {
//                     //                                    fuentes[k][2] = fuentes[k][2] - dataConceptos.preftes[j][l][2]; //Se actualizan los montos originales disponibles por fuente
//                     //                                }
//                     //                            }
//                     //                        }
//                     //                    }
//                 }
//                 if (dataConceptos.conceptos.length > 0) {
//                     for (var i = 0; i < dataConceptos.conceptos.length; i++) {
//                         var editar = '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>';
//                         var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
//                         if (!primeraVez) { //YA HAY CONCEPTOS RELACIONADOS A FUENTES EN AUTORIZACION
//                             var arrayObjFuente = [];
//                             for (var k = 0; k < dataConceptos.preftes[i].length; k++) {
//                                 var objFuente = {
//                                     idFte: dataConceptos.preftes[i][k][0],
//                                     montofte: dataConceptos.preftes[i][k][2]
//                                 }
//                                 arrayObjFuente.push(objFuente);
//                             }
//                             //                            $("#errorRelPreFte").hide(); 
//                             eliminaMensajePop($("#btnGuardarParcialMP"));
//                             error = false;
//                             console.log(arrayObjFuente);
//                         } else { // ENVIAR MENSAJE AL USUARIO QUE DEBE RELACIONAR FUENTES CON CONCEPTOS EN AUTORIZACION
//                             error = true;
//                             if (modulo == "3") {
//                                 setTimeout(function() {
//                                     colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "Se deben relacionar los conceptos con las fuentes");
//                                 }, 500);
//                                 var arrayObjFuente = [];
//                                 for (var k = 0; k < fuentes.length; k++) {
//                                     var objFuente = {
//                                         idFte: fuentes[k][0],
//                                         montofte: "0.00"
//                                     }
//                                     arrayObjFuente.push(objFuente);
//                                 }
//                                 //$("#errorRelPreFte").show();
//                             } else {
//                                 tablaConceptos.column(9).visible(false);
//                                 arrayObjFuente = "";
//                                 asig = true;
//                             }
//                         }
//                         if (dataConceptos.conceptos[i].idContrato != "0") {
//                             editar = "";
//                             eliminar = "";
//                             montoAutorizado = montoAutorizado + parseFloat(dataConceptos.conceptos[i].total);
//                         }
//                         tablaConceptos.row.add([dataConceptos.conceptos[i].idPresu, dataConceptos.conceptos[i].claveObj, dataConceptos.conceptos[i].concept, dataConceptos.conceptos[i].uniMedi, dataConceptos.conceptos[i].cantidad, dataConceptos.conceptos[i].precioUni, dataConceptos.conceptos[i].importe, dataConceptos.conceptos[i].iva, dataConceptos.conceptos[i].total, arrayObjFuente, dataConceptos.conceptos[i].idContrato, editar, eliminar]).draw();
//                     }
//                     tablaConceptos.column(0).visible(false);
//                     tablaConceptos.column(10).visible(false);
//                     monto25 = (25 * montoAutorizado) / 100;
//                     //                    if (!pariPassu && (modulo != "1" || (datosGlobalesSolicitud.tiposolicitud == "10" || datosGlobalesSolicitud.tiposolicitud == "11" || datosGlobalesSolicitud.tiposolicitud == "13"))) {
//                     //                        $("#pariPassu").click();
//                     //                    }
//                     datosGlobalesSolicitud.totalConceptos = montoAutorizado;
//                     console.log(fuentes.length);
//                     var renglonFuente = "";
//                     if (modulo == "1" && datosGlobalesSolicitud.psolicitud.IdSolPre != "10") {
//                         tablaConceptos.column(9).visible(false);
//                     } else {
//                         var renglonFuente = "";
//                         for (var k = 0; k < fuentes.length; k++) {
//                             renglonFuente += "<div class='row form-group'><div class='col-lg-9'>" + "<div class='input-group'>" + "<span class='input-group-addon' id='sizing-addon" + k + "'>" + fuentes[k][4] + "</span>" + "<input id='fte" + fuentes[k][0] + "' type='text' value='0.00' class='form-control number fteVar' aria-describedby='sizing-addon" + k + "' />" + "</div>" + "</div></div>";
//                         }
//                         $("#divFtes").append(renglonFuente);
//                         $(".number").autoNumeric();
//                     }
//                 }
//                 //
//                 //            // console.log("DISPONIBLE INICIAL PARA FUENTES:");
//                 //            // console.log(fuentes);
//                 //            // console.log("MONTO POR CONCEPTO FUENTES:");
//                 //            // console.log(montosFuentes);
//                 if (ro) { //SI ES PROCESO DE REVISION
//                     tablaConceptos.column(0).visible(false);
//                     tablaConceptos.column(10).visible(false);
//                     tablaConceptos.column(11).visible(false);
//                     tablaConceptos.column(12).visible(false);
//                     $("#pariPassu").attr("disabled", "disabled");
//                 }
//                 //                // console.log(tablaConceptos.data());
//                 eliminaWaitGeneral();
//                 actualizaTotales();
//                 guardado = true;
//             } else {
//                 if (modulo == "1" && datosGlobalesSolicitud.psolicitud.IdSolPre != "10") {
//                     tablaConceptos.column(9).visible(false);
//                 } else {
//                     var renglonFuente = "";
//                     for (var k = 0; k < fuentes.length; k++) {
//                         renglonFuente += "<div class='row form-group'><div class='col-lg-9'>" + "<div class='input-group'>" + "<span class='input-group-addon' id='sizing-addon" + k + "'>" + fuentes[k][4] + "</span>" + "<input id='fte" + fuentes[k][0] + "' type='text' value='0.00' class='form-control number fteVar' aria-describedby='sizing-addon" + k + "' />" + "</div>" + "</div></div>";
//                     }
//                     $("#divFtes").append(renglonFuente);
//                     $(".number").autoNumeric();
//                 }
//                 eliminaWaitGeneral();
//                 actualizaTotales();
//             }
//             if (datosGlobalesSolicitud.tiposolicitud == "1" || datosGlobalesSolicitud.tiposolicitud == "3") {
//                 $("#pp").hide();
//             }
//             if (typeof(callback) != "undefined") {
//                 callback();
//             }
//             if (typeof(datosGlobalesSolicitud.psolicitud) === "object" && (datosGlobalesSolicitud.psolicitud.IdEdoSol === "3" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "4")) {
//                 $("#pariPassu").attr("disabled", "disabled");
//             }
//             // console.log("fuentes");
//             // console.log(fuentes);
//             // console.log("montosFuentes");
//             // console.log(montosFuentes);
//         },
//         error: function(response) {
//             // console.log("Errores::", response);
//         }
//     });
//     //    }
// }
function guardarHoja3() {
    if (!error) {
        var conceptosPresupuesto = [];
        var conceptos = tablaConceptos.rows().data();
        for (var i = 0; i < conceptos.length; i++) {
            conceptosPresupuesto.push(conceptos[i]);
        }
        montoAutorizado = $("#total").text().replace(/,/g, "");
        $.ajax({
            data: {
                'conceptosPresupuesto': conceptosPresupuesto,
                'id_expediente_tecnico': $("#form_anexo_uno id_expediente_tecnico").val()
            },
            url: '/ExpedienteTecnico/guardar_hoja_3',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                //                // console.log(response);
                var id = $.parseJSON(response);
                if (id) {
                    for (var i = 0; i < id.length; i++) {
                        tablaConceptos.cell(parseInt(id[i][1]), 0).data(parseInt(id[i][0])).draw();
                        guardado = true;
                    }
                    tablaConceptos.column(0).visible(false);
                    // eliminaWaitGeneral();
                    BootstrapDialog.mensaje(null, "Datos del Anexo 1 guardados correctamente.<br>Folio de Expediente Técnico: " + data.id_expediente_tecnico, 1);
                }
                guardado = true;
                //// console.log(tablaConceptos.data());
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    } else {
        eliminaWaitGeneral();
        BootstrapDialog.mensaje(null, "Existe error en los conceptos de trabajo. ", 2);
        actualizaTotales();
    }
}
// function cargaExterna(fileName) {
//     //    alert(fileName);
//     colocaWaitGeneral();
//     $.ajax({
//         type: "POST",
//         url: "contenido_SGI/libs/parser.php",
//         data: {
//             fileName: fileName
//         },
//         success: function(response) {
//             var dataConceptos = $.parseJSON(response);
//             //// console.log(dataConceptos);
//             var editar = '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>';
//             var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
//             var element_count = 0;
//             for (e in dataConceptos) {
//                 element_count++;
//             }
//             //// console.log(element_count);
//             for (var i = 1; i <= element_count; i++) {
//                 tablaConceptos.row.add(["", dataConceptos[i][1], dataConceptos[i][2], dataConceptos[i][3], dataConceptos[i][4], dataConceptos[i][5], dataConceptos[i][6], dataConceptos[i][7], dataConceptos[i][8], "", "0", editar, eliminar]).draw();
//             }
//             eliminaWaitGeneral();
//             actualizaTotales();
//             //          e             
//         },
//         error: function(response) {
//             // console.log("Errores::", response);
//         }
//     });
// }
// function prorrateo() {
//     colocaWaitGeneral();
//     bootbox.confirm("Se realizar\u00e1 el prorrateo sobre las fuentes, Desea continuar?", function(result) {
//         if (result) {
//             var totalConceptos = $('#tablaConceptos tbody tr').length;
//             for (var a = 0; a < totalConceptos; a++) {
//                 var datosFila = tablaConceptos.row(a).data();
//                 console.log(datosFila);
//                 if (datosFila[10] == 0 || datosFila[10] == "") {
//                     console.log(datosFila);
//                     var totalConcepto = datosFila[8].replace(/,/g, "");
//                     var arrayObjFuente = [];
//                     for (var i = 0; i < fuentes.length; i++) {
//                         var idfte = fuentes[i][0];
//                         var pje = fuentes[i][3];
//                         var montoFte = (totalConcepto * pje) / 100; //Se realiza el prorrateo para cada fuente
//                         console.log("idFte: " + idfte);
//                         console.log("pje: " + pje);
//                         console.log("montoFte: " + montoFte);
//                         var objFuente = {
//                             idFte: fuentes[i][0],
//                             montofte: montoFte
//                         };
//                         arrayObjFuente.push(objFuente);
//                     }
//                     tablaConceptos.cell(a, 9).data(arrayObjFuente).draw();
//                 }
//             }
//             eliminaMensajePop($("#btnGuardarParcialMP"));
//             error = false;
//             console.log(arrayObjFuente);
//         }
//     });
//     eliminaWaitGeneral();
// }
// function replaceAll(text, busca, reemplaza) {
//     while (text.toString().indexOf(busca) != -1) text = text.toString().replace(busca, reemplaza);
//     return text;
// }
// function ajustardec() {
//     var totalC = 0.00;
//     totalC = parseFloat(replaceAll($('#totalConcepto').html(), ",", ""));
//     $("#decScroll").val(totalC);
//     $("#contEd").attr("hidden", false);
//     $("#decScroll").TouchSpin({
//         min: totalC - 1,
//         max: totalC + 1,
//         step: 0.01,
//         decimals: 2
//     });
// }
// function ajustaDec() {
//     $("#totalConcepto").text($("#decScroll").val());
//     $("#totalConcepto").autoNumeric("update");
//     $("#contEd").attr("hidden", true);
//     var impSIVA = parseFloat(replaceAll($('#impsiniva').val(), ",", ""));
//     var totAct = parseFloat(replaceAll($('#decScroll').val(), ",", ""));
//     var nvoIVA = 0.00;
//     if ($("#iva").val() > "0.00") {
//         nvoIVA = totAct - impSIVA;
//         $("#iva").val(nvoIVA);
//         $("#iva").autoNumeric("update");
//     } else {
//         $("#iva").val(0.00);
//         $("#iva").autoNumeric("update");
//     }
// }