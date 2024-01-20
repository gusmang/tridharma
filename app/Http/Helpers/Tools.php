<?php

namespace App\Http\Helpers;


class Tools
{


    public static function getFormalDate($date = null){
        if($date == null){
            return '';
        }
        $date_ar = explode("-", $date);
        $bulan_ar = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $date_ar[2] . " ". $bulan_ar[(int)$date_ar[1]] . " " . $date_ar[0];
    }


    public static function rupiah($angka){
	
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

}
