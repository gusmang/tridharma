<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Meta;
use App\Traits\StripTag;

class PengaturanController extends Controller
{
    use StripTag;

    public function index() {
        $metas = Meta::where('halaman_id',0)->get();
        $datas = [];
        foreach ($metas as $key => $meta) {
            $datas[$meta->meta_key] = [$meta->id,$meta->meta_value];
        }
        return view('dashboard.pengaturan.index',['title'=>'Pengaturan','datas'=>$datas]);
    }

    public function store(Request $request) {
        if($request->namaAplikasi)
            $this->saveMeta('nama_aplikasi',$request->namaAplikasi);

        if($request->subTitle)
            $this->saveMeta('subtitle_aplikasi',$request->subTitle);

        if($request->content)
            $this->saveMeta('content',$request->content);

        if($request->alamat)
            $this->saveMeta('alamat',$request->alamat);

        if($request->maps)
            $this->saveMeta('maps',$request->maps);

        if($request->hasFile('featureImage')){
            $file_image = Str::random(50).'.'.$request->file('featureImage')->getClientOriginalExtension();
            $request->file('featureImage')->storeAs('public/full',$file_image);
            $this->updateMeta('feature_image',$file_image);
        }
        if($request->hasFile('logo')){
            $file_image = Str::random(50).'.'.$request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('public/full',$file_image);
            $this->updateMeta('logo',$file_image);
        }
        return redirect()->route('pengaturan.index')->with('notif-success','menyimpan pengaturan berhasil');
    }

    public function update(Request $request) {
        // dd($request->all());
        if($request->namaAplikasi)
            $this->updateMeta('nama_aplikasi',$request->namaAplikasi);

        if($request->subTitle)
            $this->updateMeta('subtitle_aplikasi',$request->subTitle);

        if($request->content)
            $this->updateMeta('content',$request->content);

        if($request->alamat)
            $this->updateMeta('alamat',$request->alamat);

        if($request->maps)
            $this->updateMeta('maps',$request->maps);

        if($request->hasFile('featureImage')){
            $file_image = Str::random(50).'.'.$request->file('featureImage')->getClientOriginalExtension();
            $request->file('featureImage')->storeAs('public/full',$file_image);
            $this->updateMeta('feature_image',$file_image,true);
        }
        if($request->hasFile('logo')){
            $file_image = Str::random(50).'.'.$request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('public/full',$file_image);
            $this->updateMeta('logo',$file_image,true);
        }

        if($request->nama_bank)
            $this->updateMeta('nama_bank', $request->nama_bank);

        if($request->norek_bank)
            $this->updateMeta('norek_bank', $request->norek_bank);

        if($request->pemilik_bank)
            $this->updateMeta('pemilik_bank', $request->pemilik_bank);


        return redirect()->route('pengaturan.index')->with('notif-success','Update pengaturan berhasil');
    }

    private function saveMeta($key,$value,$isPhoto=null){
        $meta = new Meta;
        $meta -> halaman_id = 0;
        $meta -> order  = 0;
        $meta -> meta_key = $key;
        $meta -> meta_value = strip_tags($value,$this->stripTagFilter());
        if($isPhoto)
            $meta->is_photo = true;
        $meta -> save();
    }
    private function updateMeta($key,$value,$isPhoto=null){
        $meta = Meta::where('meta_key', $key)->first();
        if($meta){
            $meta -> meta_value = strip_tags($value,$this->stripTagFilter());
            $meta -> save();
        }
        else{
            $this->saveMeta($key,$value,$isPhoto);
        }
    }
}
