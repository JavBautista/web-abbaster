<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCourse extends Model
{
    Protected $guarded=[];
    public    $timestamps=false;

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
