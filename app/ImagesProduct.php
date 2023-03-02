<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesProduct extends Model
{
	protected $table = 'images_product';
    protected $guarded=[];

/*
    public function getImageAttribute($image){
    	
    }
*/

    public function getStoreImage($image){
    	
    	if( !$image || starts_with($image,'http')){
    		//return $image;
    		return \Storage::disk('public')->url('assets/no-image.png');      		
    	}
    	return \Storage::disk('public')->url($image);
    }
}
