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
var tablas =['ejercicio','fuente', 'inversion', 'recurso', 'clasificacion', 'sector', 'ejecutora', 'municipio',
	'estadoAP', 'estadoOf', 'tipoAP', 'tipoOf', 'programa', 'proyecto', 'grupo', 'ejecucion'];
var colAction = {
				orderable: false,
				searchable: false,
				data: 'action',
				name: 'action'
			};
var colEjercicio = {
				data: 'ejercicio',
				name: 'ejercicio',
				className: 'seleccionar'
			};
var colEjercicio2 = {
				data: 'ejercicio',
				name: 'ejercicio',
				className: 'seleccionar text-center'
			};
var colNombre = {
				data: 'nombre',
				name: 'nombre',
				className: 'seleccionar'
			};
var colActivo = {
				data: 'bactivo',
				name: 'bactivo',
				className: 'seleccionar text-center'
			};
var colClave = {
				data: 'clave',
				name: 'clave',
				className: 'seleccionar'
			};
var colTablas = [
			// 0 -ejercicio
			[colAction, colEjercicio],
			// 1 - fuente
			[colAction, colClave, colNombre, {
				data: 'descripcion',
				name: 'descripcion',
				className: 'seleccionar'
			}, {
				data: 'tipo',
				name: 'tipo',
				className: 'seleccionar'
			} ],
			// 2 - inversión
			[colAction, colNombre],
			// 3 - recurso
			[colAction, colNombre],
			// 4 - clasificación
			[colAction, colNombre],
			// 5 - sector
			[colAction, colNombre, colActivo],
			// 6 - ejecutora
			[colAction, colNombre, {
				data: 'sector.nombre',
				name: 'sector',
				className: 'seleccionar'
			}, colClave, colActivo ],
			// 7 - municipio
			[colAction, colNombre],
			// 8 - estado AP
			[colAction, colNombre],
			// 9 - estado Oficio
			[colAction, colNombre],
			// 10 - tipo AP
			[colAction, colNombre],
			// 11 - tipo Oficio
			[colAction, colNombre],
			// 12 - Programa
			[colAction, colEjercicio2, colNombre, colClave],
			// 13 - Proyecto
			[colAction, colEjercicio2, colNombre, colClave],
			// 14 - Grupo Social
			[colAction, colNombre],
			// 15 - Mod Ejecución
			[colAction, colNombre]
			]
var anio = 0;
var cmontos = ['asignado', 'autorizado', 'ejercido', 'por_ejercer', 'anticipo', 'retenciones', 'comprobado', 'por_comprobar', 'pagado', 'por_pagar'];
var tablaReportes;
var reporte = '';

$(document).ready( function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("#tabs").tabs();
	
	$("#catalogos").accordion({collapsible:true,  active: false, heightStyle: "fill"});
	Triggers ();
	iniciaTablas ();
});


function limpiaReportes () {
	reporte = '';
	// Pestaña 1
	$("#tabs").tabs("option", "active", 0);
	$('#id_tipo_reporte').val('0');
	$('#eRpt').hide();
	$('#reportes tbody tr.selected').removeClass('selected');
	$('#titulo, #titulo2').val('');

	// Pestaña 2	
	$("#catalogos" ).accordion("option", "active", false);
	$('#catalogos input:checkbox').prop( "checked", false);
	$("#catalogos table tbody tr").removeClass( "selected");
	$("#catalogos h3 span").text( "Todo");
	if (anio > 0)
		$('#ejercicio').find("tbody tr input[data-id='" + anio + "']").prop( "checked", true).change();

	// Datos
	/*$('#datos :input').val('');
	$('#por_asignar').hide();*/
}

function iniciaTablas () {
	$("#divLoading h3").text('Cargando información');
	$("#divLoading").show();
	// Reportes
	tablaReportes = $('#reportes').DataTable({
		searching: false,
		language: {
			emptyTable: "No existen reportes disponibles",
			infoEmpty: "No existe información",
			zeroRecords: "No se encontraron reportes",
			processing: "Procesando . . ."
		},
		select: 'single',
		ordering: false,
		processing: true,
		serverSide: true,
		paging: false,
		info: false,
		ajax: {
			url: '/Consulta/get_reportes',
			data: function (d) {
				d.id_tipo_reporte = $('#id_tipo_reporte').val();
			},
			method: 'POST'
		},
		columns: [
		{
			data: 'tipo_reporte.nombre',
			name: 'tipo',
			className: 'text-center'
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'text-center'
		}, {
			data: 'descripcion',
			name: 'descripcion'
		} ]
	});
	// Catalogos
	var ui = 6, height, columnas;
	for (var i = 0; i < tablas.length; i++) {
		$('#' + tablas[i]).DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
			ajax: {
				url: '/Consulta/get_catalogo',
				data: {
					'catalogo': tablas[i]
				},
				method: 'POST'
			},
			columns: colTablas[i],
			drawCallback: function( settings ) {
				height = calculaHeight (settings.json.recordsTotal);
				$('#ui-id-' + ui).css({'height': height, 'margin-bottom': '5px'});
				$('#ui-id-' + (ui - 1)).css('margin-bottom', '5px');
				ui = ui + 2;
			}
		});
	}
	/*
	// Ejercicios
	$('#Ejercicios').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_ejercicios',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'ejercicio',
			name: 'ejercicio',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-6').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Fuentes
	$('#Fuentes').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_fuentes',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'clave',
			name: 'clave',
			className: 'seleccionar'
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		}, {
			data: 'descripcion',
			name: 'descripcion',
			className: 'seleccionar'
		}, {
			data: 'tipo',
			name: 'tipo',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-8').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Inversiones
	$('#Inversiones').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_inversiones',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-10').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Recursos
	$('#Recursos').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_recursos',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-12').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Clasificaciones
	$('#Clasificaciones').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_clasificaciones',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-14').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Sectores
	$('#Sectores').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_sectores',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		}, {
			data: 'bactivo',
			name: 'bactivo',
			className: 'seleccionar text-center'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-16').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Ejecutoras
	$('#Ejecutoras').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_ejecutoras',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		}, {
			data: 'sector.nombre',
			name: 'sector',
			className: 'seleccionar'
		}, {
			data: 'clave',
			name: 'clave',
			className: 'seleccionar'
		}, {
			data: 'bactivo',
			name: 'bactivo',
			className: 'seleccionar text-center'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-18').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Municipios
	$('#Municipios').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_municipios',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-20').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Estados AP
	$('#Estados_AP').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_estados_AP',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-22').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Estados Oficio
	$('#Estados_Of').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_estados_Of',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-24').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Tipos AP
	$('#Tipos_AP').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_tipos_AP',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-26').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Tipos Oficio
	$('#Tipos_Of').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_tipos_Of',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-28').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Programas
	$('#Programas').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_programas',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'ejercicio',
			name: 'ejercicio',
			className: 'seleccionar text-center'
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		}, {
			data: 'clave',
			name: 'clave',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-30').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Proyectos
	$('#Proyectos').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_proyectos',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'ejercicio',
			name: 'ejercicio',
			className: 'seleccionar text-center'
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		}, {
			data: 'clave',
			name: 'clave',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-32').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Grupos
	$('#Grupos').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_grupos',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-34').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	// Ejecuciones
	$('#Ejecuciones').DataTable({destroy: true, autoWidth: false, searching: false, paging: false, info: false, ordering: false, processing: true, serverSide: true,
		ajax: {
			url: '/Consulta/get_ejecuciones',
			method: 'POST'
		},
		columns: [
		{
			orderable: false,
			searchable: false,
			data: 'action',
			name: 'action',
		}, {
			data: 'nombre',
			name: 'nombre',
			className: 'seleccionar'
		} ],
		drawCallback: function( settings ) {
			var height = calculaHeight (settings.json.recordsTotal);
			$('#ui-id-36').css({'height': height, 'margin-bottom': '5px'});
		}
	});
	*/
	/*
	for (var i = 5; i <= 7; i+=2) {
		$('#ui-id-' + i).css('margin-bottom', '5px');
	}
	*/
	$.ajax({type: "POST",	url: '/Consulta/get_anio', 
		success: function(data){
			anio = data;
			limpiaReportes ();
			$("#divLoading").hide();
		},
		error: function () {
			anio = 0;
			limpiaReportes ();
			$("#divLoading").hide();
			BootstrapDialog.mensaje (null, 'Error al cargar datos. Intente nuevamente', 3);
		}
	});
}

function Triggers () {
	// evento Buscar (Tipo de Reporte)
	$('#id_tipo_reporte').on('change', function() {
		tablaReportes.draw();
		reporte = '';
	});

	// Seleccionar reporte
	$('#reportes tbody').on( 'click', 'tr', function () {
		var nombre = '';
		var row = tablaReportes.row( $(this) );
		if (typeof row.data() !== 'undefined')
			nombre = row.data().nombre;
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
			reporte = '';
		}
		else {
			tablaReportes.$('tr.selected').removeClass('selected');
			if (nombre != 0)
				$(this).addClass('selected');
			reporte = nombre;
		}
		if (nombre != '')
			$('#eRpt').hide();
	});

	// checkbox Catálogos
	$('body').on('change','#chkCat', function () {	
		valorAcordion ($(this), false);
	});
	// Seleccionar tr
	$('table').on('click', 'td.seleccionar', function () {
		valorAcordion ($(this), true);
		
	});
	// Todos
	$('body').on('change','#chkTodo', function () {
		Todos ($(this));
	});

	// evento Imprimir
	$('#btnImprimir').on('click', imprimeReporte );

	// evento Limpiar
	$('#btnLimpiar').on('click', function () {
		/*$("#divLoading h3").text('Limpiando datos');
		$("#divLoading").show();*/
		limpiaReportes();
		/*$("#divLoading").hide();*/
	});
}

function imprimeReporte () {
	var str = "";
	if (validaFormularioReportes()) {
		str = 'reporte=' + reporte + '&' + $('#titulo').serialize() + '&' + $('#titulo2').serialize();
		for (var i = 0; i < tablas.length; i++) {
			str += '&' + tablas[i] + '=' + getCatalogo(tablas[i]);
		}
		/*str += '&' + $('#fechas').serialize() + '&' + $('#montos').serialize() + '&' + $('#columnas').serialize() + '&Grupos=' + getAllText($('#lstGpo2'));
		str += '&Columnas=' + getAllText($('#lstCol2'));
		*/
		//alert (str + ' &FIN');
		window.open ("/Consulta/imprimeReporte?"+str,"_blank","left=100, top=100, width=900, height=500");
	}
}


function Todos (elem) {
	var id_tabla = elem.closest('table').attr('id');
	if (elem.is(":checked")) {
		$("#" + id_tabla + " tbody input:checkbox").prop( "checked", true);
		$("#" + id_tabla + " tbody tr").addClass( "selected");
	}
	else {
		$("#" + id_tabla + " tbody input:checkbox").prop( "checked", false);
		$("#" + id_tabla + " tbody tr").removeClass( "selected");
	}
	$('#txt-' + id_tabla).text('Todo');
}

function valorAcordion (elem, cambia) {
	var tr = elem.closest('tr');
	var id_tabla = elem.closest('table').attr('id');
	var valor = '';
	if (tr.find('input').is(":checked")) {
		if (cambia) {
			tr.find('input').prop( "checked", false);
			tr.removeClass("selected");
		}
		else
			tr.addClass("selected");
	}
	else {
		if (cambia) {
			tr.find('input').prop( "checked", true);
			tr.addClass("selected");
		}
		else
			tr.removeClass("selected");
	}
	var checked =  $('#' + id_tabla + ' tbody input:checked').length;
	var todos = $('#' + id_tabla + ' tbody input').length;
	if (checked == todos) {
		$('#' + id_tabla).find('thead #chkTodo').prop( "checked", true);
		valor = 'Todo';
	}
	else {
		$('#' + id_tabla).find('thead #chkTodo').prop( "checked", false);
		$('#' + id_tabla + ' tbody input:checked').each( function (i, e) {
			if (valor == '')
				valor = $(e).val();
			else
				valor = valor + ', ' + $(e).val();
		});
		if (valor == '')
			valor = 'Todo';
	}
	/*
	if (id_tabla == 'Ejercicios') {
		if (valor != 'Todo')
			$('#eEje').hide();
	}
	*/
	$('#txt-' + id_tabla).text(valor);
}

function calculaHeight (n) {
	var height = '220px';
	if (n <= 4) {
		height = (n + 1) * 40 + 10 + 'px';
	}
	return height;
}

function getCatalogo (id_tabla) {
	var valor = '';
	var checked =  $('#' + id_tabla + ' tbody input:checked').length;
	var todos = $('#' + id_tabla + ' tbody input').length;
	if (checked != todos) {
		$('#' + id_tabla + ' tbody input:checked').each( function (i, e) {
			if (valor == '')
				valor = $(e).attr('data-id');
			else
				valor = valor + ',' + $(e).attr('data-id');
		});
	}
	return valor;
}

function validaFormularioReportes(){
	var err = false, ierr = 0, msj = "";
	var num, val1 = 0, val2 = 0;
	if (reporte == '') {
		msj = '* Seleccione un reporte';
		ierr ++;
		$('#eRpt').text(msj).show();
	}
	/*
	if ($('#Ejercicio').text() == '') {
		msj = '* Seleccione al menos un ejercicio';
		ierr ++;
		$('#eEje').text(msj).show();
	}
	*/

	/*
	if (!$('#chkTodo').is(':checked') && $('#tfFecIni').val() == '') {
		msj = '* Introduzca Fecha Inicial';
		ierr ++;
		$('#eFecIni').text(msj).show();
	}
	if (!$('#chkTodo').is(':checked') && $('#tfFecFin').val() == '') {
		msj = '* Introduzca Fecha Final';
		ierr ++;
		$('#eFecFin').text(msj).show();
	}
	if ($("input[name='radAvaFin']:checked").val() * 1 == 2) {
		if ($('#tfAvaFin1').val() == '') {
			msj = '* Introduzca porcentaje financiero';
			ierr ++;
			$('#eFin1').text(msj).show();
		}
		if ($('#CmbAvaFin').val() * 1 >= 7)
			if ($('#tfAvaFin2').val() == '') {
				msj = '* Introduzca porcentaje financiero';
				ierr ++;
				$('#eFin2').text(msj).show();
			}
			else if ($('#tfAvaFin2').val() * 1 < $('#tfAvaFin1').val() * 1) {
				msj = '* Porcentaje financiero debe ser mayor al primer valor';
				ierr ++;
				$('#eFin2').text(msj).show();
			}
	}
	if ($("input[name='radAvaFis']:checked").val() * 1 == 2) {
		if ($('#tfAvaFis1').val() == '') {
			msj = '* Introduzca porcentaje f\u00edsico';
			ierr ++;
			$('#eFis1').text(msj).show();
		}
		if ($('#CmbAvaFis').val() * 1 >= 7)
			if ($('#tfAvaFis2').val() == '') {
				msj = '* Introduzca porcentaje f\u00edsico';
				ierr ++;
				$('#eFis2').text(msj).show();
			}
			else if ($('#tfAvaFis2').val() * 1 < $('#tfAvaFis1').val() * 1) {
				msj = '* Porcentaje f\u00edsico debe ser mayor al primer valor';
				ierr ++;
				$('#eFix2').text(msj).show();
			}
	}
	// eliminar espacios y comas al inicio y fin
	var str = $('#tfObras').val();
	var res;
	do {
	   str = str.trim();
		if (str[0] == ',' || str[str.length - 1] == ',') {
		   res = true;
			str = str.replace(/^\,+|\,+$/gm,'');
		}
		else
		   res = false;
	} while (res);
	
	var arr = str.split (",");
	var n = arr.length;
	var i;
	
	$('#tfObras').val(str);
	for (i = 0; i < n; i++) {
		str = arr[i].trim();
		if (isNaN(str)) {
			msj = '* Valor ' + str + ' no es un valor';
			ierr ++;
			$('#eObr').text(msj).show();
			break;
		}
	}
	if ($("input[name='radAsignado']:checked").val() * 1 == 2) {
		if ($('#tfAsignado1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#eAsi1').text(msj).show();
		}
		if ($('#CmbAsignado').val() * 1 >= 7)
			if ($('#tfAsignado2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#eAsi2').text(msj).show();
			}
			else {
				str = $('#tfAsignado1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfAsignado2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#eAsi2').text(msj).show();
				}
			}
	}
	if ($("input[name='radPAsignar']:checked").val() * 1 == 2) {
		if ($('#tfPAsignar1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#ePAsi1').text(msj).show();
		}
		if ($('#CmbPAsignar').val() * 1 >= 7)
			if ($('#tfPAsignar2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#ePAsi2').text(msj).show();
			}
			else {
				str = $('#tfPAsignar1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfPAsignar2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#ePAsi2').text(msj).show();
				}
			}
	}
	if ($("input[name='radAutorizado']:checked").val() * 1 == 2) {
		if ($('#tfAutorizado1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#eAut1').text(msj).show();
		}
		if ($('#CmbAutorizado').val() * 1 >= 7)
			if ($('#tfAutorizado2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#eAut2').text(msj).show();
			}
			else {
				str = $('#tfAutorizado1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfAutorizado2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#eAut2').text(msj).show();
				}
			}
	}
	if ($("input[name='radPAutorizar']:checked").val() * 1 == 2) {
		if ($('#tfPAutorizar1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#ePAut1').text(msj).show();
		}
		if ($('#CmbPAutorizar').val() * 1 >= 7)
			if ($('#tfPAutorizar2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#ePAut2').text(msj).show();
			}
			else {
				str = $('#tfPAutorizar1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfPAutorizar2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#ePAut2').text(msj).show();
				}
			}
	}
	if ($("input[name='radEjercido']:checked").val() * 1 == 2) {
		if ($('#tfEjercido1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#eEje1').text(msj).show();
		}
		if ($('#CmbEjercido').val() * 1 >= 7)
			if ($('#tfEjercido2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#eEje2').text(msj).show();
			}
			else {
				str = $('#tfEjercido1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfEjercido2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#eEje2').text(msj).show();
				}
			}
	}
	if ($("input[name='radPEjercer']:checked").val() * 1 == 2) {
		if ($('#tfPEjercer1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#ePEje1').text(msj).show();
		}
		if ($('#CmbPEjercer').val() * 1 >= 7)
			if ($('#tfPEjercer2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#ePEje2').text(msj).show();
			}
			else {
				str = $('#tfPEjercer1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfPEjercer2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#ePEje2').text(msj).show();
				}
			}
	}
	if ($("input[name='radComprobado']:checked").val() * 1 == 2) {
		if ($('#tfComprobado1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#eCom1').text(msj).show();
		}
		if ($('#CmbComprobado').val() * 1 >= 7)
			if ($('#tfComprobado2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#eCom2').text(msj).show();
			}
			else {
				str = $('#tfComprobado1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfComprobado2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#eCom2').text(msj).show();
				}
			}
	}
	if ($("input[name='radPComprobar']:checked").val() * 1 == 2) {
		if ($('#tfPComprobar1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#ePCom1').text(msj).show();
		}
		if ($('#CmbPComprobar').val() * 1 >= 7)
			if ($('#tfPComprobar2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#ePCom2').text(msj).show();
			}
			else {
				str = $('#tfPComprobar1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfPComprobar2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#ePCom2').text(msj).show();
				}
			}
	}
	if ($("input[name='radPagado']:checked").val() * 1 == 2) {
		if ($('#tfPagado1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#ePag1').text(msj).show();
		}
		if ($('#CmbPagado').val() * 1 >= 7)
			if ($('#tfPagado2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#ePag2').text(msj).show();
			}
			else {
				str = $('#tfPagado1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfPagado2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#ePag2').text(msj).show();
				}
			}
	}
	if ($("input[name='radPPagar']:checked").val() * 1 == 2) {
		if ($('#tfPPagar1').val() == '') {
			msj = '* Introduzca monto';
			ierr ++;
			$('#ePPag1').text(msj).show();
		}
		if ($('#CmbPPagar').val() * 1 >= 7)
			if ($('#tfPPagar2').val() == '') {
				msj = '* Introduzca monto';
				ierr ++;
				$('#ePPag2').text(msj).show();
			}
			else {
				str = $('#tfPPagar1').val()
				num = numeral(str);
				val1 = num.value();
				str = $('#tfPPagar2').val()
				num = numeral(str);
				val2 = num.value();
				if (val2 < val1) {
					msj = '* Monto debe ser mayor al primer valor';
					ierr ++;
					$('#ePPag2').text(msj).show();
				}
			}
	}
	if ($('#CmbTipRpt').val() * 1 == 1 && $('#lstGpo2').children().length == 0) {
		msj = '* Seleccione grupos del reporte';
		ierr ++;
		$('#eGpo').text(msj).show();
	}
	
	if ($('#lstCol2').children().length == 0) {
		msj = '* Seleccione columnas del reporte';
		ierr ++;
		$('#eCol').text(msj).show();
	}
	*/
	
	if (ierr >= 1) {
		err = true;
		if (ierr == 1)
			msj = 'Todavía falta una opción para generar reporte <br> <br>' + msj;
		else
			msj = 'Seleccione opciones para generar reporte';
		BootstrapDialog.mensaje (null, msj, 2);
	}
	return !err;
}
