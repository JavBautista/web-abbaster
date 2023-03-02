<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    Protected $guarded=[];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
