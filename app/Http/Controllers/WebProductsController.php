<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductQuestions;
class WebProductsController extends Controller
{
    public function getComentarios(Request $request){

    	$comentarios = ProductQuestions::with('answers')->where('product_id',$request->product_id)
    		->orderBy('id','desc')
    		->get();
    	return $comentarios;
    }

    public function storeComentario(Request $request){
    	if(!$request->ajax()) return redirect('/');
    	$question = ProductQuestions::create([
            'product_id'=> $request->product_id,
            'question'=> $request->comentario,
            'status'=> 0,
        ]);

    }
 }
