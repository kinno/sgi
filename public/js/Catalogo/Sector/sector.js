/*$(document).ready(function () {
	$.ajaxSetup({
       	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
	});
	alert ('sector1');
});*/

$(document).ready( function() {
	Triggers ();
	LimpiaSector ();
});

function LimpiaSector () {
	var vacio ='<option value="0">- Selecciona</option>';
		
	$('#id_departamento').html(vacio);
	$('#id_area, #id_departamento').val('0');
	$('#nombre, #titulo, #titular, #apellido, #cargo').val('');
	$('#bactivo').prop('checked',false);
	//$('.oculto').hide();
}


function Triggers () {
	var vacio ='<option value="0">- Selecciona</option>';
	var str = "";
	
	// evento Area
	$('#id_area').unbind("change").on('change', function (){
		var id = $('#id_area').val();
		if (id == '0')
		    $('#id_departamento').html(vacio);
		else {
			//$('#eEje').hide();
			$.ajax({
	            data: {
	                id: id
	            },
	            url: '/Catalogo/dropdown',
	            type: 'GET',
	            success: function (data) {
	            	//alert(data);
	            	$('#id_departamento').html(data);
            	}
            });
		}
   });
}	
