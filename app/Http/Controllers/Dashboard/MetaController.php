<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meta;

use App\Traits\Models\MediaRepositories;

class MetaController extends Controller
{
    //
    use MediaRepositories;

    public function setOrder(Request $request) {
        $request->validate([
            'id'=>'required|exists:App\Models\Meta,id',
            'order'=>'required|Integer|min:0'
        ]);

        $meta = Meta::findOrFail($request->id);
        $meta -> order = strip_tags($request->order);
        $meta -> save();

        return back()->with('notif-success','Update Order berhasil');
    }

    public function delete(Request $request) {
        return $this->deleteMediaOnMeta($request->id);
    }
}
