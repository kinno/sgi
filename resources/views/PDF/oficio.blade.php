{{-- {{dd($oficio->id_solicitud_presupuesto)}} --}}
@php
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$fecha = Carbon\Carbon::parse($oficio->fecha_oficio);

	$fecha_completa = $fecha->day." de ".$meses[$fecha->month]." del ".$fecha->year;
	$montoTotal = 0;
	foreach ($oficio->detalle as $value) {
         if ($oficio->id_solicitud_presupuesto == 1 || $oficio->id_solicitud_presupuesto == 9) {
            $montoTotal += (double)$value->asignado;
            } else if ($oficio->id_solicitud_presupuesto == 2) {
                $montoTotal += (double)$value->autorizado;
            } else {
                $montoTotal += (double)$value->autorizado;
            }
		
	}
	// NumeroALetras::convertir($montoTotal, 'de pesos', 'centimos');
@endphp
<style type="text/css">
     @font-face {
        font-family: gotham-book;
        src: url({{ asset('fonts/Gotham-Book.ttf') }}) format("truetype");
        
    }
    @font-face {
       
        font-family: gotham-medium;
        src: url({{ asset('fonts/Gotham-Medium.ttf') }}) format("truetype");
    }
@page rotated { size: landscape; }
html {
    font-family: gotham-book !important;

}
.contenedor {
    font-size: 14px;
    margin-top: 100px;
    margin-bottom: 0px;
    height: 100%;
    page-break-after: always;
   
}

.leyenda {
    text-align: center;
    padding-bottom: 10px;
    font-family: gotham-medium !important;
    /*transform: scale(1, .9) !important;*/
}

.asunto {
    text-align: right;
}

p {
    line-height: 100%;
}

/*.texto-asunto{
	line-height: 200%;
}*/

.titular {
    text-align: left;
    font-family: gotham-medium !important;
}

.texto {
    padding-top: 10px;
    text-align: justify;
    text-justify: inter-word;
    line-height: 100%;
    /*transform: scale(1, .9) !important;*/
   
}
.monto{
	font-family: gotham-medium !important;
}
.atentamente {
    text-align: center;
    padding-top: 20px;
    font-family: gotham-medium !important;
    }

.ccp {
   font-size: 10px;
    position: absolute;
    bottom: 0;
    /*transform: scale(1, .9) !important;*/
}

.historial{
background-color: gray;
    height: 100%;
    width: 100%;
    /*transform: rotate(270deg);*/
    /*transform-origin: left bottom 0;*/
    /*page: rotated;*/
}
.tabla{
     transform: rotate(270deg);
    transform-origin: left bottom 0;
    left: 100px;
}
</style>
<div class="contenedor">
    <div class="leyenda">
        {{$oficio->frase_ejercicio->frase}}
    </div>
    <div class="asunto">
        <p>
            203200-{{$oficio->prefijo}}-{{$oficio->clave}}
        	<br />
            Toluca de Lerdo, México;
        	<br />
            {{$fecha_completa}}
        	<br />
            ASUNTO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!!nl2br($oficio->asunto)!!}
        </p>
    </div>
    <div class="titular">
        {!!nl2br($oficio->titular)!!}
        <br/>
        P&nbsp;&nbsp;R&nbsp;&nbsp;E&nbsp;&nbsp;S&nbsp;&nbsp;E&nbsp;&nbsp;N&nbsp;&nbsp;T&nbsp;&nbsp;E
    </div>
    <div class="texto">
        {!!nl2br(str_replace("<<<Total>>>","<span class='monto'>$".number_format($montoTotal,2)."</span> (".NumeroALetras::convertir($montoTotal, 'de pesos', 'centimos').")",$oficio->texto))!!}
    </div>
    <div class="atentamente">
        <p>
            A T E N T A M E N T E
        </p>
        <p>
            SUBSECRETARIO
        </p>
        <br/>
        <p>
            M. EN A. CARLOS DANIEL APORTELA RODRÍGUEZ
        </p>
    </div>
    <div class="ccp">
    	<code>
        C.p.p: {!!nl2br(str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$oficio->ccp))!!}
        </code>
        <br/>
        <br/>
        {{$oficio->iniciales}}
        
    </div>
</div>
