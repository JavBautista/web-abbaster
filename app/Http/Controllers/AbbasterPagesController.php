<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GlobalWebCarousel;
use App\Http\Requests\SearchRequest;
use App\Shop;
use App\Product;
use App\Category;
use App\Purchase;
use App\WebSection;
use App\WebContentTestimonios;
use App\WebContentDestacados;
use App\WebContentSeccionLogosTiendas;
use App\WebContentSeccionAccesoTiendas;
use App\WebContentSeccionMetodosPagos;
use App\WebContentSeccionCarousel;
use App\WebContentSeccionTestimonios;
use App\WebContentSeccionCrece;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Cart;

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
            'seccion_crece'=>$seccion_crece,


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
        $products = Product::where('name','LIKE',"%$query%")
                    ->orwhere('key','LIKE',"%$query%")
                    ->orwhere('keywords','LIKE',"%$query%")
                    ->orderBy('name','desc')
                    ->get();
        $count_products=$products?$products->count():0;
        return view('search',[
            'query'=>$query,
            'count_products'=>$count_products,
            'products'=>$products,
            'shops'=>$shops,

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

    public function payment(){
        $shops   = Shop::where('status',0)->get();
        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
        $purchase = Purchase::with('Customer')
        	->with('PurchaseDetail')
            ->where('id',$purchase_id)->firstOrFail();
        //dd($purchase);
        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
        if($purchase_id){
            return view('payment',['shops'=>$shops, 'purchase'=>$purchase]);
        }else{
            return redirect('/shopping-cart');
        }


    }

    public function selectCurrency(Request $request){
        Session::put('currency',$request->currency);
        return back();
    }
}