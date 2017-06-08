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
	$('#id_exp_tec, #id_det_obra').val('');
	if ($('#id_estatus').children().length > 1)
		$('#id_estatus').val('0');
	$('#clave, #solicitud_presupuesto, #fecha_oficio, #fecha_firma').val('');
	$('.has-error').removeClass('has-error has-feedback');
	$("[id^='err_']" ).hide();
	$('#btnGuardar, #fecha_firma, #id_estatus').attr("disabled","disabled");
	$('#detObras').html(tblvacia);
}

function HabilitaCamposObra (asignado, cuenta_federal, cuenta_estatal) {
	$('#id_clasificacion_obra, #id_grupo_social').removeAttr('disabled');
	if (!asignado)
		$('#programa, #id_proyecto_ep').removeAttr('disabled');
	if (cuenta_federal) {
		$('.cuenta_federal .numcta').removeAttr('disabled');
		$('.cuenta_federal .partida').removeAttr('disabled');
	}
	if (cuenta_estatal) {
		$('.cuenta_estatal .numcta').removeAttr('disabled');
		$('.cuenta_estatal .partida').removeAttr('disabled');
	}
	$("#btnGuardar").removeAttr("disabled");
}

function HabilitaCampos () {
	$('#id_unidad_ejecutora').removeAttr('disabled');
	$('#id_modalidad_ejecucion, #ejercicio, #id_clasificacion_obra, #id_sector').removeAttr('disabled');
	$('#id_unidad_ejecutora, #id_cobertura, #programa, #id_proyecto_ep, #id_grupo_social').removeAttr('disabled');
	$("#id_region, #id_municipio, #id_acuerdo_est, #id_acuerdo_fed").removeAttr('disabled');
	$('#nombre, #justificacion, #caracteristicas, #localidad').removeAttr('disabled');
	$('.monfed, .monest, .numftef, .numftee, .numcta, .partida').removeAttr('disabled');
	$('.bt_ftefed, .bt_fteest').removeAttr("disabled");
	$("#btnGuardar").removeAttr("disabled");
}

function inHabilitaCampos () {
	$('#id_unidad_ejecutora').attr("disabled","disabled");
	$('#id_modalidad_ejecucion, #ejercicio, #id_clasificacion_obra, #id_sector').attr("disabled","disabled");
	$('#id_unidad_ejecutora, #id_cobertura, #programa, #id_proyecto_ep').attr("disabled","disabled");
	$("#id_region, #id_municipio, #id_acuerdo_est, #id_acuerdo_fed").attr("disabled","disabled");
	$('#nombre, #justificacion, #caracteristicas, #localidad, #id_grupo_social').attr("disabled","disabled");
	$('.monfed, .monest, .numftef, .numftee, .numcta, .partida').attr("disabled","disabled");
	$('.bt_ftefed, .bt_fteest').attr("disabled","disabled");
	$("#btnGuardar").attr("disabled","disabled");
}



function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';

	// evento cambio, para ocultar error
	$('#id_modalidad_ejecucion, #id_clasificacion_obra, #id_unidad_ejecutora, #id_proyecto_ep, #nombre, #id_municipio, #id_region').unbind("change").on('change', function (){
		$('#div_' + $(this).attr('id')).removeClass('has-error has-feedback');
		$('#err_' + $(this).attr('id')).hide();
	});
	// selects Fuente
	$('body').on('change','#monto_federal, #fuente_federal, #cuenta_federal, #monto_estatal, #fuente_estatal, #cuenta_estatal, #partida_federal, #partida_estatal', function () {
		$(this).parent().parent().removeClass('has-error has-feedback');
		$(this).siblings('span').hide();
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
		if ($('#accion').val() == '1') {
			if ($('#id_expediente_tecnico').val() * 1 == 0)
				BootstrapDialog.mensaje (null, 'Introduzca No. de Expediente', 2);
			else
				muestraExpediente ();
		}
		else {
			if ($('#id_obra1').val() * 1 == 0)
				BootstrapDialog.mensaje (null, 'Introduzca No. de Obra', 2);
			else if ($('#ejercicio_obra').val() * 1 == 0)
				BootstrapDialog.mensaje (null, 'Selecciona ejercicio', 2);
			else
				muestraObra ();
		}
		return false;
	});

	// botón guardar
	$('#btnGuardar').unbind('click').on('click', function () {      
		guardaObra ();
	});

	// botón Limpiar
	$('#btnLimpiar').unbind('click').on('click', function () {      
		$('#accion').val('0').change();
	});
}

function muestraExpediente () {
	$.ajax({
		data: {
			'id_expediente_tecnico': $("#id_expediente_tecnico").val()
		},
		url: '/Obra/buscar_expediente',
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
				LimpiaObra ();
				acuerdos = data.acuerdos;
				fuentes = data.fuentes_monto;
				$('#id_exp_tec').val(data.relacion.id_expediente_tecnico);
				$('#id_det_obra').val('');
				$("#id_modalidad_ejecucion").val(data.hoja1.id_modalidad_ejecucion);
				$("#ejercicio").val(data.ejercicio);
				//$("#id_clasificacion_obra").val(data.id_clasificacion_obra);
				$("#id_sector").val(data.hoja1.id_sector);
				$("#id_unidad_ejecutora").html(data.opciones.ue);
				$("#nombre").val(data.hoja1.nombre_obra);
				$("#justificacion").val(data.hoja1.justificacion_obra);
				$("#caracteristicas").val(data.hoja1.principales_caracteristicas);
				$("#id_cobertura").val(data.hoja2.id_cobertura).change();
				if (data.hoja2.id_cobertura == 2) {
					regiones = data.regiones;
					arrRegiones = [];
					for (var i = 0; i < regiones.length; i++) {
						arrRegiones.push(regiones[i].id);
					}
					$("#id_region").val(arrRegiones).trigger('change');
					$("#localidad").val(data.hoja2.nombre_localidad);
				}
				if (data.hoja2.id_cobertura == 3) {
					municipios = data.municipios;
					arrMunicipios = [];
					for (var i = 0; i < municipios.length; i++) {
						arrMunicipios.push(municipios[i].id);
					}
					$("#id_municipio").val(arrMunicipios).trigger('change');
					$("#localidad").val(data.hoja2.nombre_localidad);
				}
				$("#programa").html(data.opciones.programa);
				$("#id_proyecto_ep").html(data.opciones.proyecto);
				arrAcuerdos = [];
				for (var i = 0; i < acuerdos.length; i++) {
					arrAcuerdos.push(acuerdos[i].id);
				}
				$("#id_acuerdo_est, #id_acuerdo_fed").val(arrAcuerdos).trigger('change');
				j = 0;
				var cuenta_estatal = false, cuenta_federal = false;
				for (var i = 0; i < fuentes.length; i++) {
					if (fuentes[i].pivot.tipo_fuente == 'F') {
						cuenta_federal = true;
						if (i === 0) {
							$(".monfed:first").val(fuentes[i].pivot.monto).autoNumeric('update');
							$('select[name="fuente_federal[]"]:eq(0) option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
						}
						else {
							addfed($(".monfed:first"), function() {
								$(".monfed:eq(" + i + ")").val(fuentes[i].pivot.monto).autoNumeric('update');
								$('select[name="fuente_federal[]"]:eq(' + i + ') option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
							});
						}
					}
					else {
						cuenta_estatal = true;
						if (j === 0) {
							$(".monest:first").val(fuentes[i].pivot.monto).autoNumeric('update');
							$('select[name="fuente_estatal[]"]:eq(0) option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
						}
						else {
							addest($(".monest:first"), function() {
								$(".monest:eq(" + j + ")").val(fuentes[i].pivot.monto).autoNumeric('update');
								$('select[name="fuente_estatal[]"]:eq(' + j + ') option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
							});
						}
						j++;
					}
				}
				$(".monfed:first").change();
				HabilitaCamposObra (false, cuenta_federal, cuenta_estatal);
			} 
			else 
				BootstrapDialog.mensaje (null, data.error, 2);
		},
		error: function(response) {
			console.log("Errores::", response);
		}
	});
}



function guardaObra () {
	var accion = $('#accion').val() * 1, url = "";
	if (accion == 0) {
		BootstrapDialog.mensaje (null, 'Selecciona acción', 2);
		return;
	}
	if (accion <= 2)
		url = '/Obra/guardar';
	else
		url = '/Obra/update';
	var data = new FormData();
	data.append("accion", $('#accion').val());
	data.append("id_exp_tec", $('#id_exp_tec').val());
	data.append("id_det_obra", $('#id_det_obra').val());
	data.append("id_modalidad_ejecucion", $('#id_modalidad_ejecucion').val());
	data.append("ejercicio", $('#ejercicio').val());
	data.append("id_clasificacion_obra", $('#id_clasificacion_obra').val());
	data.append("id_sector", $('#id_sector').val());
	data.append("id_unidad_ejecutora", $('#id_unidad_ejecutora').val());
	data.append("nombre", $('#nombre').val());
	data.append("justificacion", $('#justificacion').val());
	data.append("caracteristicas", $('#caracteristicas').val());
	data.append("id_cobertura", $('#id_cobertura').val());
	if ($('#id_cobertura').val() == '2') {
		var arr = $('#id_region').val();
		for (i = 0; i < arr.length; i++)
			data.append("id_region[]", arr[i]);
	}
	if ($('#id_cobertura').val() == '3') {
		var arr = $('#id_municipio').val();
		for (i = 0; i < arr.length; i++)
			data.append("id_municipio[]", arr[i]);
	}
	data.append("localidad", $('#localidad').val());
	data.append("monto", $.trim($('#monto').val()) !== "" ? ((($('#monto').val()).replace(/,/g, "")) * 1) : '');
	$('.monfed').each(function() {
		var montofed1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : '';
		data.append("monto_federal[]", montofed1);
	});
	$('.numftef').each(function() {
		var ftefed = $.trim($(this).val()) != "0" ? $(this).val() * 1 : '';
		data.append("fuente_federal[]", ftefed);
	});
	$('.cuenta_federal .partida').each(function() {
		data.append("partida_federal[]", $(this).val());
	});
	$('.cuenta_federal .numcta').each(function() {
		data.append("cuenta_federal[]", $(this).val());
	});
	$('.monest').each(function() {
		var montoest1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : '';
		data.append("monto_estatal[]", montoest1);
	});
	$('.numftee').each(function() {
		var fteest = $.trim($(this).val()) != "0" ? $(this).val() * 1 : '';
		data.append("fuente_estatal[]", fteest);
	});
	$('.cuenta_estatal .partida').each(function() {
		data.append("partida_estatal[]", $(this).val());
	});
	$('.cuenta_estatal .numcta').each(function() {
		data.append("cuenta_estatal[]", $(this).val());
	});
	data.append("id_proyecto_ep", $('#id_proyecto_ep').val());
	var arr = $('#id_acuerdo_est').val();
	for (i = 0; i < arr.length; i++)
		data.append("id_acuerdo_est[]", arr[i]);
	var arr = $('#id_acuerdo_fed').val();
	for (i = 0; i < arr.length; i++)
		data.append("id_acuerdo_fed[]", arr[i]);
	data.append("id_grupo_social", $('#id_grupo_social').val());
	$("#btnGuardar").attr("disabled","disabled");
	$.ajax({
		data: data,
		url: url,
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
				BootstrapDialog.mensaje (null, data.mensaje, data.error);
				if (data.error == 1)
					$('#accion').val('0').change();
			} 
			else {
				var n = 0;
				for (campo in data.errores) {
					n++;
					campo_err = campo;
					var pos = campo.indexOf("."); 
					if (pos >= 0) {
						var i = campo.slice(pos + 1, campo.length) * 1;
						var campo = campo.slice(0, pos);
						var elem = $('.' + campo ).eq(i);
						$(elem).find('#div_' + campo).addClass('has-error has-feedback');
						$(elem).find('#err_' + campo).show();
					}
					else {
						//$("#" + campo).notify(data.errores[campo][0], "error");
						$('#div_' + campo).addClass('has-error has-feedback');
						$('#err_' + campo).show();
					}
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
		}
	});
}
