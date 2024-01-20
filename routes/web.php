<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ImageProcessingController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontEndController::class, 'index'])->name('acara');
Route::get('/konfirmasi-pembayaran', [FrontEndController::class, 'konfirmasiPembayaran'])->name('konfirmasi.pembayaran');
Route::post('/konfirmasi-pembayaran', [FrontEndController::class, 'konfirmasiPembayaranStore'])->name('konfirmasi.pembayaran.store');
Route::get('/sertifikat', [FrontEndController::class, 'sertifikat'])->name('konfirmasi.sertifikat');
Route::get('/sertifikat/{id_peserta}/download', [FrontEndController::class, 'unduhSertifikat'])->name('konfirmasi.unduhSertifikat');

Route::get('acara/{slug}', [FrontEndController::class, 'acara'])->name('acara');
Route::get('agenda', [FrontEndController::class, 'agendaIndex'])->name('agenda.index');

Route::post('cekPembayaran' , [FrontEndController::class, 'cekPembayaran'])->name('cekPembayaran');

route::prefix('/daftar')->group(function(){
    Route::get('{acara_id}/acara/{jadwal_id?}', [FrontEndController::class, 'daftar'])->name('daftar.index');
    Route::post('/simpan', [FrontEndController::class, 'daftarStore'])->name('daftar.store');
    Route::get('/sukses', [FrontEndController::class, 'daftarSuccess'])->name('daftar.success');
});

route::post('cari-tanggal',function(Request $request){
        if(!isset($request->panca) || !isset($request->sapta) ){
            abort(403);
        }
        if(!isset($request->wuku)){

            $link = 'https://www.babadbali.com/pewarigaan/cari2.php?sapta='.$request->sapta.'&panca='.$request->panca.'&xx=wuku';
            $response = Http::post($link);
            $html= $response->getBody();

            // exit();
            $html2 = explode('pewarigaan.php?today=',$html);
            $html2 = explode('<b>Wuku:</b>',$html2[0]);
            $html2 = explode('<b>mulai:</b>',$html2[1]);
            // exit();

            return $html2[0];
        }

        $link = 'https://www.babadbali.com/pewarigaan/cari2.php?sapta='.$request->sapta.'&panca='.$request->panca.'&wuku='.$request->wuku.'&year='.date('Y').'&Hitung=cari';
        $response = Http::post($link);
        $html= $response->getBody();
        $html2 = explode('pewarigaan.php?today=',$html);
        $texts ='';
        $html2 = array_slice( $html2, 0, 10);
        foreach($html2 as $key=>$date){
            if($key!=0 ){
                $tmp1= explode('">',$date);
                $tmp2 = str_replace("&month=",'-',str_replace('&year=','-',$tmp1[0]));
                $weton = $request->sapta.' '.$request->panca.' '.$request->wuku;
                $tanggal = date("d-M-Y",strtotime($tmp2));
                $texts.= '<div class="col-md-4 mt-2"><span class="tanggal-weton btn btn-info" title="Pilih tanggal" data-toggle="tooltip" tanggal="'.$tanggal.'" weton="'.$weton.'">'.$tanggal ."</span></div>";
                // array_push($texts,[$tanggal,$weton]);
            }
        }
        // dd($text);
        return response($texts);

})->name('cari-tanggal');



// Route for image prosesing
Route::get("cdn/image/{image}",[ImageProcessingController::class,'index'])->name('cdn.image');
Route::get("cdn/image/{image}?type=thumnail",[ImageProcessingController::class,'index'])->name('cdn.image.thumbnail');
Route::get("cdn/image/{image}?type=medium",[ImageProcessingController::class,'index'])->name('cdn.image.medium');
Route::get("cdn/image/{image}?width={width}&height={height}",[ImageProcessingController::class,'index'])->name('cdn.image.w&h');

