<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    Protected $guarded=[];

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
