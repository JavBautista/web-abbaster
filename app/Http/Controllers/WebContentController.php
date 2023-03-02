<?php

namespace App\Http\Controllers;

use App\Shop;
use App\DownloadDocument;
use App\WebContentAboutUs;
use App\WebContentServices;
use App\WebContentImagesCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\WebContentDestacados;
use App\WebContentNuevos;
use App\WebContentLandingTiendaSecciones;

class WebContentController extends Controller
{


    public function descargas($shop_id){
    	$shop = Shop::find($shop_id);
        $documents = DownloadDocument::where('shop_id',$shop_id)->get();
    	return view('admin.web_content.descargas',[
    		'shop'=>$shop,
            'documents'=>$documents,
    	]);

    }

    public function upload(Request $request){
        //dd($request);
        $this->validate($request,[
                'name'=>['required'],
                'description'=>['required'],
            ],
            [
                'name.required'=>'Por favor ingrese un nombre del documento.',
                'description.required'=>'Por favor ingrese una descripción del documento.',

        ]);

    	$shop_id = $request->input('shop_id');
        $file = $request->file('document');

        $document = DownloadDocument::create([

            'name'=> $request->input('name'),
            'description'=> $request->input('description'),
            'status'=> $request->input('status'),
            'file'=> $file->store('downloads_documents','public'),
            'shop_id'=> $shop_id,
        ]);

        Session::flash('alert', 'Documento '.$request->input('name').' guardado correctamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/descargas");
    }

    public function download($id){
        $document = DownloadDocument::find($id);
        $file = $document->file;
        $exists = Storage::disk('public')->exists($file);
        //dd($file.' '.$exists);
        if($exists){
            return Storage::disk('public')->download($file);

        }
        Session::flash('alert', 'El documento solicitado no existe. Consulte al administrador del sistema.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/dashboard/store/$shop_id/web/descargas");

    }

    public function updateStatus($shop_id,$file_id){
        $document = DownloadDocument::find($file_id);

        $new_status= $document->status?0:1;
        $document->status=$new_status;
        $document->save();
        Session::flash('alert', 'El status del documento '.$document->name.' ha sido actualizado correctamente');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/descargas");
    }

    public function remove($shop_id,$file_id){
        $document = DownloadDocument::find($file_id);
        $shop = Shop::find($shop_id);
         return view('admin.web_content.descargas_remove',[
            'document'=>$document,
            'shop'=>$shop,
        ]);
    }

    public function deleteFile(Request $request){
        $document = DownloadDocument::find($request->input('document_id'));
        $shop_id = $document->shop_id;
        $file = $document->file;
        //dd($file);
        $exists = Storage::disk('public')->exists($file);
        if($exists){

            Storage::disk('public')->delete($file);
            $document->delete();
            Session::flash('alert', 'El documento fue eliminado exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/dashboard/store/$shop_id/web/descargas");


        }
        Session::flash('alert', 'El documento solicitado no existe. Consulte al administrador del sistema.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/dashboard/store/$shop_id/web/descargas");
    }

    public function aboutUs($shop_id){
        $shop = Shop::find($shop_id);
        $content=WebContentAboutUs::where('shop_id',$shop_id)->first();
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
        return view('admin.web_content.about_us',[
            'shop'=>$shop,
            'content'=>$content,
            'content_id'=>$content_id,
            'content_html'=>$content_html,
        ]);
    }

    public function services($shop_id){
        $shop = Shop::find($shop_id);
        $content=WebContentServices::where('shop_id',$shop_id)->first();
        $content_id=$content?$content->id:0;

        $content_html = $content?$content->content:'';
        if($content){
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
        return view('admin.web_content.services',[
            'shop'=>$shop,
            'content'=>$content,
            'content_id'=>$content_id,
            'content_html'=>$content_html,
        ]);
    }

    public function updateAboutUs(Request $request){
        $shop_id = $request->input('shop_id');
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
            $web_content = WebContentAboutUs::find($content_id);

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
            $web_content = new WebContentAboutUs;
            $web_content->shop_id = $shop_id;
            $web_content->content = $content;
            $web_content->save();
        }
        Session::flash('alert', 'El contenido fue actualizado correctamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/ubout-us");
    }

    public function updateServices(Request $request){

        $shop_id = $request->input('shop_id');
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
            $web_content = WebContentServices::find($content_id);
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
            $web_content = new WebContentServices;
            $web_content->shop_id = $shop_id;
            $web_content->content = $content;
            $web_content->save();
        }
        Session::flash('alert', 'El contenido fue actualizado correctamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/services");
    }

    public function imagesCarouselIndex($shop_id){
        $shop = Shop::find($shop_id);
        $carousel = WebContentImagesCarousel::where('shop_id',$shop_id)->orderBy('order', 'asc')->get();

        //Validanmos cada ves que se entre a la pagina el orden de los indices de orden
        if($carousel->count()){
            $new_order=0;
            foreach($carousel as $img){
                $new_order++;
                $img->order = $new_order;
                $img->save();
            }//foreach
        }//if count

        return view('admin.web_content.images_carousel_index',[
            'shop'=>$shop,
            'carousel'=>$carousel,

        ]);

    }
    public function imagesCarouselAdd($shop_id){
        $shop = Shop::find($shop_id);
        return view('admin.web_content.images_carousel_add',[
            'shop'=>$shop,
        ]);
    }

    public function createImageCarousel(Request $request){

        $shop_id = $request->input('shop_id');
        $image = $request->file('image');


        $images_shop = WebContentImagesCarousel::where('shop_id',$shop_id)->get();
        $order=$images_shop->count();

        $reg = WebContentImagesCarousel::create([
            'order'=> $order+1,
            'align'=> $request->input('align'),
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
            'url'=> $request->input('url'),
            'image'=> $image->store('web_content','public'),
            'shop_id'=> $shop_id,
        ]);
        Session::flash('alert', 'Contenido guardado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/images-carousel");
    }

    public function imagesCarouselEdit($shop_id, $item_id){
        $shop = Shop::find($shop_id);
        $item = WebContentImagesCarousel::find($item_id);
        return view('admin.web_content.images_carousel_edit',[
            'shop'=>$shop,
            'item'=>$item,
        ]);
    }
    public function updateImageCarousel(Request $request){
        $item = WebContentImagesCarousel::find($request->input('item_id'));

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
            $item->image = $request->file('image')->store('web_content', 'public');
            $item->save();
            Session::flash('alert', 'Iamgen actualizada exitosamente.');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('alert', 'No fue posible alctualizar el contenido. intente nuevamente o consulte al administrador del sistema.');
            Session::flash('alert-class', 'alert-danger');
        }#./if-else

        return redirect("/dashboard/store/".$item->shop->id."/web/images-carousel/edit/".$item->id);
    }

    public function imagesCarouselRemove($shop_id, $item_id){
        $item = WebContentImagesCarousel::find($item_id);
        return view('admin.web_content.images_carousel_remove',[
            'shop'=>$item->shop,
            'item'=>$item,
        ]);
    }
    public function deleteImageCarousel(Request $request){
        $item = WebContentImagesCarousel::find($request->input('item_id'));
        $shop_id = $item->shop->id;
        $image = $item->image;
        //Verificamos que exista el archivo de la imagen, si existe lo eliminamos
        if( Storage::disk('public')->exists($image) ) Storage::disk('public')->delete($image);
        $item->delete();
        Session::flash('alert', 'El item fue eliminado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/images-carousel");
    }

    public function updateOrderImageCarousel(Request $request){
        $img_id = $request->input('img_id');
        $command = $request->input('command');

        $image_update=WebContentImagesCarousel::find($img_id);
        $shop_id = $image_update->shop_id;

        $image_orden_actual=$image_update->order;

        $images_shop=WebContentImagesCarousel::where('shop_id',$shop_id)->orderBy('order', 'asc')->get();

        //dd($image_orden_actual-1);

        $count=$images_shop->count();

        if($command=='up'){
            //Si es UP pero el actual es 1 nada que hacer
            if($image_orden_actual!=1){
                //Localizamos la imagen con el num orden antes del que queremos cambiar
                foreach ($images_shop as $image) {
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
                foreach ($images_shop as $image) {
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
        return redirect("/dashboard/store/".$shop_id."/web/images-carousel");
    }

    public function imagePromotionalBanner($shop_id){
        $shop = Shop::find($shop_id);
        return view('admin.web_content.image_banner_promotional',[
            'shop'=>$shop,
        ]);
    }

    public function uploadBannerPromotional(Request $request){
        $shop_id = $request->input('shop_id');
        $image = $request->file('image');
        $shop = Shop::find($shop_id);

        $shop->promotional_banner_image = $image->store('web_content','public');
        $shop->promotional_banner_show  = 0;
        $shop->save();

        Session::flash('alert', 'Contenido guardado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/web/promotional-banner");
    }

    public function deleteBannerPromotional(Request $request){
        $shop_id = $request->input('shop_id');
        $shop = Shop::find($shop_id);

        $file = $shop->promotional_banner_image;

        $exists = Storage::disk('public')->exists($file);
        if($exists){
            Storage::disk('public')->delete($file);

            $shop->promotional_banner_image  = NULL;
            $shop->promotional_banner_show  = 0;
            $shop->save();
            Session::flash('alert', 'La imagen fue eliminada exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/dashboard/store/$shop_id/web/promotional-banner");
        }
        Session::flash('alert', 'No se pudo borrar el archivo del servidor, intentelo nuevamente.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/dashboard/store/$shop_id/web/promotional-banner");
    }

    public function productosDestacados($shop_id){
        $shop = Shop::find($shop_id);
        $seccion = WebContentDestacados::where('shop_id',$shop_id)->first();
        if(!$seccion){
            $seccion=(object)[
                'show'=>0,
                'title'=>'',
                'description'=>'',
                'num_items'=>0,
                'id'=>0,
            ];
        }
        return view('admin.web_content.productos_destacados',[
            'shop'=>$shop,
            'seccion'=>$seccion,
        ]);
    }

    public function updateProductosDestacados(Request $request){
        //dd($request);
        if($request->id){
            $seccion = WebContentDestacados::findOrfail($request->id);
            $seccion->show = isset($request->show)?1:0;
            $seccion->title = $request->title;
            $seccion->description = $request->description;
            $seccion->num_items = $request->num_items;
            $seccion->save();
        }else{
            $seccion = new WebContentDestacados;
            $seccion->shop_id = $request->shop_id;
            $seccion->show = isset($request->show)?1:0;
            $seccion->title = $request->title;
            $seccion->description = $request->description;
            $seccion->num_items = $request->num_items;
            $seccion->save();
        }

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$request->shop_id."/web/productos-destacados");
    }

    public function productosNuevos($shop_id){
        $shop = Shop::find($shop_id);
        $seccion = WebContentNuevos::where('shop_id',$shop_id)->first();
        if(!$seccion){
            $seccion=(object)[
                'show'=>0,
                'title'=>'',
                'description'=>'',
                'num_items'=>0,
                'id'=>0,
            ];
        }
        return view('admin.web_content.productos_nuevos',[
            'shop'=>$shop,
            'seccion'=>$seccion,
        ]);
    }

    public function updateProductosNuevos(Request $request){
        if($request->id){
            $seccion = WebContentNuevos::findOrfail($request->id);
            $seccion->show = isset($request->show)?1:0;
            $seccion->title = $request->title;
            $seccion->description = $request->description;
            $seccion->num_items = $request->num_items;
            $seccion->save();
        }else{
            $seccion = new WebContentNuevos;
            $seccion->shop_id = $request->shop_id;
            $seccion->show = isset($request->show)?1:0;
            $seccion->title = $request->title;
            $seccion->description = $request->description;
            $seccion->num_items = $request->num_items;
            $seccion->save();
        }

        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$request->shop_id."/web/productos-nuevos");
    }

    public function seccionDescripcion($shop_id){
        $shop = Shop::find($shop_id);
        $seccion = WebContentLandingTiendaSecciones::where('shop_id',$shop_id)->first();

        $content_html = $seccion?$seccion->content:'';

        if($seccion){
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
        }

        if(!$seccion){
            $seccion=(object)[
                'show'=>0,
                'title'=>'',
                'description'=>'',
                'content'=>'',
                'id'=>0,
                'content_html'=>'',
            ];
        }
        return view('admin.web_content.seccion_descripcion',[
            'shop'=>$shop,
            'seccion'=>$seccion,
            'content_html'=>$content_html,
        ]);

    }

    public function updateSeccionDescripcion(Request $request){
        #--------------------------------------------------

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
            Storage::disk('public')->put('web_content/'.$image_name, $data);
            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
        }

        $content = $dom->savehtml();

        /////////////////////////////////////////////////////////////////
        if($request->id){
            $seccion = WebContentLandingTiendaSecciones::findOrfail($request->id);
                #Se procesan las imagenes del conetnido HTML
                #BORRAMOS LOS ARCHIVOS DE LAS IMAGENES QUE ESTABAN ALMACENADAS EN EL ANTERIOR CONTENIDO
                $content_html_bd = $seccion?$seccion->content:'';
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
                #fin de procesar imagenes html del content
            $seccion->show = isset($request->show)?1:0;
            $seccion->title = $request->title;
            $seccion->description = $request->description;
            $seccion->content = $content;
            $seccion->save();
        }else{
            $seccion = new WebContentLandingTiendaSecciones;
            $seccion->shop_id = $request->shop_id;
            $seccion->show = isset($request->show)?1:0;
            $seccion->title = $request->title;
            $seccion->description = $request->description;
            $seccion->content = $content;
            $seccion->save();
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////
        Session::flash('alert', 'Actualización exitosa.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$request->shop_id."/web/seccion-descripcion");

    }

}
