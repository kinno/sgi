
<html>
<head>
  <style>
	  @font-face {
	    font-family: gotham-book;
	    src: url({{ asset('fonts/Gotham-Book.ttf') }}) format("truetype");
	    
		}
		@font-face {
		   
		    font-family: gotham-medium;
		    src: url({{ asset('fonts/GothamHTF-Bold.ttf') }}) format("truetype");
		}
	 @page { margin: 40px 25px; }
   html{
    font-family: gotham-book ;

	}
   table {border-collapse: collapse; }
   
    .container{width:100%; border-top: 3px solid #d6d6d6;}
    
	.left{float:left;width:33%; 	}
	.right{float:right;width:33%;  text-align: right; }
	.center{margin:0 auto;width:34%; text-align: center; }
	.numero{
		text-align: right;
	}
	.
	.head{ height: 50px; border-top: 3px solid #d6d6d6; font-size: 12px;}
	.sub-head {padding: 0; font-size: 10px; border-top: 3px solid #d6d6d6; border-bottom: 3px solid #d6d6d6;}
	.blank{ height: 10px;}

	/*.main{
		
		padding-top: 55px;
	}*/
	.unidad-ejecutora{
		font-family: gotham-medium;
		font-size: 12px;
		background-color: #d6d6d6;
	}
	.id-obra{
		font-size: 10px !important;
		text-align: center;
	}
	.nombre-obra{
		font-size: 10px !important;
	}
	.general{
		
		font-size: 8px;
	}
	.totales{
		
		font-size: 8px;
	}
	.total{
		border-top: 2px solid #d6d6d6;
	}
	.negrita{
		font-family: gotham-medium !important;
	}
  
  </style>
</head>
<body>
  {{-- <footer>footer on each page</footer> --}} 
  <main class="main">
    <div>
		<table  border="0" style="width:100%" cellpadding="0">
		    <thead style="font-family: gotham-medium;">
		    	<tr>
		    		<td class="head" colspan="6">
		    			<div id="container">
						    <div class="left negrita">
						        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANEXO
						    </div>
						    <div class="right negrita">
						        {{mb_strtoupper ($oficio_actual->tipo_solicitud->nombre)}}<br/>
						        203200-APAD-{{$oficio_actual->clave}}
						    </div>
						    <div class="center negrita">
						        {{mb_strtoupper($oficio_actual->sector->nombre)}}
						    </div>
					    </div>
		    		</td>
		    	</tr>
	    		<tr >
			        <td style="text-align: center" width="5%" class="sub-head">	
			        	No. de Control
			        </td>
			        <td width="50%" class="sub-head">
			       	 Descripción<br>Municipio / Localidad<br>Estructura Programática
			        </td>
			        <td width="20%" class="sub-head">
			        	Oficio
			        </td>
			        <td width="5%" class="sub-head">
			        	Inversión
			        </td >
			        <td class="sub-head numero" width="10%" >
			        	Monto<br>Asignado
			        </td>
			        <td class="sub-head numero" width="10%">
			        	Monto<br>Autorizado
			        </td>
		        </tr>
		        <tr >
		    		<th class="blank" colspan="6">
		    		</th>
		    	</tr>
		    </thead>
		    <tbody>
		    @for ($i = 0; $i < 7; $i++)
		    	@foreach ($detalle as $unidad)
			    	<tr>
						<td class="unidad-ejecutora" colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$unidad->nombre}}</td>
					</tr>	
						@foreach ($unidad->obras as $obra)
							@php
								$sumaAsignado = 0.00;
								$sumaAutorizado = 0.00;

							@endphp	 
							<tr class="general">
								<td class="id-obra">{{$obra->id}}</td>
								<td class="nombre-obra">{{mb_strtoupper($obra->nombre)}}</td>
								@foreach ($obra->detalle_oficios as $detalle_oficio)
									@if($loop->iteration==1)
										<tr class="general">
										<td></td>
										<td>{{$obra->municipio_reporte->nombre}}</td>
									@endif
									@if(!$loop->first)
										<tr class="general">
										<td></td>
										<td></td>
									@endif
									@php
										if($detalle_oficio->oficio->clave == $oficio_actual->clave){
											$clase = 'negrita';
										}else{
											$clase = '';
										}
									@endphp	 
										<td class="{{$clase}}">{{$detalle_oficio->oficio->clave}} {{$detalle_oficio->oficio->fecha_oficio}} {{$detalle_oficio->oficio->id_solicitud_presupuesto}} {{substr($detalle_oficio->fuentes->descripcion,0,3)}}</td>
										 <td class="{{$clase}}">{{($detalle_oficio->fuentes->tipo=='E')?'Estatal' : 'Federal'}}</td>
										 @if ($detalle_oficio->oficio->id_solicitud_presupuesto==4)
										 	<td class="{{$clase}} numero">({{($detalle_oficio->asignado)?number_format($detalle_oficio->asignado,2):'0.00'}})</td>
										 	<td class="{{$clase}} numero">({{($detalle_oficio->autorizado)?number_format($detalle_oficio->autorizado,2):'0.00'}})</td>
										 @else
										 	<td class="{{$clase}} numero">{{($detalle_oficio->asignado)?number_format($detalle_oficio->asignado,2):'0.00'}}</td>
										 	<td class="{{$clase}} numero">{{($detalle_oficio->autorizado)?number_format($detalle_oficio->autorizado,2):'0.00'}}</td>	
										 @endif
									 @if(!$loop->first)
										</tr>
									@endif
									@php
										if($detalle_oficio->oficio->id_solicitud_presupuesto!==4){
											$sumaAsignado += $detalle_oficio->asignado;
											$sumaAutorizado += $detalle_oficio->autorizado;
										}
									@endphp	 
						    	@endforeach
							</tr>
							<tr class="totales negrita">
								<td colspan="4" style="text-align: right">ACUMULADO</td>
								<td class="numero total">{{number_format($sumaAsignado,2)}}</td>
								<td class="numero total">{{number_format($sumaAutorizado,2)}}</td>

							</tr>
						@endforeach
					</tr>
				@endforeach
		    @endfor
		    </tbody>
		</table>
	</div>
  </main>
</body>
</html>
{{-- <div class="header">
	<div id="container">
	    <div class="left">
	        ANEXO
	    </div>
	    <div class="right">
	        TIPO DE SOLICITUD<br>
	        203200-APAD-CLAVE
	    </div>
	    <div class="center">
	        SECTOR
	    </div>
	</div>
	<table border="1" style="width:100%">
	    <tr>
	        <td>	
	        No. de Control
	        </td>
	        <td>
	        Descripción<br>Municipio / Localidad<br>Estructura Programática
	        </td>
	        <td colspan="3">
	        Oficio
	        </td>
	        <td>
	        Inversión
	        </td>
	        <td>
	        Monto Asignado
	        </td>
	        <td>
	        Monto Autorizado
	        </td>
	    </tr>
    </table>
</div>
<div class="main">
<table border="1" style="width:100%">
    <tr>
        <td>	
        No. de Control
        </td>
        <td>
        Descripción<br>Municipio / Localidad<br>Estructura Programática
        </td>
        <td colspan="3">
        Oficio
        </td>
        <td>
        Inversión
        </td>
        <td>
        Monto Asignado
        </td>
        <td>
        Monto Autorizado
        </td>
    </tr>
    
    	@foreach ($detalle as $unidad)
    	<tr>
			<td colspan="8">{{$unidad->nombre}}</td>
		</tr>	
			@foreach ($unidad->obras as $obra)
				@php
					$sumaAsignado = 0.00;
					$sumaAutorizado = 0.00;
				@endphp	 
				<tr>
					<td>{{$obra->id}}</td>
					<td>{{$obra->nombre}}</td>
					@foreach ($obra->detalle_oficios as $detalle_oficio)
						@if(!$loop->first)
							<tr>
							<td></td>
							<td></td>
						@endif
							<td>{{$detalle_oficio->oficio->clave}}</td>
							 <td>{{$detalle_oficio->oficio->fecha_oficio}}</td>
							 <td>{{$detalle_oficio->oficio->id_solicitud_presupuesto}} {{$detalle_oficio->fuentes->descripcion}}</td>
							 <td>{{($detalle_oficio->fuentes->tipo=='E')?'Estatal' : 'Federal'}}</td>
							 @if ($detalle_oficio->oficio->id_solicitud_presupuesto==4)
							 	<td class="numero">({{($detalle_oficio->asignado)?number_format($detalle_oficio->asignado,2):'0.00'}})</td>
							 	<td class="numero">({{($detalle_oficio->autorizado)?number_format($detalle_oficio->autorizado,2):'0.00'}})</td>
							 @else
							 	<td class="numero">{{($detalle_oficio->asignado)?number_format($detalle_oficio->asignado,2):'0.00'}}</td>
							 	<td class="numero">{{($detalle_oficio->autorizado)?number_format($detalle_oficio->autorizado,2):'0.00'}}</td>	
							 @endif
							 
						
						 @if(!$loop->first)
							</tr>
						@endif
						@php
							if($detalle_oficio->oficio->id_solicitud_presupuesto!==4){
								$sumaAsignado += $detalle_oficio->asignado;
								$sumaAutorizado += $detalle_oficio->autorizado;
							}
						@endphp	 
			    	@endforeach
				</tr>
				<tr class="totales">
					<td colspan="6" style="text-align: right">ACUMULADO</td>
					<td class="numero">{{number_format($sumaAsignado,2)}}</td>
					<td class="numero">{{number_format($sumaAutorizado,2)}}</td>

				</tr>
			@endforeach
		@endforeach
    </tr>
</table>
</div> --}}

{{-- {{dd($detalle)}} --}}
{{-- {{dd($oficio_actual)}} --}}
