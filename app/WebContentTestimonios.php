<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebContentTestimonios extends Model
{
    protected $table = 'web_content_testimonios';
    protected $guarded = [];

    public function getImageStore($image){
        if(!$image){
            return \Storage::disk('public')->url('assets/no-image.png');
        }
        return \Storage::disk('public')->url($image);
    }
}
