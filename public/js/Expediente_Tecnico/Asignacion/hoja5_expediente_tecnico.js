function llenarHoja5(id_expediente_tecnico, hoja5) {
    $("#form_anexo_cinco #id_hoja_cinco").val(hoja5.id);
    $("#form_anexo_cinco #id_expediente_tecnico").val(id_expediente_tecnico);
    $("#observaciones_unidad_ejecutora").val(hoja5.observaciones_unidad_ejecutora);
}

function guardarHoja5() {
    if( $("#form_anexo_cinco #id_expediente_tecnico").val()===""){
         $("#form_anexo_cinco #id_expediente_tecnico").val( $("#form_anexo_uno #id_expediente_tecnico").val());
    }
    var valoresh5 = $("#form_anexo_cinco").serialize();
    $.ajax({
        data: valoresh5,
        url: '/ExpedienteTecnico/Asignacion/guardar_hoja_5',
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
                    BootstrapDialog.mensaje(null, "Datos del Anexo 5 guardados correctamente.<br>Folio de Expediente Técnico: " + data.id_expediente_tecnico, 1);
                    // $.notify("Datos guardados correctamente.", "success");
                    $("#form_anexo_cinco #id_expediente_tecnico").val(data.id_expediente_tecnico);
                    $("#id_hoja_cinco").val(data.id_anexo_cinco);
                    
                } else {
                    BootstrapDialog.mensaje(null, data.error, 3);
                    // $.notify(data.error, "error");
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