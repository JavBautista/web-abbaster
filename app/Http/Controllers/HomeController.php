<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['user', 'admin', 'vendedor']);   
        
        if($request->user()->hasRole('admin')){
           
            $shops = Shop::where('status',0)->get();
            foreach ($shops as $shop) {                 
                $num_questions=0;
                $categories=Category::where('shop_id',$shop->id)->get();
                foreach ($categories as $category) {
                    foreach($category->products as $product){
                        foreach($product->questions as $question){
                            if(!$question->status) $num_questions++;
                        }
                    }
                }
                $notification_questions[$shop->id]=$num_questions;
            }

            return view('admin.index',[
                'shops'=>$shops,
                'notification_questions'=>$notification_questions,
            ]);
        }else if ($request->user()->hasRole('user')){
            return redirect('customer/');
        }else if ($request->user()->hasRole('vendedor')){
            return view('admin_seller.index');
        }//.if-else
    }
}
