@php
$count=0;
$listaN="";
    $notificaciones = session('notificaciones');
    foreach ($notificaciones as $notificacion) {
        if($notificacion->bleido==0){
            $count++;
            $negritas="style='font-weight:bold;'";
            $botonLeer ="<span style='float:right;' class='btn btn-default btn-xs fa fa-check-circle-o notificacion-element' title='Marcar como leída' id='".$notificacion->id."'></span>";
        }else{
            $negritas ="";
            $botonLeer="";
        }
        $listaN .= "<li class='message-preview '>
                <a>
                    <div class='media' $negritas>
                        <span class='pull-left'>
                            <img alt='' class='media-object' src='http://placehold.it/50x50'>
                            </img>
                        </span>
                        <div class='media-body'>
                            <h5 class='media-heading'>
                                <strong>
                                    ".Auth::user()->name."
                                </strong>
                            </h5>
                            <p class='small text-muted'>
                                <i class='fa fa-clock-o'>
                                </i>
                              ".$notificacion->created_at." $botonLeer
                            </p>

                            <p>
                               ".$notificacion->detalle_notificacion."
                            </p>
                           
                        </div>
                    </div>
                </a>
            </li>";
    }
   
@endphp
<div class="navbar-header">
    <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
        <span class="sr-only">
            Toggle navigation
        </span>
        <span class="icon-bar">
        </span>
        <span class="icon-bar">
        </span>
        <span class="icon-bar">
        </span>
    </button>
    <div class="logoHeader">
      <img src="/images/gem.png" >  
    </div>
    <div class="titleHeader">
        Sistema de Gasto de Inversión
    </div>
        {{-- {!! Breadcrumbs::renderIfExists() !!} --}}

   
    {{-- <span class="navbar-brand">
        Sistema de Gasto de Inversión {2017}
    </span> --}}
</div>

<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            @if ($count>0)
                <span class="badge">{{$count}}</span>
            @endif
            <i class="fa fa-envelope">
            </i>
            <b class="caret">
            </b>
        </a>
        <ul id="panel_notificaciones" class="dropdown-menu message-dropdown">
       @php
           echo $listaN;
       @endphp
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user">
            </i>
            {{Auth::user()->name}}
            <b class="caret">
            </b>
        </a>
        <ul class="dropdown-menu">
           {{--  <li>
                <a href="#">
                    <i class="fa fa-fw fa-user">
                    </i>
                    Profile
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-fw fa-envelope">
                    </i>
                    Inbox
                </a>
            </li> --}}
            {{-- <li>
                <a href="#">
                    <i class="fa fa-fw fa-gear">
                    </i>
                    Settings
                </a>
            </li> --}}
            <li class="divider">
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out fa-fw"></i>Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
</ul>
{{-- {{!!Breadcrumbs::render()!!}} --}}
{{-- {{dd(session()->all())}} --}}
 <script src="/js/main.js">
</script>
