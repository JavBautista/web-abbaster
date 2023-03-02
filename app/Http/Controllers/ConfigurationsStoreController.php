<?php

namespace App\Http\Controllers;

use App\Shop;
use App\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfigurationsStoreController extends Controller
{


    public function editShipping($shop_id){

    	$shop=Shop::find($shop_id);
		$shipping = Shipping::find($shop_id);

    	$tipo_shipping= $shipping?'update':'add';
    	$shipping_cost=0;
    	$shipping_from=0;
    	$shipping_id=0;
    	if($shipping){
    		$shipping_cost=$shipping->shipping_cost;
    		$shipping_from=$shipping->shipping_from;
    		$shipping_id=$shipping->id;
    	}

    	return view('admin.configurations.edit_shipping',[
    		'shop'=>$shop,
    		'shipping_id'=>$shipping_id,
    		'tipo_shipping'=>$tipo_shipping,
    		'shipping_cost'=>$shipping_cost,
    		'shipping_from'=>$shipping_from,

    	]);
    }

    public function updateShipping(Request $request){
    	$this->validate($request,[
    			'shipping_cost'=>['required','max:999'],
    			'shipping_from'=>['required','max:999'],
    		],
    		[
    			'shipping_cost.required'=>'Por favor, ingrese un monto.',
    			'shipping_cost.max'=>'El titulo no debe ser mayor a 999.',
    			'shipping_from.required'=>'Por favor, ingrese un monto.',
    			'shipping_from.max'=>'El titulo no debe ser mayor a 999.',
    	]);

    	$shop_id=$request->input('shop_id');
    	if($request->input('tipo_shipping')=='add'){
    		
    		$shipping = Shipping::create([	           
	            'shop_id'=>$request->input('shop_id'),
	            'shipping_cost'=>$request->input('shipping_cost'),
	            'shipping_from'=>$request->input('shipping_from'),	            
        	]);
        	Session::flash('alert', 'Shipping actualizado satisfactoriamente!');
			Session::flash('alert-class', 'alert-success');
	    	return redirect("/dashboard/store/$shop_id/configurations/actualizar");

    	}else{

    		$shipping = Shipping::find($request->input('shipping_id'));
	        $shipping->shipping_cost=$request->input('shipping_cost');
	        $shipping->shipping_from=$request->input('shipping_from');
	        $shipping->save();
	        Session::flash('alert', 'Shipping actualizado satisfactoriamente!');
			Session::flash('alert-class', 'alert-success');
	    	return redirect("/dashboard/store/$shop_id/configurations/actualizar");
    	}//if-else
    	
    	Session::flash('alert', 'Ocurrió un error al intentar guardar. Inténtelo nuevamente o consulte al administrador del sistema.');
		Session::flash('alert-class', 'alert-danger');
    	return redirect("/dashboard/store/$shop_id/configurations/actualizar");
    }

    public function editInformation($shop_id){
    	$shop=Shop::find($shop_id);
    	return view('admin.configurations.edit_information',['shop'=>$shop]);
    }

    public function updateShopInformation(Request $request){
    	/*$this->validate($request,[
    			'shipping_cost'=>['required','max:999'],
    			'shipping_from'=>['required','max:999'],
    		],
    		[
    			'shipping_cost.required'=>'Por favor, ingrese un monto.',
    			'shipping_cost.max'=>'El titulo no debe ser mayor a 999.',
    			'shipping_from.required'=>'Por favor, ingrese un monto.',
    			'shipping_from.max'=>'El titulo no debe ser mayor a 999.',
    	]);*/

    	$shop=Shop::find($request->shop_id);
		$shop->phone = $request->phone;
		$shop->email = $request->email;
		$shop->web = $request->web;
		$shop->facebook = $request->facebook;
		$shop->twitter = $request->twitter;
		$shop->instagram = $request->instagram;
		$shop->pinterest = $request->pinterest;
		$shop->slogan = $request->slogan;
		$shop->video_channel = $request->video_channel;
		$shop->location = $request->location;
		$shop->save();
		Session::flash('alert', 'Actualización exitosa.');
		Session::flash('alert-class', 'alert-success');
    	return redirect("/dashboard/store/$shop->id/configurations/information");
    }
}
