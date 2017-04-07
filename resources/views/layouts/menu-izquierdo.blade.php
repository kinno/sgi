<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
    @php

        $menus = \Auth::user()->menus()->with('menuPadre')->get();
        // dd($menus);
        // $menus = $user->menus;
        $menuItems = "";
        $menuHead = "";
        $auxMenu=0;
        $countMenu = count($menus);
        $idMenuPadre=0;
        foreach ($menus as $menu) {
            if($menu->id_menu_padre){
                if($idMenuPadre!==$menu->id_menu_padre){
                    if($auxMenu>0){
                        $menuItems .='</ul></li>';
                    }
                    $menuItems .= '
                                    <li>
                                        <a data-target="#'.$idMenuPadre.'" data-toggle="collapse" href="javascript:;">
                                            <i class="fa fa-circle-o">
                                            </i>
                                            '.$menu->menuPadre->nombre.'
                                            <i class="fa fa-fw fa-caret-down">
                                            </i>
                                        </a>
                                    <ul class="collapse" id="'.$idMenuPadre.'">
                                    ';
                }
                
                $menuItems .= '
                <li>
                    <a href="/'.$menu->ruta.'">
                        '.$menu->nombre.'
                    </a>
                </li>
                ';
                $idMenuPadre = $menu->id_menu_padre;
            }else{}
            $auxMenu++;
        }
        echo $menuItems;
    @endphp
    
        {{-- <li>
            <a data-target="#estudio" data-toggle="collapse" href="javascript:;">
                <i class="fa fa-child">
                </i>
                Estudio Socioeconómico
                <i class="fa fa-fw fa-caret-down">
                </i>
            </a>
            <ul class="collapse" id="estudio">
                <li>
                    <a href="/EstudioSocioeconomico/crear_estudio">
                        Creación/Modificación
                    </a>
                </li>
                <li>
                    <a href="/Banco/dictaminacion">
                        Dictaminación
                    </a>
                </li>
                <li>
                    <a href="">
                        Consulta de Comentarios
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a data-target="#expediente" data-toggle="collapse" href="javascript:;">
                <i class="fa fa-clipboard">
                </i>
                Expediente Técnico
                <i class="fa fa-fw fa-caret-down">
                </i>
            </a>
            <ul class="collapse" id="expediente">
                <li>
                    <a href="/EstudioSocioeconomico/crear_estudio">
                        Creación/Modificación
                    </a>
                </li>
                <li>
                    <a href="/Banco/dictaminacion">
                        Dictaminación
                    </a>
                </li>
                <li>
                    <a href="">
                        Consulta de Comentarios
                    </a>
                </li>
            </ul>
        </li> --}}
        {{--
        <li class="active">
            <a href="index.html">
                <i class="fa fa-fw fa-dashboard">
                </i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="charts.html">
                <i class="fa fa-fw fa-bar-chart-o">
                </i>
                Charts
            </a>
        </li>
        <li>
            <a href="tables.html">
                <i class="fa fa-fw fa-table">
                </i>
                Tables
            </a>
        </li>
        <li>
            <a href="forms.html">
                <i class="fa fa-fw fa-edit">
                </i>
                Forms
            </a>
        </li>
        <li>
            <a href="bootstrap-elements.html">
                <i class="fa fa-fw fa-desktop">
                </i>
                Bootstrap Elements
            </a>
        </li>
        <li>
            <a href="bootstrap-grid.html">
                <i class="fa fa-fw fa-wrench">
                </i>
                Bootstrap Grid
            </a>
        </li>
        <li>
            <a data-target="#demo" data-toggle="collapse" href="javascript:;">
                <i class="fa fa-fw fa-arrows-v">
                </i>
                Dropdown
                <i class="fa fa-fw fa-caret-down">
                </i>
            </a>
            <ul class="collapse" id="demo">
                <li>
                    <a href="#">
                        Dropdown Item
                    </a>
                </li>
                <li>
                    <a href="#">
                        Dropdown Item
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="blank-page.html">
                <i class="fa fa-fw fa-file">
                </i>
                Blank Page
            </a>
        </li>
        <li>
            <a href="index-rtl.html">
                <i class="fa fa-fw fa-dashboard">
                </i>
                RTL Dashboard
            </a>
        </li>
        --}}
    </ul>
</div>
<!-- /.navbar-collapse -->
