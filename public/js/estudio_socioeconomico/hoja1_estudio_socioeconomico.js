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
        url: '/EstudioSocioeconomico/guardar_hoja_1',
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
                    $.notify("Datos guardados correctamente.", "success");
                    $("#estudio_socioeconomico").val(data.id_estudio_socioeconomico);
                    $("#id_hoja_uno").val(data.id_anexo_uno_estudio);
                } else {
                    $.notify(data.error, "error");
                    if (data.error_validacion) {}
                }
            } else {
                for (property in data.error_validacion) {
                    $("#" + property).notify("Campo requerido", "error");
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}