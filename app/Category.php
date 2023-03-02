<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
	protected $guarded=[];
	
    public function shop(){
    	return $this->belongsTo(Shop::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getImageAttribute($image){
    	if( !$image || starts_with($image,'http')){
    		//return $image;
            return \Storage::disk('public')->url('assets/no-image.png');
            
    	}
    	return \Storage::disk('public')->url($image);
    }
}
