<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Category;
use App\Http\Requests\CreateShopRequest;

class ShopsController extends Controller
{

    public function index($id){
    	$shop=Shop::find($id);    

        $categories=Category::where('shop_id',$shop->id)->get();
        $questions=[];
        foreach ($categories as $category) {
            foreach($category->products as $product){
                foreach($product->questions as $question){
                    if(!$question->status)
                        $questions[]=$question;
                } 
            }
        }

        $notification_questions = count($questions);	
    	return view('admin.shop.index',[
    		'shop'=>$shop,
            'notification_questions'=>$notification_questions,
    	]);    	
    }

    public function add(){
    	return view('admin.shop.add');
    }

    public function create(CreateShopRequest $request){
    	$shop = Shop::create([
    		'name'=>$request->input('name'),
    		'description'=>$request->input('description'),
    		'status'=>$request->input('status'),
            'dynamic'=>$request->input('dynamic'),
    		'image'=>'https://lorempixel.com/600/338/?'.mt_rand(0,1000),
    	]);

    	return redirect('/dashboard');
    }
}
