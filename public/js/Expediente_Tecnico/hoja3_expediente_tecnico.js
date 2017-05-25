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
var totalGeneral = 0.00;
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
         limpiar("modalConcepto");
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
    $("#archivoExcel").filestyle({
        buttonText: " Cargar catálogo de conceptos",
        buttonName: "btn-success",
        buttonBefore: true,
        iconName: "fa fa-file-excel-o"
    });
    $("#archivoExcel").on('change', function() {
        $("#subirCatalogo").show();
    });
    $("#subirCatalogo").on('click', function() {
        cargaExterna();
    });
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
            actualizaTotales();
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
        id: null,
        clave_objeto_gasto: $("#clave").val(),
        concepto: $("#concepto").val(),
        unidad_medida: $("#unidadm").val(),
        cantidad: $("#cantidad").val(),
        precio_unitario: $("#preciou").val(),
        importe: $("#impsiniva").val(),
        iva: $("#iva").val(),
        total: $("#totalConcepto").text()
    }
    // tablaConceptos.row.add([null, $("#clave").val(), $("#concepto").val(), $("#unidadm").val(), $("#cantidad").val(), $("#preciou").val(), $("#impsiniva").val(), $("#iva").val(), $("#totalConcepto").text(), '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar concepto" style="cursor:hand;" onClick="editar(this);"></span>', '<span  class="btn btn-danger fa fa-trash" title="Eliminar concepto" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw('false');
    tablaConceptos.row.add(objConcepto).draw('false');
    actualizaTotales();
    $("#totalConcepto").text("0.00");
     $("#ivaCheck").prop('checked',false);
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
        id: id,
        clave_objeto_gasto: $("#clave").val(),
        concepto: $("#concepto").val(),
        unidad_medida: $("#unidadm").val(),
        cantidad: $("#cantidad").val(),
        precio_unitario: $("#preciou").val(),
        importe: $("#impsiniva").val(),
        iva: $("#iva").val(),
        total: $("#totalConcepto").text().replace(/,/g, "")
    }
    tablaConceptos.row(indiceEditar).data(objConcepto).draw();
    // tablaConceptos.row(indiceEditar).data([id, $("#clave").val(), $("#concepto").val(), $("#unidadm").val(), $("#cantidad").val(), $("#preciou").val(), $("#impsiniva").val(), $("#iva").val(), $("#totalConcepto").text().replace(/,/g, ""), '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar concepto" style="cursor:hand;" onClick="editar(this);"></span>', '<span  class="btn btn-danger fa fa-trash" title="Eliminar concepto" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
    tablaConceptos.column(0).visible(false); //ID CONCEPTO
    actualizaTotales();
    $("#totalConcepto").text("0.00");
    $("#ivaCheck").prop('checked',false);
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
    totalGeneral = $("#form_anexo_uno #monto").val().replace(/,/g, "");
    totalGeneralFormat = $("#form_anexo_uno #monto").val();
    // console.log(arraySinIva);
    for (var i = 0; i < arrayTotal.length; i++) {
        totalSinIva = parseFloat(totalSinIva) + parseFloat(arraySinIva[i].toString().replace(/,/g, ""));
        totalIva = parseFloat(totalIva) + parseFloat(arrayIva[i].toString().replace(/,/g, ""));
        total = parseFloat(total) + parseFloat(arrayTotal[i].toString().replace(/,/g, ""));
    }
    $("#totalSinIva").text(totalSinIva);
    $("#totalIva").text(totalIva);
    $("#total").text(total);
    $("#totalSinIva,#totalIva,#total").autoNumeric("update");
    if (total > totalGeneral) {
        // console.log(total + "::" + totalGeneral);
        eliminaNotificacion();
        colocaNotificacion('','Atenci\u00f3n! El monto ha superado el monto inicial, Monto inicial: $'+ totalGeneralFormat,'error','right bottom');
        error = true;
        desactivaNavegacion(true);
        return false;
    } else if(($("#form_anexo_uno #id_tipo_solicitud").val()=="10"||$("#form_anexo_uno #id_tipo_solicitud").val()=="11")&& total<totalGeneral){
        eliminaNotificacion();
        colocaNotificacion('','Atenci\u00f3n! El monto de los conceptos debe ser igual al monto inicial, Monto inicial: $'+ totalGeneralFormat,'error','right bottom');
        error = true;
        desactivaNavegacion(true);
        return false;
    }
    else{
        eliminaNotificacion();
        error = false;
        desactivaNavegacion(false);
    }
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
    if (datosFila['iva'] > 0) {
        // $("#ivaCheck").click();
        $("#ivaCheck").prop('checked',true);
    }else{
        $("#ivaCheck").prop('checked',false);
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
        if (datosFila['id'] !== "") {
            arrayEliminados.push(datosFila['id']);
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

function guardarHoja3() {
    var exp = $("#form_anexo_uno #id_expediente_tecnico").val();
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
                'conceptosEliminados': arrayEliminados,
                'id_expediente_tecnico': exp,
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
                // console.log(response);
                if (!response.error) {
                    var id = (response);
                    if (id) {
                        for (var i = 0; i < id.length; i++) {
                            tablaConceptos.cell(i, 0).data(parseInt(id)).draw();
                            guardado = true;
                        }
                        tablaConceptos.column(0).visible(false);
                        // eliminaWaitGeneral();
                        BootstrapDialog.mensaje(null, "Datos del Anexo 3 guardados correctamente.<br>Folio de Expediente Técnico: " + exp, 1);
                    }
                    guardado = true;
                    //// console.log(tablaConceptos.data());
                } else {
                    BootstrapDialog.mensaje(null, response.error, 3);
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    } else {
        BootstrapDialog.mensaje(null, "Existe error en los conceptos de trabajo. ", 2);
        actualizaTotales();
    }
}

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1) text = text.toString().replace(busca, reemplaza);
    return text;
}

function ajustardec() {
    var totalC = 0.00;
    totalC = parseFloat(replaceAll($('#totalConcepto').html(), ",", ""));
    $("#decScroll").val(totalC);
    $("#contEd").attr("hidden", false);
    $("#decScroll").TouchSpin({
        min: totalC - 1,
        max: totalC + 1,
        step: 0.01,
        decimals: 2
    });
}

function ajustaDec() {
    $("#totalConcepto").text($("#decScroll").val());
    $("#totalConcepto").autoNumeric("update");
    $("#contEd").attr("hidden", true);
    var impSIVA = parseFloat(replaceAll($('#impsiniva').val(), ",", ""));
    var totAct = parseFloat(replaceAll($('#decScroll').val(), ",", ""));
    var nvoIVA = 0.00;
    if ($("#iva").val() > "0.00") {
        nvoIVA = totAct - impSIVA;
        $("#iva").val(nvoIVA);
        $("#iva").autoNumeric("update");
    } else {
        $("#iva").val(0.00);
        $("#iva").autoNumeric("update");
    }
}

function cargaExterna() {
    var formdata = new FormData($("#formCargaExterna")[0]);
    $.ajax({
        data: new FormData($("#formCargaExterna")[0]),
        url: '/ExpedienteTecnico/carga_externa',
        type: 'post',
        processData: false,
        contentType: false,
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
                // console.log(response);
            var data = $.parseJSON(response);
            if (!data.error_validacion) {
                $.each(data, function(index, val) {
                    // console.log(data[index]);
                    var objConcepto = {
                        id: null,
                        clave_objeto_gasto: data[index].clave_objeto_gasto,
                        concepto: data[index].concepto,
                        unidad_medida: data[index].unidad_medida,
                        cantidad: data[index].cantidad,
                        precio_unitario: data[index].precio_unitario,
                        importe: data[index].importe,
                        iva: data[index].iva,
                        total: data[index].total
                    }
                    tablaConceptos.row.add(objConcepto).draw('true');
                });
                actualizaTotales();
            } else {
                for (property in data.error_validacion) {
                    $("#archivoExcel").notify("Extensión no válida, se requiere .XLS", "error");
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}