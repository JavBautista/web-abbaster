<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    Protected $guarded=[];

    public function videos(){
        return $this->hasMany(CourseVideo::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
