<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded=[];

    public function Shipping(){
    	return $this->hasOne(Shipping::class);
    }

    public function getImageStore($promotional_banner_image){
    	if( !$promotional_banner_image || starts_with($promotional_banner_image,'http')){
    		return \Storage::disk('public')->url('assets/no-image.png');    		
    	}
    	return \Storage::disk('public')->url($promotional_banner_image);
    }

    public function getLogoStore($logo){
        if( !$logo || starts_with($logo,'http')){
            return \Storage::disk('public')->url('assets/no-image.png');            
        }
        return \Storage::disk('public')->url($logo);
    }

    
}
