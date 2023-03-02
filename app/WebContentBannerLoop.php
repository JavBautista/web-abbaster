<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebContentBannerLoop extends Model
{
    protected $guarded = [];

    public function getImageStore($image){
        if( !$image || starts_with($image,'http')){
            return \Storage::disk('public')->url('assets/no-image.png');
        }
        return \Storage::disk('public')->url($image);
    }
}
