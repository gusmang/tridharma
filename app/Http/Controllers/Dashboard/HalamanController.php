<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use App\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\StripTag;
use App\Traits\Models\AcaraTrait as AcaraRepositories;

class HalamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use StripTag,AcaraRepositories;

    public function index()
    {
        $halamans = Halaman::orderBy('order','ASC')->get();
        return view('dashboard.halaman.index',['title'=>'Halaman','halamans'=>$halamans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acara = $this->getAllAcara(['id','name']);
        return view('dashboard.halaman.form',['title'=>'Halaman','halaman'=>[],'acaras'=>$acara]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
        ]);

        $slug = Str::slug($request->title);
        $check_halaman = Halaman::where('slug',$slug)->count();
        if($check_halaman){
            $slug  = $slug.'-'.($check_halaman+1);
        }
        // dd($request->all());
        $halaman = new Halaman;
        $halaman -> title = strip_tags($request->title);
        $halaman -> slug = $slug;
        $halaman -> content = strip_tags($request->content,$this->stripTagFilter());
        $halaman -> order = strip_tags($request->order);
        if($request->acara)
            $halaman -> acara_id = strip_tags($request->acara);

        if(isset($request->is_homepage)){
            Halaman::where('is_homepage',true)->update(['is_homepage'=>false]);
            $halaman->is_homepage = true;
        }

        if($request->hasFile('featureImage')){
            $file_image = Str::random(50).'.'.$request->file('featureImage')->getClientOriginalExtension();
            $request->file('featureImage')->storeAs('public/full',$file_image);
            $halaman -> feature_image = $file_image;
        }

        $halaman -> save();

        if(isset($request->metaKey) && isset($request->metaValue)) {
            $meta_keys = $request->metaKey;
            $meta_values = $request->metaValue;

            // make sure count meta key and value same
            if(count($meta_keys) === count($meta_values)){
                foreach($meta_keys as $key=>$meta_key) {
                    if( !is_null($meta_key) && !is_null($meta_values[$key])) {
                        $meta =  new Meta;
                        $meta-> halaman_id = $halaman->id;
                        $meta -> meta_key = $meta_key;
                        $meta -> meta_value = $meta_values[$key];
                        $meta -> order = $key;
                        $meta ->save();
                    }
                }
            }

        }

        if(isset($request->metaKeyFile) && isset($request->metaValueFile)) {
            $meta_keys   = $request->metaKeyFile;
            $meta_values = $request->metaValueFile;

            // make sure count meta key and value same
            if(count($meta_keys) === count($meta_values)){
                foreach($meta_keys as $key=>$meta_key) {
                    if( !is_null($meta_key) && !is_null($meta_values[$key])) {
                        $file_image = Str::random(50).'.'.$meta_values[$key]->getClientOriginalExtension();
                        $meta_values[$key]->storeAs('public/full',$file_image);

                        $meta =  new Meta;
                        $meta -> halaman_id = $halaman->id;
                        $meta -> meta_key   = $meta_key;
                        $meta -> meta_value = $file_image;
                        $meta -> is_photo   = true ;
                        $meta -> order      = $key;
                        $meta ->save();
                    }
                }
            }

        }


        return redirect()->route('halaman.edit',$halaman->id)->with('notif-success','Save Data Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Halaman  $halaman
     * @return \Illuminate\Http\Response
     */
    public function show(Halaman $halaman)
    {
        dd("sdas");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Halaman  $halaman
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $halaman = Halaman::whereId($id)->with('metas',function($query){
            $query->orderBy('order','ASC');
        })
        ->first();
        $acara = $this->getAllAcara(['id','name']);
        return view('dashboard.halaman.form',['title'=>'Halaman','halaman'=>$halaman,'acaras'=>$acara]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Halaman  $halaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|string',
        ]);

        $slug = Str::slug($request->title);

        $halaman = Halaman::findOrFail($id);
        $halaman -> title   = strip_tags($request->title);
        $halaman -> slug    = $slug;
        $halaman -> content = strip_tags($request->content,$this->stripTagFilter());

        $halaman -> order = strip_tags($request->order);
        if($request->acara)
            $halaman -> acara_id = strip_tags($request->acara);

        if(isset($request->is_homepage))
            Halaman::where('is_homepage',true)->update(['is_homepage'=>false]);

        $halaman->is_homepage = isset($request->is_homepage)? true :false;

        if($request->hasFile('featureImage')){
            $file_image = Str::random(50).'.'.$request->file('featureImage')->getClientOriginalExtension();
            $request->file('featureImage')->storeAs('public/full',$file_image);
            $halaman -> feature_image = $file_image;
        }

        $halaman -> save();

        //delete all meta  related with this page

        Meta::where('halaman_id',$halaman->id)->where('is_photo','0')->where('is_vidio','0')->delete();

        if(isset($request->metaKey) && isset($request->metaValue)) {
            $meta_keys   = $request->metaKey;
            $meta_values = $request->metaValue;

            // make sure count meta key and value same
            if(count($meta_keys) === count($meta_values)){
                foreach($meta_keys as $key=>$meta_key) {
                    if( !is_null($meta_key) && !is_null($meta_values[$key])) {

                        $meta =  new Meta;
                        $meta -> halaman_id = $halaman->id;
                        $meta -> meta_key   = $meta_key;
                        $meta -> meta_value = $meta_values[$key] ;
                        $meta -> order      = $key;
                        $meta ->save();
                    }
                }
            }

        }
        //save file
        if(isset($request->metaKeyFile) && isset($request->metaValueFile)) {
            $meta_keys   = $request->metaKeyFile;
            $meta_values = $request->metaValueFile;

            // make sure count meta key and value same
            if(count($meta_keys) === count($meta_values)){
                foreach($meta_keys as $key=>$meta_key) {
                    if( !is_null($meta_key) && !is_null($meta_values[$key])) {
                        $file_image = Str::random(50).'.'.$meta_values[$key]->getClientOriginalExtension();
                        $meta_values[$key]->storeAs('public/full',$file_image);

                        $meta =  new Meta;
                        $meta -> halaman_id = $halaman->id;
                        $meta -> meta_key   = $meta_key;
                        $meta -> meta_value = $file_image;
                        $meta -> is_photo   = true ;
                        $meta -> order      = $key;
                        $meta ->save();
                    }
                }
            }

        }

        return redirect()->route('halaman.edit',$halaman->id)->with('notif-success','Save Data Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Halaman  $halaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Halaman $halaman)
    {
        dd("sdas");
    }

    public function deleteFI($id){
        $halaman = Halaman::findOrFail($id);
        \Storage::delete('public/full/'.$halaman->feature_image);

        $halaman->feature_image = '';
        $halaman->save();
        return back()->with('notif-success','Hapus Gambar utama berhasil');
    }
}
