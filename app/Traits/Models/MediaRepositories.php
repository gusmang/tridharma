<?php
namespace App\Traits\Models;
use App\Models\Meta;
use App\Models\Media;

trait MediaRepositories{
    public function deleteMediaOnMeta($id){
        $meta = Meta::findOrFail($id);

        if($meta->is_photo)
            $this->deleteFile($meta->meta_value);

        $meta -> delete();

        return back()->with('notif-success','Update Order berhasil');
    }

    public function deleteMedia($id){
        $media =  Media::findOrFail($id);

        $this->deleteFile($media->url);

        $media->delete();
        return back()->with('notif-success','Media berhasil di hapus');
    }

    public function deleteFile($filename){
          \Storage::delete('public/full/'.$filename);
    }
}
