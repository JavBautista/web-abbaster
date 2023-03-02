<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Shop;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Facades\Session;


class CategoriesController extends Controller
{
    public function index($shop_id)
    {          
    	$shop=Shop::find($shop_id);
        $categories = Category::where('shop_id',$shop_id)->orderBy('order_by', 'asc')->paginate(10);

        #arreglo especial para guardar los nombres de las raices
        $array_roots=array();
        //recorremos el arreglo de actegorias
        foreach($categories as $category) {
            //Por cada categoria creamos un item con una cadena vacia
            $array_roots[$category->id]='';
            //si el root de la categoria es es porque es padre y no hay mas que hacer
            if($category->root == 0 ) continue;
            //Si existe un root buscaremos su numbre recorriendo nuevamente todo el array de categorias
            foreach($categories as $category_root){
                //Una vez enonctrado el nombre de la categoria root
                if($category->root == $category_root->id){
                    $array_roots[$category->id]=$category_root->name;
                    continue;
                }
            }
        }    

        return view('admin.categories.index',[
            'shop'=>$shop,
            'categories'=>$categories,
            'array_roots'=>$array_roots,
        ]);        
    }

    public function view($category_id){
        $category=Category::find($category_id);
        $root_category_id=$category->root;
        $root_category=Category::find($root_category_id);
        return view('admin.categories.view',[
            'category'=>$category,          
            'root_category'=>$root_category,          
        ]);   
    }

    public function add($shop_id){
        $shop=Shop::find($shop_id);
        $categories = Category::where('shop_id',$shop_id)->get();        
        return view('admin.categories.add',[
            'shop'=>$shop,  
            'categories'=>$categories,          
        ]);   

    } 

    public function edit($category_id){
        $category=Category::find($category_id);
        $shop_id=$category->shop->id;
        $categories = Category::where('shop_id',$shop_id)->get();        
        return view('admin.categories.edit',[
            'category'=>$category,
            'categories'=>$categories,          
        ]);   

    }

    public function image($category_id){
        $category=Category::find($category_id);
         $shop=$category->shop;
        return view('admin.categories.image',[
            'shop'=>$shop,  
            'category'=>$category,
        ]);   

    }

    public function editStatus($category_id){
        $category=Category::find($category_id);                
        return view('admin.categories.edit_status',[
            'category'=>$category,          
        ]);   

    }

    public function remove($category_id){
        $category=Category::find($category_id);                
        return view('admin.categories.remove',[
            'category'=>$category,          
        ]);   

    }
    

    public function create(CreateCategoryRequest $request,$shop_id){
        $image = $request->file('image');
        $category = Category::create([
            'name'=>$request->input('name'),
            'description'=>$request->input('description'),
            'status'=>$request->input('status'),
            'image'=> $image->store('categories','public'),
            'root'=>$request->input('root'),
            'shop_id'=>$shop_id,
        ]);

        return redirect("/dashboard/store/$shop_id/categories");
    }
    
    public function update(UpdateCategoryRequest $request){

        $category = Category::find($request->input('category_id'));
        $category->name=$request->input('name');
        $category->description=$request->input('description');
        $category->status=$request->input('status');
        $category->root=$request->input('root');        
        $category->save();

        return redirect("/dashboard/store/".$category->shop->id."/categories");
        
    }

    public function updateStatus(Request $request){
        $category = Category::find($request->input('category_id'));
        $category->status=$request->input('status');
        $category->save();
        return redirect("/dashboard/store/".$category->shop->id."/categories");    
    }

    public function delete(Request $request){
        $category = Category::find($request->input('category_id'));
        $shop_id=$category->shop->id;
        $category->delete();
        return redirect("/dashboard/store/".$shop_id."/categories");    
    }

    public function updateMainImage(Request $request){
        $shop_id = $request->input('shop_id');
        $category_id = $request->input('category_id');
        
        if($request->hasFile('main_image')){
            $category = Category::find($category_id);
            $category->image = $request->file('main_image')->store('categories', 'public');
            $category->save();
        }

        return redirect("/dashboard/store/".$shop_id."/categories");
    }

    private function generarRandSlug($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};            
        return $key;      
    }

    public function adminSlugs($shop_id){
        $shop=Shop::find($shop_id);
        $categories = Category::where('shop_id',$shop_id)->get();

        $slugs=[];
        foreach ($categories as $category){
            //Si ya existe un Slug
            if($category->slug){
                $slugs[$category->id]=$category->slug;
            }else{
                //Sino proponemos uno
                $sigue=true;
                $rand_slug='';//la primera vez no generara nada, para conservar un slug mas limpio
                while($sigue){
                    $tmp=$rand_slug;
                    $tmp.= Str::slug($category->name);
                    
                    $existe=Category::where('slug',$tmp)->first();
                    if(!$existe){
                        $sigue=false;
                        break;
                    }
                    
                    $rand_slug = $this->generarRandSlug(5);
                    $rand_slug .= '-';
                }
                //                
                $slugs[$category->id]=$tmp;
            }

        }        

        return view('admin.categories.slugs',[
            'shop'=>$shop,
            'categories'=>$categories,
            'slugs'=>$slugs,
        ]);   
    }

    public function updateSlug(Request $request){
        $category_id = $request->input('category_id');
        $slug = $request->input('slug');

        $this->validate($request,[
                'slug'=>['required','unique:categories'],
            ],
            [
                'slug.required'=>'No se pueden guardar Slug vacios.',
                'slug.unique'=>'El Slug: '.$slug.' ya existe en la BD. Intente otro.',
        ]);
        $category=Category::find($category_id);
        $category->slug = $slug;
        $category->save();

        Session::flash('alert', 'Slug para '.$category->name.'actualizado correctamnente ');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/categories/slugs/".$category->shop_id);
    }

    public function adminOrderBy($shop_id){
        $shop=Shop::find($shop_id);
        $categories = Category::where('shop_id',$shop_id)->orderBy('order_by', 'asc')->get();

        $ordena=false;
        foreach ($categories as $category){
            if($category->order_by==0) $ordena=true;
        }
        
        if($ordena){
            $cont=0;
            foreach ($categories as $category) {                
                $cont++;
                $category_item = Category::find($category->id);
                $category_item->order_by=$cont;
                $category_item->save();
            }
            $categories=Category::where('shop_id',$shop_id)->orderBy('order_by', 'asc')->get();
        }
        
         return view('admin.categories.order_by',[
            'shop'=>$shop,
            'categories'=>$categories,
        ]);
    }

    public function updateOrderBy(Request $request){
        
        $category_id = $request->input('category_id');
        $command = $request->input('command');

        $category_update=Category::find($category_id);
        $category_orden_actual=$category_update->order_by;
        $shop_id=$category_update->shop_id;
          
        $categories=Category::where('shop_id',$shop_id)->orderBy('order_by', 'asc')->get();
        $count=$categories->count();
        
        if($command=='up'){
            //Si es UP pero el actual es 1 nada que hacer
            if($category_orden_actual!=1){
                //Localizamos el producto con el num orden antes del que queremos cambiar
                foreach ($categories as $category) {
                    if($category->order_by==$category_orden_actual-1){
                        $category->order_by = $category_orden_actual;
                        $category->save();
                        $category_update->order_by=$category_orden_actual-1;
                        $category_update->save();
                        break;
                    }
                }
            }

        }else if($command=='down'){
            //Si es DOWN pero el actual es el ultimo nada que hacer
            if($category_orden_actual!=$count){
                //Localizamos el producto con el num orden despues del que queremos cambiar
                foreach ($categories as $category) {
                    if($category->order_by==$category_orden_actual+1){
                        $category->order_by = $category_orden_actual;
                        $category->save();
                        $category_update->order_by=$category_orden_actual+1;
                        $category_update->save();
                        break;
                    }
                }
            }
        }//if-else command
     

        Session::flash('alert', 'Orden actualizado correctamnente ');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/categories/order-by/$shop_id");

    }

}
