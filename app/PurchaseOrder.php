<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $guarded=[];

    public function PurchaseOrderDetail(){
        return $this->hasMany(PurchaseOrderDetail::class);
    }
}
