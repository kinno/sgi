$(document).ready(function(){
	$(".notificacion-element").each(function(){
		$(this).click(function(event) {
			marcar_notificacion_leida($(this).attr('id'));
		});
	});

    $(".element-menu").each(function(){
        $(this).on('click',function(){
            // $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
            $("ul.in").collapse("hide");
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