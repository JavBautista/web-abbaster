<?php

namespace App\Http\Controllers;

use App\Product;
use App\InventoryProduct;
use App\Proveedor;
use App\Shop;
use App\Category;
use Illuminate\Http\Request;


class InventoriesProductController extends Controller
{
    public function index($shop_id,$product_id){
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);

        $inventories= InventoryProduct::where('product_id',$product_id)->get();

        $stock_total=0;
        foreach ($inventories as $data) {
        	$stock_total+=$data['stock'];
        }


        return view('admin.products.inventories.index',[
            'shop'=>$shop,
            'product'=>$product,
            'inventories'=>$inventories,
            'stock_total'=>$stock_total,
        ]);
    }

    public function getInventoryProduct(Request $request, $product_id){
        if(!$request->ajax()) return redirect('/');
        $inventories= InventoryProduct::where('product_id',$product_id)->get();
        return $inventories;
    }

    public function add($shop_id,$product_id){
    	$shop=Shop::find($shop_id);
        $product= Product::find($product_id);
		return view('admin.products.inventories.add',[
            'shop'=>$shop,
            'product'=>$product,
        ]);
	}

	public function store(Request $request){
        $shop_id=$request->input('shop_id');
        $product_id=$request->input('product_id');

        $product = InventoryProduct::create([
            'shop_id'=> $request->input('shop_id'),
            'product_id'=> $request->input('product_id'),
            'description'=> $request->input('description'),
            'stock'=> $request->input('stock'),
            'total'=> $request->input('stock'),
        ]);
        return redirect("/dashboard/store/".$shop_id."/products/inventories/".$product_id);
    }

    public function storeExhibition(Request $request){

        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
                'exhibition'=>['required'],
            ],
            [
                'exhibition.required'=>'Ingrese No de Piezas.',
        ]);

        $product_id=$request->product_id;
        $product= Product::findOrFail($product_id);
        InventoryProduct::create([
            'shop_id'=> $product->category->shop->id,
            'product_id'=> $product_id,
            'description'=> 'Stock General',
            'exhibition'=> $request->exhibition,
            'total'=> $request->exhibition,
            'warehouse_id'=>0,
            'purchase_order_id'=>0,
        ]);

    }
    public function updateExhibition(Request $request){
        if(!$request->ajax()) return redirect('/');

        $inventory= InventoryProduct::findOrFail($request->inv_id);
        $new_total=0;
        if ($inventory) {
            $new_total= $inventory->stock+$inventory->defective+$inventory->lost+$inventory->sale+$request->ex;
            $inventory->exhibition = $request->ex;
            $inventory->total = $new_total;
            $inventory->save();
        }

    }

    public function edit($shop_id,$product_id,$inventory_id){
        $inventory = InventoryProduct::find($inventory_id);
        $shop=Shop::find($shop_id);
        $product= Product::find($product_id);
        return view('admin.products.inventories.edit',[
            'shop'=>$shop,
            'product'=>$product,
            'inventory'=>$inventory,
        ]);
    }

    public function update(Request $request)
    {
        $shop_id=$request->input('shop_id');
        $product_id=$request->input('product_id');
        $inventory_id=$request->input('inventory_id');

        $inventory = InventoryProduct::find( $inventory_id );
        //Valores actuales an la BD
        $stock      = $inventory->stock;
        $exhibition = $inventory->exhibition;
        $disponibles = $stock+$exhibition;

        //Valores nuevos para la BD
        $new_exhibition = $request->input('exhibition');

        if($new_exhibition!=$exhibition){
            $inventory->exhibition  = $new_exhibition;
            $inventory->stock       = ($disponibles-$new_exhibition);
            $inventory->save();
        }

        return redirect("/dashboard/store/".$shop_id."/products/inventories/".$product_id.'/edit/'.$inventory_id)->with('succes', 'Actualización correcta!');
    }


}
