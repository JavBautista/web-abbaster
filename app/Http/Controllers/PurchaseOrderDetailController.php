<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrderDetail;
use App\PurchaseOrder;
use App\Shop;
use App\Category;
use App\Product;
use App\InventoryProduct;

class PurchaseOrderDetailController extends Controller
{

    public function index(Request $request,$po_id)
    {
        if(!$request->ajax()) return redirect('/');
        $articulos= PurchaseOrderDetail::where('purchase_order_id',$po_id)->get();
        return $articulos;
    }

    public function getProductsAndInventories(Request $request,$po_id)
    {
        if(!$request->ajax()) return redirect('/');
        $registros_po= PurchaseOrderDetail::where('purchase_order_id',$po_id)->get();
        $inventories=[];
        foreach ($registros_po as $reg_po) {
            $reg = InventoryProduct::where([
                ['product_id','=',$reg_po->product_id],
                ['purchase_order_id','=',$po_id],
            ])->get();
            $inventories[$reg_po->id] = $reg; //OJO no es el ID del Producto sino del REG del PO
        }

        return [
            'articulos'=>$registros_po,
            'inventories'=>$inventories
        ];

    }

    public function infoPO(Request $request,$po_id)
    {
        if(!$request->ajax()) return redirect('/');
        $po=PurchaseOrder::findOrFail($po_id);
        return $po;
    }

    public function getShops(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $shops= Shop::where('status',0)->get();
        return $shops;
    }

    public function getCategories(Request $request,$shop_id)
    {
        if(!$request->ajax()) return redirect('/');
        $cetegories= Category::where('shop_id',$shop_id)->get();
        return $cetegories;
    }
    public function getProducts(Request $request, $category_id)
    {
        if(!$request->ajax()) return redirect('/');
        $products= Product::where('category_id',$category_id)->get();
        return $products;
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->product_id);
        $item_PO = new PurchaseOrderDetail;
        $item_PO->product = $product->name;
        $item_PO->product_id = $product->id;
        $item_PO->qty = 1;
        $item_PO->cost = 0;
        $item_PO->status = 'pendiente';
        $item_PO->purchase_order_id = $request->purchase_order_id;
        $item_PO->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = PurchaseOrderDetail::findOrFail($request->id);
        $articulo->product = $request->product;
        $articulo->qty = $request->qty;
        $articulo->cost = $request->cost;
        $articulo->save();
    }

    public function updateQty(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = PurchaseOrderDetail::findOrFail($request->id);
        $articulo->qty = $request->qty;
        $articulo->save();
    }

    public function updateCost(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = PurchaseOrderDetail::findOrFail($request->id);
        $articulo->cost = $request->cost;
        $articulo->save();
    }


    public function deleteProductPo(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = PurchaseOrderDetail::findOrFail($request->id);
        $articulo->delete();
    }

    public function updateInfoPO(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $po = PurchaseOrder::findOrFail($request->id);
        $po->folio_proveedor= $request->folio_proveedor;
        $po->proveedor= $request->proveedor;
        $po->precio_dolar= $request->precio_dolar;
        $po->observaciones= $request->observaciones;
        $po->fecha_entrega_estimada= $request->fecha_entrega_estimada;
        $po->fecha_entrega_real= $request->fecha_entrega_real;
        $po->save();
    }

}
