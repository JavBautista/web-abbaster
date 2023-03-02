<?php

namespace App\Http\Controllers;


use App\PurchaseOrder;
use App\StatusPurchaseOrder;
use App\Mail\PurchaseOrderCreated;
use App\PurchaseOrderDetail;
use App\InventoryProduct;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class PurchaseOrdersController extends Controller
{
    public function index(){
    	$purchase_orders=PurchaseOrder::orderBy('id','desc')->get();
    	return view('admin.purchase_orders.index',['purchase_orders'=>$purchase_orders]);
    }

    public function  create(){

    	$start_date = Carbon::now();
        $start_date = $start_date->format('m/d/Y');
    	return view('admin.purchase_orders.create',[
    		'start_date'=>$start_date,
    	]);
    }

    public function store(Request $request){

    	//dd($request);
        $user_created = $request->user()->name;

        $this->validate($request,[
                'proveedor'=>['required'],
                'precio_dolar'=>['required','min:0'],
                'fecha_entrega_estimada'=>['required','date_format:m/d/Y'],
            ],
            [
                'proveedor.required'=>'Ingrese información.',
                'precio_dolar.required'=>'Por favor, ingrese un monto.',
                'precio_dolar.min'=>'El monto debe ser mayor a 0.',
                'fecha_entrega_estimada.required'=>'Por favor, seleccione una fecha.',
                'fecha_entrega_estimada.date_format'=>'Por favor, seleccione una fecha de inicio con formato correcto.',

        ]);

        $format = 'm/d/Y';
        $input_date  = $request->input('fecha_entrega_estimada');
        $date = Carbon::createFromFormat($format, $input_date);

        $purchase_order = PurchaseOrder::create([
			'estatus'=> 'creado',
			'proveedor'=> $request->input('proveedor'),
			'folio_proveedor'=> $request->input('folio_proveedor'),
			'precio_dolar'=> $request->input('precio_dolar'),
			'fecha_entrega_estimada'=> $date,
			'observaciones'=> $request->input('observaciones'),
			'user_created'=> $user_created,
        ]);

        //dd($purchase_order);
        //Mail::to('jav.bautista@gmail.com')->send(new PurchaseOrderCreated);

        Session::flash('alert', 'Orden de compra creada correctamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/dashboard/purchase-orders');
    }

    public function show(Request $request,$purchase_order_id){
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_id);
        if($request->ajax()){
            return $purchase_order;
        }

        $purchase_order_detail = PurchaseOrderDetail::where('purchase_order_id',$purchase_order_id)->get();

        return view('admin.purchase_orders.show',[
            'purchase_order'=>$purchase_order,
            'purchase_order_detail'=>$purchase_order_detail,
        ]);
    }


    public function editStatus($purchase_order_id){
        $statuses = StatusPurchaseOrder::all();
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_id);
        return view('admin.purchase_orders.edit_status',
            [
                'purchase_order'=>$purchase_order,
                'statuses'=>$statuses,
            ]);
    }

    public function editFechaReal($purchase_order_id){
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_id);
        return view('admin.purchase_orders.edit_fecha_entrega_real',['purchase_order'=>$purchase_order]);
    }


    public function updateFechaEntregaReal(Request $request){
        dd($request);
    }

    public function edit($purchase_order_id){
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_id);
        return view('admin.purchase_orders.edit',['purchase_order'=>$purchase_order]);
    }

    public function surtir($purchase_order_id){
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_id);
        return view('admin.purchase_orders.surtir',['purchase_order'=>$purchase_order]);
    }


    public function updateStatus(Request $request){
        if(!$request->ajax()) return redirect('/');
        $purchase_order = PurchaseOrder::findOrFail($request->id);
        $purchase_order->estatus = $request->estatus;
        $purchase_order->save();
    }

    public function storeInventory(Request $request){
        $product = Product::findOrFail($request->product_id);
        $shop_id = $product->category->shop->id;
        $description='Inventario '.$product->name.' Tienda '.$product->category->shop->name.' OC '.$request->purchase_order_id;
        $inventory = InventoryProduct::create([
            'shop_id'=> $shop_id,
            'product_id'=> $product->id,
            'description'=> $description,
            'stock'=> $request->stock,
            'total'=> $request->stock,
            'warehouse_id'=> $request->warehouse_id,
            'purchase_order_id'=> $request->purchase_order_id,
        ]);

    }


}
