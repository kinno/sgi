$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.numero').autoNumeric({aSep:"", mDec:0, vMax:10});
	Triggers ();
	LimpiaMenu ();
});

function LimpiaMenu () {
	$('#id_menu_padre').val('0');
	$('#nombre, #descripcion, #orden, #ruta').val('');
    $('#div_ruta').hide();
	$("#btnGuardar").removeAttr("disabled");
	$("[id^='err_']" ).hide();
}


function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';

	// evento Menu Padre
    $('#id_menu_padre').unbind("change").on('change', function (){
        if ($(this).val() == '0') {
            $('#ruta').val('');
            $('#div_ruta').hide().removeClass('has-error has-feedback');
            $('#err_ruta').hide();
        }
        else {
            $('#div_ruta').show();
        }
    });

    // evento cambio, para ocultar error
	$('#nombre, #orden, #ruta').unbind("change").on('change', function (){
		$('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
		$('#err_' + $(this).attr('id')).hide();
	});

	// evento guardar
	$('#btnGuardar').unbind('click').on('click', function () {		
	   guardaMenu ();
   });
}

function guardaMenu () {
    var data = new FormData($("form#Menu")[0]);
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: data,
        url: '/Catalogo/Menu',
        type: 'POST',
        processData: false,
        contentType: false,
        beforeSend:function(){
            $("#divLoading h3").text('Guardando . . .');
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
	                	window.location='/Catalogo/Menu';
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