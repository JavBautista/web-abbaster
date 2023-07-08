<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProject extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function getStoreImage($image){

        if( !$image || starts_with($image,'http')){
            //return $image;
            return \Storage::disk('public')->url('assets/no-image.png');
        }
        return \Storage::disk('public')->url($image);
    }
}
