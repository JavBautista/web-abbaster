<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductQuestions extends Model
{
    protected $guarded=[];

    public function answers(){
        return $this->hasMany(ProductQuestionsAnswers::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
