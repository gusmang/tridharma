<?php
namespace App\Traits\Models;

use App\Models\Acara;

trait AcaraTrait{

    public function getAllAcara($fields='*'){
        return  Acara::orderBy('Order','ASC')->get($fields);
    }

    public function getAllAcaraWith(){
        return  Acara::with(['photos','videos'])
                    ->with('jadwals', function($query){
                        $query->where('tanggal', '>=', date('Y-m-d'));
                        $query->orderBy('tanggal', 'ASC');
                    })
                    ->get();
    }

    public function getAcaraById($id){
        return  Acara::whereId($id)->with(['photos','halaman'])
                        ->with('jadwals',function($query){
                            $query->where('tanggal','>=',date('Y-m-d'));
                            $query->orderBy('tanggal','ASC');
                        })
                        ->First();

    }
    public function getAcaraBySlug($slug){
        return  Acara::where('slug',$slug)->with('photos')
                        ->with('jadwals',function($query){
                            $query->where('tanggal','>=',date('Y-m-d'));
                            $query->orderBy('tanggal','ASC');
                        })
                        ->First();

    }

    public function getAcaraByName($name){
        return  Acara::where("name" , "like" , "%".$name."%")->orWhere("penjelasan" , "like" , "%".$name."%")->with(['photos','videos'])
                ->with('jadwals', function($query){
                    $query->where('tanggal', '>=', date('Y-m-d'));
                    $query->orderBy('tanggal', 'ASC');
                })
                ->get();

    }

    public function deleteAcara(){

    }


}
