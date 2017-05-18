<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
    <div class="mnu-inicio"><span class="fa fa-list"></span> Módulos</div>
    <div class="separador"></div>
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
                                        <a data-target="#'.$idMenuPadre.'" class="element-menu" data-toggle="collapse" href="javascript:;">
                                            <i class="fa fa-fw fa-caret-right">
                                            </i>
                                            <span class="small" style="font-weight:bold;">
                                             :: '.$menu->menuPadre->nombre.'
                                            </span>
                                            
                                        </a>
                                    <ul class="collapse" id="'.$idMenuPadre.'">
                                    ';
                }
                
                $menuItems .= '
                <li>
                    <a href="/'.$menu->ruta.'">
                        <span class="small " style="font-weight:bold;">
                        : '.$menu->nombre.'
                        </span>
                    </a>
                </li>
                ';
                $idMenuPadre = $menu->id_menu_padre;
            }else{}
            $auxMenu++;
        }
        echo $menuItems;
    @endphp
       
    </ul>
</div>
<!-- /.navbar-collapse -->
