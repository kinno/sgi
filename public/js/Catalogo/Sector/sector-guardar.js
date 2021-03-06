$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	Triggers ();
	LimpiaSector ();
});

function LimpiaSector () {
	//var vacio ='<option value="0">- Selecciona</option>';
	//$('#id_departamento').html(vacio).val('0');
	$('#clave, #unidad_responsabvle, #nombre, #titulo, #titular, #apellido, #cargo').val('');
	$('#bactivo').prop('checked', true);
	$("#btnGuardar").removeAttr("disabled");
	$("[id^='err_']" ).hide();
    //if ($('#id_area').val() != '0')
    //    $('#id_area').change();
}


function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';
	
	// evento Area
	$('#id_area').unbind("change").on('change', function (){
		var id = $('#id_area').val();
		if (id == '0')
		    $('#id_departamento').html(vacio);
		else {
			$.ajax({
	            data: {
	                id: id
	            },
	            url: '/Catalogo/Sector/dropdownArea',
	            type: 'POST',
	            success: function (data) {
	            	console.log(data);
	            	$('#div_id_departamento').removeClass('has-error has-feedback');
	            	$('#err_id_departamento').hide();
	            	$('#id_departamento').html(data);
            	},
                error: function(data) {
                    console.log("Errores::", data);
                }
            });
		}
    });

	// evento cambio, para ocultar error
	$('#id_departamento, #clave, #unidad_responsdable, #nombre, #titulo, #titular, #apellido, #cargo').unbind("change").on('change', function (){
		$('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
		$('#err_' + $(this).attr('id')).hide();
	});

	// botón guardar
	$('#btnGuardar').unbind('click').on('click', function () {		
	   guardaSector ();
    });

    // botón Regresar
    $('#btnRegresar').unbind('click').on('click', function () {      
        window.location='/Catalogo/Sector';
    });
}

function guardaSector () {
    var data = new FormData($("form#Sector")[0]);
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: data,
        url: '/Catalogo/Sector',
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
	                	window.location='/Catalogo/Sector';
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
