<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait Uploads {

    private $path = 'images/';


    public function imageDelete($name)
    {
        $thumb = public_path($this->path.'thumb/').$name;
        $img = public_path($this->path) . $name;
        return File::delete(["$thumb", "$img"]);
    }

    public function imageUpload($image, $size = null,$TSize = null ,$name = null){
        if(!is_string($name)){
           $name = (int) microtime(true).'.'.$image->getClientOriginalExtension();
            $image = $image->move(public_path($this->path),$name);
            if($size){
                Image::make(public_path($this->path) . $name)
                    ->resize($size[0] ?? null, $size[1] ?? null, function ($constraint) {
//                        $constraint->aspectRatio();
                    })->save(public_path($this->path) . $name);
            }
            if($TSize){
                Image::make(public_path($this->path) . $name)
                    ->resize($TSize[0] ?? null, $TSize[1] ?? null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path($this->path.'thumb/') . $name);
            }

            return $name;
        }
    }

}
