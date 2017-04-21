var contadorNuevos =0;
$(document).ready(function() {
	var tableDetail;
	var template = Handlebars.compile($("#details-template").html());
	var templateComentarios = Handlebars.compile($("#comentarios-template").html());
    var table = $('#tablaObservaciones').DataTable({
    	"ordering": false,
        processing: true,
        serverSide: true,
        ajax: '/Banco/get_datos_consulta',
        columns:[
			        {
			        	data: 'id',
			        	name: 'id',
			        	render: function(data,type,full,meta){
			        		return '<a href=/EstudioSocioeconomico/ficha_tecnica/'+data+' target="_blank">'+data+'</a>';
			        	}
			        },
			        {
			        	data: 'dictamen',
			        	name: 'dictamen',
			        	render: function(data,type,full,meta){
			        		return '<a href=/Banco/imprime_dictamen/0/'+data+' target="_blank">'+data+'</a>';
			        	}
			        },
			        {data: 'hoja1.nombre_obra', name: 'hoja1.nombre_obra'},
			        {data: 'hoja1.unidad_ejecutora.nombre', name: 'hoja1.unidad_ejecutora.nombre'},
			        {data: 'movimientos[0].fecha_movimiento', name: 'movimientos.fecha_movimiento'},
			        {data: 'movimientos[0].status', name: 'movimientos.status'},
			        {
			    		"className":      'mto',
			        	data: 'hoja1.monto', name: 'hoja1.monto'
			        },
			        {
			                "className":      'details-control',
			                "orderable":      false,
			                "searchable":      false,
			                "data":           null,
			                "defaultContent": ''
			        },
		        ],
    	"rowCallback": function( row, data, index ) {
		    if(data.movimientos.length>0){
		    	 if(data.movimientos[0].id_tipo_movimiento==="2"||data.movimientos[0].id_tipo_movimiento==="3"){
		    	 	$(row).addClass('negrita');
		    	 	contadorNuevos++;
		    	 }
		    }
		   $("#total").html(contadorNuevos);
		   $("td:eq(2)",row).html("<span title='"+data.hoja1.nombre_obra+"'>"+data.hoja1.nombre_obra.substr(0,100)+"...</span>");
		  }
    });
    table.on('draw.dt',function(){
    	$(".mto").each(function(){
		    	$(this).autoNumeric({
		        aSep: ',',
		        mDec: 2,
		        vMin: '0.00'
	    	});
	    });
    });

    $('#tablaObservaciones tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'movimientos-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            // alert(row.data().id);
            initTable(tableId, row.data());
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
    });

    function initTable(tableId, data) {
        tableDetail = $('#' + tableId).DataTable({
        	"ordering": false,
        	"paging":   false,
        	"searching":   false,
        	"info":   false,
            processing: true,
            serverSide: true,
            ajax: '/Banco/get_datos_movimientos/'+data.id,
            columns: [
                { data: 'id_evaluacion', name: 'id_evaluacion' },
                { data: 'fecha', name: 'fecha' },
                { data: null },
                { data: 'observaciones', name: 'observaciones' },
                {
                "className":      'comentarios-control',
                "orderable":      false,
                "searchable":      false,
                "data":           null,
                "defaultContent": ''
        },
            ]
        })

        $('#'+tableId+' tbody').on('click', 'td.comentarios-control', function () {
	        var tr = $(this).closest('tr');
	        var row = tableDetail.row(tr);
	        var tableId = 'comentarios-' + row.data().id_evaluacion;

	        if (row.child.isShown()) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        } else {
	            // Open this row
	            row.child(templateComentarios(row.data())).show();
	            // alert(row.data().id_evaluacion);
	            initTableComentarios(tableId, row.data());
	            tr.addClass('shown');
	            tr.next().find('td').addClass('no-padding bg-gray');
	        }
	    });
    }



    function initTableComentarios(tableId, data) {
       $('#' + tableId).DataTable({
        	"ordering": false,
        	"paging":   false,
        	"searching":   false,
        	"info":   false,
            processing: true,
            serverSide: true,
            ajax: '/Banco/get_datos_comentarios/'+data.id_evaluacion,
            columns: [
                { data: 'sub_inciso.nombre_subinciso', name: 'inciso' },
                { data: 'pagina',name: 'pagina' },
                { data: 'observaciones', name: 'observaciones' },
            ]
        })
    }



});