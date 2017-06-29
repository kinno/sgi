var montoMasIVA = 0.00;
$(document).ready(function() {
    $('.porcentaje').autoNumeric('init', {
        vMin: '0.00000',
        vMax: '100.00000'
    });
    $("#importe_anticipo").on("change", function() {
        $("#isAutorizedAnticipo").val("0");
        montoMasIVA = parseFloat($("#monto").val().replace(/,/g, ""));
        cambioMontoAnticipo("monto");
    });
    $("#porcentaje_anticipo").on("change", function() {
        if ($(this).val() !== "") {
            var valPje = parseFloat($(this).val());
            montoMasIVA = parseFloat($("#monto").val().replace(/,/g, ""));
            $("#importe_anticipo").val(((valPje * montoMasIVA) / 100).toFixed(2));
            cambioMontoAnticipo("pje");
            // asignaCalendarizadosToContrato();
            $('.number').autoNumeric("update");
        }
    });
    $('#fecha_inicio_garantia').datepicker({
        language: "es",
        weekStart: 1, format: "dd-mm-yyyy",
        autoclose: true
    }).on('changeDate', function (selected) {
        $('#fecha_fin_garantia').datepicker('setStartDate', new Date(selected.date.valueOf()));
    });

    $('#fecha_inicio_garantia_cumplimiento').datepicker({
        language: "es",
        weekStart: 1, format: "dd-mm-yyyy",
        autoclose: true
    }).on('changeDate', function (selected) {
        $('#fecha_fin_garantia_cumplimiento').datepicker('setStartDate', new Date(selected.date.valueOf()));
    });

    
});

function cambioMontoAnticipo(origen) {
    if (parseFloat($("#importe_anticipo").val() !== "" ? $("#importe_anticipo").val().replace(/,/g, "") : "0") <= parseFloat($("#importe_garantia").val() !== "" ? $("#importe_garantia").val().replace(/,/g, "") : "0")) {
        if (parseFloat($("#importe_anticipo").val() !== "" ? $("#importe_anticipo").val().replace(/,/g, "") : "0") > (montoMasIVA * 0.30) && parseFloat($("#importe_anticipo").val() !== "" ? $("#importe_anticipo").val().replace(/,/g, "") : "0") <= (montoMasIVA * 0.50)) {
            BootstrapDialog.mensaje(null, "El monto del anticipo supera el 30%", 3, function() {
                $("#importe_anticipo,#porcentaje_anticipo").parent().addClass('has-error');
            });
        }
        $("#importe_anticipo,#porcentaje_anticipo").parent().removeClass('has-error');
    } else {
        BootstrapDialog.mensaje(null, "El monto del anticipo es mayor al monto de la garantía ", 3, function() {
            $("#importe_anticipo").parent().addClass('has-error');
        });
    }
    if (origen !== "pje") {
        calculaPje();
    }
    // asignaCalendarizadosToContrato();
}

function calculaPje() {
    $("#porcentaje_anticipo").val(((parseFloat($("#importe_anticipo").val() !== "" ? $("#importe_anticipo").val().replace(/,/g, "") : "0") * 100) / montoMasIVA).toFixed(5));
}

function guardarGarantias(){
	var valoresGarantias = $("#form_garantias").serialize();
    valoresGarantias+='&id_contrato='+$("#id_contrato").val();
    $.ajax({
        data: valoresGarantias,
        url: '/ExpedienteTecnico/Autorizacion/guardar_contrato_garantias',
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
                    BootstrapDialog.mensaje(null, "Garantías del contrato guardados correctamente.", 1);
                    $("#form_garantias").find('.has-error').each(function(){
                    	$(this).removeClass('has-error');
                    });
                } else {
                    BootstrapDialog.mensaje(null, data.error, 3);
                }
            } else {
            	$.notify('Por favor llenar los campos seleccionados',"error");
                for (property in data.error_validacion) {
                    $("#" + property).parent().addClass('has-error');
                    // desactivaNavegacion(true);
                }
            }
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}