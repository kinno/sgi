var tablaPrograma;
var indiceEditar;
var arrayProgramasEliminados = [];
$(document).ready(function() {
    initDataPrograma();
    $('.numerote').autoNumeric({
        aSep: '',
        mDec: 2,
        vMin: '0.00'
    });
    $('.porcentaje').autoNumeric({
        aSep: '',
        mDec: 5,
        vMin: '0.00000'
    });
    $('.numero2').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $(".acumesfina").autoNumeric('init', {
        aSep: ',',
        mDec: 2
    });
    $(".acumesfinaAdmin").autoNumeric('init', {
        aSep: ',',
        mDec: 2
    });
    $("#btnAddModal").unbind("click").on("click", function() {
        eliminaNotificacion();
        $("#ene").keyup();
        $("#isEdit").val("0");
        $("#isAdmin").val("1");
        $("#modal1").modal({
            backdrop: true,
            keyboard: false
        });
    });
    $("#agregamodal1").unbind("click").on("click", function() {
        agregaValores();
    });
    $('#meseneAdmin,#mesfebAdmin,#mesmarAdmin,#mesabrAdmin,#mesmayAdmin,#mesjunAdmin,#mesjulAdmin,#mesagoAdmin,#messepAdmin,#mesoctAdmin,#mesnovAdmin,#mesdicAdmin').unbind("change").on("change", function() {
        sumaAcumulado();
    });
});

function initDataPrograma(id_contrato) {
    if (!id_contrato) {
        id_contrato = 0;
    }
    tablaPrograma = $('#tablaPrograma').DataTable({
        "ordering": false,
        "searching": false,
        "destroy": true,
        processing: false,
        serverSide: false,
        ajax: '/ExpedienteTecnico/Autorizacion/get_data_programa/' + id_contrato,
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'concepto',
            name: 'concepto'
        }, {
            data: 'porcentaje_enero',
            name: 'porcentaje_enero'
        }, {
            data: 'porcentaje_febrero',
            name: 'porcentaje_febrero'
        }, {
            data: 'porcentaje_marzo',
            name: 'porcentaje_marzo'
        }, {
            data: 'porcentaje_abril',
            name: 'porcentaje_abril'
        }, {
            data: 'porcentaje_mayo',
            name: 'porcentaje_mayo'
        }, {
            data: 'porcentaje_junio',
            name: 'porcentaje_junio'
        }, {
            data: 'porcentaje_julio',
            name: 'porcentaje_julio'
        }, {
            data: 'porcentaje_agosto',
            name: 'porcentaje_agosto'
        }, {
            data: 'porcentaje_septiembre',
            name: 'porcentaje_septiembre'
        }, {
            data: 'porcentaje_octubre',
            name: 'porcentaje_octubre'
        }, {
            data: 'porcentaje_noviembre',
            name: 'porcentaje_noviembre'
        }, {
            data: 'porcentaje_diciembre',
            name: 'porcentaje_diciembre'
        }, {
            data: 'porcentaje_total',
            name: 'porcentaje_total'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-success fa fa-pencil-square-o" title="Editar concepto" style="cursor:hand;" onClick="editarPrograma(this);"></span>'
        }, {
            "data": null,
            "defaultContent": '<span  class="btn btn-danger fa fa-trash" title="Eliminar concepto" style="cursor:hand;" onClick="eliminarPrograma(this);"></span>'
        }],
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            for (var i = 2; i <= 14; i++) {
                var cell = tablaPrograma.cell(nRow, i).node();
                $(cell).addClass('number');
            }
        },
        "drawCallback": function(settings) {
            $(".number").autoNumeric();
            $(".number").autoNumeric("update");
        }
    });
    tablaPrograma.column(0).visible(false); //ID 
    tablaPrograma.on('draw.dt', function() {
        $(".number").each(function() {
            $(this).autoNumeric({
                aSep: ',',
                mDec: 2,
                vMin: '0.00'
            });
        });
    });
}

function agregaValores() {
    var valoresMesHoja4 = obtenervaloresdemodalmodal1();
    var total = (valoresMesHoja4.ene + valoresMesHoja4.feb + valoresMesHoja4.mar + valoresMesHoja4.abr + valoresMesHoja4.may + valoresMesHoja4.jun + valoresMesHoja4.jul + valoresMesHoja4.ago + valoresMesHoja4.sep + valoresMesHoja4.oct + valoresMesHoja4.nov + valoresMesHoja4.dic);
    if (total > 0 && total <= 100) {
        $("#totaldecontra").prev("div").remove();
        if (total <= 100) {
            if ($("#isEdit").val() === "0") {
                var objPrograma = {
                    id: null,
                    concepto: $("#contrato").val(),
                    porcentaje_enero: valoresMesHoja4.ene,
                    porcentaje_febrero: valoresMesHoja4.feb,
                    porcentaje_marzo: valoresMesHoja4.mar,
                    porcentaje_abril: valoresMesHoja4.abr,
                    porcentaje_mayo: valoresMesHoja4.may,
                    porcentaje_junio: valoresMesHoja4.jun,
                    porcentaje_julio: valoresMesHoja4.jul,
                    porcentaje_agosto: valoresMesHoja4.ago,
                    porcentaje_septiembre: valoresMesHoja4.sep,
                    porcentaje_octubre: valoresMesHoja4.oct,
                    porcentaje_noviembre: valoresMesHoja4.nov,
                    porcentaje_diciembre: valoresMesHoja4.dic,
                    porcentaje_total: total,
                }
                tablaPrograma.row.add(objPrograma).draw('false');
                tablaPrograma.column(0).visible(false); //ID 
                $("#totaldecontra").html(total + "%");
            } else {
                var id = tablaPrograma.cell(indiceEditar, 0).data();
                if (id != "") {
                    id = id;
                } else {
                    id = "";
                }
                var objPrograma = {
                    id: id,
                    concepto: $("#contrato").val(),
                    porcentaje_enero: valoresMesHoja4.ene,
                    porcentaje_febrero: valoresMesHoja4.feb,
                    porcentaje_marzo: valoresMesHoja4.mar,
                    porcentaje_abril: valoresMesHoja4.abr,
                    porcentaje_mayo: valoresMesHoja4.may,
                    porcentaje_junio: valoresMesHoja4.jun,
                    porcentaje_julio: valoresMesHoja4.jul,
                    porcentaje_agosto: valoresMesHoja4.ago,
                    porcentaje_septiembre: valoresMesHoja4.sep,
                    porcentaje_octubre: valoresMesHoja4.oct,
                    porcentaje_noviembre: valoresMesHoja4.nov,
                    porcentaje_diciembre: valoresMesHoja4.dic,
                    porcentaje_total: total,
                }
                tablaPrograma.row(indiceEditar).data(objPrograma).draw();
                tablaPrograma.column(0).visible(false); //ID 
            }
            eliminaNotificacion();
             // desactivaNavegacion(false);
            limpiar("modal1");
            // tablaPrograma.column(0).visible(false);
            $("#modal1").modal("hide");
        } else {
            // $("#totaldecontra").before('<div class="alert alert-danger col-md-12" role="alert" style="position: absolute; z-index:1;">El total debe de ser menor a 100%</div>');
            colocaNotificacion("", "El total debe de ser menor a 100%", "error", "right bottom");
             // desactivaNavegacion(true);
        }
    } else {
        if ((total <= 0 || total > 100)) {
            // $("#totaldecontra").before('<div class="alert alert-danger col-md-12" role="alert" style="position: absolute; z-index:1;">La suma debe ser mayor a 0% y menor a 100%</div>');
            colocaNotificacion("", "La suma debe ser mayor a 0% y menor a 100%", "error", "right bottom");
             // desactivaNavegacion(true);
        }
    }
    $("#totaldecontra").html("0");
}

function obtenervaloresdemodalmodal1() {
    var valoresModal1 = {
        ene: parseFloat($('#ene').val() !== "" ? $('#ene').val() : "0"),
        feb: parseFloat($('#feb').val() !== "" ? $('#feb').val() : "0"),
        mar: parseFloat($('#mar').val() !== "" ? $('#mar').val() : "0"),
        abr: parseFloat($('#abr').val() !== "" ? $('#abr').val() : "0"),
        may: parseFloat($('#may').val() !== "" ? $('#may').val() : "0"),
        jun: parseFloat($('#jun').val() !== "" ? $('#jun').val() : "0"),
        jul: parseFloat($('#jul').val() !== "" ? $('#jul').val() : "0"),
        ago: parseFloat($('#ago').val() !== "" ? $('#ago').val() : "0"),
        sep: parseFloat($('#sep').val() !== "" ? $('#sep').val() : "0"),
        oct: parseFloat($('#oct').val() !== "" ? $('#oct').val() : "0"),
        nov: parseFloat($('#nov').val() !== "" ? $('#nov').val() : "0"),
        dic: parseFloat($('#dic').val() !== "" ? $('#dic').val() : "0")
    };
    return valoresModal1;
}

function editarPrograma(elem) {
    eliminaNotificacion();
    indiceEditar = tablaPrograma.row($(elem).parent().parent()).index();
    var datosFila = tablaPrograma.row(indiceEditar).data();
    $('#contrato').val(datosFila['concepto']);
    $('#ene').val(datosFila['porcentaje_enero']);
    $('#feb').val(datosFila['porcentaje_febrero']);
    $('#mar').val(datosFila['porcentaje_marzo']);
    $('#abr').val(datosFila['porcentaje_abril']);
    $('#may').val(datosFila['porcentaje_mayo']);
    $('#jun').val(datosFila['porcentaje_junio']);
    $('#jul').val(datosFila['porcentaje_julio']);
    $('#ago').val(datosFila['porcentaje_agosto']);
    $('#sep').val(datosFila['porcentaje_septiembre']);
    $('#oct').val(datosFila['porcentaje_octubre']);
    $('#nov').val(datosFila['porcentaje_noviembre']);
    $('#dic').val(datosFila['porcentaje_diciembre']);
    $("#totaldecontra").html(datosFila['porcentaje_total'] + "%");
    $("#isEdit").val("1");
    $("#modal1").modal("show");
}

function eliminarPrograma(elem) {
    // bootbox.confirm("Se eliminar\u00e1 el concepto, \u00BFDesea Continuar?", function(response) {
    if (confirm("Se eliminar\u00e1 el concepto, \u00BFDesea Continuar?")) {
        var indiceEliminar = tablaPrograma.row($(elem).parent().parent()).index();
        var montosCancel = tablaPrograma.cell(indiceEliminar, 8).data();
        var datosFila = tablaPrograma.row(indiceEliminar).data();
        if (datosFila['id'] !== "") {
            arrayProgramasEliminados.push(datosFila['id']);
        }
        tablaPrograma.row(indiceEliminar).remove().draw();
        // actualizaTotales();
    }
    // });
}

function limpiar(limformularios) {
    $("#" + limformularios + " :input").each(function() {
        $(this).val('');
    });
}

function colocaNotificacion(elem, aviso, clase, posicion) {
    if (!elem) {
        $.notify(aviso, {
            autoHide: false,
            clickToHide: false,
            className: clase,
            position: posicion
        });
    } else {
        $(elem).notify(aviso, {
            autoHide: false,
            clickToHide: false,
            className: clase,
            position: posicion
        });
    }
}

function eliminaNotificacion() {
    $('.notifyjs-wrapper').trigger('notify-hide');
}

// function desactivaNavegacion(errornav) {
//     if (errornav) {
//         $("ul.nav-tabs>li").addClass('error');
//     } else {
//         $("ul.nav-tabs>li").removeClass('error');
//     }
// }

function guardarPrograma() {
    var id_contrato = $("#id_contrato").val();
    if (!error) {
        var arrayPrograma = [];
        
        var programas = tablaPrograma.rows().data();
        for (var i = 0; i < programas.length; i++) {
            arrayPrograma.push(programas[i]);
        }
        
        $.ajax({
            data: {
                'calendarizadoPrograma': arrayPrograma,
                'programasEliminados': arrayProgramasEliminados,
                'id_contrato': id_contrato,
            },
            url: '/ExpedienteTecnico/Autorizacion/guardar_programa_contrato',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
                console.log(response);
                if (!response.error) {
                    var id = (response);
                    if (id) {
                        for (var i = 0; i < id.length; i++) {
                            console.log(id);
                            tablaPrograma.cell(i, 0).data(parseInt(id[i])).draw();
                        }
                        // tablaPrograma.column(0).visible(false);
                        // eliminaWaitGeneral();
                        BootstrapDialog.mensaje(null, "Datos del Programa guardados correctamente. ", 1);
                    }
                    guardado = true;
                    // console.log(tablaConceptos.data());
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
        
    }
}