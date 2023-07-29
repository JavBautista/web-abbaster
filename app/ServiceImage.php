<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps=false;

    public function getStoreImage($image){

        if( !$image || starts_with($image,'http')){
            //return $image;
            return \Storage::disk('public')->url('assets/no-image.png');
        }
        return \Storage::disk('public')->url($image);
    }
}
