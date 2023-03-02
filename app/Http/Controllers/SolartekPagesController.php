<?php

namespace App\Http\Controllers;


use App\Category;
use App\Product;
use App\Shipping;
use App\DownloadDocument;
use App\WebContentAboutUs;
use App\WebContentServices;
use App\WebContentImagesCarousel;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class SolartekPagesController extends Controller
{
    private const TIENDA_ID=3;
    private const TIENDA_NAME='solartekmexico';
    private const TIENDA_DIR='solartek';

    private function getImagesAndContentWebHtml($page){
        #Dependdiendo la pagina bsucaremos en un modelo u otro
        switch ($page) {
            case 'about':
                $content=WebContentAboutUs::where('shop_id',self::TIENDA_ID)->first();
                break;
            case 'services':
                $content=WebContentServices::where('shop_id',self::TIENDA_ID)->first();
                break;
            default:
                return '';
                break;
        }
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
        return $content_html;
    }

    public function index(){
    	$carousel = WebContentImagesCarousel::where('shop_id', self::TIENDA_ID)->get();
        return view(self::TIENDA_DIR.'.index',[
            'carousel'=>$carousel,
        ]);
    }

    public function store(){
    	$categories=Category::where('shop_id',self::TIENDA_ID)->orderBy('order_by', 'asc')->get();
    	return view(self::TIENDA_DIR.'.store',[
    		'categories'=>$categories,
    	]);
    }



    public function about(){
        $content_html = $this->getImagesAndContentWebHtml('about');
        return view(self::TIENDA_DIR.'.about',[
            'content_html'=>$content_html,
        ]);
    }

    public function services(){
        $content_html = $this->getImagesAndContentWebHtml('services');
        return view(self::TIENDA_DIR.'.services',[
            'content_html'=>$content_html,
        ]);
    }

    public function support(){
        return view(self::TIENDA_DIR.'.support');
    }

    public function descargas(){
        $documents = DownloadDocument::where([
            ['shop_id','=',self::TIENDA_ID],
            ['status','=',0],
        ])->get();
        return view(self::TIENDA_DIR.'.descargas',[
            'documents'=>$documents,
        ]);
    }

    public function category($category_id){
        $category=Category::find($category_id);
        $products=Product::where('category_id',$category_id)->where('status','0')->orderBy('order_by', 'asc')->paginate(9);
        return view(self::TIENDA_DIR.'.category',[
            'category'=>$category,
            'products'=>$products,
        ]);
    }

    public function categorySlug($slug){
        $category=Category::where('slug',$slug)->firstOrFail();
        $products=Product::where('category_id',$category->id)->where('status','0')->orderBy('order_by', 'asc')->paginate(9);
        return view(self::TIENDA_DIR.'.category',[
            'category'=>$category,
            'products'=>$products,
        ]);
    }

    public function product($category_id,$product_id){
        $category=Category::find($category_id);
        $product=Product::find($product_id);
        $config_shipping=Shipping::find($product->category->shop_id);
        $inventories=$product->inventoryProduct;
        $stock_exhibition=0;

        //Articulos que se peuden comprar a travez de la web
        //default 25
        $sales_limit_web = $product->sales_limit_web;

        $_tmp=0;
        foreach($inventories as $inventory) $_tmp += $inventory->exhibition;

        $stock_exhibition=($_tmp >= $sales_limit_web)?$sales_limit_web:$_tmp;
        $suggested_products = Product::where('category_id',$category->id)
                                        ->where('status','0')
                                        ->limit(10)
                                        ->get();

    	return view(self::TIENDA_DIR.'.product',[
            'category'=>$category,
            'product'=>$product,
            'stock_exhibition'=>$stock_exhibition,
            'config_shipping'=>$config_shipping,
            'suggested_products'=>$suggested_products,
        ]);
    }

    public function productSlug($slug){

        $product=Product::where('slug',$slug)->firstOrFail();

        $category=Category::find($product->category_id);

        $config_shipping=Shipping::find($product->category->shop_id);
        $inventories=$product->inventoryProduct;
        $stock_exhibition=0;

        //Articulos que se peuden comprar a travez de la web
        //default 25
        $sales_limit_web = $product->sales_limit_web;

        $_tmp=0;
        foreach($inventories as $inventory) $_tmp += $inventory->exhibition;

        $stock_exhibition=($_tmp >= $sales_limit_web)?$sales_limit_web:$_tmp;
        $suggested_products = Product::where('category_id',$category->id)
                                        ->where('status','0')
                                        ->limit(10)
                                        ->get();

        return view(self::TIENDA_DIR.'.product',[
            'category'=>$category,
            'product'=>$product,
            'stock_exhibition'=>$stock_exhibition,
            'config_shipping'=>$config_shipping,
            'suggested_products'=>$suggested_products,
        ]);
    }

    public function shoppingCart(){
        return view(self::TIENDA_DIR.'.shopping_cart');
    }

    public function search(SearchRequest $request){
        $query = $request->input('query');
        $count_products=0;
        $products = Product::where('name','LIKE',"%$query%")->orwhere('key','LIKE',"%$query%")->orwhere('keywords','LIKE',"%$query%")->get();
        //$count_products=$products->count();
        $count_products=0;
        foreach($products as $product)
            if($product->category->shop->id == self::TIENDA_ID) $count_products++;
        return view(self::TIENDA_DIR.'.results_search',[
            'query'=>$query,
            'count_products'=>$count_products,
            'products'=>$products,
        ]);
    }

    public function downloadFile($id){
        $document = DownloadDocument::findOrFail($id);
        $file = $document->file;
        $exists = Storage::disk('public')->exists($file);
        if($exists){
            return Storage::disk('public')->download($file);
        }
        Session::flash('alert', 'El documento solictado no existe. Consulte al administrador del sistema.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/".self::TIENDA_NAME."/descargas");

    }
}
