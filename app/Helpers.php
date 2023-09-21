<?php
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\ViewWeb;
use App\ViewsProduct;
use App\ViewsCategory;
use App\Shop;
use App\Category;
use App\ProductQuestions;
use App\CustomerNotification;
use App\Message;
use App\MessagesContact;
use App\DollarPrice;
use App\DollarPriceCurrent;
use App\WebContentBannerLoop;
use App\AbbasterInformation;
use Illuminate\Support\Facades\Session;
//use Cart;
//use Illuminate\Database\Eloquent\Builder;

function setActive($route){
	return  request()->routeIs($route)?'active page-active':'';
}

function contVisita(){
	$result='';
	$ip= \Request::ip();
	$day=Carbon::now();
	$day =$day->format('Y-m-d');
	$visitas = ViewWeb::where('ip',$ip)->where('day',$day)->get();
	if(!$visitas->count()){
		$view = new ViewWeb;
	    $view->ip = $ip;
	    $view->day = $day;
	    $view->views += 1;
	    $view->save();
	}
}

function contVisitaProducto($product_id){
	$result='';

	$ip= \Request::ip();
	$day=Carbon::now();
	$day =$day->format('Y-m-d');

	$visitas = ViewsProduct::where('ip',$ip)->where('day',$day)->where('product_id',$product_id)->get();

	if(!$visitas->count()){
		$view = new ViewsProduct;
	    $view->product_id = $product_id;
	    $view->ip = $ip;
	    $view->day = $day;
	    $view->views += 1;
	    $view->save();
	}
}
function contVisitaCategoria($category_id){
	$result='';
	$ip= \Request::ip();
	$day=Carbon::now();
	$day =$day->format('Y-m-d');
	$visitas = ViewsCategory::where('ip',$ip)->where('day',$day)->where('category_id',$category_id)->get();

	if(!$visitas->count()){
		$view = new ViewsCategory;
	    $view->category_id = $category_id;
	    $view->ip = $ip;
	    $view->day = $day;
	    $view->views += 1;
	    $view->save();
	}
}

	function getNotificaciones(){
		$notifications = ProductQuestions::where('status',0)->get();
		$count = $notifications?$notifications->count():0;
		return $count;
	}

	function getCustomersNotificaciones(){
		$notifications = CustomerNotification::where('read',0)->get();
		$count = $notifications?$notifications->count():0;
		return $count;
	}

	function getNotificacionesMessagesCustomer(){
		$notifications = Message::where('status',0)->get();
		$count = $notifications?$notifications->count():0;
		return $count;
	}

	function getNotificacionesMessagesFormContact(){
		$notifications = MessagesContact::where('read',0)->get();
		$count = $notifications?$notifications->count():0;
		return $count;
	}

	function existeShoppingCart(){
		$cart = Cart::content();
        return $cart;
	}

	function getCategorias(){
		$categories = Category::where('status',0)->get();
		return $categories;
	}

	function getPriceDollar($retail){
		$dollar = DollarPrice::find(1);
		$price=  $retail / $dollar->price;
		return number_format($price,2);
	}

	function getTipoCambio(){
		$dollar = DollarPrice::find(1);
		return $dollar->price;

	}

	function getTipoCambioActual(){
		$dollar = DollarPriceCurrent::find(1);
		return $dollar->price;

	}

	function getPrice($retail){
		$currency = (Session::has('currency'))?Session::get('currency'):'MXN';

		if($currency=='MXN'){
			return number_format($retail,2);
		}else{
			$dollar = DollarPrice::find(1);
			$price=  $retail / $dollar->price;
			return number_format($price,2);
		}
	}

	function getShops(){
		$shops = Shop::where('status',0)->get();
		return $shops;
	}

	function getShop($id){
		$shop = Shop::find($id);
		return $shop;
	}

	function getAbbasterInformation(){
		//ṔARA QUE ETSE METODO NO DE ERRO DEBE EXISTIR EL REGISTRO EN LA BD CON ID=1
		$abbaster_info = AbbasterInformation::find(1);
		return $abbaster_info;
	}

	function getBannerLoop(){
		$section = WebContentBannerLoop::where('shop_id',0)->first();
		return $section;
	}


