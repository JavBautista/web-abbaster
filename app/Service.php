<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Importación de Storage
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;
    Protected $guarded=[];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function images(){
        return $this->hasMany(ServiceImage::class);
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

    public function getShortNameAttribute($name)
    {
        return Str::limit($name, 50, '...');
    }

}
