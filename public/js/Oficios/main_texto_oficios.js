$(document).ready(function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#limpiar").on('click', function() {
        location.reload();
    });
    $("#guardar").on('click', function() {
        guardarTexto();
    });
    $(".input-trigger").each(function() {
        $(this).on('change', function() {
            buscaTexto();
        });
    });
    $("#etiquetaTotal").click(function (){
        var txt = $("#texto").val();
        if(txt.indexOf('<<<Total>>>') != -1){
        	$("#texto").notify("Ya hay una etiqueta para el TOTAL en el texto", "error");
            $("#texto").focus();
            return false;
        }
        else{
            $("#texto").val($("#texto").val() + '<<<Total>>>');
        }
    });
});

function guardarTexto() {
    var datos = $("#form_texto_oficios").serialize();
    $.ajax({
        data: datos,
        url: '/Oficios/guardar_texto',
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
                    BootstrapDialog.mensaje(null, "Texto guardado correctamente", 1,function(){location.reload();});
                } else {
                    BootstrapDialog.mensaje(null, data.error, 3);
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
};

function buscaTexto() {
    if ($("#id_fuente").val() !== "") {
        var data = {
            'id_solicitud_presupuesto': $("#id_solicitud_presupuesto").val(),
            'ejercicio': $("#ejercicio").val(),
            'id_fuente': $("#id_fuente").val()
        }
        $.ajax({
            data: data,
            url: '/Oficios/buscar_texto',
            type: 'post',
            beforeSend: function() {
                $("#divLoading").show();
            },
            complete: function() {
                $("#divLoading").hide();
            },
            success: function(response) {
            	if(response){
            		$("#id").val(response.id);
            		$("#asunto").val(response.asunto);
            		$("#prefijo").val(response.prefijo);
            		$("#texto").val(response.texto);
            	}else{
            		$("#id").val("");
            		$("#asunto").val("");
            		$("#prefijo").val("");
            		$("#texto").val("");
            	}
                // console.log(response);
            },
            error: function(response) {
                console.log("Errores::", response);
            }
        });
    }
}