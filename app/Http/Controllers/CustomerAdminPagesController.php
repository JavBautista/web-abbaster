<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Course;
use App\PuchasesStatus;
use App\Customer;
use App\CustomerCourse;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Session;

class CustomerAdminPagesController extends Controller
{
    private function  getDescriptionStatus($id_status){
        $desc_status='';
        $status=PuchasesStatus::all();
        foreach ($status as $val) if($val->id == $id_status){
            $desc_status= $val->status;
            break;
        }//.if.foreach
        return $desc_status;
    }

    public function index(Request  $request){
    	$user_id = $request->user()->id;
    	$customer = Customer::where('user_id',$user_id)->first();
    	$datos_faltantes=($customer)?false:true;
    	return view('admin_customer.index',['datos_faltantes'=>$datos_faltantes]);
    }

    public function contactInformation(){
    	return view('admin_customer.contact_information.index');
    }

    public function contactInformationGet(Request $request){
        $user_id = $request->user()->id;
        $customer = Customer::where('user_id',$user_id)->first();
        return $customer;
    }

    public function purchases(Request $request){
        $status=PuchasesStatus::all();
        $user_id = $request->user()->id;
        $customer = Customer::where('user_id',$user_id)->first();
        $purchases=$customer->purchases;
        return view('admin_customer.purchases.index',[
            'purchases'=>$purchases,
            'status'=>$status,
        ]);

    }

    public function purchaseView(Request $request, $purchase_id){
        //dd($purchase_id);

        $purchase = Purchase::find($purchase_id);
        $customer = $purchase->customer;
        $sale_status= $this->getDescriptionStatus($purchase->status);
        return view('admin_customer.purchases.view_purchase',[
            'purchase'=>$purchase,
            'customer'=>$customer,
            'sale_status'=>$sale_status,
        ]);

    }

    public function purchasesReloadShoppingCart(Request $request, $purchase_id){
        //Borramos datos existentes de la Session
        Cart::destroy();
        Session::forget('session_discount_code');
        Session::forget('session_type_discount');
        Session::forget('session_discount');
        Session::forget('customer_id');
        Session::forget('shop_id');
        Session::forget('purchase_id');
        Session::forget('discount_admin');
        //---------------------------------------

        $purchase = Purchase::find($purchase_id);

        //Obtenemos la descripcion de la tienda
        $TIENDA=NULL;
        switch ($purchase->shop->id) {
            case 1: $TIENDA='eagletekmexico'; break;
            case 2: $TIENDA='ziotrobotik'; break;
            case 3: $TIENDA='solartek'; break;
            default: $TIENDA=NULL; break;
        }

        //Creamos una nueva instancia del ShoppingCart
        foreach ($purchase->PurchaseDetail as $product){
            Cart::add($product->product_id, $product->name, $product->qty, $product->price,
                [
                    'key' => $product->key,
                    'stock_exhibition' =>0,
                ]
            );
        }

        //creamos unas variables de session para controlar la compra y que no vaya a dubplicar la orden de compra

        Session::put('discount_admin', $purchase->discount);
        Session::put('customer_id', $purchase->customer_id);
        Session::put('shop_id', $purchase->shop_id);
        Session::put('purchase_id', $purchase->id);

        return redirect("/".$TIENDA."/shopping-cart/payment");
    }



    public function messages(Request $request){
        $user_id = $request->user()->id;
        return view('admin_customer.messages.index',['user_id'=>$user_id]);
    }


    public function courses(Request $request){
        $user_id  = $request->user()->id;
        $customer = Customer::where('user_id',$user_id)->first();
        $courses  = CustomerCourse::with('course')->where('customer_id',$customer->id)->get();
        return view('admin_customer.courses.index',['courses'=>$courses]);
    }

    public function course($course_id){
        return view('admin_customer.courses.course',['course_id'=>$course_id]);
    }
}
