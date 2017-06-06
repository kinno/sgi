$(document).ready(function() {
    $("#accion_estatal,#accion_federal").select2({
        placeholder: "Seleccione una acción"
    });
    //Funciones para la suma de montos
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function() {
        suma();
    });
    $(".bt_ftefed").unbind("click").on("click", function() {
        addfed($(this));
    });
    $(".bt_fteest").unbind("click").on("click", function() {
        addest($(this));
    });
    $('.numero').autoNumeric();
    $('.number-int').autoNumeric({
        mDec: 0
    });
    $('.number-oneDec').autoNumeric({
        mDec: 2
    });
    $('.monfed,.monest,.monmun').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $('#monto').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $('#numerobanco').autoNumeric({
        aSep: '',
        mDec: 0,
        vMin: '0'
    });
    $('.numeroDecimal').autoNumeric({
        mDec: 2
    });
    $("#id_tipo_solicitud").on('change', function() {
        if ($(this).val() == "1" || $(this).val() == "9") {
            $("#id_modalidad_ejecucion").val("1");
            $("#id_modalidad_ejecucion").prop("readonly", true);
        } else if ($(this).val() == "10") {
            $("#id_modalidad_ejecucion").val("2");
            $("#id_modalidad_ejecucion").prop("readonly", true);
        } else {
            $("#id_modalidad_ejecucion").prop("readonly", false);
        }
    });
    $("#bevaluacion_socioeconomica").click(function() {
        var valevasoc = $("#bevaluacion_socioeconomica").val();
        if (valevasoc === "1" || valevasoc === "3") {
            $('#nes').removeAttr('hidden');
            $('#nes').addClass('obligatorioHoja1');
        } else {
            $('#nes').attr('hidden', 'hidden');
            $('#nes').removeClass('obligatorioHoja1');
        }
    });
    $("#id_estudio_socioeconomico").change(function() {
        buscarBanco();
    });
    $("#botro").on('click', function() {
        if ($(this).prop('checked')) {
            $("#otro").show();
        } else {
            $("#otro").hide();
        }
    });
});

function addfed(elem, callback) {
    var newElem = elem.parents(".ftefederal").clone();
    newElem.find("input").val("");
    newElem.find("select").val("");
    newElem.find(".bt_ftefed").val("-").unbind("click").on("click", function() {
        delRow($(this));
    });
    elem.parents("div").parent().find(".ftefederal").last().after(newElem);
    $('.monfed,.monest').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function() {
        suma();
    });
    // $("select[name='ffed[]']").unbind("change").on("change", function() {
    //     // fuenteFMHTML = this;
    //     // verificaFM(this);
    // });
    if (typeof(callback) === "function") {
        callback();
    }
}

function addest(elem, callback) {
    var newElem = elem.parents(".fteestatal").clone();
    newElem.find("input").val("");
    newElem.find("select").val("");
    newElem.find(".bt_fteest").val("-").unbind("click").on("click", function() {
        delRow($(this));
    });
    elem.parents("div").parent().find(".fteestatal").last().after(newElem);
    $('.monfed,.monest').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function() {
        suma();
    });
    if (typeof(callback) === "function") {
        callback();
    }
}

function delRow(elem) {
    elem.parent("div").remove();
    suma();
}

function suma() {
    var montofed = 0;
    var montoest = 0;
    var montomun = 0;
    $('.monfed').each(function() {
        var montofed1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : 0;
        montofed = montofed + parseFloat(montofed1);
    });
    $('.monest').each(function() {
        var montoest1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : 0;
        montoest = montoest + parseFloat(montoest1);
    });
    montomun = $.trim($('.monmun').val()) !== "" ? (parseFloat(($('.monmun').val()).replace(/,/g, "")) * 1) : 0;
    var total = parseFloat(montofed) + parseFloat(montoest) + parseFloat(montomun);
    $("#monto").val(total);
    $("#monto").focusin().focusout();
}

function guardarHoja1() {
    var valoresh1 = $("#form_anexo_uno").serialize();
    $.ajax({
        data: valoresh1,
        url: '/ExpedienteTecnico/Asignacion/guardar_hoja_1',
        type: 'post',
        beforeSend: function() {
            $("#divLoading").show();
        },
        complete: function() {
            $("#divLoading").hide();
        },
        success: function(response) {
            var data = response;
            if (!data.error_validacion) {
                if (!data.error) {
                    BootstrapDialog.mensaje(null, "Datos del Anexo 1 guardados correctamente.<br>Folio de Expediente Técnico: " + data.id_expediente_tecnico, 1);
                    // $.notify("Datos guardados correctamente.", "success");
                    desactivaNavegacion(false);
                    $("#id_expediente_tecnico").val(data.id_expediente_tecnico);
                    $("#id_hoja_uno").val(data.id_anexo_uno);
                    if(data.id_anexo_dos){
                        $("#form_anexo_dos #id_hoja_dos").val(data.id_anexo_dos);

                    }
                    
                } else {
                    BootstrapDialog.mensaje(null, data.error, 3);
                    // $.notify(data.error, "error");
                    if (data.error_validacion) {}
                }
            } else {
                for (property in data.error_validacion) {
                    $("#" + property).notify("Campo requerido", "error");
                    desactivaNavegacion(true);
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}

function llenarHoja1(id_expediente_tecnico, hoja1, acuerdos, fuentes, tipo,id_estudio_socioeconomico) {
    if (tipo == 'expediente') {
        var disabled = false;
        $("[name='monto_fuente_federal[]'],[name='monto_fuente_estatal[]'],[name='fuente_federal[]'],[name='fuente_estatal[]']").prop('readonly', disabled);
        $("#id_hoja_uno").val(hoja1.id);
        $("#id_tipo_solicitud").val(hoja1.id_tipo_solicitud);
        $("#bevaluacion_socioeconomica").val(hoja1.bevaluacion_socioeconomica).click();
        $("#id_estudio_socioeconomico").val(id_estudio_socioeconomico);
        $("#id_expediente_tecnico").val(id_expediente_tecnico);
        if (hoja1.bestudio_socioeconomico) {
            $("#bestudio_socioeconomico").prop('checked', true);
        }
        if (hoja1.bproyecto_ejecutivo) {
            $("#bproyecto_ejecutivo").prop('checked', true);
        }
        if (hoja1.bderecho_via) {
            $("#bderecho_via").prop('checked', true);
        }
        if (hoja1.bimpacto_ambiental) {
            $("#bimpacto_ambiental").prop('checked', true);
        }
        if (hoja1.bobra) {
            $("#bobra").prop('checked', true);
        }
        if (hoja1.baccion) {
            $("#baccion").prop('checked', true);
        }
        if (hoja1.botro) {
            $("#botro").prop('checked', true);
        }
    } else {
        var disabled = true;
        $("[name='monto_fuente_federal[]'],[name='monto_fuente_estatal[]'],[name='fuente_federal[]'],[name='fuente_estatal[]']").prop('readonly', disabled);
    }
    $("#ejercicio").val(hoja1.ejercicio).prop('readonly', disabled);
    $("#nombre_obra").val(hoja1.nombre_obra).prop('readonly', disabled);
    $("#unidad_ejecutora").val(hoja1.unidad_ejecutora.nombre).prop('readonly', disabled);
    $("#id_unidad_ejecutora").val(hoja1.unidad_ejecutora.id).prop('readonly', disabled);
    $("#id_sector").val(hoja1.sector.id).prop('readonly', disabled);
    $("#sector").val(hoja1.sector.nombre).prop('readonly', disabled);
    arrAcuerdos = [];
    for (var i = 0; i < acuerdos.length; i++) {
        arrAcuerdos.push(acuerdos[i].id);
    }
    $("#accion_federal,#accion_estatal").val(arrAcuerdos).trigger('change').prop('readonly', disabled);
    $("#justificacion_obra").val(hoja1.justificacion_obra).prop('readonly', disabled);
    $("#id_modalidad_ejecucion").val(hoja1.id_modalidad_ejecucion).prop('readonly', disabled);
    $("#id_tipo_obra").val(hoja1.id_tipo_obra).prop('readonly', disabled);
    $("#monto").val(hoja1.monto).autoNumeric('update').prop('readonly', disabled);
    $("#principales_caracteristicas").val(hoja1.principales_caracteristicas).prop('readonly', disabled);
    $("#id_meta").val(hoja1.id_meta).prop('readonly', disabled);
    $("#cantidad_meta").val(hoja1.cantidad_meta).autoNumeric('update').prop('readonly', disabled);
    $("#id_beneficiario").val(hoja1.id_beneficiario).prop('readonly', disabled);
    $("#cantidad_beneficiario").val(hoja1.cantidad_beneficiario).autoNumeric('update').prop('readonly', disabled);
    j = 0;
    for (var i = 0; i < fuentes.length; i++) {
        if (fuentes[i].pivot.tipo_fuente == 'F') {
            if (i === 0) {
                $(".monfed:first").val(fuentes[i].pivot.monto).autoNumeric('update');
                $('select[name="fuente_federal[]"]:eq(0) option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
            } else {
                addfed($(".monfed:first"), function() {
                    $(".monfed:eq(" + i + ")").val(fuentes[i].pivot.monto).autoNumeric('update');
                    $('select[name="fuente_federal[]"]:eq(' + i + ') option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
                });
            }
        } else {
            if (j === 0) {
                $(".monest:first").val(fuentes[i].pivot.monto).autoNumeric('update');
                $('select[name="fuente_estatal[]"]:eq(0) option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
            } else {
                addest($(".monest:first"), function() {
                    $(".monest:eq(" + j + ")").val(fuentes[i].pivot.monto).autoNumeric('update');
                    $('select[name="fuente_estatal[]"]:eq(' + j + ') option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
                });
            }
            j++;
        }
    }
    //     if (info.infoFteFed[i].idFte === "134" || info.infoFteFed[i].idFte === "136") {
    //         $("#isFM").val("1");
    //         $("#idDetFon").val(info.FM.IdDetFon);
    //         $('select[name="ffed[]"]:eq(' + i + ') option[value=' + info.infoFteFed[i].idFte + ']').parent().parent().parent().popover({
    //             html: true,
    //             animation: true,
    //             trigger: "focus",
    //             content: "<p style='width: 150px;'>Proyecto seleccionado: <b>" + info.FM.CvePry + " - " + info.FM.NomPry + "</b></p><p>Monto disponible: <b>$<span class='numeroDecimal'>" + info.FM.disponiblePry + "</span></b></p><p><span class='btn btn-default' onclick='cambioProyectoFM(" + info.FM.idFte + ");'>Cambiar proyecto</span></p>",
    //             placement: "top"
    //         }).on('shown.bs.popover', function() {
    //             $('.numeroDecimal').autoNumeric({
    //                 mDec: 2
    //             });
    //         });
    //     }
    // }
    $("#monto_municipal").val(hoja1.monto_municipal).autoNumeric('update').prop('readonly', disabled);
    $("#fuente_municipal").val(hoja1.fuente_municipal).prop('readonly', disabled);
}