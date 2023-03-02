<?php


namespace App;
namespace App\Http\Controllers;

use App\Http\Requests\SaveCustomerPurchaseRequest;
use Illuminate\Http\Request;
use Cart;
use App\Shipping;
use App\Purchase;
use App\PurchaseDetail;
use App\Customer;
use App\CustomerShippingAddresses;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\PurchaseNotification;
use App\DiscountCode;
use App\Estado;
use App\Municipio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Shop;



class ShoppingCartController extends Controller
{
    private $EAGLETEK_ID=1;
    private $ZIOTROBOTIK_ID=2;

    private function fechaEnRango($fecha_inicial,$fecha_final){

        $ahora=date('Y-m-d H:i:s');
        if (($ahora >= $fecha_inicial)&&($ahora <= $fecha_final) )
            return true;
        return false;
    }

    private function porcentaje($cantidad,$porciento,$decimales=2) {
        return round($cantidad*$porciento/100 ,$decimales);
    }




    public function indexEagletek(Request $request){
            return view('eagletek.shopping_cart');
    }
    public function indexZiotrobotik(){
        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $config_shipping=Shipping::find($this->ZIOTROBOTIK_ID);

    	$cart = Cart::content();
        $subtotal=Cart::subtotal();
        $tax=Cart::tax();
        $total=str_replace(',', '', Cart::total());
        $shipping=0;
        if($total>0){
            if($total< $config_shipping->shipping_from){
                $shipping=$config_shipping->shipping_cost;
                $total+=$shipping;
            }
            if($existe_codigo){
                if($session_type_discount=='monto'){
                    $total-=  $session_discount;
                }else if($session_type_discount=='porcentaje'){
                    $tmp = $this->porcentaje($total,$session_discount,2);
                    $total-=  $tmp;
                }
            }
            $total =number_format($total,2);
            $shipping =number_format($shipping,2);
        	return view('ziotrobotik.shopping_cart',[
                'cart'=>$cart,
                'subtotal'=>$subtotal,
                'tax'=>$tax,
                'total'=>$total,
                'shipping'=>$shipping,
                'config_shipping'=>$config_shipping,
                'existe_codigo'=>$existe_codigo,
                'session_type_discount'=>$session_type_discount,
                'session_discount'=>$session_discount,
                'session_discount_code'=>$session_discount_code,
            ]);
        }else{
            return redirect('/ziotrobotik/store');
        }
    }





    #POST ADD
    public function addToCart(Request $request){
        $tienda=$request->input('tienda');
        Cart::add($request->input('id'), $request->input('name'), $request->input('qty'), $request->input('price'),
            [
                'key' => $request->input('key'),
                'stock_exhibition' => $request->input('stock_exhibition'),
                'image' => $request->input('image'),
                'product_slug'=>$request->input('product_slug'),
                'shop_id' => $request->input('shop_id'),
                'shop_name' => $request->input('shop_name'),
                'shop_slug'=>$request->input('shop_slug'),
                'category_id'=>$request->input('category_id'),
                'category_name'=>$request->input('category_name'),
                'category_slug'=>$request->input('category_slug'),
            ]
        );
        return redirect('/'.$tienda.'/shopping-cart');
    }

    public function newAddToCart(Request $request){

        Cart::add($request->input('id'), $request->input('name'), $request->input('qty'), $request->input('price'),
            [
                'key' => $request->input('key'),
                'stock_exhibition' => $request->input('stock_exhibition'),
                'image' => $request->input('image'),
                'product_slug'=>$request->input('product_slug'),
                'shop_id' => $request->input('shop_id'),
                'shop_name' => $request->input('shop_name'),
                'shop_slug'=>$request->input('shop_slug'),
                'category_id'=>$request->input('category_id'),
                'category_name'=>$request->input('category_name'),
                'category_slug'=>$request->input('category_slug'),
            ]
        );
        return redirect('/shopping-cart');
    }

    public function checkAuthCustomer(Request $request, $name_shop){
        //si el usaurio es de tipo admin
        if($request->user()->hasRole('user')){
            $user_id = $request->user()->id;
            $customer = Customer::where('user_id',$user_id)->first();
            //si el usuario ya tiene datos de contacto optenemos dicho id
            if($customer){
                $request->session()->put('customer_id', $customer->id);
                return redirect("/".$name_shop."/shopping-cart/payment");
            }else{
                //Si aun tiene datos de contacto guardados lo llevamos a capturar dichos datos
                return redirect('/customer');
            }
        }
        return redirect("/");

    }

    public function saveDatosComprador(SaveCustomerPurchaseRequest $request){

        $TIENDA=$request->input('tienda');
        $cart = Cart::content();
        $subtotal= str_replace(",","",Cart::subtotal());
        $tax=  str_replace(",","",Cart::tax());
        $total= str_replace(",","", Cart::total() );
        if($total>0){
            //De momento el ID de la tienda lo detrminamos directamente
            $shop_id=0;
            switch ($TIENDA) {
                case 'eagletekmexico':  $shop_id=1; break;
                case 'ziotrobotik':     $shop_id=2; break;
                default:                $shop_id=0; break;
            }
            $customer = Customer::create([
                'mail'  => $request->input('mail'),
                'name'  => $request->input('name'),
                'phone'  => $request->input('phone'),
                'movil'  => $request->input('movil'),
                'zip_code' => $request->input('zip_code'),
                'address'  => $request->input('address'),
                'number_out'  => $request->input('number_out'),
                'number_int'  => $request->input('number_int'),
                'district' => $request->input('district'),
                'city'  => $request->input('city'),
                'state'  => $request->input('state'),
                'reference' => $request->input('reference'),
                'detail'  => $request->input('detail'),
                'user_id'  => 0,
            ]);
            $customer_id=$customer->id;
            $request->session()->put('customer_id', $customer_id);
            return redirect("/".$TIENDA."/shopping-cart/payment");
        }else{
            return redirect("/".$TIENDA."/store");
        }

    }

    public function paymentEagletek(Request $request){
        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }


        $config_shipping=Shipping::find($this->EAGLETEK_ID);
        $customer_id = ($request->session()->has('customer_id'))? $request->session()->get('customer_id') : 0;
        if($customer_id){
            $customer= Customer::find($customer_id);
            $cart = Cart::content();
            $subtotal= str_replace(",","",Cart::subtotal());
            $tax=  str_replace(",","",Cart::tax());
            $total= str_replace(",","", Cart::total() );
            $shipping=0;
            if($total>0){
                $shipping=($total<$config_shipping->shipping_from)?$config_shipping->shipping_cost:0;
                $total+=$shipping;
                if($existe_codigo){
                    if($session_type_discount=='monto'){
                        $total-=  $session_discount;
                    }else if($session_type_discount=='porcentaje'){
                        $tmp = $this->porcentaje($total,$session_discount,2);
                        $total-=  $tmp;
                    }
                }
                if(Session::has('discount_admin')){
                    $total -= Session::get('discount_admin');
                }
                //llamar a helper mercado pago
                $token_user = generate_token();
                $tienda='eagletekmexico';
                $url_mercadopago =  mercadoPago($cart, $total, $token_user,$tienda);
                //dd($url_mercadopago);
                return view('eagletek.finish_payment',[
                    'cart'=>$cart,
                    'subtotal'=>$subtotal,
                    'tax'=>$tax,
                    'total'=>$total,
                    'shipping'=>$shipping,
                    'customer'=>$customer,
                    'url_mercadopago' => $url_mercadopago,
                    'config_shipping' => $config_shipping,
                    'existe_codigo'=>$existe_codigo,
                    'session_type_discount'=>$session_type_discount,
                    'session_discount'=>$session_discount,
                    'session_discount_code'=>$session_discount_code,
                ]);

            }else{
                return redirect("/eagletekmexico/store");
            }
        }else{
            return redirect("/eagletekmexico/shopping-cart");
        }

    }
    public function paymentZiotrobotik(Request $request){
        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $config_shipping=Shipping::find($this->ZIOTROBOTIK_ID);
        $customer_id = ($request->session()->has('customer_id'))? $request->session()->get('customer_id') : 0;
        if($customer_id){
            $customer= Customer::find($customer_id);
            $cart = Cart::content();
            $subtotal= str_replace(",","",Cart::subtotal());
            $tax=  str_replace(",","",Cart::tax());
            $total= str_replace(",","", Cart::total() );
            $shipping=0;
            if($total>0){
                $shipping=($total<$config_shipping->shipping_from)?$config_shipping->shipping_cost:0;
                $total+=$shipping;

                if($existe_codigo){
                    if($session_type_discount=='monto'){
                        $total-=  $session_discount;
                    }else if($session_type_discount=='porcentaje'){
                        $tmp = $this->porcentaje($total,$session_discount,2);
                        $total-=  $tmp;
                    }
                }
                if(Session::has('discount_admin')){
                    $total -= Session::get('discount_admin');
                }

                //llamar a helper mercado pago
                $token_user = generate_token();
                //dd($cart);
                $tienda='ziotrobotik';
                $url_mercadopago =  mercadoPago($cart, $total, $token_user,$tienda);
                return view('ziotrobotik.finish_payment',[
                    'cart'=>$cart,
                    'subtotal'=>$subtotal,
                    'tax'=>$tax,
                    'total'=>$total,
                    'shipping'=>$shipping,
                    'customer'=>$customer,
                    'url_mercadopago' => $url_mercadopago,
                    'config_shipping' => $config_shipping,
                    'existe_codigo'=>$existe_codigo,
                    'session_type_discount'=>$session_type_discount,
                    'session_discount'=>$session_discount,
                    'session_discount_code'=>$session_discount_code,
                ]);

            }else{
                return redirect("/ziotrobotik/store");
            }
        }else{
            return redirect("/ziotrobotik/shopping-cart");
        }

    }

    # Clear()
    public function clearEagletek(){
        Cart::destroy();
        Session::forget('session_discount_code');
        Session::forget('session_type_discount');
        Session::forget('session_discount');
        return redirect('/eagletekmexico/shopping-cart');
    }
    public function clearZiotrobotik(){
    	Cart::destroy();
        Session::forget('session_discount_code');
        Session::forget('session_type_discount');
        Session::forget('session_discount');
    	return redirect('/ziotrobotik/shopping-cart');
    }


    #POSTS Updates



    public function updateCartQtyEagletek(Request $request){
        Cart::update($request->input('rowId'),$request->input('qty'));
        return redirect('/eagletekmexico/shopping-cart');
    }

    public function deleteToCartEagletek(Request $request){
        Cart::remove($request->input('rowId'));
        return redirect('/eagletekmexico/shopping-cart');
    }

    #POSTS Delete Items
    public function updateCartQtyZiotrobotik(Request $request){
        Cart::update($request->input('rowId'),$request->input('qty'));
        return redirect('/ziotrobotik/shopping-cart');
    }

    public function deleteToCartZiotrobotik(Request $request){
        Cart::remove($request->input('rowId'));
        return redirect('/ziotrobotik/shopping-cart');
    }


    #confirmPayments
    public function confirmPaymentEagletek(Request $request){
        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $config_shipping=Shipping::find($this->EAGLETEK_ID);

        $customer_id = ($request->session()->has('customer_id'))? $request->session()->get('customer_id') : 0;
        if(!$customer_id){
            $cart       = Cart::content();
            $subtotal   = Cart::subtotal();
            $tax        = Cart::tax();
            $total      = str_replace(',', '', Cart::total());

            $shipping=0;
            if($total>0){
                if($total<$config_shipping->shipping_from){
                    $shipping=$config_shipping->shipping_cost;
                    $total+=$shipping;
                }
                if($existe_codigo){
                    if($session_type_discount=='monto'){
                        $total-=  $session_discount;
                    }else if($session_type_discount=='porcentaje'){
                        $tmp = $this->porcentaje($total,$session_discount,2);
                        $total-=  $tmp;
                    }
                }
                $total =number_format($total,2);
                $shipping =number_format($shipping,2);

                return view('eagletek.confirm_payment',[
                    'cart'=>$cart,
                    'subtotal'=>$subtotal,
                    'tax'=>$tax,
                    'total'=>$total,
                    'shipping'=>$shipping,
                    'config_shipping'=>$config_shipping,
                    'existe_codigo'=>$existe_codigo,
                    'session_type_discount'=>$session_type_discount,
                    'session_discount'=>$session_discount,
                    'session_discount_code'=>$session_discount_code,
                ]);

            }else{
                return redirect('/eagletekmexico/store');
            }
        }else{
            return redirect('/eagletekmexico/shopping-cart/payment');
        }
    }

    public function confirmPaymentZiotrobotik(Request $request){
        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $config_shipping=Shipping::find($this->ZIOTROBOTIK_ID);
        $customer_id = ($request->session()->has('customer_id'))? $request->session()->get('customer_id') : 0;
        if(!$customer_id){
            $cart = Cart::content();
            $subtotal=Cart::subtotal();
            $tax=Cart::tax();
            $total=str_replace(',', '', Cart::total());
            $shipping=0;
            if($total>0){
                if($total<$config_shipping->shipping_from){
                    $shipping=$config_shipping->shipping_cost;
                    $total+=$shipping;
                }
                if($existe_codigo){
                    if($session_type_discount=='monto'){
                        $total-=  $session_discount;
                    }else if($session_type_discount=='porcentaje'){
                        $tmp = $this->porcentaje($total,$session_discount,2);
                        $total-=  $tmp;
                    }
                }
                $total =number_format($total,2);
                $shipping =number_format($shipping,2);
                return view('ziotrobotik.confirm_payment',[
                    'cart'=>$cart,
                    'subtotal'=>$subtotal,
                    'tax'=>$tax,
                    'total'=>$total,
                    'shipping'=>$shipping,
                    'config_shipping'=>$config_shipping,
                    'existe_codigo'=>$existe_codigo,
                    'session_type_discount'=>$session_type_discount,
                    'session_discount'=>$session_discount,
                    'session_discount_code'=>$session_discount_code,
                ]);
            }else{
                return redirect('/ziotrobotik/store');
            }
        }else{
           return redirect('/ziotrobotik/shopping-cart/payment') ;
        }
    }

    public function paymentSuccessEagletek(Request $request){
        $purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;

        if($request->session()->has('purchase_id')){
          $request->session()->forget('purchase_id');
        }
        if($request->session()->has('customer_id')){
          $request->session()->forget('customer_id');
        }

        if($purchase_id){
            $purchase=Purchase::find($purchase_id);
            $receivers = $purchase->customer->mail;
            //Mail::to($receivers)->send(new PurchaseNotification($purchase));
            return view('eagletek.payment_success',[
                'purchase'=>$purchase,
            ]);
        }else{
            return redirect('/eagletekmexico');
        }
    }
    public function paymentSuccessZiotrobotik(Request $request){
        $purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;

        if($request->session()->has('purchase_id')){
          $request->session()->forget('purchase_id');
        }
        if($request->session()->has('customer_id')){
          $request->session()->forget('customer_id');
        }

        if($purchase_id){
            $purchase=Purchase::find($purchase_id);
            $receivers = $purchase->customer->mail;
            //Mail::to($receivers)->send(new PurchaseNotification($purchase));
            return view('ziotrobotik.payment_success',[
                'purchase'=>$purchase,
            ]);
        }else{
            return redirect('/ziotrobotik');
        }
    }

    public function paymentFinishEagletek(Request $request){
        if($request->session()->has('purchase_id')){
          $request->session()->forget('purchase_id');
        }
        if($request->session()->has('customer_id')){
          $request->session()->forget('customer_id');
        }
        return redirect('/eagletekmexico');
    }
    public function paymentFinishZiotrobotik(Request $request){
        if($request->session()->has('purchase_id')){
          $request->session()->forget('purchase_id');
        }
        if($request->session()->has('customer_id')){
          $request->session()->forget('customer_id');
        }
        return redirect('/ziotrobotik');
    }


    public function changeShowTax(Request $request){
        $show_tax=true;
        $val_tax=$request->input('select_show_tax');

        if($val_tax=='with_tax') $show_tax=true;
        if($val_tax=='tax_free') $show_tax=false;

        Session::put('show_tax', $show_tax);
        return back();
    }
    #POST getDiscountCode
    public function getDiscountCode(Request $request){

        $this->validate($request,[
                'discount_code'=>['required'],
            ],
            [
                'discount_code.required'=>'Por favor, ingrese un codigo de descuento valido.',
        ]);

        $exito=false;
        $error_msg='Error Desconocido';
        $tienda=$request->input('tienda');
        $input_discount_code=$request->input('discount_code');

        $discount_code = DiscountCode::where('code',$input_discount_code)->first();
        if($discount_code){
            if($discount_code->status==0){

                $vigencia= $this->fechaEnRango($discount_code->start_date,$discount_code->finish_date);
                if($vigencia){
                    if($discount_code->number_uses <= $discount_code->limit_uses){
                        $permitido=false;
                        switch ($discount_code->shop_id) {
                            case 0:
                                $permitido=true;
                                break;
                            case 1:
                                if($tienda=='eagletekmexico') $permitido=true;
                                break;
                            case 2:
                                if($tienda=='ziotrobotik') $permitido=true;
                                break;
                        }
                        if($permitido){

                            Session::put('session_discount_code', $discount_code->code);
                            Session::put('session_type_discount', $discount_code->type_discount);
                            Session::put('session_discount', $discount_code->discount);
                            $exito=true;

                        }else $error_msg='Codigo de Descuento Invalido.';

                    }else $error_msg='Numero de usos excedido.';

                }else $error_msg='Codigo de Descuento Sin Vigencia.';

            }else $error_msg='Codigo de Descuento Obsoleto.';

        }else $error_msg='Codigo de Descuento Invalido.';


        if($exito){
            Session::flash('alert', 'Codigo de Descuento Correcto. ');
            Session::flash('alert-class', 'alert-success');
            return redirect('/'.$tienda.'/shopping-cart');
        }

        Session::flash('alert', $error_msg);
        Session::flash('alert-class', 'alert-danger');
        return redirect('/'.$tienda.'/shopping-cart');

    }



    public function saveCompra(Request $request){

        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $cart = Cart::content();

        $subtotal= str_replace(",","",Cart::subtotal());
        $tax=  str_replace(",","",Cart::tax());
        $total= str_replace(",","", Cart::total() );


        $TIENDA=$request->input('tienda');
        $customer_id=$request->input('customer_id');
        //De momento el ID de la tienda lo detrminamos directament
        $shop_id=($TIENDA=='eagletekmexico')?1:2;

        $config_shipping=Shipping::find($shop_id);
        //Como el Shippping no viene dentro del carro de compras
        //Se lo sumamos manualmente al total
        $shipping=($total<$config_shipping->shipping_from)?$config_shipping->shipping_cost:0;
        $total+=$shipping;

        $monto_discount=0;
        if($existe_codigo){
            if($session_type_discount=='monto') $monto_discount = $session_discount;
            if($session_type_discount=='porcentaje') $monto_discount = $this->porcentaje($total,$session_discount,2);
            $total-=  $monto_discount;
        }

        $purchase = Purchase::create([
            'shop_id'=>$shop_id,
            'customer_id'=>$customer_id,
            'status'=>13, //Estatus 13 es solo Guardado
            'subtotal'=>$subtotal,
            'shipping'=>$shipping,
            'tax'=>$tax,
            'total'=>$total,
            'payment_method'=>'Guardado',
            'discount_code'=>$session_discount_code,
            'discount'=> $monto_discount,

        ]);

        $purchase_id = $purchase->id;
        $request->session()->put('purchase_id', $purchase_id);

        foreach($cart as $art){
            $purchase_detail=PurchaseDetail::create([
                'purchase_id' =>$purchase_id,
                'product_id'  =>$art->id,
                'key'         =>$art->options->key,
                'name'        =>$art->name,
                'qty'         =>$art->qty,
                'price'       =>$art->price,
                'type_price'  =>'retail',
            ]);
        }

        Cart::destroy();
        Session::forget('session_discount_code');
        Session::forget('session_type_discount');
        Session::forget('session_discount');
        Session::flash('alert', 'Compra Guardada Correctamente! En breve nos ponemos en contacto.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/'.$TIENDA.'/shopping-cart/payment-success');

    }
    #------------------------------------------------------------------------------------------------
    #------------------------------------------------------------------------------------------------
    # NUEVOS METODOS GENERALES PARA AXIOS
    #------------------------------------------------------------------------------------------------
    #------------------------------------------------------------------------------------------------
    public function getShoppingCart(){
        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $config_shipping=Shipping::find($this->EAGLETEK_ID);

        $cart = Cart::content();
        $subtotal=Cart::subtotal();
        $tax=Cart::tax();
        $total=str_replace(',', '', Cart::total());
        $shipping=0;

        if($total>0){

            if($total< $config_shipping->shipping_from){
                $shipping=$config_shipping->shipping_cost;
                $total+=$shipping;
            }
            if($existe_codigo){
                if($session_type_discount=='monto'){
                    $total-=  $session_discount;
                }else if($session_type_discount=='porcentaje'){
                    $tmp = $this->porcentaje($total,$session_discount,2);
                    $total-=  $tmp;
                }
            }
            $total =number_format($total,2);
            $shipping =number_format($shipping,2);
            return [
                'contenido'=>true,
                'cart'=>$cart,
                'subtotal'=>$subtotal,
                'tax'=>$tax,
                'total'=>$total,
                'shipping'=>$shipping,
                'config_shipping'=>$config_shipping,
                'existe_codigo'=>$existe_codigo,
                'session_type_discount'=>$session_type_discount,
                'session_discount'=>$session_discount,
                'session_discount_code'=>$session_discount_code,
            ];

        }
        return ['contenido'=>false];
    }



    public function searchDiscountCode(Request $request,$code){
        if(!$request->ajax()) return redirect('/');
        $exito=false;
        $error_msg='Error Desconocido';
        $discount_code = DiscountCode::where('code',$code)->first();
        if($discount_code){
            if($discount_code->status==0){
                $vigencia= $this->fechaEnRango($discount_code->start_date,$discount_code->finish_date);
                if($vigencia){
                    if($discount_code->number_uses <= $discount_code->limit_uses){
                            Session::put('session_discount_code', $discount_code->code);
                            Session::put('session_type_discount', $discount_code->type_discount);
                            Session::put('session_discount', $discount_code->discount);
                            $exito=true;
                    }else $error_msg='Numero de usos excedido.';
                }else $error_msg='Codigo de descuento sin vigencia.';
            }else $error_msg='Codigo de descuento obsoleto.';
        }else $error_msg='Codigo de descuento invalido.';

        return [
            'exito'=>$exito,
            'error_msg'=>$error_msg,
        ];

    }

    public function clearDiscountCode(Request $request){
        if(!$request->ajax()) return redirect('/');
        Session::forget('session_discount_code');
        Session::forget('session_type_discount');
        Session::forget('session_discount');
    }

    public function updateCartQty(Request $request){
        if(!$request->ajax()) return redirect('/');
        Cart::update($request->rowId,$request->qty);
    }

    public function deleteItem(Request $request){
        if(!$request->ajax()) return redirect('/');
        Cart::remove($request->rowId);

        /*$purchase_id =0;
        if(Session::has('purchase_id')){
            $purchase_id=Session::get('purchase_id');
        }*/

    }

    public function clearShoppingCart(Request $request){
        if(!$request->ajax()) return redirect('/');
        Cart::destroy();
        Session::forget('session_discount_code');
        Session::forget('session_type_discount');
        Session::forget('session_discount');
    }

    //METODOS PARA PASARELA DE PAGO

    public function checkLoggedInCustomer(Request $request){
        $check=false;
        $is_customer=false;
        $customer=null;
        $customer_shipping_addresses=null;
        $count_direcciones = 0;

        if(Auth::check()) {
            $check=true;
            if($request->user()->hasRole('user')){
                $is_customer=true;
                $customer= Customer::where('user_id', $request->user()->id)->first();
                if($customer){
                    $customer_shipping_addresses = CustomerShippingAddresses::where('customer_id',$customer->id)->get();
                    $count_direcciones=$customer_shipping_addresses->count();
                }
            }
        }
        return [
            'check'=>$check,
            'is_customer'=>$is_customer,
            'customer'=>$customer,
            'customer_shipping_addresses'=>$customer_shipping_addresses,
            'count_direcciones'=>$count_direcciones,
        ];
    }

    public function guardarDireccionEnvioCliente(Request $request){

        if(!$request->ajax()) return redirect('/');
        CustomerShippingAddresses::create([
            'customer_id'  => $request->customer_id,
            'active'  => 1,
            'name'  => $request->name,
            'phone'  => $request->phone,
            'movil'  => $request->movil,
            'zip_code' => $request->zip_code,
            'address'  => $request->address,
            'number_out'  => $request->number_out,
            'number_int'  => $request->number_int,
            'district' => $request->district,
            'city'  => $request->city,
            'state'  => $request->state,
            'reference' => $request->reference,
            'detail'  => $request->detail,
            'observations'  => '',
        ]);

    }

    public function getStates(Request $request){
        if(!$request->ajax()) return redirect('/');
        $states = Estado::all();
        return $states;
    }

    public function getCities(Request $request, $state_id){
        if(!$request->ajax()) return redirect('/');
        $cities = Municipio::where('estado_id',$state_id)->get();
        return $cities;
    }

    public function savePurchase(Request $request){

        $address_id = $request->address_id;
        $customer_id = $request->customer_id;

        $session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

        $cart = Cart::content();

        $subtotal= str_replace(",","",Cart::subtotal());
        $tax=  str_replace(",","",Cart::tax());
        $total= str_replace(",","", Cart::total() );


        //De momento el ID de la tienda lo detrminamos directament
        //$shop_id=($TIENDA=='eagletekmexico')?1:2;
        $shop_id=1;
        //--->OJO HAY QUE CAMBIAR SHIPPING DE LA TIENDA POR EL SHIPPING GENERAL
        $config_shipping=Shipping::find($shop_id);
        //Como el Shippping no viene dentro del carro de compras
        //Se lo sumamos manualmente al total
        $shipping=($total<$config_shipping->shipping_from)?$config_shipping->shipping_cost:0;
        $total+=$shipping;

        $monto_discount=0;
        if($existe_codigo){
            if($session_type_discount=='monto') $monto_discount = $session_discount;
            if($session_type_discount=='porcentaje') $monto_discount = $this->porcentaje($total,$session_discount,2);
            $total-=  $monto_discount;
        }

        $address=CustomerShippingAddresses::find($address_id);

        $purchase_id =0;
        if(Session::has('purchase_id')){
            $purchase_id=Session::get('purchase_id');
        }

        //NO EXISTE UN COMPRA
        if($purchase_id==0){

            $purchase = Purchase::create([
                'shop_id'=>$shop_id,
                'customer_id'=>$customer_id,
                'status'=>13, //Estatus 13 es solo Guardado
                'subtotal'=>$subtotal,
                'shipping'=>$shipping,
                'tax'=>$tax,
                'total'=>$total,
                'payment_method'=>'Guardado',
                'discount_code'=>$session_discount_code,
                'discount'=> $monto_discount,

                'name'=> $address->name,
                'phone'=> $address->phone,
                'movil'=> $address->movil,
                'zip_code'=> $address->zip_code,
                'address'=> $address->address,
                'number_out'=> $address->number_out,
                'number_int'=> $address->number_int,
                'district'=> $address->district,
                'city'=> $address->city,
                'state'=> $address->state,
                'reference'=> $address->reference,
                'detail'=> $address->detail,

            ]);

            $purchase_id = $purchase->id;
            $request->session()->put('purchase_id', $purchase_id);

        }else{
        //Ya existe la compra guardada la actualizamos
            $purchase = Purchase::find($purchase_id);

            $purchase->status=13; //Estatus 13 es solo Guardado
            $purchase->subtotal=$subtotal;
            $purchase->shipping=$shipping;
            $purchase->tax=$tax;
            $purchase->total=$total;
            $purchase->payment_method='Guardado';
            $purchase->discount_code=$session_discount_code;
            $purchase->discount= $monto_discount;

            $purchase->name= $address->name;
            $purchase->phone= $address->phone;
            $purchase->movil= $address->movil;
            $purchase->zip_code= $address->zip_code;
            $purchase->address= $address->address;
            $purchase->number_out= $address->number_out;
            $purchase->number_int= $address->number_int;
            $purchase->district= $address->district;
            $purchase->city= $address->city;
            $purchase->state= $address->state;
            $purchase->reference= $address->reference;
            $purchase->detail= $address->detail;
            $purchase->save();

            PurchaseDetail::where('purchase_id',$purchase_id)->delete();
            //$detalle->delete();
        }

        foreach($cart as $art){
            $purchase_detail=PurchaseDetail::create([
                'purchase_id' =>$purchase_id,
                'product_id'  =>$art->id,
                'key'         =>$art->options->key,
                'name'        =>$art->name,
                'qty'         =>$art->qty,
                'price'       =>$art->price,
                'type_price'  =>'retail',
            ]);
        }
        return $purchase_id;
    }


    public function paymentSuccessGral(Request $request){
        $shops   = Shop::where('status',0)->get();
        $purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;

        if($request->session()->has('purchase_id')){
          $request->session()->forget('purchase_id');
        }
        if($request->session()->has('customer_id')){
          $request->session()->forget('customer_id');
        }

        if($purchase_id){
            $purchase=Purchase::find($purchase_id);
            //$receivers = $purchase->customer->mail;
            //Mail::to($receivers)->send(new PurchaseNotification($purchase));
            return view('payment_success',[
                'purchase'=>$purchase,
                'shops'=>$shops,
            ]);
        }else{
            return redirect('/');
        }
    }

     public function paymentFinishGral(Request $request){
        if($request->session()->has('purchase_id')){
          $request->session()->forget('purchase_id');
        }
        if($request->session()->has('customer_id')){
          $request->session()->forget('customer_id');
        }
        return redirect('/');
    }
}
