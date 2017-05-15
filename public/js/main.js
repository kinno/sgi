$(document).ready(function(){
	$(".notificacion-element").each(function(){
		$(this).click(function(event) {
			marcar_notificacion_leida($(this).attr('id'));
		});
	});

});

function marcar_notificacion_leida(id){
	$.ajax({
        data: {"_token":$('meta[name="csrf-token"]').attr('content'),'id':id},
        url: '/marcar_leida',
        type: 'post',
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(response) {
           $("#hdr").load('/actualizar_head');
        },
        error: function(response) {
            console.log("Errores::", response);
        }
    });
}