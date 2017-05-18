<style type="text/css">
    .menu-bar{
    overflow: visible;
    position: fixed; 
    left:0;
    top:50px;
    z-index: 1;
    height: auto;
    width: 100%;
    background-color: #F1F1F1;
    color: #2B2B2B;
    border-bottom: 1px solid #C2C2C2;
    }
    .botones{
            right: 10px;
    top: 10px;
    }
</style>
@isset ($barraMenu)
<div class="menu-bar">
    <div aria-label="..." class="btn-group pull-right botones" role="group">
        <div class="form-group form-inline">
            @isset ($barraMenu['input'])
            <p class="navbar-text">
                {{$barraMenu['input']['title']}}
            </p>
            <input class="form-control {{$barraMenu['input']['class']}}" id="{{$barraMenu['input']['id']}}" name="{{$barraMenu['input']['id']}}" placeholder="Buscar" type="text" value=""/>
            @endisset
        @foreach ($barraMenu['botones'] as $boton)
            <button class="btn {{$boton['tipo']}}" id="{{$boton['id']}}" title="{{$boton['title']}}">@isset($boton['texto'])
                {{$boton['texto']}}&nbsp;
            @endisset
            <span class="{{$boton['icono']}}" aria-hidden="true"></span>
            </button>
            @endforeach
        </div>
    </div>
</div>
@endisset
