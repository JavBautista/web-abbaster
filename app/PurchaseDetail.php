<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table='purchases_detail';
    protected $guarded=[];

    public function product(){
    	return $this->belongsTo(Product::class);
    }

}
