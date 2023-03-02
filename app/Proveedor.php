<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    protected $table = 'proveedores';

    protected $guarded = [];

    public function getImageAttribute($image){
    	if( !$image || starts_with($image,'http')){
    		//return $image;
    		return \Storage::disk('public')->url('assets/no-image.png');      		
    	}
    	return \Storage::disk('public')->url($image);
    }
}
