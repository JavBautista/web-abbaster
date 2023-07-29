<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Shop;
use App\Category;
use App\Product;
use App\Shipping;
use App\Service;
use App\DownloadDocument;
use App\WebContentAboutUs;
use App\WebContentServices;
use App\WebContentImagesCarousel;

class EudermPagesController extends Controller
{
    private const TIENDA_ID=7;
    private const TIENDA_NAME='euderm';
    private const TIENDA_DIR='euderm';

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
        $shop=Shop::find(self::TIENDA_ID);
        $carousel = WebContentImagesCarousel::where('shop_id', self::TIENDA_ID)->orderBy('order','asc')->get();

        $categorias = Category::where('shop_id', self::TIENDA_ID)->get();

        $products=[];
        $products_featured=[];

        foreach ($categorias as $categoria) {
            $producto = Product::where('category_id', $categoria->id)->orderBy('id','desc')->first();
            if($producto) $products[]=$producto;

            $producto_featured = Product::where([
                ['category_id', $categoria->id],
                ['featured', 1],
            ])->orderBy('id','desc')->get();

            foreach($producto_featured as $featured){

                $products_featured[]=$featured;
            }
        }

        return view(self::TIENDA_DIR.'.index',[
            'carousel'=>$carousel,
            'products'=>$products,
            'products_featured'=>$products_featured,
            'shop'=>$shop,
        ]);
    }

    public function store(){
        $shop=Shop::find(self::TIENDA_ID);
        $categories=Category::where('shop_id',self::TIENDA_ID)->orderBy('order_by', 'asc')->get();
        return view(self::TIENDA_DIR.'.store',[
            'categories'=>$categories,
            'shop'=>$shop,
        ]);
    }

    public function category($category_id){
        $shop=Shop::find(self::TIENDA_ID);
        $category=Category::find($category_id);
        $products=Product::where('category_id',$category_id)->where('status','0')->orderBy('order_by', 'asc')->paginate(9);
        return view(self::TIENDA_DIR.'.category',[
            'category'=>$category,
            'products'=>$products,
            'shop'=>$shop,
        ]);
    }

     public function categorySlug($slug){
        $shop=Shop::find(self::TIENDA_ID);
        $category=Category::where('slug',$slug)->firstOrFail();
        $products=Product::where('category_id',$category->id)->where('status','0')->orderBy('order_by', 'asc')->paginate(9);
        return view(self::TIENDA_DIR.'.category',[
            'category'=>$category,
            'products'=>$products,
            'shop'=>$shop,
        ]);
    }

    public function product($category_id,$product_id){
        $shop=Shop::find(self::TIENDA_ID);
        $category=Category::find($category_id);
        $product=Product::find($product_id);
        $config_shipping=Shipping::find($product->category->shop_id);
        $inventories=$product->inventoryProduct;
        $stock_exhibition=0;

        //Articulos que se peuden comprar a travez de la web

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
            'shop'=>$shop,
            'suggested_products'=>$suggested_products,
        ]);
    }

    public function productSlug($slug){
        $shop=Shop::find(self::TIENDA_ID);
        $product=Product::where('slug',$slug)->firstOrFail();

        $category=Category::find($product->category_id);

        $config_shipping=Shipping::find($product->category->shop_id);
        $inventories=$product->inventoryProduct;
        $stock_exhibition=0;

        //Articulos que se peuden comprar a travez de la web

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
            'shop'=>$shop,
            'suggested_products'=>$suggested_products,
        ]);
    }

    public function about(){
        $shop=Shop::find(self::TIENDA_ID);
       $content_html = $this->getImagesAndContentWebHtml('about');
        return view(self::TIENDA_DIR.'.about',[
            'content_html'=>$content_html,
            'shop'=>$shop,
        ]);
    }

    public function services(){
        $shop=Shop::find(self::TIENDA_ID);
        $content_html = $this->getImagesAndContentWebHtml('services');
        $services = Service::where('shop_id',$shop->id)->paginate(20);
        return view(self::TIENDA_DIR.'.services',[
            'content_html'=>$content_html,
            'shop'=>$shop,
            'services'=>$services,
        ]);
    }

    public function support(){
        $shop=Shop::find(self::TIENDA_ID);
        return view(self::TIENDA_DIR.'.support'.['shop'=>$shop]);
    }

    public function descargas(){
        $shop=Shop::find(self::TIENDA_ID);
        $documents = DownloadDocument::where([
            ['shop_id','=',self::TIENDA_ID],
            ['status','=',0],
        ])->get();
        return view(self::TIENDA_DIR.'.descargas',[
            'documents'=>$documents,
            'shop'=>$shop,
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

    public function search(SearchRequest $request){
        $shop=Shop::find(self::TIENDA_ID);
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
            'shop'=>$shop,
        ]);
    }

    public function service(Request $request){

        $shop=Shop::find(self::TIENDA_ID);
        $slug = $request->slug;
        $service = Service::where('slug',$slug)->first();

        $url_video=null;
        if($service->url_video){
            $url_video = Storage::disk('s3')->url($service->url_video);
        }

        return view(self::TIENDA_DIR.'.service',[
            'service'=>$service,
            'shop'=>$shop,
            'url_video'=>$url_video
        ]);
    }
}
