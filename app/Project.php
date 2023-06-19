<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Importación de Storage

class Project extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function images(){
        return $this->hasMany(ImageProject::class);
    }

    public function getImageAttribute($image){
    	if( !$image || starts_with($image,'http')){
    		return Storage::url('assets/no-image.png');
    	}
    	return Storage::url($image);
        //return $image;
    }

    public function getImageFileNameAttribute($image)
    {
        return pathinfo($this->image, PATHINFO_BASENAME);
    }

}
