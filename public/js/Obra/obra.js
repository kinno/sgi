jQuery(document).ready(function($) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("#id_acuerdo_est, #id_acuerdo_fed").select2({
		placeholder: "  Selecciona una acción"
	});
	//Funciones para la suma de montos
	$('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function() {
		suma();
	});
	$(".bt_ftefed").unbind("click").on("click", function() {
		addfed($(this));
	});
	$(".bt_fteest").unbind("click").on("click", function() {
		addest($(this));
	});
	$('.partida').autoNumeric({
		aSep: '',
		mDec: 0,
		vMin: 0,
		vMax: 9999
	});
	$('.numero').autoNumeric({
		aSep: '',
		mDec: 0,
		vMin: 0,
		vMax: 99999
	});
	$('.numeroEntero').autoNumeric({
		aSep: ',',
		mDec: 0,
		vMin: '0'
	});
	$('.numeroDecimal').autoNumeric({
		aSep: ',',
		mDec: 2,
		vMin: 0.00
	});
	Triggers ();
	$('#accion').val('0').change();
});

function LimpiaObra () {
	var vacio ='<option value="0">- Selecciona</option>';
	$('#id_exp_tec, #id_det_obra').val('');
	if ($('#ejercicio').children().length > 1) {
		$('#ejercicio_obra, #ejercicio').val('0');
		$('#programa, #id_proyecto_ep').html(vacio);
	}
	else if ($('#programa').children().length > 1) {
		$('#programa').val('0');
		$('#id_proyecto_ep').html(vacio).val('0');
	}
	else if ($('#id_proyecto_ep').children().length > 1)
		$('#id_proyecto_ep').val('0');
	if ($('#id_modalidad_ejecucion').children().length > 1)
		$('#id_modalidad_ejecucion').val('0');
	if ($('#id_clasificacion_obra').children().length > 1)
		$('#id_clasificacion_obra').val('0');
	if ($('#id_tipo_obra').children().length > 1)
		$('#id_tipo_obra').val('0');
	if ($('#id_sector').children().length > 1) {
		$('#id_sector').val('0');
		$('#id_unidad_ejecutora').html(vacio).val('0');
	}
	else if ($('#id_unidad_ejecutora').children().length > 1)
		$('#id_unidad_ejecutora').val('0');
	if ($('#id_cobertura').children().length > 1)
		$('#id_cobertura').val('0');
	if ($('#id_grupo_social').children().length > 1)
		$('#id_grupo_social').val('0');
	$("#id_region, #id_municipio, #id_acuerdo_est, #id_acuerdo_fed").val([]).change();
	$('#id_expediente_tecnico, #nombre, #justificacion, #caracteristicas, #localidad, .numeroDecimal, .numcta, .numero, .partida').val('');
	$('.fuente_federal:gt(0), .fuente_estatal:gt(0)').remove();
	if ($('#fuente_federal').children().length > 1)
		$('#fuente_federal').val('0');
	if ($('#fuente_estatal').children().length > 1)
		$('#fuente_estatal').val('0');
	$('.has-error').removeClass('has-error has-feedback');
	$("[id^='err_']" ).hide();
}

function HabilitaCamposObra (oficios, cuenta_federal, cuenta_estatal) {
	$('#id_clasificacion_obra, #id_tipo_obra, #id_grupo_social').removeAttr('disabled');
	if (!oficios)
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
	$('#id_modalidad_ejecucion, #ejercicio, #id_clasificacion_obra, #id_tipo_obra, #id_sector').removeAttr('disabled');
	$('#id_unidad_ejecutora, #id_cobertura, #programa, #id_proyecto_ep, #id_grupo_social').removeAttr('disabled');
	$("#id_region, #id_municipio, #id_acuerdo_est, #id_acuerdo_fed").removeAttr('disabled');
	$('#nombre, #justificacion, #caracteristicas, #localidad').removeAttr('disabled');
	$('.monfed, .monest, .numftef, .numftee, .numcta, .partida').removeAttr('disabled');
	$('.bt_ftefed, .bt_fteest').removeAttr("disabled");
	$("#btnGuardar").removeAttr("disabled");
}

function inHabilitaCampos () {
	$('#id_unidad_ejecutora').attr("disabled","disabled");
	$('#id_modalidad_ejecucion, #ejercicio, #id_clasificacion_obra, #id_tipo_obra, #id_sector').attr("disabled","disabled");
	$('#id_unidad_ejecutora, #id_cobertura, #programa, #id_proyecto_ep').attr("disabled","disabled");
	$("#id_region, #id_municipio, #id_acuerdo_est, #id_acuerdo_fed").attr("disabled","disabled");
	$('#nombre, #justificacion, #caracteristicas, #localidad, #id_grupo_social').attr("disabled","disabled");
	$('.monfed, .monest, .numftef, .numftee, .numcta, .partida').attr("disabled","disabled");
	$('.bt_ftefed, .bt_fteest').attr("disabled","disabled");
	$("#btnGuardar").attr("disabled","disabled");
}

function addfed(elem, callback) {
	var newElem = elem.parents(".fuente_federal").clone();
	newElem.find("input").val("");
	newElem.find("select").val("0");
	newElem.find(".bt_ftefed").val("-").unbind("click").on("click", function() {
		delRow($(this));
	});
	elem.parents("div").parent().find(".fuente_federal").last().after(newElem);
	$('.numeroDecimal').autoNumeric({
		aSep: ',',
		mDec: 2,
		vMin: '0.00'
	});
	$('.partida').autoNumeric({
		aSep: '',
		mDec: 0,
		vMin: 0,
		vMax: 9999
	});
	$('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function() {
		suma();
	});
	if (typeof(callback) === "function") {
		callback();
	}
}

function addest(elem, callback) {
	var newElem = elem.parents(".fuente_estatal").clone();
	newElem.find("input").val("");
	newElem.find("select").val("0");
	newElem.find(".bt_fteest").val("-").unbind("click").on("click", function() {
		delRow($(this));
	});
	elem.parents("div").parent().find(".fuente_estatal").last().after(newElem);
	$('.numeroDecimal').autoNumeric({
		aSep: ',',
		mDec: 2,
		vMin: '0.00'
	});
	$('.partida').autoNumeric({
		aSep: '',
		mDec: 0,
		vMin: 0,
		vMax: 9999
	});
	$('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function() {
		suma();
	});
	if (typeof(callback) === "function") {
		callback();
	}
}

function delRow(elem) {
	elem.parent("div").parent().remove();
	suma();
}

function suma() {
	var montofed = 0;
	var montoest = 0;
	var montomun = 0;
	$('.monfed').each(function() {
		var montofed1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : 0;
		montofed = montofed + parseFloat(montofed1);
	});
	$('.monest').each(function() {
		var montoest1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : 0;
		montoest = montoest + parseFloat(montoest1);
	});
	var total = parseFloat(montofed) + parseFloat(montoest);
	$("#monto").val(total);
	$("#monto").focusin().focusout();
	$('#div_monto').removeClass('has-error has-feedback');
	$('#err_monto').hide();
}

function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';
	// acción
	$("#accion").on('change', function() {
		LimpiaObra ();
		switch ($(this).val()) {
			case '1': //Obra Con expediente
				inHabilitaCampos ();
				$("#div_id_obra1, #div_ejercicio_obra, #div_id_obra").hide();
				$("#div_id_expediente_tecnico, #div_buscar" ).show();
				break;
			case '2': //Obra sin expediente
				HabilitaCampos ();
				$("#div_id_expediente_tecnico, #div_id_obra1, #div_ejercicio_obra, #div_buscar, #div_id_obra" ).hide();
				break;
			case '3': //Modificación obra
				inHabilitaCampos ();
				$("#div_id_expediente_tecnico" ).hide();
				$("#div_id_obra1, #div_ejercicio_obra, #div_buscar, #div_id_obra" ).show();
				break;
			default:
				inHabilitaCampos ();
				$("#div_id_expediente_tecnico, #div_id_obra1, #div_ejercicio_obra, #div_buscar, #div_id_obra" ).hide();
				break;
		}
	});

	// evento Ejercicio
	$('#ejercicio').unbind("change").on('change', function (){
		var ejercicio = $(this).val();        
		if (ejercicio == '0')
			$('#programa, #id_proyecto_ep').html(vacio);
		else {
			$.ajax({
				data: {
					ejercicio: ejercicio
				},
				url: '/Obra/dropdownEjercicio',
				type: 'POST',
				success: function (data) {
					console.log(data);
					$('#programa').html(data.programa);
					$('#id_proyecto_ep').html(data.proyecto);
					if ($('#id_proyecto_ep').val() != '0') {
						$('#div_id_proyecto_ep').removeClass('has-error has-feedback');
						$('#err_id_proyecto_ep').hide();
					}
				},
				error: function(data) {
					console.log("Errores::", data);
				}
			});
			$('#div_ejercicio').removeClass('has-error has-feedback');
			$('#err_ejercicio').hide();
		}
   });

	// evento Sector
	$('#id_sector').unbind("change").on('change', function (){
		var id = $(this).val();
		if (id == '0')
			$('#id_unidad_ejecutora').html(vacio);
		else {
			$.ajax({
				data: {
					id: id
				},
				url: '/Obra/dropdownSector',
				type: 'POST',
				success: function (data) {
					console.log(data);
					$('#id_unidad_ejecutora').html(data);
					if ($('#id_unidad_ejecutora').val() != '0') {
						$('#div_id_unidad_ejecutora').removeClass('has-error has-feedback');
						$('#err_id_unidad_ejecutora').hide();
					}
				},
				error: function(data) {
					console.log("Errores::", data);
				}
			});
			$('#div_id_sector').removeClass('has-error has-feedback');
			$('#err_id_sector').hide();
		}
   });

	// Cobertura
	$("#id_cobertura").on('change', function() {
		$('#div_id_cobertura').removeClass('has-error has-feedback');
		$('#err_id_cobertura').hide();
		switch ($(this).val()) {
			case '1': //Estatal
				$("#div_id_region, #div_id_municipio, #div_localidad").hide();
				$("#id_region, #id_municipio").val([]).change();
				$("#localidad").val('');
				break;
			case '2': //Regional
				$("#div_id_region, #div_localidad").show();
				$("#id_region").select2({
					placeholder: "  Seleccione la(s) región(es)"
				});
				$("#div_id_municipio").hide();
				$("#id_municipio").val([]).change();
				break;
			case '3': //Municipal
				$("#div_id_region").hide();
				$("#div_id_municipio, #div_localidad").show();
				$("#id_municipio").select2({
					placeholder: "  Seleccione el(los) municipio(s)"
				});
				$("#id_region").val([]).change();
				break;
			default:
				$("#div_id_region, #div_id_municipio, #div_localidad").hide();
				$("#id_region, #id_municipio").val([]).change();
				$("#localidad").val('');
				break;
		}
	});

	// evento Programa
	$('#programa').unbind("change").on('change', function (){
		var id = $(this).val();
		var ejercicio = $('#ejercicio').val();
		if (id == '0' || ejercicio == '0')
			$('#id_proyecto_ep').html(vacio);
		else {
			$.ajax({
				data: {
					id: id,
					ejercicio: ejercicio
				},
				url: '/Obra/dropdownPrograma',
				type: 'POST',
				success: function (data) {
					console.log(data);
					$('#id_proyecto_ep').html(data);
					if ($('#id_proyecto_ep').val() != '0') {
						$('#div_id_proyecto_ep').removeClass('has-error has-feedback');
						$('#err_id_proyecto_ep').hide();
					}
				},
				error: function(data) {
					console.log("Errores::", data);
				}
			});
		}
	});

	// evento cambio, para ocultar error
	$('#id_modalidad_ejecucion, #id_clasificacion_obra, #id_tipo_obra, #id_unidad_ejecutora, #id_proyecto_ep, #nombre, #id_municipio, #id_region').unbind("change").on('change', function (){
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
		   if ($(this).attr('id') == 'id_expediente_tecnico' || $(this).attr('id') == 'id_obra1')
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
				$("#id_tipo_obra").val(data.hoja1.id_tipo_obra);
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


function muestraObra () {
	$.ajax({
		data: {
			'id_obra': $("#id_obra1").val(),
			'ejercicio': $("#ejercicio_obra").val()
		},
		url: '/Obra/buscar_obra',
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
				fuentes = data.fuentes;
				$('#id_det_obra').val(data.id);
				$("#id_obra").val(data.id_obra);
				$("#id_modalidad_ejecucion").val(data.id_modalidad_ejecucion);
				$("#ejercicio").val(data.ejercicio);
				$("#id_clasificacion_obra").val(data.id_clasificacion_obra);
				$("#id_tipo_obra").val(data.id_tipo_obra);
				$("#id_sector").val(data.id_sector);
				$("#id_unidad_ejecutora").html(data.opciones.ue);
				$("#nombre").val(data.nombre);
				$("#justificacion").val(data.justificacion);
				$("#caracteristicas").val(data.caracteristicas);
				$("#id_cobertura").val(data.id_cobertura).change();
				if (data.id_cobertura == 2) {
					regiones = data.regiones;
					arrRegiones = [];
					for (var i = 0; i < regiones.length; i++) {
						arrRegiones.push(regiones[i].id);
					}
					$("#id_region").val(arrRegiones).trigger('change');
					$("#localidad").val(data.localidad);
				}
				if (data.id_cobertura == 3) {
					municipios = data.municipios;
					arrMunicipios = [];
					for (var i = 0; i < municipios.length; i++) {
						arrMunicipios.push(municipios[i].id);
					}
					$("#id_municipio").val(arrMunicipios).trigger('change');
					$("#localidad").val(data.localidad);
				}
				$("#programa").html(data.opciones.programa);
				$("#id_proyecto_ep").html(data.opciones.proyecto);
				arrAcuerdos = [];
				for (var i = 0; i < acuerdos.length; i++) {
					arrAcuerdos.push(acuerdos[i].id);
				}
				$("#id_acuerdo_est, #id_acuerdo_fed").val(arrAcuerdos).trigger('change');
				$("#id_grupo_social").val(data.id_grupo_social);
				j = 0;
				var oficios = false, cuenta_estatal = false, cuenta_federal = false;
				//if (data.asignado * 1 > 0)
				oficios = data.has_oficios;
				for (var i = 0; i < fuentes.length; i++) {
					if (fuentes[i].pivot.tipo_fuente == 'F') {
						if (!oficios) cuenta_federal = true;
						if (i === 0) {
							$(".monfed:first").val(fuentes[i].pivot.monto).autoNumeric('update');
							$('select[name="fuente_federal[]"]:eq(0) option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
							$(".partida_federal:eq(0) .partida").val(fuentes[i].pivot.partida).autoNumeric('update');
							$(".cuenta_federal:eq(0) .numcta").val(fuentes[i].pivot.cuenta);
						}
						else {
							addfed($(".monfed:first"), function() {
								$(".monfed:eq(" + i + ")").val(fuentes[i].pivot.monto).autoNumeric('update');
								$('select[name="fuente_federal[]"]:eq(' + i + ') option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
								$(".partida_federal:eq(" + i + ")" + " .partida").val(fuentes[i].pivot.partida).autoNumeric('update');
								$(".cuenta_federal:eq(" + i + ")" + " .numcta").val(fuentes[i].pivot.cuenta);
							});
						}
					}
					else {
						if (!oficios) cuenta_estatal = true;
						if (j === 0) {
							$(".monest:first").val(fuentes[i].pivot.monto).autoNumeric('update');
							$('select[name="fuente_estatal[]"]:eq(0) option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
							$(".partida_estatal:eq(0) .partida").val(fuentes[i].pivot.partida).autoNumeric('update');
							$(".cuenta_estatal:eq(0) .numcta").val(fuentes[i].pivot.cuenta);
						}
						else {
							addest($(".monest:first"), function() {
								$(".monest:eq(" + j + ")").val(fuentes[i].pivot.monto).autoNumeric('update');
								$('select[name="fuente_estatal[]"]:eq(' + j + ') option[value=' + fuentes[i].id + ']').prop('selected', 'selected');
								$(".partida_estatal:eq(" + i + ")" + " .partida").val(fuentes[i].pivot.partida).autoNumeric('update');
								$(".cuenta_estatal:eq(" + i + ")" + " .numcta").val(fuentes[i].pivot.cuenta);
							});
						}
						j++;
					}
				}
				$(".monfed:first").change();
				// Existe expediente técnico
				if (data.relacion.id_expediente_tecnico > 0) {
					inHabilitaCampos ();
					HabilitaCamposObra (oficios, cuenta_federal, cuenta_estatal);
				}
				else
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
	data.append("id_tipo_obra", $('#id_tipo_obra').val());
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
