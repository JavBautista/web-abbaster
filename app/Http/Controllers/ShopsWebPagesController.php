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
use App\DownloadDocument;
use App\WebContentAboutUs;
use App\WebContentServices;
use App\WebContentImagesCarousel;
use App\WebContentSeccionCarousel;

use App\WebContentDestacados;
use App\WebContentNuevos;
use App\WebContentLandingTiendaSecciones;

class ShopsWebPagesController extends Controller
{
    private function getImagesAndContentWebHtml($page,$shop_id){
        #Dependdiendo la pagina bsucaremos en un modelo u otro
        switch ($page) {
            case 'about':
                $content=WebContentAboutUs::where('shop_id',$shop_id)->first();
                break;
            case 'services':
                $content=WebContentServices::where('shop_id',$shop_id)->first();
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
    }//getImagesAndContentWebHtml

    public function index($shop_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();


        $destacados = WebContentDestacados::where('shop_id',$shop->id)->first();
        $nuevos = WebContentNuevos::where('shop_id',$shop->id)->first();

        $seccion_carousel = WebContentSeccionCarousel::where('shop_id',$shop->id)->first();
        $carousel = WebContentImagesCarousel::where('shop_id', $shop->id)->orderBy('order','asc')->get();

        $categorias = Category::where('shop_id', $shop->id)->get();

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

        return view('shops.index',[
            'seccion_carousel'=>$seccion_carousel,
            'shop'=>$shop,
            'carousel'=>$carousel,
            'products'=>$products,
            'products_featured'=>$products_featured,
            'destacados'=>$destacados,
            'nuevos'=>$nuevos,

        ]);
    }//index

    public function store($shop_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $categories=Category::where('shop_id',$shop->id)->orderBy('order_by', 'asc')->get();
        return view('shops.store',['categories'=>$categories,'shop'=>$shop]);
    }//store

    public function about($shop_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $content_html = $this->getImagesAndContentWebHtml('about',$shop->id);
        return view('shops.about',['content_html'=>$content_html,'shop'=>$shop]);
    }//about

    public function services($shop_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $content_html = $this->getImagesAndContentWebHtml('services',$shop->id);
        return view('shops.services',['content_html'=>$content_html,'shop'=>$shop]);
    }//services

    public function downloads($shop_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $documents = DownloadDocument::where([
            ['shop_id','=',$shop->id],
            ['status','=',0],
        ])->get();
        return view('shops.downloads',['documents'=>$documents,'shop'=>$shop]);
    }//downloads

    public function category($shop_slug, $category_id){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $category=Category::find($category_id);
        $products=Product::where('category_id',$category_id)->where('status','0')->orderBy('order_by', 'asc')->paginate(9);
        return view('shops.category',[
            'category'=>$category,
            'products'=>$products,
            'shop'=>$shop,
        ]);
    }//category

     public function categorySlug($shop_slug, $category_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $category=Category::where('slug',$category_slug)->firstOrFail();
        $products=Product::where('category_id',$category->id)->where('status','0')->orderBy('order_by', 'asc')->paginate(9);
        return view('shops.category',[
            'category'=>$category,
            'products'=>$products,
            'shop'=>$shop,
        ]);
    }//categorySlug

    public function product($shop_slug, $product_id){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $product=Product::find($product_id);
        $config_shipping=Shipping::find($product->category->shop_id);
        $inventories=$product->inventoryProduct;
        $stock_exhibition=0;
        //Articulos que se peuden comprar a travez de la web
        $sales_limit_web = $product->sales_limit_web;
        $_tmp=0;
        foreach($inventories as $inventory) $_tmp += $inventory->exhibition;
        $stock_exhibition=($_tmp >= $sales_limit_web)?$sales_limit_web:$_tmp;
        $suggested_products = Product::where('category_id',$product->category_id)
                                        ->where('status','0')
                                        ->limit(10)
                                        ->get();
        return view('shops.product',[
            'product'=>$product,
            'stock_exhibition'=>$stock_exhibition,
            'config_shipping'=>$config_shipping,
            'shop'=>$shop,
            'suggested_products'=>$suggested_products,
        ]);

    }//product
    public function productSlug($shop_slug, $product_slug){
        $shop=Shop::where('slug',$shop_slug)->firstOrFail();
        $product=Product::where('slug',$product_slug)->firstOrFail();
        $config_shipping=Shipping::find($product->category->shop_id);
        $inventories=$product->inventoryProduct;
        $stock_exhibition=0;
        $sales_limit_web = $product->sales_limit_web;
        $_tmp=0;
        foreach($inventories as $inventory) $_tmp += $inventory->exhibition;
        $stock_exhibition=($_tmp >= $sales_limit_web)?$sales_limit_web:$_tmp;
        $suggested_products = Product::where('category_id',$product->category_id)
                                        ->where('status','0')
                                        ->limit(10)
                                        ->get();
        return view('shops.product',[
            'product'=>$product,
            'stock_exhibition'=>$stock_exhibition,
            'config_shipping'=>$config_shipping,
            'shop'=>$shop,
            'suggested_products'=>$suggested_products,
        ]);
    }//productSlug

}
