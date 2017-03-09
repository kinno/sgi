jQuery(document).ready(function($) {
	$("#panel1").on('click',function(){
		$("#hojaActual").val('1');
	});
	$("#panel2").on('click',function(){
		$("#hojaActual").val('2');
	});
	$("#btnGuardar").on('click',function(){
		guardar();
	});
});

function guardar(){
	
}