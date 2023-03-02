<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\Http\Requests\CreateSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use Illuminate\Support\Facades\Session;
use App\DiscountCode;
use App\User;
use App\Role;
use App\Purchase;
use App\PurchaseDetail;
use App\PuchasesStatus;
use App\Customer;
use App\Shop;
class SellerController extends Controller
{
    public function index(){
    	$sellers = Seller::paginate(10);
    	return view('admin.afiliados.sellers.index',[
    		'sellers'=>$sellers,
    	]);
    }

    public function add(){
    	return view('admin.afiliados.sellers.add');
    }

    
    public function view($seller_id){
    	$seller = Seller::find($seller_id);
        $discount_codes = DiscountCode::where('seller_id',$seller_id)->get();
    	return view('admin.afiliados.sellers.view',[
    		'seller'=>$seller,
            'discount_codes'=>$discount_codes,
    	]);

    }

    public function edit($seller_id){
    	$seller = Seller::find($seller_id);
    	return view('admin.afiliados.sellers.edit',[
    		'seller'=>$seller,
    	]);
    }

    public function editStatus($seller_id){
    	$seller = Seller::find($seller_id);
    	return view('admin.afiliados.sellers.edit_status',[
    		'seller'=>$seller,
    	]);
    }

    #POSTS
    public function create(CreateSellerRequest $request){
    	
    	$seller = Seller::create([
                'status'  => $request->input('status'),
                'mail'  => $request->input('mail'),
                'name'  => $request->input('name'),
                'phone'  => $request->input('phone'),
                'movil'  => $request->input('movil'),
                'zip_code' => $request->input('zip_code'),
                'address'  => $request->input('address'),
                'district' => $request->input('district'),
                'city'  => $request->input('city'),
                'state'  => $request->input('state'),
            ]);      	

    	Session::flash('alert', 'Afiliado creado satisfactoriamente!');
		Session::flash('alert-class', 'alert-success');

    	return redirect("/dashboard/afiliados/sellers/");
    }

    public function update(UpdateSellerRequest $request){
    	$seller = Seller::find($request->input('seller_id'));

    	$seller->status = $request->input('status');
		$seller->name = $request->input('name');
		$seller->phone = $request->input('phone');
		$seller->movil = $request->input('movil');
		$seller->zip_code = $request->input('zip_code');
		$seller->address = $request->input('address');
		$seller->district = $request->input('district');
		$seller->city = $request->input('city');
		$seller->state = $request->input('state');
		$seller->save();
		Session::flash('alert', 'Afiliado actualizado satisfactoriamente!');
		Session::flash('alert-class', 'alert-success');

    	return redirect("/dashboard/afiliados/sellers/");
    }

    public function updateStatus(Request $request){
    	$seller = Seller::find($request->input('seller_id'));
    	$seller->status = $request->input('status');
		$seller->save();
		Session::flash('alert', 'Estatus de afiliado actualizado satisfactoriamente!');
		Session::flash('alert-class', 'alert-success');
    	return redirect("/dashboard/afiliados/sellers/");
    }


    public function sysUser($seller_id){
        $seller = Seller::find($seller_id);
        $user=null;
        if($seller->user_id!=0){
            $user=$seller->user;
        }
        return view('admin.afiliados.sellers.user',[
            'seller'=>$seller,
            'user'=>$user,
        ]);

    }

    public  function createUser(Request $request){
        $seller = Seller::find($request->input('seller_id'));
        $user = User::create([
            'name' => $seller->name,
            'email' => $seller->mail,
            'password' => bcrypt('secret'),
        ]);
        $user
            ->roles()
            ->attach(Role::where('name', 'vendedor')->first());
        
        $seller->user_id = $user->id;
        $seller->save();

        Session::flash('alert', 'Usuario vcreado satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/afiliados/sellers/user/".$seller->id);

    }

    //A PARTIR DE AQUI SON METODOS DEL ADMIN PANEL DE VENDEDORES VER SI GENERAMOS UN CONTROLER SOLO PARA ESO

    public function showTablaProcentajes(){
        return view('admin_seller.view_tabla_procentajes');
    }

    public function ventas(){
        $user = auth()->user();   
        $status=PuchasesStatus::all();
        $sales=[];
        foreach($user->vendedor->discountCodes as $discount_code){            
            $purchases_for_code = Purchase::where('discount_code',$discount_code->code)->orderBy('created_at', 'desc')->get();
            foreach($purchases_for_code as $purchase)
                if($purchase)
                    $sales[]=$purchase;
        }
        //dd($sales);
        return view('admin_seller.ventas',[            
            'user'=>$user,
            'sales'=>$sales,
            'status'=>$status,

        ]);   
    }


}
