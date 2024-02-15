<?php

use App\Models\Menu;

function getDynamicMenu()
{
        $menus = \App\Models\Menu::where('sub_menu_id', 0)->orderBy('id', 'asc')->get()->toArray();
        foreach ($menus as &$menu) {
            $menu['submenus'] = \App\Models\Menu::where('sub_menu_id', $menu['id'])->orderBy('id', 'asc')->get()->toArray();
        }
    return $menus;
 
}
function get_all_menu_list(){
   return $menus = \App\Models\Menu::orderBy('id', 'asc')->get()->toArray();
}
function get_permission(){
    return $permission = \App\Models\permission::orderBy('id', 'asc')->get()->toArray();

}
?>