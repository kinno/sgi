$(document).ready(function() {
    $(".acumesfina").autoNumeric('init', {
        aSep: ',',
        mDec: 2
    });
    $(".acumesfinaAdmin").autoNumeric('init', {
        aSep: ',',
        mDec: 2
    });
    $('#meseneAdmin,#mesfebAdmin,#mesmarAdmin,#mesabrAdmin,#mesmayAdmin,#mesjunAdmin,#mesjulAdmin,#mesagoAdmin,#messepAdmin,#mesoctAdmin,#mesnovAdmin,#mesdicAdmin').unbind("change").on("change", function() {
        sumaAcumulado();
    });
});

function sumaAcumulado() {
    var totalPresupuesto = $("#monto").val().replace(/,/g, "");
    var totalPresupuestoFormat = $("#monto").val();
    var acumulados = obtenerValoresdeMeses();
    for (var i = 0; i < 12; i++) {
        if (acumulados[i] > totalPresupuesto) {
            colocaNotificacion('', "Excediste el monto del contrato ($" + totalPresupuestoFormat + ")", 'error', 'right bottom');
            $(".montoMesFinaAdmin").each(function() {
                $(this).parent().addClass('has-error');
            });
            error = true;
            if (i > 0) {
                $(".montoMesFina:gt( " + (i - 1) + " )").val("0");
            } else {
                $(".montoMesFina:eq( 0 )").val("0");
                $(".montoMesFina:gt( 0 )").val("0");
            }
            acumulados = obtenerValoresdeMeses();
            $(".acumesfinaAdmin:eq( " + i + " )").html(acumulados[i]);
            $(".acumesfinaAdmin:gt( " + i + " )").html(acumulados[i]);
            break;
        } else {
            eliminaNotificacion();
            error = false;
            $("#form_financiero").find('.has-error').each(function() {
                $(this).removeClass('has-error');
            });
            // desactivaNavegacion(false);
        }
        $(".acumesfinaAdmin:eq( " + i + " )").html(acumulados[i]);
    }
    $('.numero2').autoNumeric({
        aSep: ',',
        mDec: 2,
        vMin: '0.00'
    });
    $(".numero2").autoNumeric("update");
    var porcentajesAcu = new Array();
    for (var i = 0; i < 12; i++) {
        porcentajesAcu.push(((acumulados[i] * 100) / totalPresupuesto).toFixed(5));
        $('.pjeAcuFinaAdmin:eq(' + i + ')').html(porcentajesAcu[i]);
    }
    $(".acumesfinaAdmin").autoNumeric("update");
}

function obtenerValoresdeMeses() {
    var acumulados = [];
    var valoresMeses;
    valoresMeses = {
        mesene: $.trim($('#meseneAdmin').val()) !== "" ? parseFloat($('#meseneAdmin').val().replace(/,/g, "")) : 0,
        mesfeb: $.trim($('#mesfebAdmin').val()) !== "" ? parseFloat($('#mesfebAdmin').val().replace(/,/g, "")) : 0,
        mesmar: $.trim($('#mesmarAdmin').val()) !== "" ? parseFloat($('#mesmarAdmin').val().replace(/,/g, "")) : 0,
        mesabr: $.trim($('#mesabrAdmin').val()) !== "" ? parseFloat($('#mesabrAdmin').val().replace(/,/g, "")) : 0,
        mesmay: $.trim($('#mesmayAdmin').val()) !== "" ? parseFloat($('#mesmayAdmin').val().replace(/,/g, "")) : 0,
        mesjun: $.trim($('#mesjunAdmin').val()) !== "" ? parseFloat($('#mesjunAdmin').val().replace(/,/g, "")) : 0,
        mesjul: $.trim($('#mesjulAdmin').val()) !== "" ? parseFloat($('#mesjulAdmin').val().replace(/,/g, "")) : 0,
        mesago: $.trim($('#mesagoAdmin').val()) !== "" ? parseFloat($('#mesagoAdmin').val().replace(/,/g, "")) : 0,
        messep: $.trim($('#messepAdmin').val()) !== "" ? parseFloat($('#messepAdmin').val().replace(/,/g, "")) : 0,
        mesoct: $.trim($('#mesoctAdmin').val()) !== "" ? parseFloat($('#mesoctAdmin').val().replace(/,/g, "")) : 0,
        mesnov: $.trim($('#mesnovAdmin').val()) !== "" ? parseFloat($('#mesnovAdmin').val().replace(/,/g, "")) : 0,
        mesdic: $.trim($('#mesdicAdmin').val()) !== "" ? parseFloat($('#mesdicAdmin').val().replace(/,/g, "")) : 0
    };
    acumulados.push(valoresMeses.mesene);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep + valoresMeses.mesoct);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep + valoresMeses.mesoct + valoresMeses.mesnov);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep + valoresMeses.mesoct + valoresMeses.mesnov + valoresMeses.mesdic);
    return acumulados;
}

function guardar_avance_financiero() {
    var id_contrato = $("#id_contrato").val();
    if (!error) {
        var avanceFinanciero;
        avanceFinanciero = {
            enero: $.trim($('#meseneAdmin').val()) !== "" ? parseFloat($('#meseneAdmin').val().replace(/,/g, "")) : 0,
            febrero: $.trim($('#mesfebAdmin').val()) !== "" ? parseFloat($('#mesfebAdmin').val().replace(/,/g, "")) : 0,
            marzo: $.trim($('#mesmarAdmin').val()) !== "" ? parseFloat($('#mesmarAdmin').val().replace(/,/g, "")) : 0,
            abril: $.trim($('#mesabrAdmin').val()) !== "" ? parseFloat($('#mesabrAdmin').val().replace(/,/g, "")) : 0,
            mayo: $.trim($('#mesmayAdmin').val()) !== "" ? parseFloat($('#mesmayAdmin').val().replace(/,/g, "")) : 0,
            junio: $.trim($('#mesjunAdmin').val()) !== "" ? parseFloat($('#mesjunAdmin').val().replace(/,/g, "")) : 0,
            julio: $.trim($('#mesjulAdmin').val()) !== "" ? parseFloat($('#mesjulAdmin').val().replace(/,/g, "")) : 0,
            agosto: $.trim($('#mesagoAdmin').val()) !== "" ? parseFloat($('#mesagoAdmin').val().replace(/,/g, "")) : 0,
            septiembre: $.trim($('#messepAdmin').val()) !== "" ? parseFloat($('#messepAdmin').val().replace(/,/g, "")) : 0,
            octubre: $.trim($('#mesoctAdmin').val()) !== "" ? parseFloat($('#mesoctAdmin').val().replace(/,/g, "")) : 0,
            noviembre: $.trim($('#mesnovAdmin').val()) !== "" ? parseFloat($('#mesnovAdmin').val().replace(/,/g, "")) : 0,
            diciembre: $.trim($('#mesdicAdmin').val()) !== "" ? parseFloat($('#mesdicAdmin').val().replace(/,/g, "")) : 0
        };
        $.ajax({
            data: {
                'avance_financiero': avanceFinanciero,
                'id_contrato': id_contrato,
            },
            url: '/ExpedienteTecnico/Autorizacion/guardar_avance_financiero_contrato',
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
                    BootstrapDialog.mensaje(null, "Avance Financiero del contrato guardado correctamente.", 1);
                    guardado = true;
                } else {
                    BootstrapDialog.mensaje(null, response.error, 3);
                }
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    } else {
        BootstrapDialog.mensaje(null, "Existe error. ", 2);
    }
}