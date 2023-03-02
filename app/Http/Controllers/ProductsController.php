<?php

namespace App\Http\Controllers;
use App\Product;
use App\Proveedor;
use App\Shop;
use App\Category;
use App\Course;
use App\ImagesProduct;
use App\Warehouse;
use App\DollarPrice;
use App\InventoryProduct;
use App\ProductQuestions;
use App\ProductQuestionsAnswers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ProductsController extends Controller
{
    public function getProducts(Request $request,$category_id){
        if(!$request->ajax()) return redirect('/');
        $dollar_price = DollarPrice::find(1);
        $warehouses= Warehouse::all();

        $buscar   = $request->buscar;
        $criterio   = $request->criterio;
        $filtro_status   = $request->filtro_status;
        $busqueda_gral=$request->busqueda_gral;

        //Si la busqueda es general
        if($busqueda_gral){
            $categoria = Category::find($category_id);
            $shop_id = $categoria->shop_id;
            $categorias=Category::where('shop_id',$shop_id)->get();
            $arrayProducts=[];
            foreach ($categorias as $cat) {
                $products = Product::with('inventoryProduct')
                        ->with('category')
                        ->with('images')
                        ->where('category_id',$cat->id)
                        ->estatus($filtro_status)
                        ->buscartexto($buscar,$criterio)
                        ->orderBy('id','desc')->get();
                foreach($products as $prod){
                    $arrayProducts[]=$prod;
                }
            }
            $count_products= $arrayProducts?count($arrayProducts):0;
            return [
                'pagination'=>[
                    'total'=> $count_products,
                    'current_page'=> 1,
                    'per_page'=> $count_products,
                    'last_page'=> 1,
                    'from'=> 1,
                    'to'=> $count_products
                ],
                'products'=>['data'=>$arrayProducts],
                'warehouses'=>$warehouses,
                'dollar_price'=> $dollar_price->price,
            ];
        }else{
            $products = Product::with('inventoryProduct')
                ->with('category')
                ->with('images')
                ->where('category_id',$category_id)
                ->orderBy('id','desc')
                ->estatus($filtro_status)
                ->buscartexto($buscar,$criterio)
                ->paginate(5);
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
                'warehouses'=>$warehouses,
                'dollar_price'=> $dollar_price->price,
            ];
        }//if-else busqueda_gral
    }

    public function getCategoriesShop(Request $request,$shop_id){
        if(!$request->ajax()) return redirect('/');
        $categories= Category::where('shop_id',$shop_id)->get();
        return $categories;
    }

    public function getCoursesShop(Request $request,$shop_id){
        if(!$request->ajax()) return redirect('/');
        $courses= Course::where('shop_id',$shop_id)->get();
        return $courses;
    }

    public function getDatosShop(Request $request,$shop_id){
        if(!$request->ajax()) return redirect('/');
        $shop= Shop::findOrFail($shop_id);
        return $shop;
    }

    public function index(Request $request, $shop_id){
        $shop=Shop::find($shop_id);
        $categories=Category::where('shop_id',$shop_id)->get();
        $category_id=($request->session()->has('category_id'))? $request->session()->get('category_id') : 0;

        return view('admin.products.index',[
            'shop'=>$shop,
            'shop_id'=>$shop_id,
            'categories'=>$categories,
            'category_id'=>$category_id,
        ]);
    }

    public function select_category(Request $request){
        $category_id = $request->input('category');
        $request->session()->put('category_id', $category_id);
        $shop_id=$request->input('shop_id');
        return redirect("/dashboard/store/$shop_id/products");
    }

    public function add(Request $request,$shop_id){
        $category_id= (SESSION::has('category_id'))? SESSION::get('category_id') : 0;
        $shop=Shop::find($shop_id);
        $proveedores=Proveedor::where('shop_id',$shop_id)->get();
        $categories=Category::where('shop_id',$shop_id)->get();
        return  view('admin.products.add',[
            'shop'=>$shop,
            'proveedores'=>$proveedores,
            'categories'=>$categories,
            'category_id'=>$category_id,
        ]);
    }

    public function create(Request $request){

        $this->validate($request,[
                'key'=>['required'],
                'barcode'=>['required'],
                'name'=>['required'],
            ],
            [
                'key.required'=>'Ingrese informacion.',
                'barcode.required'=>'Ingrese informacion.',
                'name.required'=>'Ingrese informacion.',

        ]);

        //$image = $request->file('image');
        $limit_web=25;
        if($request->type_course) $limit_web=1;
        $product = Product::create([
            'proveedor_id'=> $request->proveedor,
            'category_id'=> $request->category,
            'key'=> $request->key,
            'barcode'=> $request->barcode,
            'name'=> $request->name,
            'description'=> $request->description,
            'cost_dollar'=> 0,
            'cost'=> 0,
            'retail'=> 0,
            'wholesale'=> 0,
            'status'=> $request->status,
            'url_video'=> $request->url_video,
            'type_course'=> $request->type_course,
            'sales_limit_web'=> $limit_web,
        ]);

        if(!$request->ajax()){
            $shop_id=$request->input('shop_id');
            Session::flash('alert', 'Producto '.$request->input('name').' guardado exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/dashboard/store/$shop_id/products");
        }
    }

    public function images($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        return view('admin.products.images',[
            'shop'=>$shop,
            'product'=>$product,
        ]);
    }

    public function updateMainImage(Request $request){
        $shop_id = $request->input('shop_id');
        $product_id = $request->input('product_id');

        if($request->hasFile('main_image')){
           $product = Product::find($product_id);
           $product->image = $request->file('main_image')->store('products', 'public');
           $product->save();
        }
        Session::flash('alert', 'Imagen de Producto '.$product->name.' actualizado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products/images/$product_id");
    }

    public function updateMainImageAxios(Request $request){

        $request->validate([
            'main_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $product = Product::findOrFail($request->product_id);
        $file    = $product->image;
        $exists  = Storage::disk('public')->exists($file);
        if($exists){
            Storage::disk('public')->delete($file);
        }

        $product->image = $request->file('main_image')->store('products', 'public');
        $product->save();


    }

    public function addImageProduct(Request $request){
        $shop_id = $request->input('shop_id');
        $product_id = $request->input('product_id');
        $image = $request->file('image');

        $product = ImagesProduct::create([
            'product_id'=> $product_id,
            'image'=> $image->store('images_products','public'),
        ]);

        Session::flash('alert', 'Imagen agregada exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products/images/$product_id");
    }

   public function deleteImageProduct(Request $request){
        $shop_id    = $request->input('shop_id');
        $product_id = $request->input('product_id');
        $image_id   = $request->input('image_id');

        $image = ImagesProduct::find($image_id);
        $file = $image->image;

        $exists = Storage::disk('public')->exists($file);
        if($exists){
            Storage::disk('public')->delete($file);
            $image->delete();

            Session::flash('alert', 'La imagen fue eliminada exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/dashboard/store/$shop_id/products/images/$product_id");
        }
        Session::flash('alert', 'El archivo solicitado no existe. Consulte al administrador del sistema.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/dashboard/store/$shop_id/products/images/$product_id");
    }

    public function edit($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        $proveedores=Proveedor::where('shop_id',$shop_id)->get();
        $categories=Category::where('shop_id',$shop_id)->get();
        return view('admin.products.edit',[
            'shop'=>$shop,
            'product'=>$product,
             'proveedores'=>$proveedores,
            'categories'=>$categories,
        ]);
    }

    public function update(Request $request){
        $shop_id = $request->input('shop_id');
        $product_id = $request->input('product_id');

        $product= Product::find($product_id);


        $product->proveedor_id= $request->input('proveedor');
        $product->category_id= $request->input('category');
        $product->key= $request->input('key');
        $product->barcode= $request->input('barcode');
        $product->name= $request->input('name');
        $product->description= $request->input('description');
        $product->cost= $request->input('cost');
        $product->retail= $request->input('retail');
        $product->wholesale= $request->input('wholesale');
        $product->status= $request->input('status');
        $product->url_video= $request->input('url_video');
        $product->save();
        Session::flash('alert', 'Producto '.$request->input('name').' actualizado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products");
    }


    public function updateStars(Request $request){

        $shop_id = $request->input('shop_id');
        $product_id = $request->input('product_id');
        $product= Product::find($product_id);
        $product->stars=$request->input('select-star-'.$product->id);
        $product->save();
        Session::flash('alert', 'Producto '.$product->name.' actualizado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products");
    }//updateStars()


    public function editStatus($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        return view('admin.products.edit_status',[
            'product'=>$product,
            'shop'=>$shop,
        ]);

    }
    public function remove($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        return view('admin.products.remove',[
            'product'=>$product,
            'shop'=>$shop,
        ]);

    }

    public function updateStatus(Request $request){
        $shop_id=$request->input('shop_id');
        $product = Product::find($request->input('product_id'));
        $product->status= $request->input('status');
        $product->save();
        Session::flash('alert', 'Estatus de Producto '.$product->name.' actualizado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products");
    }

    public function delete(Request $request){
        $shop_id=$request->input('shop_id');
        $product = Product::find($request->input('product_id'));
        $product->delete();
        Session::flash('alert', 'Producto '.$product->name.' eliminado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products");
    }

    public function view($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        return view('admin.products.view',[
            'shop'=>$shop,
            'product'=>$product,
        ]);
    }

    public function editLimitWeb($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        return view('admin.products.edit_limit_web',[
            'product'=>$product,
            'shop'=>$shop,
        ]);
    }

    public function updateSalesLimitWeb(Request $request){
        $shop_id=$request->input('shop_id');
        $product = Product::find($request->input('product_id'));
        $product->sales_limit_web= $request->input('sales_limit_web');
        $product->save();
        Session::flash('alert', 'Limites Web de Producto '.$product->name.' actualizado exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/$shop_id/products");
    }

    private function generarRandSlug($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
        return $key;
    }

    private function generarBarcode($longitud) {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
        return $key;
    }


    public function adminSlugs(Request $request, $shop_id){

        $category_id= ($request->session()->has('category_id'))? $request->session()->get('category_id') : 0;

        $shop=Shop::find($shop_id);
        $categories=Category::where('shop_id',$shop_id)->get();

        if($category_id){
            $products=Product::where('category_id',$category_id)->get();
        }else{ $products=NULL; }

        $slugs=[];
        foreach ($products as $product){
            //Si ya existe un Slug
            if($product->slug){
                $slugs[$product->id]=$product->slug;
            }else{
                //Sino proponemos uno
                $sigue=true;
                $rand_slug='';//la primera vez no generara nada, para conservar un slug mas limpio
                while($sigue){
                    $tmp=$rand_slug;
                    $tmp.= Str::slug($product->name);

                    $existe=Product::where('slug',$tmp)->first();
                    if(!$existe){
                        $sigue=false;
                        break;
                    }

                    $rand_slug = $this->generarRandSlug(5);
                    $rand_slug .= '-';
                }
                //
                $slugs[$product->id]=$tmp;
            }

        }


        return view('admin.products.slugs',[
            'shop'=>$shop,
            'products'=>$products,
            'categories'=>$categories,
            'category_id'=>$category_id,
            'slugs'=>$slugs,
        ]);
    }

    public function updateSlug(Request $request){
        $product_id = $request->input('product_id');
        $slug = $request->input('slug');

        $this->validate($request,[
                'slug'=>['required','unique:products'],
            ],
            [
                'slug.required'=>'No se pueden guardar Slug vacios.',
                'slug.unique'=>'El Slug: '.$slug.' ya existe en la BD. Intente otro.',
        ]);

        $product=Product::find($product_id);
        $product->slug = $slug;
        $product->save();

        Session::flash('alert', 'Slug para '.$product->name.'actualizado correctamnente ');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$product->category->shop_id."/products/slugs");

    }

    public function updateBarcode(Request $request){
        $product_id = $request->input('product_id');
        $barcode = $request->input('barcode');

        $this->validate($request,[
                'barcode'=>['required','unique:products'],
            ],
            [
                'barcode.required'=>'No se pueden guardar códigos de barras vacios.',
                'barcode.unique'=>'El código: '.$barcode.' ya existe en la BD. Intente otro.',
        ]);

        $product=Product::find($product_id);
        $product->barcode = $barcode;
        $product->save();

        Session::flash('alert', 'Código de barras para '.$product->name.'actualizado correctamnente ');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$product->category->shop_id."/products/barcodes");

    }

    public function adminOrderBy(Request $request,$shop_id){
        $category_id= ($request->session()->has('category_id'))? $request->session()->get('category_id') : 0;

        $shop=Shop::find($shop_id);
        $categories=Category::where('shop_id',$shop_id)->get();

        if($category_id){
            $products=Product::where('category_id',$category_id)->orderBy('order_by', 'asc')->get();
            $ordena=false;
            foreach ($products as $product){
                if($product->order_by==0) $ordena=true;
            }
            if($ordena){
                $cont=0;
                foreach ($products as $product) {
                    $cont++;
                    $product_item = Product::find($product->id);
                    $product_item->order_by=$cont;
                    $product_item->save();
                }
                $products=Product::where('category_id',$category_id)->orderBy('order_by', 'asc')->get();
            }
        }else{ $products=NULL; }

        return view('admin.products.order_by',[
            'shop'=>$shop,
            'products'=>$products,
            'categories'=>$categories,
            'category_id'=>$category_id,
        ]);
    }

    public function updateOrderBy(Request $request){

        $product_id = $request->input('product_id');
        $command = $request->input('command');

        $product_update=Product::find($product_id);
        $product_orden_actual=$product_update->order_by;

        $category_id= ($request->session()->has('category_id'))? $request->session()->get('category_id') : 0;
        if($category_id){

            $products=Product::where('category_id',$category_id)->orderBy('order_by', 'asc')->get();
            $count=$products->count();

            if($command=='up'){
                //Si es UP pero el actual es 1 nada que hacer
                if($product_orden_actual!=1){
                    //Localizamos el producto con el num orden antes del que queremos cambiar
                    foreach ($products as $product) {
                        if($product->order_by==$product_orden_actual-1){
                            $product->order_by = $product_orden_actual;
                            $product->save();
                            $product_update->order_by=$product_orden_actual-1;
                            $product_update->save();
                            break;
                        }
                    }
                }

            }else if($command=='down'){
                //Si es DOWN pero el actual es el ultimo nada que hacer
                if($product_orden_actual!=$count){
                    //Localizamos el producto con el num orden despues del que queremos cambiar
                    foreach ($products as $product) {
                        if($product->order_by==$product_orden_actual+1){
                            $product->order_by = $product_orden_actual;
                            $product->save();
                            $product_update->order_by=$product_orden_actual+1;
                            $product_update->save();
                            break;
                        }
                    }
                }
            }//if-else command
        }//category_id

        Session::flash('alert', 'Orden actualizado correctamnente ');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$product_update->category->shop_id."/products/order-by");

    }

    public function search(Request $request){
        if($request->input('search')!='' )
            Session::put('search_product', $request->input('search'));
        return redirect('/dashboard/store/'.$request->input('shop_id').'/products');
    }

    public function searchClear($shop_id){
        Session::forget('search_product');
        return redirect('/dashboard/store/'.$shop_id.'/products');
    }


    public function getDataProduct(Request $request,$product_id){
        if(!$request->ajax()) return redirect('/');
        $product= Product::find($product_id);
        return $product;
    }

    public function updateCostosProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->retail = $request->new_retail;
        $product->cost_dollar = $request->new_cost_usd;
        $product->save();
    }

    public function updateStarsProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->stars = $request->stars;
        $product->save();
    }

    public function updateDesactivarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->status = '1';
        $product->save();
    }

    public function updateActivarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->status = '0';
        $product->save();
    }

    public function updateDestacarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->featured = '1';
        $product->save();
    }

    public function updateNoDestacarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->featured = '0';
        $product->save();

    }

    public function updateDatosProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->key= $request->key;
        $product->barcode= $request->barcode;
        $product->name= $request->name;
        $product->description= $request->description;
        $product->status= $request->status;
        $product->url_video= $request->url_video;
        $product->save();
    }

    public function updateEliminarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');

        $product = Product::findOrFail($request->id);
        $product_id=$product->id;
        //1 Eliminamos la imagen principal del producto
        if($product->image){
            $file = $product->image;
            $exists = Storage::disk('public')->exists($file);
            if($exists){
                Storage::disk('public')->delete($file);
            }
        }
        //2 Eliminamos las imagenes relacionadas al producto
        $images = ImagesProduct::where('product_id',$product->id)->get();
        if($images){
            foreach ($images as $img) {
                $image = ImagesProduct::find($img->id);
                $file = $image->image;
                $exists = Storage::disk('public')->exists($file);
                if($exists){
                    Storage::disk('public')->delete($file);
                    $image->delete();
                }
            }
        }

        //3 eliminamos las questions
        $questions=ProductQuestions::where('product_id',$product_id)->get();
        if($questions){
            foreach($questions as $question){
                $answers= ProductQuestionsAnswers::where('product_questions_id',$question->id)->get();
                foreach ($answers as $answer) {
                    $ans=ProductQuestionsAnswers::find($answer->id);
                    $ans->delete();
                }
                $qst=ProductQuestions::find($question->id);
                $qst->delete();
            }
        }
        //3 eliminamos el inventorio del product
        $inventories=InventoryProduct::where('product_id',$product_id)->get();
        foreach ($inventories as $inventory) {
            $inv=InventoryProduct::find($inventory->id);
            $inv->delete();
        }
        //Finalmente eliminamos el articulo
        $product->delete();
    }

    public function getGenerateSlugToProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $sigue=true;
        $rand_slug='';//la primera vez no generara nada, para conservar un slug mas limpio
        while($sigue){
            $tmp=$rand_slug;
            $tmp.= Str::slug($product->name);
            $existe=Product::where('slug',$tmp)->first();
            if(!$existe){
                $sigue=false;
                break;
            }
            $rand_slug = $this->generarRandSlug(5);
            $rand_slug .= '-';
        }
        return $tmp;
    }

    public function updateSlugProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
                'slug'=>['required','unique:products'],
            ],
            [
                'slug.required'=>'No se pueden guardar Slug vacios.',
                'slug.unique'=>'El Slug ya existe en la BD. Intente otro.',
        ]);
        $product = Product::findOrFail($request->id);
        $product->slug = $request->slug;
        $product->save();
    }

    public function updateBarcodeProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
                'barcode'=>['required','unique:products'],
            ],
            [
                'barcode.required'=>'No se pueden guardar codigos vacios.',
                'barcode.unique'=>'El codigo ya existe en la BD. Intente otro.',
        ]);
        $product = Product::findOrFail($request->id);
        $product->barcode = $request->barcode;
        $product->save();
    }

    public function updateQtySoldProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
                'qty_sold'=>['required'],
            ],
            [
                'qty_sold.required'=>'No se pueden guardar cantidades vacias.'
        ]);
        $product = Product::findOrFail($request->id);
        $product->qty_sold = $request->qty_sold;
        $product->save();
    }

    public function updateCategoryProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->category_id = $request->category_id;
        $product->save();
    }

    public function updateCourseProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->course_id = $request->course_id;
        $product->save();
    }

    public function updateCodeFactProduct(Request $request){
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);
        $product->code_fact = $request->code_fact;
        $product->save();
    }

    public function adminBarcodes(Request $request, $shop_id){

        $category_id= ($request->session()->has('category_id'))? $request->session()->get('category_id') : 0;

        $shop=Shop::find($shop_id);
        $categories=Category::where('shop_id',$shop_id)->get();

        if($category_id){
            $products=Product::where('category_id',$category_id)->get();
        }else{ $products=NULL; }

        $barcodes=[];

        foreach ($products as $product){
            //Si ya existe un barcode
            if($product->barcode!="0"){
                $barcodes[$product->id]=$product->barcode;
            }else{
                //Sino proponemos uno
                $sigue=true;
                $rand_barcode='';//la primera vez no generara nada, para conservar uno mas limpio
                while($sigue){
                    $current_timestamp = Carbon::now()->timestamp;

                    $tmp=$rand_barcode;
                    $tmp.= $current_timestamp.$product->id;
                    $existe=Product::where('barcode',$tmp)->first();
                    if(!$existe){
                        $sigue=false;
                        break;
                    }
                    $rand_barcode = $this->generarBarcode(1);
                }
                //
                $barcodes[$product->id]=$tmp;
            }

        }

        return view('admin.products.barcodes',[
            'shop'=>$shop,
            'products'=>$products,
            'categories'=>$categories,
            'category_id'=>$category_id,
            'barcodes'=>$barcodes,
        ]);
    }


}
