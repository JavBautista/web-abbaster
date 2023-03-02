<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded=[];

    public function Customer(){
    	return $this->belongsTo(Customer::class);
    }

    public function Shop(){
    	return $this->belongsTo(Shop::class);
    }

    public function PurchaseDetail(){
        return $this->hasMany(PurchaseDetail::class);
    }
}
