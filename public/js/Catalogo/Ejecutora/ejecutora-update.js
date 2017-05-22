$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("[id^='err_']" ).hide();
	Triggers ();
    $('#id_sector').change();
});


function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';

    // evento Sector
    $('#id_sector').unbind("change").on('change', function (){
        if ($(this).val() == '4') {
            $('#clave').val('');
            $('#div_clave').hide();
            $('#div_grupo_titular').show();
        }
        else {
            $('#titulo, #titular, #apellido, #cargo').val('');
            $('#div_clave').show();
            $('#div_grupo_titular').hide();
        }
        $('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
        $('#err_' + $(this).attr('id')).hide();
    });

    // evento cambio, para ocultar error
    $('#clave, #nombre, #titulo, #titular, #apellido, #cargo').unbind("change").on('change', function (){
        $('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
        $('#err_' + $(this).attr('id')).hide();
    });

    // botón guardar
    $('#btnGuardar').unbind('click').on('click', function () {      
       guardaEjecutora ();
   });

    // botón Regresar
    $('#btnRegresar').unbind('click').on('click', function () {      
        window.location='/Catalogo/Ejecutora?page=' + $('#page').val();
    });

}

function guardaEjecutora () {
    var id = $('#id').val();
    var data = new FormData($("form#Ejecutora")[0]);
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: data,
        url: '/Catalogo/Ejecutora/' + id,
        type: 'POST',
        processData: false,
        contentType: false,
        beforeSend:function(){
            $("#divLoading h3").text('Actualizando . . .');
            $("#divLoading").show();
        },
        complete:function(){
        	$("#btnGuardar").removeAttr("disabled");
            $("#divLoading").hide();
        },
        cache: false,
        success: function(data) {
            console.log(data);
            if (!data.errores) {
                if (data.error == 1) {
                    BootstrapDialog.mensaje (null, data.mensaje, 1, function () {
                        window.location='/Catalogo/Ejecutora?page=' + data.page;
                    });
                } 
                else
                    BootstrapDialog.mensaje (null, data.mensaje, data.error);
            } 
            else
                for (campo in data.errores) {
                    $("#" + campo).notify(data.errores[campo], "error");
                    $('#div_' + campo).addClass('has-error has-feedback');
                    $('#err_' + campo).show();
                }
        },
        error: function(data) {
            console.log("Errores::", data);
        }
    });
}