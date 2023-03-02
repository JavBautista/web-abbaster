<?php

namespace App\Http\Controllers;


use App\User;
use App\Role;
use App\Customer;
use App\CustomerNotification;
use App\Shop;
use App\Purchase;
use App\PuchasesStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    public function registerCustomer(Request $request){
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],
        ],[
                'name.required'=>'No se puede guardar nombre vacio.',
                'email.required'=>'No se puede guardar email vacio.',
                'password.required'=>'No se puede guardar password vacio.',
                'name.string'=>'Campo nombre debe ser de tipo cadena.',
                'email.string'=>'Campo email debe ser de tipo cadena.',
                'password.string'=>'Campo password debe ser de tipo cadena.',
                'email.email'=>'El formato del email no es correcto.',
                'name.max'=>'Campo nombre no debe ser mayor a 255 caracteres.',
                'email.max'=>'Campo email no debe ser mayor a 255 caracteres.',
                'password.min'=>'Campo password debe tener minimo 6 caracteres.',
                'email.unique'=>'El email proporcionado ya existe en la BD.',
        ]);

        CustomerNotification::create([
             'mail' => $request->email,
             'read' => 0,
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->roles()
            ->attach(Role::where('name', 'user')->first());


        $customer = Customer::create([
            'mail'  => $request->email,
            'name'  => $request->name,
            'user_id'  => $user->id
        ]);

        return $customer;

    }



    public function index($shop_id){
        $shop=Shop::find($shop_id);
        $customers = Customer::paginate(20);

        $purchases_customer=[];
        foreach($customers as $customer){
            $purchases = Purchase::where('customer_id',$customer->id)->get();
            $purchases_customer[$customer->id] =count($purchases);
        }

        return view('admin.customers.index',['customers'=>$customers,'shop'=>$shop,'purchases_customer'=>$purchases_customer]);
    }

    //NUEVOS MET DESDE LAS NOTOFICACIONES Y SIN SHOP
    public function indexCustomers(){
        return view('admin.customers.index_customers');
    }

    public function getCustomers(Request $request){
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $news=CustomerNotification::where('read',0)->get();
        if($buscar==''){
            $customers = Customer::orderBy('id','desc')->paginate(20);
        }else{
            $customers = Customer::where('name', 'like', '%'.$buscar.'%')
                                ->orWhere('mail', 'like', '%'.$buscar.'%')
                                ->orWhere('phone', 'like', '%'.$buscar.'%')
                                ->orWhere('movil', 'like', '%'.$buscar.'%')
                                ->orWhere('address', 'like', '%'.$buscar.'%')
                                ->orWhere('district', 'like', '%'.$buscar.'%')
                                ->orderBy('id','desc')->paginate(20);
        }

        $purchases_customer=[];
        foreach($customers as $customer){
            $purchases = Purchase::where('customer_id',$customer->id)->get();
            $purchases_customer[$customer->id] =count($purchases);
        }

        return [
            'pagination'=>[
                'total'=> $customers->total(),
                'current_page'=> $customers->currentPage(),
                'per_page'=> $customers->perPage(),
                'last_page'=> $customers->lastPage(),
                'from'=> $customers->firstItem(),
                'to'=> $customers->lastItem(),
            ],
            'customers'=>$customers,
            'purchases_customer'=>$purchases_customer,
            'news'=>$news,
        ];
    }
    //./NUEVO DES LAS NOTOFICACIONES Y SIN SHOP

    public function getShopCustomers(Request $request){
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $news=CustomerNotification::where('read',0)->get();
        $shop=Shop::find($request->shop_id);

        if($buscar==''){
            $customers = Customer::orderBy('id','desc')->paginate(20);

        }else{
            $customers = Customer::where('name', 'like', '%'.$buscar.'%')
                                ->orWhere('mail', 'like', '%'.$buscar.'%')
                                ->orWhere('phone', 'like', '%'.$buscar.'%')
                                ->orWhere('movil', 'like', '%'.$buscar.'%')
                                ->orWhere('address', 'like', '%'.$buscar.'%')
                                ->orWhere('district', 'like', '%'.$buscar.'%')
                                ->orderBy('id','desc')->paginate(20);
        }

        $purchases_customer=[];
        foreach($customers as $customer){
            $purchases = Purchase::where('customer_id',$customer->id)->get();
            $purchases_customer[$customer->id] =count($purchases);
        }

        return [
            'pagination'=>[
                'total'=> $customers->total(),
                'current_page'=> $customers->currentPage(),
                'per_page'=> $customers->perPage(),
                'last_page'=> $customers->lastPage(),
                'from'=> $customers->firstItem(),
                'to'=> $customers->lastItem(),
            ],
            'customers'=>$customers,
            'purchases_customer'=>$purchases_customer,
            'news'=>$news,
        ];
    }//getShopCustomers


    public function updateCustomerInfo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $customer=Customer::find($request->customer_id);
        $customer->phone  = $request->phone;
        $customer->movil  = $request->movil;
        $customer->zip_code = $request->zip_code;
        $customer->address  = $request->address;
        $customer->number_out  = $request->number_out;
        $customer->number_int  = $request->number_int;
        $customer->district = $request->district;
        $customer->city  = $request->city;
        $customer->state  = $request->state;
        $customer->reference = $request->reference;
        $customer->detail  = $request->detail;
        $customer->save();
    }//updateCustomerInfo

    public function updateCustomerPassword(Request $request){
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[
            'password.required'=>'No se puede guardar password vacio.',
            'password.string'=>'Campo password debe ser de tipo cadena.',
            'password.min'=>'Campo password debe tener minimo 6 caracteres.',
        ]);

        $user = User::findOrFail($request->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();
    }//updateCustomerPassword

    public function updateAdminCustomer(Request $request){
        if(!$request->ajax()) return redirect('/');
        $customer=Customer::find($request->customer_id);
        $customer->mail  = $request->input('mail');
        $customer->name  = $request->input('name');
        $customer->phone  = $request->input('phone');
        $customer->movil  = $request->input('movil');
        $customer->zip_code = $request->input('zip_code');
        $customer->address  = $request->input('address');
        $customer->number_out  = $request->input('number_out');
        $customer->number_int  = $request->input('number_int');
        $customer->district = $request->input('district');
        $customer->city  = $request->input('city');
        $customer->state  = $request->input('state');
        $customer->reference = $request->input('reference');
        $customer->detail  = $request->input('detail');
        $customer->save();
    }//updateAdminCustomer

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $customer=Customer::find($request->customer_id);
        $customer->delete();
    }//delete

    public function readNtf(Request $request){
        if(!$request->ajax()) return redirect('/');
        $ntf=CustomerNotification::find($request->id);
        $ntf->read=1;
        $ntf->save();
    }//delete

    public function purchases($shop_id,$customer_id){
        $shop=Shop::find($shop_id);
        $customer = Customer::find($customer_id);
        $status=PuchasesStatus::all();
        $purchases = Purchase::where('customer_id',$customer_id)->orderBy('created_at', 'desc')->get();
        $count_purchases=count($purchases);

        return view('admin.customers.purchases',[
            'customer'=>$customer,
            'shop'=>$shop,
            'purchases'=>$purchases,
            'status'=>$status,
            'count_purchases'=>$count_purchases,
        ]);
    }

}
