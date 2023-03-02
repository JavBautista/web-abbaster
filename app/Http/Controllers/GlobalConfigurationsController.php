<?php

namespace App\Http\Controllers;

use App\StatusPurchaseOrder;
use App\GlobalWebCarousel;
use App\Shop;
use App\DollarPrice;
use App\Product;
use App\WebSection;
use App\DownloadDocument;
use App\WebContentTestimonios;
use App\WebContentDestacados;
use App\WebContentSeccionMetodosPagos;
use App\WebContentSeccionLogosTiendas;
use App\WebContentSeccionAccesoTiendas;
use App\WebContentSeccionCarousel;
use App\WebContentSeccionTestimonios;
use App\WebContentSeccionCrece;
use App\WebContentBannerLoop;
use App\AbbasterInformation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GlobalConfigurationsController extends Controller
{

	public function index(){

		return view('admin.global_configurations.index');
	}

    public function dollarPrice(){

        return view('admin.global_configurations.dollar_price');
    }

    public function getDataConfigDollar(Request $request){
        if(!$request->ajax()) return redirect('/');
        $price = DollarPrice::take(1)->get();
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $tienda = $request->tienda;
        $shop_id=0;
        switch ($tienda) {
            case 'eagletek': $shop_id=1; break;
            case 'ziot':     $shop_id=2; break;
            case 'solartek': $shop_id=3; break;
            default:         $shop_id=0; break;
        }

        if($buscar==''){
            if($tienda==''){
                $products= Product::join('categories','products.category_id','=','categories.id')
                    ->join('shops','categories.shop_id','=','shops.id')
                    ->select('products.id','products.key','products.name','products.image','products.cost_dollar','products.retail','categories.name as nombre_categoria','shops.name as nombre_shop')
                    ->orderBy('products.cost_dollar','asc')
                    ->paginate(20);
            }else{
                $products= Product::join('categories','products.category_id','=','categories.id')
                    ->join('shops','categories.shop_id','=','shops.id')
                    ->select('products.id','products.key','products.name','products.image','products.cost_dollar','products.retail','categories.name as nombre_categoria','shops.name as nombre_shop')
                    ->where('shops.id',$shop_id)
                    ->orderBy('products.cost_dollar','asc')
                    ->paginate(20);
            }
        }else{
            if($tienda==''){
                $products= Product::join('categories','products.category_id','=','categories.id')
                    ->join('shops','categories.shop_id','=','shops.id')
                    ->select('products.id','products.key','products.name','products.image','products.cost_dollar','products.retail','categories.name as nombre_categoria','shops.name as nombre_shop')
                    ->where('products.'.$criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('products.cost_dollar','asc')
                    ->paginate(20);
            }else{
                $products= Product::join('categories','products.category_id','=','categories.id')
                    ->join('shops','categories.shop_id','=','shops.id')
                    ->select('products.id','products.key','products.name','products.image','products.cost_dollar','products.retail','categories.name as nombre_categoria','shops.name as nombre_shop')
                    ->where('shops.id',$shop_id)
                    ->where('products.'.$criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('products.cost_dollar','asc')
                    ->paginate(20);

            }
        }
        return [
            'pagination'=>[
                'total'=> $products->total(),
                'current_page'=> $products->currentPage(),
                'per_page'=> $products->perPage(),
                'last_page'=> $products->lastPage(),
                'from'=> $products->firstItem(),
                'to'=> $products->lastItem(),
            ],
            'price'=>$price,
            'products'=>$products,
        ];
    }

    public function updateDollarPrice(Request $request){
        if(!$request->ajax()) return redirect('/');
        $dollar = DollarPrice::findOrFail(1);
        $dollar->price= $request->price;
        $dollar->save();
        $dollar_price= $request->price;
        $products = Product::all();
        foreach($products as $product){
            $new_retail = $product->cost_dollar * $dollar_price;
            $articulo = Product::find($product->id);
            $articulo->retail = $new_retail;
            $articulo->save();
        }

    }

    public function updateProductRetail(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::find($request->id);
        $product->retail = $request->new_retail;
        $product->cost_dollar = $request->new_cost_usd;
        $product->save();
    }

    public function updateProductsCostUSD(Request $request){
        $dollar = DollarPrice::find(1);
        $dollar_price= $dollar->price;
        $products = Product::all();
        foreach($products as $product){
            $new_cost_usd = $product->retail / $dollar_price;
            $articulo = Product::find($product->id);
            $articulo->cost_dollar = $new_cost_usd;
            $articulo->save();
        }

    }


    public function statusesPurchaseOrder(){
    	$statuses = StatusPurchaseOrder::all();
    	return view('admin.global_configurations.statuses_po.index',[ 'statuses'=>$statuses]);
    }

    public function statusesPurchaseOrderCreate(){
    	return view('admin.global_configurations.statuses_po.create');
    }

    public function statusesPurchaseOrderStore(Request $request){
    	StatusPurchaseOrder::create([
    		'description'=>$request->input('description'),
    	]);

    	Session::flash('alert', 'Status Creado satisfactoriamente');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/statuses-purchase-order');
    }

    public function webContentIndex(){

        return view('admin.global_configurations.web_content.index');
    }

    public function webContentCarousel(){
        $carousel=GlobalWebCarousel::orderBy('order','asc')->get();

        $seccion = WebContentSeccionCarousel::where('shop_id',0)->first();
         //Validanmos cada ves que se entre a la pagina el orden de los indices de orden
        if($carousel->count()){
            $new_order=0;
            foreach($carousel as $img){
                $new_order++;
                $img->order = $new_order;
                $img->save();
            }//foreach
        }//if count
        return view('admin.global_configurations.web_content.carousel.index',['carousel'=>$carousel,'seccion'=>$seccion]);
    }

    public function webContentTestimonios(){
        $seccion=WebContentSeccionTestimonios::where('shop_id',0)->first();
        return view('admin.global_configurations.web_content.testimonios',['seccion'=>$seccion]);
    }



    public function webContentCrece(){
        $content=WebSection::where('description','crece')->first();
        $seccion =WebContentSeccionCrece::where('shop_id',0)->first();

        $content_id=$content?$content->id:0;
        $content_html = $content?$content->content:'';
        if($content){
            $content_html = $content->content;
            $dom = new \domdocument();
            $dom->loadHtml('<?xml encoding="UTF-8">'.$content_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getelementsbytagname('img');
            //loop over img elements, decode their base64 src and save them to public folder,
            //and then replace base64 src with stored image URL.
            foreach($images as $k => $img){
                $data = $img->getattribute('src');
                $url_img=Storage::disk('public')->url('web_content/'.$data);
                $img->removeattribute('src');
                $img->setattribute('src', $url_img);
            }

            $content_html = $dom->savehtml();
            //dd($content_html);
        }
        return view('admin.global_configurations.web_content.section_crece.index',[
            'content'=>$content,
            'content_id'=>$content_id,
            'content_html'=>$content_html,
            'seccion'=>$seccion,
        ]);
    }

    public function webContentComoComprar(){
        $content=WebSection::findOrFail(2);
        $content_id=$content?$content->id:0;
        $content_html = $content?$content->content:'';
        if($content){
            $content_html = $content->content;
            $dom = new \domdocument();
            $dom->loadHtml('<?xml encoding="UTF-8">'.$content_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getelementsbytagname('img');
            //loop over img elements, decode their base64 src and save them to public folder,
            //and then replace base64 src with stored image URL.
            foreach($images as $k => $img){
                $data = $img->getattribute('src');
                $url_img=Storage::disk('public')->url('web_content/'.$data);
                $img->removeattribute('src');
                $img->setattribute('src', $url_img);
            }

            $content_html = $dom->savehtml();
            //dd($content_html);
        }
        return view('admin.global_configurations.web_content.section_como_comprar.index',[
            'content'=>$content,
            'content_id'=>$content_id,
            'content_html'=>$content_html,
        ]);
    }

    public function updateWebSectionCrece(Request $request){
        $seccion = WebContentSeccionCrece::findOrfail($request->id);
        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->save();

        $content_id = $request->input('content_id');
        $content=$request->content;

        $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="UTF-8">'.$content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');


        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name= time().$k.'.jpg';
            $path = public_path() .'/'. $image_name;

            //file_put_contents($path, $data);
            Storage::disk('public')->put('web_content/'.$image_name, $data);
            //$data->store('web_content','public');

            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
            //$img->setattribute('src', $path);
        }

        $content = $dom->savehtml();

        //dd($content);
        if($content_id){
            //UPDATE
            $web_content = WebSection::find($content_id);

                #BORRAMOS LOS ARCHIVOS DE LAS IMAGENES QUE ESTABAN ALMACENADAS EN EL ANTERIOR CONTENIDO
                $content_html_bd = $web_content?$web_content->content:'';
                if($content_html_bd!=''){
                    $dom_bd = new \domdocument();
                    $dom_bd->loadHtml('<?xml encoding="UTF-8">'.$content_html_bd, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images_bd = $dom_bd->getelementsbytagname('img');
                    //loop over img elements, decode their base64 src and save them to public folder,
                    //and then replace base64 src with stored image URL.
                    foreach($images_bd as $k => $img){
                        $data = $img->getattribute('src');
                        Storage::disk('public')->delete('web_content/'.$data);
                    }
                }

            $web_content->content = $content;
            $web_content->save();
        }else{
            //CREATE
            $web_content = new WebSection;
            $web_content->content = $content;
            $web_content->save();
        }
        Session::flash('alert', 'El contenido fue actualizado correctamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/web-content/crece");
    }

    public function updateWebSectionComoComprar(Request $request){
        $content_id = $request->input('content_id');
        $content=$request->content;

        $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="UTF-8">'.$content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');


        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name= time().$k.'.jpg';
            $path = public_path() .'/'. $image_name;

            //file_put_contents($path, $data);
            Storage::disk('public')->put('web_content/'.$image_name, $data);
            //$data->store('web_content','public');

            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
            //$img->setattribute('src', $path);
        }

        $content = $dom->savehtml();

        //dd($content);
        if($content_id){
            //UPDATE
            $web_content = WebSection::find($content_id);

                #BORRAMOS LOS ARCHIVOS DE LAS IMAGENES QUE ESTABAN ALMACENADAS EN EL ANTERIOR CONTENIDO
                $content_html_bd = $web_content?$web_content->content:'';
                if($content_html_bd!=''){
                    $dom_bd = new \domdocument();
                    $dom_bd->loadHtml('<?xml encoding="UTF-8">'.$content_html_bd, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images_bd = $dom_bd->getelementsbytagname('img');
                    //loop over img elements, decode their base64 src and save them to public folder,
                    //and then replace base64 src with stored image URL.
                    foreach($images_bd as $k => $img){
                        $data = $img->getattribute('src');
                        Storage::disk('public')->delete('web_content/'.$data);
                    }
                }

            $web_content->content = $content;
            $web_content->save();
        }else{
            //CREATE
            $web_content = new WebSection;
            $web_content->content = $content;
            $web_content->save();
        }
        Session::flash('alert', 'El contenido fue actualizado correctamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/web-content/como-comprar");
    }

    public function webContentCarouselAdd(){
        return view('admin.global_configurations.web_content.carousel.add');
    }//webContentCarouselAdd

    public function webContentCarouselEdit($item_id){
        $item = GlobalWebCarousel::find($item_id);
        return view('admin.global_configurations.web_content.carousel.edit',[
            'item'=>$item,
        ]);
    }//webContentCarouselEdit

    public function webContentCarouselRemove($item_id){
        $item = GlobalWebCarousel::find($item_id);
        return view('admin.global_configurations.web_content.carousel.remove',[
            'item'=>$item,
        ]);
    }//webContentCarouselRemove

    public function webContentCarouselStore(Request $request){
        $image = $request->file('image');
        $all_images = GlobalWebCarousel::all();
        $order=$all_images->count();

        $reg = GlobalWebCarousel::create([
            'order'=> $order+1,
            'align'=> $request->input('align'),
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
            'url'=> $request->input('url'),
            'image'=> $image->store('global_web_content','public'),
        ]);
        Session::flash('alert', 'Contenido guardado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/web-content/carousel");
    }//webContentCarouselStore

    public function webContentCarouselUpdate(Request $request){
        $item = GlobalWebCarousel::find($request->input('item_id'));
        if($request->input('action')=='update_content'){
            $item->title = $request->input('title');
            $item->content = $request->input('content');
            $item->align = $request->input('align');
            $item->url = $request->input('url');
            $item->save();
            Session::flash('alert', 'Contenido actualizado exitosamente.');
            Session::flash('alert-class', 'alert-success');
        }else if($request->input('action')=='update_image' && $request->hasFile('image')){
            //borramos el archivo anterior
            $old_image = $item->image;
            $existe = Storage::disk('public')->exists($old_image);
            if($existe) Storage::disk('public')->delete($old_image);
            //guardamos el nuevo
            $item->image = $request->file('image')->store('global_web_content', 'public');
            $item->save();
            Session::flash('alert', 'Iamgen actualizada exitosamente.');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('alert', 'No fue posible alctualizar el contenido. intente nuevamente o consulte al administrador del sistema.');
            Session::flash('alert-class', 'alert-danger');
        }#./if-else
        return redirect("/dashboard/global-configurations/web-content/carousel/edit/".$item->id);
    }//webContentCarouselUpdate


    public function webContentCarouselDelete(Request $request){
        $item = GlobalWebCarousel::find($request->input('item_id'));
        $image = $item->image;
        //Verificamos que exista el archivo de la imagen, si existe lo eliminamos
        if( Storage::disk('public')->exists($image) ) Storage::disk('public')->delete($image);
        $item->delete();
        Session::flash('alert', 'El item fue eliminado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/web-content/carousel");
    }//webContentCarouselDelete

    public function webContentCarouselUpdateOrder(Request $request){
        $img_id = $request->input('img_id');
        $command = $request->input('command');

        $image_update=GlobalWebCarousel::find($img_id);
        $image_orden_actual=$image_update->order;

        $images_all=GlobalWebCarousel::orderBy('order', 'asc')->get();
        $count=$images_all->count();

        if($command=='up'){

            //Si es UP pero el actual es 1 nada que hacer
            if($image_orden_actual!=1){

                //Localizamos la imagen con el num orden antes del que queremos cambiar
                foreach ($images_all as $image) {

                    if($image->order==$image_orden_actual-1){

                        $image->order = $image_orden_actual;
                        $image->save();
                        $image_update->order=$image_orden_actual-1;
                        $image_update->save();
                        break;
                    }
                }
            }

        }else if($command=='down'){
            //Si es DOWN pero el actual es el ultimo nada que hacer
            if($image_orden_actual!=$count){
                //Localizamos la imagen con el num orden despues del que queremos cambiar
                foreach ($images_all as $image) {
                    if($image->order==$image_orden_actual+1){
                        $image->order = $image_orden_actual;
                        $image->save();
                        $image_update->order=$image_orden_actual+1;
                        $image_update->save();
                        break;
                    }
                }
            }
        }//if-else command

        Session::flash('alert', 'Contenido actualizado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/web-content/carousel");
    }//webContentCarouselUpdateOrder


    public function shopsIndex(){
        $shops = Shop::all();
        return view('admin.global_configurations.shops.index',['shops'=>$shops]);
    }

    public function shopsEditStatus($shop_id){
        $shop = Shop::find($shop_id);
        return view('admin.global_configurations.shops.edit_status',['shop'=>$shop]);
    }

    public function shopsEditDatos($shop_id){
        $shop = Shop::find($shop_id);
        return view('admin.global_configurations.shops.edit_datos',['shop'=>$shop]);
    }

    public function shopsEditTipo($shop_id){
        $shop = Shop::find($shop_id);
        return view('admin.global_configurations.shops.edit_tipo',['shop'=>$shop]);
    }

    public function shopUpdateStatus(Request $request){
        $shop = Shop::find($request->input('shop_id'));
        $new_status =$request->input('status');

        $msg = 'El estatus seleccionado es el actual.';
        if( $shop->status != $new_status){
            $shop->status = $new_status;
            $shop->save();
            $msg= 'El Estatus fua actualizado correctamente';
        }

        Session::flash('alert', $msg);
        Session::flash('alert-class', 'alert-success');

        return redirect('/dashboard/global-configurations/shops');


    }

    public function shopUpdateDatos(Request $request){
        $shop = Shop::find($request->input('shop_id'));

        $shop->name =$request->input('name');
        $shop->description =$request->input('description');
        $shop->slug =$request->input('slug');
        $shop->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/shops/$shop->id/edit-datos");


    }//shopUpdateDatos

    public function shopUpdateTipo(Request $request){
        $shop = Shop::find($request->input('shop_id'));

        $shop->dynamic =$request->input('dynamic');

        $shop->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/shops/$shop->id/edit-tipo");


    }//shopUpdateTipo

    public function shopsLogo($shop_id){
        $shop = Shop::find($shop_id);
        return view('admin.global_configurations.shops.logo',['shop'=>$shop]);
    }

     public function shopUploadLogo(Request $request){
        $shop_id = $request->input('shop_id');
        $logo = $request->file('image');
        $shop = Shop::find($shop_id);

        $shop->logo = $logo->store('shop_logos','public');
        $shop->save();

        Session::flash('alert', 'Logo guardado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/shops/$shop_id/logo");
    }

    public function shopDeleteLogo(Request $request){
        $shop_id = $request->input('shop_id');
        $shop = Shop::find($shop_id);
        $file = $shop->logo;
        $exists = Storage::disk('public')->exists($file);
        $shop->logo  = NULL;
        $shop->save();
        if($exists){
            Storage::disk('public')->delete($file);
            Session::flash('alert', 'El logo fue eliminado exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/dashboard/global-configurations/shops/$shop_id/logo");
        }
        Session::flash('alert', 'No se pudo borrar el archivo del servidor, intentelo nuevamente.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/dashboard/global-configurations/shops/$shop_id/logo");
    }

    public function getTestimonios(Request $request){
        if(!$request->ajax()) return redirect('/');
        /*$buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $testimonios = WebContentTestimonios::orderBy('id','desc')->paginate(3);
        }else{
            $testimonios = WebContentTestimonios::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }*/

        $testimonios = WebContentTestimonios::orderBy('activo','desc')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $testimonios->total(),
                'current_page'=> $testimonios->currentPage(),
                'per_page'=> $testimonios->perPage(),
                'last_page'=> $testimonios->lastPage(),
                'from'=> $testimonios->firstItem(),
                'to'=> $testimonios->lastItem(),
            ],
            'testimonios'=>$testimonios
        ];
    }

    public function storeTestimonio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $testimonio = new WebContentTestimonios;
        $testimonio->description = $request->description;
        $testimonio->autor = $request->autor;
        $testimonio->job = $request->job;
        $testimonio->title = $request->title;
        $testimonio->web = $request->web;
        $testimonio->contact = $request->contact;
        $testimonio->city = $request->city;
        $testimonio->activo = $request->activo;
        $testimonio->save();
    }

    public function updateTestimonio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $testimonio = WebContentTestimonios::findOrFail($request->id);
        $testimonio->description = $request->description;
        $testimonio->autor = $request->autor;
        $testimonio->job = $request->job;
        $testimonio->title = $request->title;
        $testimonio->web = $request->web;
        $testimonio->contact = $request->contact;
        $testimonio->city = $request->city;
        $testimonio->activo = $request->activo;
        $testimonio->save();
    }

    public function activarTestimonio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $testimonio = WebContentTestimonios::findOrFail($request->id);
        $testimonio->activo = 1;
        $testimonio->save();
    }
    public function desactivarTestimonio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $testimonio = WebContentTestimonios::findOrFail($request->id);
        $testimonio->activo = 0;
        $testimonio->save();
    }


    public function webContentTestimoniosEditImage($testimonio_id)
    {
        $testimonio = WebContentTestimonios::findOrFail($testimonio_id);
        return view('admin.global_configurations.web_content.testimonios_edit_img',['testimonio'=>$testimonio]);
    }



    public function uploadImageTestimonio(Request $request)
    {
        $testimonio_id = $request->input('testimonio_id');
        $image = $request->file('image');
        $testimonio = WebContentTestimonios::find($testimonio_id);

        $testimonio->image = $image->store('testimonios','public');
        $testimonio->save();

        Session::flash('alert', 'Imagen guardada exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/web-content/testimonios/edit-image/$testimonio_id");
    }

    public function deleteImageTestimonio(Request $request)
    {
        $testimonio_id = $request->input('testimonio_id');
        $testimonio = WebContentTestimonios::find($testimonio_id);
        $file = $testimonio->image;
        $exists = Storage::disk('public')->exists($file);
        $testimonio->image  = NULL;
        $testimonio->save();
        if($exists){
            Storage::disk('public')->delete($file);
            Session::flash('alert', 'La imagen fue eliminada exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/dashboard/global-configurations/web-content/testimonios/edit-image/$testimonio_id");
        }
        Session::flash('alert', 'No se pudo borrar el archivo del servidor, intentelo nuevamente.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/dashboard/global-configurations/web-content/testimonios/edit-image/$testimonio_id");
    }

    public function eliminarTestimonio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $testimonio = WebContentTestimonios::findOrFail($request->id);
        $testimonio->delete();
    }


    public function getProductsDestacados(Request $request){
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        if($buscar==''){
            $products= Product::join('categories','products.category_id','=','categories.id')
                        ->join('shops','categories.shop_id','=','shops.id')
                        ->select('products.id','products.key','products.name','products.image','products.destacado_gral','products.destacado_gral_order','categories.name as nombre_categoria','shops.name as nombre_shop')
                        ->orderBy('products.destacado_gral','desc')
                        ->orderBy('products.destacado_gral_order','asc')
                        ->paginate(10);
        }else{
            $products= Product::join('categories','products.category_id','=','categories.id')
                        ->join('shops','categories.shop_id','=','shops.id')
                        ->select('products.id','products.key','products.name','products.image','products.destacado_gral','products.destacado_gral_order','categories.name as nombre_categoria','shops.name as nombre_shop')
                        ->where('products.name', 'like', '%'.$buscar.'%')
                        ->orWhere('products.key', 'like', '%'.$buscar.'%')
                        ->orderBy('products.destacado_gral','desc')
                        ->orderBy('products.destacado_gral_order','asc')
                        ->paginate(10);
        }
        return [
            'pagination'=>[
                'total'=> $products->total(),
                'current_page'=> $products->currentPage(),
                'per_page'=> $products->perPage(),
                'last_page'=> $products->lastPage(),
                'from'=> $products->firstItem(),
                'to'=> $products->lastItem(),
            ],
            'products'=>$products,
        ];

    }

    public function updateDestacarProductoGral(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->destacado_gral = '1';
        $product->save();
    }

    public function updateNoDestacarProductoGral(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->destacado_gral = '0';
        $product->save();
    }

    public function updateDestacadosOrder(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product_id = $request->id;
        $action = $request->action;

        $products= Product::select('products.id','products.destacado_gral','products.destacado_gral_order')
                        ->where('products.destacado_gral','1')
                        ->orderBy('products.destacado_gral','desc')
                        ->orderBy('products.destacado_gral_order','asc')
                        ->get();

        //si existe algun item con order 0 vamos a ordenar primero porque se agregaron destacados nuevos
        //en teoria esto solo se hara la primera vez

        $array_prod_order=[];
        $ind_ulitmo=0;
        $ind_prod_actual=0;
        foreach($products as $prod){
            $ind_ulitmo++;
            $array_prod_order[$prod->id]=$ind_ulitmo;
            //detectamos el orden actual del producto que vamos a mover de lugar
            if($prod->id==$product_id) $ind_prod_actual = $ind_ulitmo;
        }

        //al final $ind_ultimo tiene el ultimo numero del array

       $tmp_id=0;   //tendra el id del producto anterior o posterior al que queremos cambiar
       $tmp_ind=0;  //tendra el indice del producto anterior o posterior al que queremos cambiar
       $prod_ind=0; //tendra el nuevo indice del producto que estamos moviendo

       if($action=='up' && $ind_prod_actual>1):
            foreach ($array_prod_order as $key_id => $val_ind) {
                //Cuando encuentre el item anterior al a item que queremos modificar
                //gudaremos un temporales ese id y su nuevo orden
                if($val_ind == $ind_prod_actual-1){
                    $tmp_id  = $key_id;
                    $tmp_ind = $val_ind+1;
                }
                //Cuando encuentre el item que queremos modificar gudaremos el nuevo ind que tendra
                if($val_ind == $ind_prod_actual) $prod_ind=$val_ind-1 ;
            }//foreach
       elseif($action=='down' && $ind_prod_actual<$ind_ulitmo):
            foreach ($array_prod_order as $key_id => $val_ind) {
                //Cuando encuentre el item posterior al a item que queremos modificar
                //gudaremos un temporales ese id y su nuevo orden
                if($val_ind == $ind_prod_actual+1){
                    $tmp_id  = $key_id;
                    $tmp_ind = $val_ind-1;
                }
                //Cuando encuentre el item que queremos modificar gudaremos el nuevo ind que tendra
                if($val_ind == $ind_prod_actual) $prod_ind=$val_ind+1 ;
            }//foreach
       endif;

       //return 'tmpid:'.$tmp_id.' tmp_ind:'.$tmp_ind.' prod_idn'.$prod_ind;


       //actualizamos al arreglo los nuevos indices
       if($tmp_id && $tmp_ind && $prod_ind){
           $array_prod_order[$tmp_id]     = $tmp_ind;
           $array_prod_order[$product_id] = $prod_ind;

           //Y guardamos los resultados en la BD
           foreach ($array_prod_order as $key_id => $val_ind){
                $product = Product::find($key_id);
                $product->destacado_gral_order = $val_ind;
                $product->save();
           }
       }


    }

    public function webContentDestacados(){
        $seccion = WebContentDestacados::where('shop_id',0)->first();
        return view('admin.global_configurations.web_content.destacados',['seccion'=>$seccion]);
    }

    public function updateDestacados(Request $request){
        $seccion = WebContentDestacados::findOrfail($request->id);

        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->description = $request->description;
        $seccion->num_items = $request->num_items;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/destacados');
    }




    public function webContentMetodosPagos(){
        $seccion = WebContentSeccionMetodosPagos::where('shop_id',0)->first();
        return view('admin.global_configurations.web_content.metodos_pagos',['seccion'=>$seccion]);
    }

    public function updateDatosMetodosPagos(Request $request){
        //dd($request);
        $seccion = WebContentSeccionMetodosPagos::findOrfail($request->id);
        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->description = $request->description;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/metodos-pagos');
    }

    public function updateImageMetodosPagos(Request $request){
        $seccion = WebContentSeccionMetodosPagos::findOrfail($request->id);
        if($seccion->image){
            $old_image = $seccion->image;
            $existe = Storage::disk('public')->exists($old_image);
            if($existe) Storage::disk('public')->delete($old_image);
        }
        $seccion->image = $request->file('image')->store('global_web_content', 'public');

        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/metodos-pagos');
    }

    public function webContentLogosTiendas(){
        $seccion = WebContentSeccionLogosTiendas::where('shop_id',0)->first();
        $shops   = Shop::where('status',0)->get();

        $tmp = $seccion->shops;
        $temp2 = explode(",",$tmp);
        $tdas=[];
        foreach($temp2 as $data){
            $tdas[$data]=$data;
        }


        return view('admin.global_configurations.web_content.logos_tiendas',['seccion'=>$seccion,'shops'=>$shops,'tdas'=>$tdas]);
    }

    public function updateLogosTiendas(Request $request){

        $shops   = Shop::where('status',0)->get();
        $temp=[];
        foreach($shops as $shop){
            $shop_id = $shop->id;
            if($request->has("shop-$shop_id"))
                $temp[]=$shop_id;
        }
        $tdas='';
        if(count($temp)) $tdas = implode(",",$temp);
        //dd($request->show);
        $seccion = WebContentSeccionLogosTiendas::findOrfail($request->id);
        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->description = $request->description;
        $seccion->shops = $tdas;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/logos-tiendas');
    }

    public function webContentCarouselUpdateDatos(Request $request){
        $seccion = WebContentSeccionCarousel::findOrfail($request->id);

        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->description = $request->description;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/carousel');
    }

    public function updateDatosSeccion(Request $request){
        $seccion = WebContentSeccionTestimonios::findOrfail($request->id);

        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->description = $request->description;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/testimonios');
    }


    public function webContentBannerLoop(){

        $seccion = WebContentBannerLoop::where('shop_id',0)->first();
        return view('admin.global_configurations.web_content.banner_loop',['seccion'=>$seccion]);
    }//webContentBannerLoop

    public function updateBannerLoopDatos(Request $request){

        $seccion = WebContentBannerLoop::findOrfail($request->id);
        $seccion->show = isset($request->show)?1:0;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return back();
    }//webContentBannerLoop

    public function updateBannerLoopImage(Request $request){

        $seccion = WebContentBannerLoop::findOrfail($request->id);
        $num_img = $request->no;

        $exito=false;
        if($num_img==1){
            if($seccion->image1){
                $old_image = $seccion->image1;
                $existe = Storage::disk('public')->exists($old_image);
                if($existe) Storage::disk('public')->delete($old_image);
            }
            $seccion->image1 = $request->file('image')->store('global_web_content', 'public');
            $seccion->save();
            $exito=true;
        }elseif($num_img==2){
            if($seccion->image2){
                $old_image = $seccion->image2;
                $existe = Storage::disk('public')->exists($old_image);
                if($existe) Storage::disk('public')->delete($old_image);
            }
            $seccion->image2 = $request->file('image')->store('global_web_content', 'public');
            $seccion->save();
            $exito=true;
        }elseif($num_img==3){
            if($seccion->image3){
                $old_image = $seccion->image3;
                $existe = Storage::disk('public')->exists($old_image);
                if($existe) Storage::disk('public')->delete($old_image);
            }
            $seccion->image3 = $request->file('image')->store('global_web_content', 'public');
            $seccion->save();
            $exito=true;
        }elseif($num_img==4){
            if($seccion->image4){
                $old_image = $seccion->image4;
                $existe = Storage::disk('public')->exists($old_image);
                if($existe) Storage::disk('public')->delete($old_image);
            }
            $seccion->image4 = $request->file('image')->store('global_web_content', 'public');
            $seccion->save();
            $exito=true;
        }

        if($exito){
            Session::flash('alert', 'Actualización exitosa.');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('alert', 'Error al subir imagen, intente de nuevo con tactos a soporte.');
            Session::flash('alert-class', 'alert-danger');
        }
        return back();
    }//updateBannerLoopImage

    public function webContentNavAccesoTiendas(){
        $shops   = Shop::where('status',0)->get();
        return view('admin.global_configurations.web_content.nav_acceso_tiendas',['shops'=>$shops]);
    }//webContentNavAccesoTiendas

    public function webContentAccesoTiendas(){
        $seccion = WebContentSeccionAccesoTiendas::where('shop_id',0)->first();
        $shops   = Shop::where('status',0)->get();
        $tmp = $seccion->shops;
        $temp2 = explode(",",$tmp);
        $tdas=[];
        foreach($temp2 as $data){
            $tdas[$data]=$data;
        }
        return view('admin.global_configurations.web_content.acceso_tiendas',['seccion'=>$seccion,'shops'=>$shops,'tdas'=>$tdas]);
    }//webContentAccesoTiendas

    public function updateAccesoTiendas(Request $request){

        $shops   = Shop::where('status',0)->get();
        $temp=[];
        foreach($shops as $shop){
            $shop_id = $shop->id;
            if($request->has("shop-$shop_id"))
                $temp[]=$shop_id;
        }
        $tdas='';
        if(count($temp)) $tdas = implode(",",$temp);
        //dd($request->show);
        $seccion = WebContentSeccionAccesoTiendas::findOrfail($request->id);
        $seccion->show = isset($request->show)?1:0;
        $seccion->title = $request->title;
        $seccion->description = $request->description;
        $seccion->shops = $tdas;
        $seccion->save();

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/acceso-tiendas');
    }


    public function updateNavAccesoTiendas(Request $request){
        $shops   = Shop::where('status',0)->get();
        foreach($shops as $shop){

            $shop_id = $shop->id;

            $show = $request->has("shop-$shop_id")?1:0;

            $tienda = Shop::findOrFail($shop_id);
            $tienda->show_main_nav = $show;
            $tienda->save();

        }

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/global-configurations/web-content/nav-acceso-tiendas');
    }//updateNavAccesoTiendas


    public function abbasterInfo(Request $request){
        //PARA QUE ESTA FUNCION FUNCIONE DEBE ESTAR CREADO EL REGISTRO EN LA BD TABLA: abbaster_information
        $abbaster_info  = AbbasterInformation::find(1);
        return view('admin.global_configurations.abbaster.info',['abbaster_info'=>$abbaster_info]);
    }

    public function updateAbbasterInfo(Request $request){
        $abbaster_info  = AbbasterInformation::findOrFail(1);
        $abbaster_info->slogan = $request->slogan;
        $abbaster_info->movil = $request->movil;
        $abbaster_info->whatsapp = isset($request->whatsapp)?1:0;
        $abbaster_info->phone = $request->phone;
        $abbaster_info->email = $request->email;
        $abbaster_info->facebook = $request->facebook;
        $abbaster_info->twitter = $request->twitter;
        $abbaster_info->instagram = $request->instagram;
        $abbaster_info->pinterest = $request->pinterest;
        $abbaster_info->video_channel = $request->video_channel;
        $abbaster_info->location = $request->location;
        $abbaster_info->style_color_bg = $request->style_color_bg;
        $abbaster_info->style_color_txt = $request->style_color_txt;

        $abbaster_info->save();
        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/global-configurations/abbaster-information");
    }

}
