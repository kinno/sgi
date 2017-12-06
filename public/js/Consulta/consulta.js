var number_format = {
	separador: ",", // separador para los miles
	sepDecimal: '.', // separador para los decimales
	formatear:function (num){
		num +='';
		var splitStr = num.split('.');
		var splitLeft = splitStr[0];
		var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : this.sepDecimal + '00';
		var regx = /(\d+)(\d{3})/;
		while (regx.test(splitLeft)) {
			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		}
		return this.simbol + splitLeft +splitRight;
	},
	new:function(num, simbol) {
		this.simbol = simbol ||'';
		return this.formatear(num);
	}
};
var cmontos = ['asignado', 'autorizado', 'ejercido', 'por_ejercer', 'anticipo', 'retenciones', 'comprobado', 'por_comprobar', 'pagado', 'por_pagar'];
var tablaObras, tablaOficios, tablaAps, tablaPagos;
var templateObraEje, templateObra, templateOficio, templateAp;
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
		for(var i = 0, j = context.length; i < j; i++) {			
			context[i].pivot['por_ejercer'] = context[i].pivot['autorizado'] * 1.00 - context[i].pivot['ejercido'] * 1.00;
			context[i].pivot['por_comprobar'] = context[i].pivot['anticipo'] * 1.00 - context[i].pivot['comprobado'] * 1.00;
			context[i].pivot['por_pagar'] = context[i].pivot['ejercido'] * 1.00 - context[i].pivot['retenciones'] * 1 - context[i].pivot['pagado'] * 1.00;
			for (var k = 0; k < 10; k++) {
				context[i].pivot[cmontos[k]] = number_format.new(context[i].pivot[cmontos[k]]);
			}
			ret = ret + options.fn(context[i]);
		}
		return ret;
	});
	templateObraEje = Handlebars.compile($("#obra-template").html());
	templateObra = Handlebars.compile($("#montos-template").html());
	templateOficio = Handlebars.compile($("#oficios-template").html());
	templateAp = Handlebars.compile($("#aps-template").html());

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
			infoFiltered:   "(filtrado de _MAX_ registros)",
			processing: "Procesando . . ."
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
			className: 'text-center'
		}, {
			data: 'ejercicio',
			name: 'ejercicio',
			className: 'text-center'
		}, {
			data: 'municipio.nombre',
			name: 'municipio',
			className: 'text-center'
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
			if (data.nombre.length >= 80)
				$("td:eq(4)", row).html("<span title='" + data.nombre + "'>" + data.nombre.substr(0, 80) + " ...</span>");
		}
	});
	LimpiaConsulta();
	Triggers ();
});

function LimpiaConsulta () {
	obra_anterior = 0;
	LimpiaBusqueda();
	LimpiaDatos();
}

function LimpiaBusqueda () {
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
}

function LimpiaDatos () {
	// Oficios
	$('#obra-3').html('');
	if ( $.fn.DataTable.isDataTable(tablaOficios) ) {
		tablaOficios.clear();
		var oficios_vacio = '<tr><th colspan="8" class="text-center" style="font-weight: unset">No existe información</th></tr>';
		$('#oficios tbody').empty().html(oficios_vacio);
	}

	// APs
	$('#obra-4').html('');
	if ( $.fn.DataTable.isDataTable(tablaAps) ) {
		tablaAps.clear();
		var aps_vacio = '<tr><th colspan="9" class="text-center" style="font-weight: unset">No existe información</th></tr>';
		$('#aps tbody').empty().html(aps_vacio);
	}

	// Pagos
	$('#obra-5').html('');
	if ( $.fn.DataTable.isDataTable(tablaPagos) ) {
		tablaPagos.clear();
		var aps_vacio = '<tr><th colspan="6" class="text-center" style="font-weight: unset">No existe información</th></tr>';
		$('#pagos tbody').empty().html(aps_vacio);
	}
	
	// Datos
	$('#datos :input').val('');
	$('#por_asignar').hide();
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
			LimpiaDatos();
			tablaObras.draw();
			obra_anterior = 0;
		}
	});

	// evento Limpiar
	$('#btnLimpiar').on('click', function() {
		LimpiaConsulta();
		tablaObras.draw();
	});

	// evento + información (detalle de obras)
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
			//console.log( tablaObras.row( $(this).closest('tr') ).data() );
			muestraOficios(tablaObras.row(tr).data());
			muestraAps(tablaObras.row(tr).data());
			muestraPagos(tablaObras.row(tr).data());
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

	// evento + información (detalle de oficios)
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

	// evento + información (detalle de aps)
	$('#aps tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tablaAps.row(tr);
		if ( row.child.isShown() ) {
			row.child.hide();
			tr.removeClass('shown visto');
		}
		else {
			row.child( templateAp(row.data()) ).show();
			tr.addClass('shown visto');
		}
	});
}

function muestraOficios (data) {
	$('#obra-3').html(templateObraEje(data));
	tablaOficios = $('#oficios').DataTable({
		destroy: true,
		autoWidth: false,
		searching: false,
		paging: false,
		info: false,
		language: {
			emptyTable: "No existen oficios disponibles",
			infoEmpty: "No existe información",
			zeroRecords: "No se encontraron registros",
			infoFiltered:   "(filtrado de _MAX_ registros)",
			processing: "Procesando 1 . . ."
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
			className: 'text-center'
		}, {
			data: 'fecha_oficio',
			name: 'fecha_oficio',
			className: 'text-center'
		}, {
			data: 'estado',
			name: 'estado',
			className: 'text-center'
		}, {
			data: 'solicitud',
			name: 'solicitud',
		}, {
			data: 'recurso',
			name: 'recurso',
			className: 'text-center'
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

function muestraAps (data) {
	$('#obra-4').html(templateObraEje(data));
	tablaAps = $('#aps').DataTable({
		destroy: true,
		autoWidth: false,
		searching: false,
		paging: false,
		info: false,
		language: {
			emptyTable: "No existen APs disponibles",
			infoEmpty: "No existe información",
			zeroRecords: "No se encontraron registros",
			infoFiltered:   "(filtrado de _MAX_ registros)",
			processing: "Procesando 1 . . ."
		},
		ordering: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/Consulta/get_aps_obra',
			data: {
				id: data.id,
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
			className: 'text-center'
		}, {
			data: 'folio_amortizacion',
			name: 'folio_amortizacion',
			className: 'text-center'
		}, {
			data: 'tipo_ap.nombre',
			name: 'tipo',
			className: 'text-center'
		}, {
			data: 'estatus.nombre',
			name: 'estado',
			className: 'text-center'
		}, {
			data: 'fuente.nombre',
			name: 'fuente'
		}, {
			data: 'monto',
			name: 'monto',
			className: 'numeroDecimal'
		}, {
			data: 'monto_amortizacion',
			name: 'monto_amortizacion',
			className: 'numeroDecimal'
		}, {
			data: 'monto_iva_amortizacion',
			name: 'monto_iva_amortizacion',
			className: 'numeroDecimal'
		}, {
			data: 'pagado',
			name: 'pagado',
			className: 'numeroDecimal'
		} ]
	});
}

function muestraPagos (data) {
	$('#obra-5').html(templateObraEje(data));
	tablaPagos = $('#pagos').DataTable({
		destroy: true,
		autoWidth: false,
		searching: false,
		paging: false,
		info: false,
		language: {
			emptyTable: "No existen Pagos disponibles",
			infoEmpty: "No existe información",
			zeroRecords: "No se encontraron registros",
			infoFiltered:   "(filtrado de _MAX_ registros)",
			processing: "Procesando 1 . . ."
		},
		ordering: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/Consulta/get_pagos_obra',
			data: {
				id: data.id,
			},
			method: 'POST'
		},
		columns: [
		{
			data: 'autorizacion_pago.clave',
			name: 'clave',
			className: 'text-center'
		}, {
			data: 'autorizacion_pago.fuente.nombre',
			name: 'fuente'
		}, {
			data: 'serie',
			name: 'serie',
			className: 'text-center'
		}, {
			data: 'adefa',
			name: 'adefa',
			className: 'text-center'
		}, {
			data: 'cheque',
			name: 'cheque'
		}, {
			data: 'fecha_pago',
			name: 'fecha_pago',
			className: 'text-center'
		}, {
			data: 'monto',
			name: 'monto',
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
			//if (data.basignado == 1) {
				$('#por_asignar').show();
				$('#fuentes').DataTable({
					destroy: true,
					autoWidth: false,
					searching: false,
					paging: false,
					info: false,
					language: {
						emptyTable: "No existen Fuentes disponibles",
						infoEmpty: "No existe información",
						zeroRecords: "No se encontraron registros",
						infoFiltered:   "(filtrado de _MAX_ registros)",
						processing: "Procesando . . .",
					},
					ordering: false,
					processing: true,
					serverSide: true,
					ajax: {
						url: '/Consulta/get_fuentes_obra',
						data: {
							id: data.id,
						},
						method: 'POST'
					},
					columns: [
					{
						data: 'monto',
						name: 'monto',
						className: 'numeroDecimal'
					}, {
						data: 'fuentes.nombre',
						name: 'fuente'
					}, {
						data: 'partida',
						name: 'partida',
						className: 'text-center'
					}, {
						data: 'cuenta',
						name: 'cuenta',
						className: 'text-center'
					} ]
				});
			//}
		},
		error: function(response) {
			console.log("Errores::", response);
		}
	});
}

