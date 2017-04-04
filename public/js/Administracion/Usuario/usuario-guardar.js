$(document).ready( function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	Triggers ();
	LimpiaUsuario ();
});

function LimpiaUsuario () {
	var vacio ='<option value="0">- Selecciona</option>';
	$('#id_unidad_ejecutora, #id_departamento').html(vacio);
    $('#id_tipo_usuario, #id_sector, #id_unidad_ejecutora, #id_area, #id_departamento').val('0');
	$('#username, #name, #email, #password, #password-confirm, #iniciales').val('');
	$('#bactivo').prop('checked', true);
	$("#btnGuardar").removeAttr("disabled");
	$("[id^='err_']" ).hide();
    $('#id_tipo_usuario').change();
}


function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';
	var str = "";
	
    // evento tipo usuario
    $('#id_tipo_usuario').unbind("change").on('change', function (){
        $('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
        $('#err_' + $(this).attr('id')).hide();
        $('#div_id_unidad_ejecutora, #div_id_departamento, #div_iniciales').removeClass('has-error has-feedback');
        $('#err_id_unidad_ejecutora, #err_id_departamento, #err_iniciales').hide();
        var id = $(this).val();
        if (id == '0') {
            $('#div_grupo_ue, #div_grupo_departamento, #div_iniciales').hide()
            $('#id_sector, #id_unidad_ejecutora, #id_area, #id_departamento').val('0');
            $('#iniciales').val('');
        }
        else if (id == '1') {
            $('#div_grupo_ue').show()
            $('#div_grupo_departamento, #div_iniciales').hide()
            $('#id_area, #id_departamento').val('0');
            $('#iniciales').val('');
        }
        else {
            $('#div_grupo_departamento, #div_iniciales').show();
            $('#div_grupo_ue').hide();
            $('#id_sector, #id_unidad_ejecutora').val('0');
        }
    });

	// evento Sector
    $('#id_sector').unbind("change").on('change', function (){
        var id = $('#id_sector').val();
        if (id == '0')
            $('#id_unidad_ejecutora').html(vacio);
        else {
            $.ajax({
                data: {
                    id: id
                },
                url: '/Administracion/Usuario/dropdown',
                type: 'POST',
                success: function (data) {
                    //console.log(data);
                    $('#div_id_unidad_ejecutora').removeClass('has-error has-feedback');
                    $('#err_id_unidad_ejecutora').hide();
                    $('#id_unidad_ejecutora').html(data);
                }
            });
        }
    });

    // evento Ejecutora
    $('#id_unidad_ejecutora').unbind("change").on('change', function (){
        var id = $(this).val();
        if (id != '0')
            $('#name').val($('#id_unidad_ejecutora option:selected').text());
   });

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
	            url: '/Catalogo/Sector/dropdown',
	            type: 'POST',
	            success: function (data) {
	            	//console.log(data);
	            	$('#div_id_departamento').removeClass('has-error has-feedback');
	            	$('#err_id_departamento').hide();
	            	$('#id_departamento').html(data);
            	}
            });
		}
   });

	// evento cambio, para ocultar error
	$('#username, #name, #email, #password, #iniciales').unbind("change").on('change', function (){
		$('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
		$('#err_' + $(this).attr('id')).hide();
	});

    // evento cambio, para ocultar error
    $('#password-confirm').unbind("change").on('change', function (){
        $('#div_password').removeClass('has-error has-feedback');
        $('#err_password').hide();
    });

	// evento guardar
	$('#btnGuardar').unbind('click').on('click', function () {		
	   guardaUsuario ();
   });
}

function guardaUsuario () {
    var data = new FormData($("form#Usuario")[0]);
    $("#btnGuardar").attr("disabled","disabled");
    $.ajax({
        data: data,
        url: '/Administracion/Usuario',
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
	                	window.location='/Administracion/Usuario';
	                });
                } 
                else
                    BootstrapDialog.mensaje (null, data.mensaje, data.error);
            } 
            else
                for (campo in data.errores) {
                    $("#" + campo).notify(data.errores[campo][0], "error");
                    $('#div_' + campo).addClass('has-error has-feedback');
                    $('#err_' + campo).show();
                }
        },
        error: function(data) {
            console.log("Errores::", data);
        }
    });
}