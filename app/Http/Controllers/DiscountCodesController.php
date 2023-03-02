<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiscountCode;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Shop;
use App\Seller;
use Illuminate\Support\Facades\DB;

class DiscountCodesController extends Controller
{
    
    private function generarCodigo($longitud) {
        $pattern = '@1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;        
        $key='';
        $exito=true;
        while($exito){        
            $key='';
            for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};            
            $code_bd=DiscountCode::where('code',$key)->first();
            if(!$code_bd){
                $exito=false;
            }//if-else
        }//while 
        return $key;       
    }
    
    public function index(){    	
        $discount_codes = DiscountCode::paginate(10);
        $shops= Shop::all();
        $sellers= Seller::all();        

        $data_joins=[];
        foreach ($discount_codes as $data_codes) {
            $_seller_name="Todos";
            $_shop_name="Todos";            
            foreach($sellers as $seller)
                if( $seller->id == $data_codes->seller_id )
                    $_seller_name= $seller->name;            
            foreach($shops as $shop)
                if( $shop->id == $data_codes->shop_id )
                    $_shop_name= $shop->name;
            $data_joins[ $data_codes->id ]=[
                'seller_name'=> $_seller_name,
                'shop_name'=> $_shop_name,
            ];
        }
        
    	return view('admin.afiliados.discount_codes.index',[
    		'discount_codes'=>$discount_codes,
            'data_joins'=>$data_joins,
    	]);
    }

    public function add(){
        $shops= Shop::all();
        $sellers= Seller::all();

        $key = $this->generarCodigo(6);

        $start_date = Carbon::now(); 
        $finish_date = Carbon::now(); 
        
        $finish_date = $finish_date->addDays(7);
        
        $start_date = $start_date->format('m/d/Y'); 
        $finish_date = $finish_date->format('m/d/Y'); 
        
        #dd($start_date.' -- '.$finish_date);
    	return view('admin.afiliados.discount_codes.add',[
            'start_date'=>$start_date,
            'finish_date'=>$finish_date,
            'key'=>$key,
            'shops'=>$shops,
            'sellers'=>$sellers,
        ]);
    }

    public function create(Request $request){

        $this->validate($request,[
                'code'=>['required','unique:discount_codes'],
                'start_date'=>['required','date_format:m/d/Y'],
                'finish_date'=>['required','date_format:m/d/Y'],
                'discount'=>['required','min:0'],
            ],
            [
                'code.required'=>'Por favor vuelva a guardar: Fue necesario generar un nuevo codigo.',
                'code.unique'=>'Por favor vuelva a guardar: Fue necesario generar un nuevo codigo.',
                'start_date.required'=>'Por favor, seleccione una fecha de inicio para el codigo.',
                'start_date.date_format'=>'Por favor, seleccione una fecha de inicio con formato correcto para el codigo.',
                'finish_date.required'=>'Por favor, seleccione una fecha de finalización para el codigo.',
                'finish_date.date_format'=>'Por favor, seleccione una fecha  de finalización con formato correcto para el codigo.',
                'discount.required'=>'Por favor, ingrese un monto de descuento para el codigo.',
                'discount.min'=>'El monto del descuento debe ser mayor a 0.',
        ]);

        $input_start  = $request->input('start_date');
        $input_finish  = $request->input('finish_date');
        $format = 'm/d/Y';          
        $date_start = Carbon::createFromFormat($format, $input_start);
        $date_finish = Carbon::createFromFormat($format, $input_finish);
    	
        $discount_code = DiscountCode::create([
            'code'=> $request->input('code'),
            'status'=> $request->input('status'),
            'type_code'=> $request->input('type_code'),
            'type_discount'=> $request->input('type_discount'),
            'discount'=> $request->input('discount'),
            'number_uses'=> 0,
            'limit_uses'=> $request->input('limit_uses'),
            'start_date'=> $date_start,
            'finish_date'=> $date_finish,
            'seller_id'=> $request->input('seller'),
            'shop_id'=> $request->input('shop'),                
        ]);         

        Session::flash('alert', 'Codigo de Descuento creado satisfactoriamente: '.$request->input('code'));
        Session::flash('alert-class', 'alert-success');

        return redirect("/dashboard/afiliados/discount-codes/");    
    }

    public function remove($code_id){
        $discount_code=DiscountCode::find($code_id);
        return view('admin.afiliados.discount_codes.remove',[
            'discount_code'=>$discount_code,
        ]);
    }

    public function editEstatus($code_id){
        $discount_code=DiscountCode::find($code_id);
        return view('admin.afiliados.discount_codes.edit_status',[
            'discount_code'=>$discount_code,
        ]);
    }

    public function delete(Request $request){
        $discount_code=DiscountCode::find($request->input('discount_code_id'));
        $discount_code->delete();
        Session::flash('alert', 'Codigo de Descuento eliminado satisfactoriamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/afiliados/discount-codes/"); 
    }
    public function updateStatus(Request $request){
        $discount_code=DiscountCode::find($request->input('discount_code_id'));
        $discount_code->status = $request->input('status');
        $discount_code->save();
        Session::flash('alert', 'Codigo de Descuento '.$discount_code->code.' actualizado satisfactoriamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/afiliados/discount-codes/"); 
        
    }

}
