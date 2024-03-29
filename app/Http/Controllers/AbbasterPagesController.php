<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GlobalWebCarousel;
use App\Http\Requests\SearchRequest;
use App\Shop;
use App\Product;
use App\Category;
use App\Purchase;
use App\Project;
use App\WebSection;
use App\WebContentTestimonios;
use App\WebContentDestacados;
use App\WebContentSeccionLogosTiendas;
use App\WebContentSeccionAccesoTiendas;
use App\WebContentSeccionMetodosPagos;
use App\WebContentSeccionCarousel;
use App\WebContentSeccionTestimonios;
use App\WebContentSeccionCrece;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Shipping;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class AbbasterPagesController extends Controller
{

    public function index(){
        $testimonios = WebContentTestimonios::where('activo',1)->get();
        $destacados = WebContentDestacados::where('shop_id',0)->first();
        $logos_tiendas = WebContentSeccionLogosTiendas::where('shop_id',0)->first();
        $acceso_tiendas = WebContentSeccionAccesoTiendas::where('shop_id',0)->first();
        $metodos_pagos = WebContentSeccionMetodosPagos::where('shop_id',0)->first();
        $seccion_carousel = WebContentSeccionCarousel::where('shop_id',0)->first();
        $seccion_testimonios = WebContentSeccionTestimonios::where('shop_id',0)->first();
        $seccion_crece = WebContentSeccionCrece::where('shop_id',0)->first();


        $shops   = Shop::where('status',0)->get();

        //Esto es solo para los logos de las tiendas a mmostrar
        $tmp = $logos_tiendas->shops;
        $temp2 = explode(",",$tmp);
        $tdas_logos=[];
        foreach($temp2 as $data){
            $tdas_logos[$data]=$data;
        }

        //Esto es solo para los accesos de las tiendas a mmostrar
        $tmp = $acceso_tiendas->shops;
        $temp2 = explode(",",$tmp);
        $tdas_accesos=[];
        foreach($temp2 as $data){
            $tdas_accesos[$data]=$data;
        }

        //$products_featured=[];
        $content = WebSection::where('description','crece')->first();
        #Verficamos si existe un contenido HTML
        $content_html = $content?$content->content:'';
        if($content){
            $dom = new \domdocument();
            $dom->loadHtml('<?xml encoding="UTF-8">'.$content_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getelementsbytagname('img');
            foreach($images as $k => $img){
                $data = $img->getattribute('src');

                $url_img=Storage::disk('public')->url('web_content/'.$data);
                $img->removeattribute('src');
                $img->setattribute('src', $url_img);
            }
            $content_html = $dom->savehtml();
        }
        $section_crece=$content_html;

        $limit_products_featured=3;
        if($destacados && $destacados->num_items>0)
            $limit_products_featured = $destacados->num_items;
        $products_featured = Product::where('destacado_gral', 1)->limit($limit_products_featured)->orderBy('destacado_gral_order','asc')->get();

    	$carousel = GlobalWebCarousel::orderBy('order','asc')->get();


        return view('welcome',[
    		'carousel'=>$carousel,
            'products_featured'=>$products_featured,
            'section_crece'=>$section_crece,
            'testimonios'=>$testimonios,
            'destacados'=>$destacados,
            'logos_tiendas'=>$logos_tiendas,
            'acceso_tiendas'=>$acceso_tiendas,
            'metodos_pagos'=>$metodos_pagos,
            'shops'=>$shops,
            'tdas_logos'=>$tdas_logos,
            'tdas_accesos'=>$tdas_accesos,
            'seccion_carousel'=>$seccion_carousel,
            'seccion_testimonios'=>$seccion_testimonios,
            'seccion_crece'=>$seccion_crece

    	]);
    }

    public function terminosyCondiciones(){
        $shops   = Shop::where('status',0)->get();
    	return view('terminos_condiciones',['shops'=>$shops]);
    }

	public function politicaDePrivacidad(){
        $shops   = Shop::where('status',0)->get();
		return view('politica_privacidad',['shops'=>$shops]);
	}

	public function access(){
        $shops   = Shop::where('status',0)->get();
		return view('access',['shops'=>$shops]);
	}
    public function ecommerce(){
        $shops   = Shop::where('status',0)->get();
        return view('ecommerce',['shops'=>$shops]);
    }

    public function crece(){
        $shops   = Shop::where('status',0)->get();
        return view('crece',['shops'=>$shops]);
    }
    public function proyectos(){
        $shops   = Shop::where('status',0)->get();
        $projects = Project::where('active',1)->get();
        
        return view('proyectos',['shops'=>$shops, 'projects'=>$projects]);
    }
    
    public function proyecto($slug){
        $shops   = Shop::where('status',0)->get();
        $project = Project::where('slug',$slug)->first();
        //dd($project);
        $url_video=null;
        if($project->url_video){
            $url_video = Storage::disk('s3')->url($project->url_video);
        }
        return view('proyecto_detalle',['shops'=>$shops, 'project'=>$project,'url_video'=>$url_video]);
    }

    public function comoComprar(){
        $shops   = Shop::where('status',0)->get();
        //ID 2: Seccion Como comprar
        $content = WebSection::findOrfail(2);
        #Verficamos si existe un contenido HTML
        $content_html = $content?$content->content:'';
        if($content){
            $dom = new \domdocument();
            $dom->loadHtml('<?xml encoding="UTF-8">'.$content_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getelementsbytagname('img');
            foreach($images as $k => $img){
                $data = $img->getattribute('src');

                $url_img=Storage::disk('public')->url('web_content/'.$data);
                $img->removeattribute('src');
                $img->setattribute('src', $url_img);
            }
            $content_html = $dom->savehtml();
        }
        $content_html;
        return view('como_comprar',['content_html'=>$content_html,'shops'=>$shops]);
    }

    public function search(SearchRequest $request){
        $shops   = Shop::where('status',0)->get();
        $query = $request->input('query');
        $products = Product::query();
        $keywords = explode(' ', $query);
        foreach ($keywords as $keyword) {
            $products->where(function ($queryBuilder) use ($keyword) {
                $queryBuilder->orWhere('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('keywords', 'LIKE', '%' . $keyword . '%');
            });
        }
        $products = $products->orderBy('name', 'desc')->get();
        $count_products=$products?$products->count():0;
        return view('search',[
            'query'=>$query,
            'count_products'=>$count_products,
            'products'=>$products,
            'shops'=>$shops
        ]);
    }

    public function searchAdvance(SearchRequest $request){

        $exactMatch='';
        $selectedCategory=null;
        $selectedShop=null;


        $shops   = Shop::where('status',0)->get();
        $query = $request->input('query');

        // Verificar si se enviaron variables adicionales desde el formulario avanzado
        if ($request->has('shop')) {
            $selectedShop = $request->input('shop');
        }

        if ($request->has('category')) {
            $selectedCategory = $request->input('category');
        }

        if ($request->has('exact_match')) {
            $exactMatch = $request->input('exact_match');
        }

         $categorias = Category::orderBy('name', 'asc');
        // Filtrar categorías por tienda si se ha seleccionado una tienda
        if ($selectedShop) {
            $categorias->where('shop_id', $selectedShop);
        }

        $categorias = $categorias->get();

        $products = Product::query();

        if ($exactMatch) {
            $products->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', '%'.$query.'%')
                    ->orWhere('keywords', 'LIKE', '%'.$query.'%');
            });
        } else {
            $keywords = explode(' ', $query);

            foreach ($keywords as $keyword) {
                $products->where(function ($queryBuilder) use ($keyword) {
                    $queryBuilder->orWhere('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('keywords', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        if ($selectedCategory) {
            $products->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('id', $selectedCategory);
            });
        }

        if ($selectedShop) {
            $products->whereHas('category.shop', function ($query) use ($selectedShop) {
                $query->where('id', $selectedShop);
            });
        }

        $products = $products->orderBy('name', 'desc')->get();

        $count_products=$products?$products->count():0;

        return view('search',[
            'query'=>$query,
            'count_products'=>$count_products,
            'products'=>$products,
            'shops'=>$shops,
            'categorias'=>$categorias,
            'exactMatch'=>$exactMatch,
            'selectedCategory'=>$selectedCategory,
            'selectedShop'=>$selectedShop,
        ]);
    }


    public function shoppingCart(){
        $shops   = Shop::where('status',0)->get();
        $cart = Cart::content();
        $count_cart = Cart::count();
        if($count_cart){
            return view('shopping_cart',['shops'=>$shops]);
        } else {
            return redirect('/');
        }

    }

    public function confirmPayment(){
        $shops   = Shop::where('status',0)->get();
        $purchase_id=0;
        if(Session::has('purchase_id')){
            $purchase_id=Session::get('purchase_id');
        }

        return view('confirm_payment',['shops'=>$shops]);
        /*if(!$purchase_id){
            return view('confirm_payment',['shops'=>$shops]);
        }else{
            return redirect('/payment');
        }*/
    }

    public function payment(Request $request){
        //dd($request);
        $shops   = Shop::where('status',0)->get();

        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
        $purchase = Purchase::with('Customer')
        	->with('PurchaseDetail')
            ->where('id',$purchase_id)->firstOrFail();
        
        $cart = Cart::content();
		$subtotal= str_replace(",","",Cart::subtotal());
		$tax=  str_replace(",","",Cart::tax());
		$total= str_replace(",","", Cart::total() );
        
        $shop_id=1;
        $config_shipping=Shipping::find($shop_id);
		//Como el Shippping no viene dentro del carro de compras
		//Se lo sumamos manualmente al total
		$shipping=($total<$config_shipping->shipping_from)?$config_shipping->shipping_cost:0;

        
        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
        if($purchase_id){
            return view('payment',['shops'=>$shops, 'purchase'=>$purchase,'shipping'=>$shipping]);
        }else{
            return redirect('/shopping-cart');
        }


    }

    public function selectCurrency(Request $request){
        Session::put('currency',$request->currency);
        return back();
    }

    public function paymentShow(Request $request){
        $shops   = Shop::where('status',0)->get();
        return view('payment_show',[
            'shops'=>$shops,
        ]);
    }

    
    public function pay(Request $request){
        
        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
        
        
        $success=false;
        $payment_id = $request->get('payment_id');
        
        $accessToken = config('services.mercadopago.token');
        //dump($accessToken);
        //dump("https://api.mercadopago.com/v1/payments/$payment_id"."?access_token=$accessToken");
        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id"."?access_token=$accessToken");
        $response = json_decode($response);
        
        //dump($response);
        $status = $response->status;
        //dd($status);
        
        //dd($purchase_id);
        if($purchase_id>0){

            $purchase = Purchase::find($purchase_id);

            $purchase->payment_method ='MercadoPago';
            $purchase->no_transaction =$payment_id;
            
            if($status=='approved' || $status=='pending'){
                if($status=='approved'){
                    $purchase->status =3;            
                }
                if($status=='pending'){
                    $purchase->status =2;            
                }
                Cart::destroy();
                Session::forget('session_discount_code');
                Session::forget('session_type_discount');
                Session::forget('session_discount');
                $success=true;
                
            }
            $purchase->save();
        }//$purchase_id>0
        

       if($success){
            return redirect()->route('payment.success');
        }else{
            return redirect()->route('payment.payment');
        }
        

    }

}
