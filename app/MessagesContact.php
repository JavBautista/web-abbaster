<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagesContact extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
