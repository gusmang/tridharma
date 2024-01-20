<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Media;

use App\Traits\Models\MediaRepositories;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use MediaRepositories;

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'file'=>'required|image|mimes:jpeg,jpg,png,webp:max:5048',
            'model'=>'required',
            'model_id'=>'required',
        ]);

        if($request->hasfile('file')){
            $file_image = Str::random(50).'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/full',$file_image);

            $media = new Media;
            $media->mediable_type =$request->model;
            $media->mediable_id = $request->model_id;
            $media->url = $file_image;
            $media->photo = $request->is_photo == true? true:false;
            $media->caption ="null";
            $media -> save();
        }
        return back()->with('notif-success','File Sudah di simpan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->deleteMedia($id);
    }
}
