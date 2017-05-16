<style type="text/css">
    .menu-bar{
    overflow: hidden;
    position: fixed; 
    right: 5px;
    z-index: 1;
    height: 80px;
    }
</style>
@isset ($menu)
<div class="menu-bar">
    <div aria-label="..." class="btn-group pull-right" role="group">
        <div class="form-group form-inline">
            @isset ($menu['input'])
            <p class="navbar-text">
                {{$menu['input']['title']}}
            </p>
            <input class="form-control {{$menu['input']['class']}}" id="{{$menu['input']['id']}}" name="{{$menu['input']['id']}}" placeholder="Buscar" type="text" value=""/>
            @endisset
        @foreach ($menu['botones'] as $boton)
            <span class="btn {{$boton['tipo']}} {{$boton['icono']}}" id="{{$boton['id']}}" title="{{$boton['title']}}">
            </span>
            @endforeach
        </div>
    </div>
</div>
@endisset
