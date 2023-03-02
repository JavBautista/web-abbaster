<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
	protected $guarded=[];

    public function questions(){
        return $this->hasMany(ProductQuestions::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function inventoryProduct(){
    	return $this->hasMany(InventoryProduct::class);
    }

    public function proveedor(){
    	return $this->belongsTo(Proveedor::class);
    }

    public function images(){
        return $this->hasMany(ImagesProduct::class);
    }

    public function getImageAttribute($image){
    	if( !$image || starts_with($image,'http')){
    		return \Storage::disk('public')->url('assets/no-image.png');
    	}
    	return \Storage::disk('public')->url($image);
    }

    public function getShortNameAttribute($name)
    {
        return Str::limit($name, 50, '...');
    }

    public function scopeEstatus($query, $filtro_status) {
        if($filtro_status=='activos'){
            return $query->where('status',0);
        }else if($filtro_status=='bajas'){
            return $query->where('status',1);
        }
    }

    public function scopeBuscartexto($query, $buscar, $criterio) {
        if($buscar!=''){
            return $query->where($criterio,'like','%'.$buscar.'%');
        }
    }
}
