jQuery(document).ready(function($) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('.numero').autoNumeric({
		aSep: '',
		mDec: 0,
		vMin: 0,
		vMax: 99999999
	});
	$.fn.datepicker.dates['esp'] = {
		days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"],
		daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
		months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
		monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		today: "Hoy",
		clear: "Limpiar",
		format: "mm/dd/yyyy",
		titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
		weekStart: 0
	};
	$('#fecha_firma').datepicker({
		language: "esp",
		//weekStart: 0,
		format: "dd-mm-yyyy",
		daysOfWeekDisabled: '0,6',
		todayBtn: 'linked',
		todayHighlight: true,
		autoclose: true
	});
	//startDate
	//setStartDate
	Triggers ();
	LimpiaFirma ();
});

function LimpiaFirma () {
	var tblvacia = '<tr><td colspan="5" class="text-center"></td></tr>'
	$("#clave_oficio_search").val('');
	if ($('#id_estatus').children().length > 1)
		$('#id_estatus').val('0');
	$('#clave, #solicitud_presupuesto, #fecha_oficio, #fecha_firma').val('');
	$('.has-error').removeClass('has-error has-feedback');
	$("[id^='err_']" ).hide();
	$('#btnGuardar, #fecha_firma, #id_estatus').attr("disabled","disabled");
	$('#detObras').html(tblvacia);
}

function HabilitaCampos () {
	$('#id_estatus').removeAttr('disabled');
	$("#btnGuardar").removeAttr("disabled");
}

function Triggers () {
	// evento Estado Oficio
	$('#id_estatus').unbind("change").on('change', function () {
		if ($('#id_estatus').val() == '1')
			$('#fecha_firma').removeAttr("disabled");
		else
			$('#fecha_firma').val('').attr("disabled", "disabled");
		$('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
		$('#err_' + $(this).attr('id')).hide();
	});

	// evento cambio, para ocultar error
	$('#fecha_firma').unbind("change").on('change', function (){
		$('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
		$('#err_' + $(this).attr('id')).hide();
	});

	//evento ENTER en Numero de Control
	$('input').on('keypress',function(ev) {
		if (ev.which == 13) {
		   if ($(this).attr('id') == 'clave_oficio_search')
			  $('#btnBuscar').trigger('click');
		   return false;
		}
   });
	// botón Buscar
	$('#btnBuscar').on('click', function () {
		if ($('#clave_oficio_search').val() * 1 == 0)
			BootstrapDialog.mensaje (null, 'Introduzca No. de Oficio', 2);
		else
			muestraOficio ();
		return false;
	});

	// botón guardar
	$('#btnGuardar').unbind('click').on('click', function () {      
		guardaFirmaOficio ();
	});

	// botón Limpiar
	$('#btnLimpiar').unbind('click').on('click', function () {      
		LimpiaFirma ();
	});
}

function muestraOficio () {
	$.ajax({
		data: {
			'clave': $("#clave_oficio_search").val()
		},
		url: '/Oficios/buscar_ofi',
		type: 'post',
		beforeSend: function() {
			$("#divLoading h3").text('Buscando . . .');
			$("#divLoading").show();
		},
		complete: function() {
			$("#divLoading").hide();
		},
		success: function(data) {
			console.log(data);
			if (!data.error) {
				LimpiaFirma ();
				$('#clave').val(data.clave);
				$('#solicitud_presupuesto').val(data.tipo_solicitud.nombre);
				$("#fecha_oficio").val(data.fecha_oficio);
				if (data.id_estatus == 3)
					$('#id_estatus').val('0');
				else {
					$('#id_estatus').val(data.id_estatus);
					if (data.id_estatus == 1)
						$("#fecha_firma").val(data.fecha_firma).datepicker('setStartDate', data.fecha_oficio);
				}
				$("#detObras").html(data.tabla);
				$('#id_estatus').change();
				HabilitaCampos ();
			} 
			else 
				BootstrapDialog.mensaje (null, data.error, 2);
		},
		error: function(response) {
			console.log("Errores::", response);
		}
	});
}



function guardaFirmaOficio () {
	var data = new FormData($("form#Firma_Oficios")[0]);
	$("#btnGuardar").attr("disabled","disabled");
	$.ajax({
		data: data,
		url: '/Oficios/guarda_firma',
		type: 'POST',
		processData: false,
		contentType: false,
		beforeSend:function(){
			$("#divLoading h3").text('Guardando . . .');
			$("#divLoading").show();
		},
		complete:function(){
			//$("#btnGuardar").removeAttr("disabled");
			$("#divLoading").hide();
		},
		cache: false,
		success: function(data) {
			console.log(data);
			$("#btnGuardar").removeAttr("disabled");
			if (!data.errores) {
				BootstrapDialog.mensaje (null, data.mensaje, data.error);
				if (data.error == 1)
					LimpiaFirma();
			} 
			else {
				var n = 0;
				for (campo in data.errores) {
					n++;
					campo_err = campo;
					$("#" + campo).notify(data.errores[campo][0], "error");
					$('#div_' + campo).addClass('has-error has-feedback');
					$('#err_' + campo).show();
				}
				if (n == 1)
					BootstrapDialog.mensaje (null, data.errores[campo_err][0], 3);
				else
					BootstrapDialog.mensaje (null, 'Se encontraron errores en la captura', 3);
			}
		},
		error: function(data) {
			console.log("Errores:: ", data);
			BootstrapDialog.mensaje (null, 'Error', 2);
			$("#btnGuardar").removeAttr("disabled");
		}
	});
}
