var tablaObras, tablaOficios;
var templateObra, templateOficio;
var obra_anterior = 0;;
$(document).ready( function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("#Criterios").accordion({collapsible:true,  active: false});
	$( "#tabs" ).tabs();
	Handlebars.registerHelper('each', function(context, options) {
		var ret = "";
		for(var i=0, j=context.length; i<j; i++) {			
			context[i].pivot['por_ejercer'] = context[i].pivot['autorizado'] * 1 - context[i].pivot['ejercido'] * 1;
			context[i].pivot['por_comprobar'] = context[i].pivot['anticipo'] * 1 - context[i].pivot['comprobado'] * 1;
			context[i].pivot['por_pagar'] = context[i].pivot['ejercido'] * 1 - context[i].pivot['retenciones'] * 1 - context[i].pivot['pagado'] * 1;
			ret = ret + options.fn(context[i]);
		}
		return ret;
	});
	templateObra = Handlebars.compile($("#montos-template").html());
	templateOficio = Handlebars.compile($("#oficios-template").html());
	tablaObras = $('#obras').DataTable({
		searching: false,
		pagingType: "full_numbers",
		language: {
			paginate: {
				first:    '<i class="glyphicon glyphicon-fast-backward"></i>',
				previous: '<i class="glyphicon glyphicon-step-backward"></i>',
				next:     '<i class="glyphicon glyphicon-step-forward"></i>',
				last:     '<i class="glyphicon glyphicon-fast-forward"></i>'
			},
			emptyTable: "No existen obras disponibles",
			info: "Mostrando _START_-_END_ de _TOTAL_ registros. Página _PAGE_ de _PAGES_",
			infoEmpty: "No existe información",
			lengthMenu: "Mostrar _MENU_ registros",
			zeroRecords: "No se encontraron registros",
			infoFiltered:   "(filtrado de _MAX_ registros)"
		},
		select: 'single',
		ordering: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/Consulta/get_datos_obra',
			data: function (d) {
				d.id_obra = $('#id_obra_search').val();
				d.nombre = $('#nombre_search').val();
				d.ejercicio = $('#ejercicio_search').val();
				d.id_municipio = $('#id_municipio_search').val();
				d.id_sector = $('#id_sector_search').val();
				d.id_unidad_ejecutora = $('#id_unidad_ejecutora_search').val();
				d.id_clasificacion_obra = $('#id_clasificacion_obra_search').val();
				d.id_grupo_social = $('#id_grupo_social_search').val();
			},
			method: 'POST'
		},
		columns: [
		{
			className: 'details-control',
			orderable: false,
			searchable: false,
			data: null,
			defaultContent: ''
		}, {
			data: 'id_obra',
			name: 'id_obra',
		}, {
			data: 'ejercicio',
			name: 'ejercicio',
		}, {
			data: 'municipio.nombre',
			name: 'municipio'
		}, {
			data: 'nombre',
			name: 'nombre'
		}, {
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		} ],
		rowCallback: function(row, data, index) {
			if (data.nombre.length >= 70)
				$("td:eq(4)", row).html("<span title='" + data.nombre + "'>" + data.nombre.substr(0, 70) + " ...</span>");
		}
	});
	//LimpiaConsulta();
	Triggers ();
});

function LimpiaConsulta () {
	obra_anterior = 0;
	// busqueda personalizada
	var vacio ='<option value="0">- Selecciona</option>';
	$('#id_obra_search, #nombre_search').val('');
	if ($('#ejercicio_search').children().length > 1)
		$('#ejercicio_search').val('0');
	if ($('#id_municipio_search').children().length > 1)
		$('#id_municipio_search').val('0');
	if ($('#id_sector_search').children().length > 1) {
		$('#id_sector_search').val('0');
		$('#id_unidad_ejecutora_search').html(vacio);
	}
	else if ($('#id_unidad_ejecutora_search').children().length > 1)
		$('#id_unidad_ejecutora_search').val('0');
	if ($('#id_clasificacion_obra_search').children().length > 1)
		$('#id_clasificacion_obra_search').val('0');
	if ($('#id_grupo_social_search').children().length > 1)
		$('#id_grupo_social_search').val('0');
	$('#obras tbody tr.infor').removeClass('infor');
	tablaObras.clear().draw();
	
	// Oficios
	$('#obra-3 :input').val('');
	if ( $.fn.DataTable.isDataTable(tablaOficios) ) {
		tablaOficios.clear();
		var oficios_vacio = '<tr><th colspan="8" class="text-center" style="font-weight: unset">No existe información</th></tr>';
		$('#oficios tbody').empty().html(oficios_vacio);
	}
	
	// Datos
	$('#datos :input').val('');
	/*$('#id_expediente_tecnico, #nombre, #justificacion, #caracteristicas, #localidad, .numeroDecimal, .numcta, .numero, .partida').val('');*/
}

function Triggers () {
	// evento Buscar
	$('#btnBuscar').on('click', function() {
		if ($('#id_obra_search').val() == '' && $('#nombre_search').val() == '' && $('#ejercicio_search').val() == '0'
			&& $('#id_municipio_search').val() == '0' && $('#id_sector_search').val() == '0'
			&& $('#id_unidad_ejecutora_search').val() == '0' && $('#id_clasificacion_obra_search').val() == '0'
			&& $('#id_grupo_social_search').val() == '0')
			BootstrapDialog.mensaje (null, 'Seleccione al menos una opción para iniciar la consulta', 2);
		else {
			tablaObras.draw();
			obra_anterior = 0;
		}
	});

	// evento Limpiar
	$('#btnLimpiar').on('click', function() {
		LimpiaConsulta();
	});

	// evento + información (listado de obras)
	$('#obras tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tablaObras.row( tr );
		if ( row.child.isShown() ) {
			row.child.hide();
			tr.removeClass('shown visto');
		}
		else {
			row.child( templateObra(row.data()) ).show();
			if (tr.hasClass('infor'))
				tr.addClass('shown');
			else
				tr.addClass('shown visto');
			$(".numeroDecimal").each(function() {
				$(this).autoNumeric({
					aSep: ',',
					mDec: 2,
					vMin: '0.00'
				});
			});
		}
	});

	// evento Información (obras)
	$('body').on('click','#btnInfo', function () {
		var id = $(this).attr('data-id') * 1;
		if (obra_anterior != id) {
			var tr;
			if (obra_anterior != 0) {
				tr = $('#obras tbody tr.infor');
				var row = tablaObras.row(tr);
				if (row.child.isShown() )
					tr.addClass('visto');
				tr.removeClass('infor');
			}
			tr = $(this).closest('tr');
			if (tr.hasClass('visto'))
				tr.removeClass('visto');
			tr.addClass('infor');
    		console.log( tablaObras.row( $(this).closest('tr') ).data() );
			muestraOficios(tablaObras.row(tr).data());
			muestraDatos (id);
		}
		obra_anterior = id;
	});

	// Cobertura
	$("#cobertura").on('change', function() {
		switch ($(this).attr('data-id')) {
			case '1': //Estatal
				$("#div_region, #div_municipio, #div_localidad").hide();
				break;
			case '2': //Regional
				$("#div_region, #div_localidad").show();
				$("#div_municipio").hide();
				break;
			case '3': //Municipal
				$("#div_region").hide();
				$("#div_municipio, #div_localidad").show();
				break;
			default:
				$("#div_region, #div_municipio, #div_localidad").hide();
				break;
		}
	});

	// evento + información (listado de oficios)
	$('#oficios tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tablaOficios.row(tr);
		var tableId = 'det-oficios-' + row.data().id;
		if ( row.child.isShown() ) {
			row.child.hide();
			tr.removeClass('shown visto');
		}
		else {
			row.child( templateOficio(row.data()) ).show();
			muestraDetalleOficios(tableId, row.data());
			tr.addClass('shown visto');
		}
	});
}

function muestraOficios (data) {
	$("#id_obra-3").val(data.id_obra);
	$("#ejercicio-3").val(data.ejercicio);
	tablaOficios = $('#oficios').DataTable({
		destroy: true,
		autoWidth: false,
		searching: false,
		pagingType: "full_numbers",
		paging: false,
		info: false,
		language: {
			emptyTable: "No existen oficios disponibles",
			infoEmpty: "No existe información",
			zeroRecords: "No se encontraron registros",
			infoFiltered:   "(filtrado de _MAX_ registros)"
		},
		ordering: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/Consulta/get_oficios_obra',
			data: {
				'id': data.id
			},
			method: 'POST'
		},
		columns: [
		{
			className: 'details-control',
			orderable: false,
			searchable: false,
			data: null,
			defaultContent: ''
		}, {
			data: 'clave',
			name: 'clave',
		}, {
			data: 'fecha_oficio',
			name: 'fecha_oficio',
		}, {
			data: 'estado',
			name: 'estado'
		}, {
			data: 'solicitud',
			name: 'solicitud'
		}, {
			data: 'recurso',
			name: 'recurso'
		}, {
			data: 'asignado',
			name: 'asignado',
			className: 'numeroDecimal'
		}, {
			data: 'autorizado',
			name: 'autorizado',
			className: 'numeroDecimal'
		} ]
	});
}

function muestraDetalleOficios (tableId, data) {
    $('#' + tableId).DataTable({
		destroy: true,
		autoWidth: false,
		searching: false,		
		paging: false,
		info: false,
		ordering: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/Consulta/get_detalle_oficio',
			data: {
				'id': data.id
			},
			method: 'POST'
		},
		columns: [
		{
			data: 'unidad_ejecutora.nombre',
			name: 'ue',
		}, {
			data: 'fuentes.nombre',
			name: 'fuente',
		}, {
			data: 'tipo_solicitud.nombre',
			name: 'solicitud'
		}, {
			data: 'asignado',
			name: 'asignado',
			className: 'numeroDecimal'
		}, {
			data: 'autorizado',
			name: 'autorizado',
			className: 'numeroDecimal'
		} ]
	});
   }

function muestraDatos (id) {
	$.ajax({
		data: {
			'id': id
		},
		url: '/Consulta/buscar_obra',
		type: 'post',
		beforeSend: function() {
			$("#divLoading h3").text('Procesando . . .');
			$("#divLoading").show();
		},
		complete: function() {
			$("#divLoading").hide();
		},
		success: function(data) {
			//console.log(data);
			//LimpiaObra ();
			acuerdos = data.acuerdos;
			//fuentes = data.fuentes;
			$("#id_obra").val(data.id_obra);
			$("#modalidad_ejecucion").val(data.modalidad_ejecucion.nombre);
			$("#ejercicio").val(data.ejercicio);
			$("#clasificacion_obra").val(data.clasificacion_obra.nombre);
			$("#tipo_obra").val(data.tipo_obra.nombre);
			$("#sector").val(data.sector.nombre);
			$("#unidad_ejecutora").val(data.unidad_ejecutora.nombre);
			$("#nombre").val(data.nombre);
			$("#justificacion").val(data.justificacion);
			$("#caracteristicas").val(data.caracteristicas);
			$("#cobertura").attr('data-id', data.id_cobertura).val(data.cobertura.nombre).change();
			if (data.id_cobertura == 2) {
				regiones = data.regiones;
				cregiones = '';
				for (var i = 0; i < regiones.length; i++) {
					if (cregiones == '')
						cregiones = regiones[i].nombre;
					else
						cregiones += ', ' + regiones[i].nombre;
				}
				$("#region").val(cregiones);
				$("#localidad").val(data.localidad);
			}
			if (data.id_cobertura == 3) {
				municipios = data.municipios;
				cmunicipios = [];
				for (var i = 0; i < municipios.length; i++) {
					if (cmunicipios == '')
						cmunicipios = municipios[i].nombre;
					else
						cmunicipios += ', ' + municipios[i].nomnbre;
				}
				$("#municipio").val(cmunicipios);
				$("#localidad").val(data.localidad);
			}
			$("#programa").val(data.programa.nombre);
			$("#proyecto_ep").val(data.proyecto.nombre);
			cAcuerdos = ['', ''];
			for (var i = 0; i < acuerdos.length; i++) {
				// Estatal
				if (acuerdos[i].id_tipo == 1)
					j = 0;
				else
					j = 1;
				if (cAcuerdos[j] == '')
					cAcuerdos[j] = acuerdos[i].clave + '  ' + acuerdos[i].nombre;
				else
					cAcuerdos[j] += String.fromCharCode(10) + acuerdos[i].clave + '  ' + acuerdos[i].nombre;
			}
			$("#acuerdo_est").val(cAcuerdos[0]);
			$("#acuerdo_fed").val(cAcuerdos[1]);
			$("#grupo_social").val(data.grupo_social.nombre);
			/*
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
			*/
		},
		error: function(response) {
			console.log("Errores::", response);
		}
	});
}