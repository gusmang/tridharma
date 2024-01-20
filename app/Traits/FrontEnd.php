<?php

namespace App\Traits;
use App\Models\Meta;
use App\Models\Acara;

trait FrontEnd{

    public function getPengaturan($halaman_id =null){
        $pengaturan = [];
        $halaman_id = $halaman_id? $halaman_id:'';
        $metas = Meta::whereIn('halaman_id',[0,$halaman_id])->get();
        foreach ($metas as $key => $meta) {
           $pengaturan[$meta->meta_key] = $meta->meta_value;
        }

        return $pengaturan;
    }
    public function getMenus(){
        $menus =  Acara::orderBy('order','ASC')->get(['slug','name']);
        return $menus;
    }
}
