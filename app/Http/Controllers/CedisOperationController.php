<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrderDetail;
use App\PurchaseOrder;
use App\Product;

class CedisOperationController extends Controller
{
    public function index(){
    	return view ('admin.cedis.operation.index');
    }

    public function recepcionIndex(){
    	return view ('admin.cedis.operation.recepcion.index');
    }

    public function getOC(Request $request,$oc_id){
    	if(!$request->ajax()) return redirect('/');
        $oc=PurchaseOrder::with('PurchaseOrderDetail')->find($oc_id);
        $products_detail=$oc->PurchaseOrderDetail;
        $arrayBarcodes=[];
        foreach ($products_detail as $detail) {
            $product=Product::find($detail->product_id);
            $barcode = ($product)? $product->barcode : 0;
            $arrayBarcodes[$detail->product_id]=$barcode;
        }
        return [
            'barcodes'=>$arrayBarcodes,
            'oc'=>$oc,
        ];
    }


}
