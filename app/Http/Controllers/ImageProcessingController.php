<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageProcessingController extends Controller
{
    public function index(Request $request,$image){

        /**
         * type => full,medium,thumbnail
         * height =>
         * width =>
         */
        // create a new empty image resource
        // $img = \Image::canvas(800, 600, '#ff0000');
        $image = \Storage::get('public/full/'.$image);
        if(!$image){
            $image =\Image::canvas($request->query('width', 360), $request->query('height', 360), '#59C4BC');
            return $image->response();
        }
        // send HTTP header and output image data

        if(isset($request->type)){
            switch ($request->type) {
                case 'thumbnail':
                    $img = \Image::make($image)->fit(200, 200, function ($constraint) {
                        $constraint->upsize();
                    });;
                    break;

                default:
                    $img = \Image::make($image)->fit(600, 600, function ($constraint) {
                        $constraint->upsize();
                    });
                    break;
            }
        }
        elseif(isset($request->width) && isset($request->height)){

            $img = \Image::make($image)->fit($request->width,$request->height, function ($constraint) {
                $constraint->upsize();
            });
        }

        elseif(isset($request->height) && !isset($request->width)){

        }

        elseif(!isset($request->height) && isset($request->width)){

        }
        else{
            $img = \Image::make($image);
        }


        return $img->response();
    }
}
