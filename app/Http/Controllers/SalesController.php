<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\PurchaseDetail;
use App\PuchasesStatus;
use App\Customer;
use App\Shop;
use App\Course;
use App\CustomerCourse;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class SalesController extends Controller
{
    private function  saleStatus($sale_status){
        $desc_status='';
        $status=PuchasesStatus::all();        
        foreach ($status as $val) if($val->id == $sale_status){
            $desc_status= $val->status;
            break;
        }//.if.foreach
        return $desc_status;
    }


    public function selectFilterStatus(Request $request){
        $sales_filter_status = $request->input('filter_status');
        $request->session()->put('sales_filter_status', $sales_filter_status);
        $shop_id=$request->input('shop_id');
        return redirect("/dashboard/store/$shop_id/sales");
    }

    public function selectFilterSearch(Request $request){
        $sales_filter_status = $request->input('filter_status');
        $sales_filter_filtro = $request->input('filtro');
        $sales_filter_buscar = $request->input('buscar');

        $request->session()->put('sales_filter_status', $sales_filter_status);
        $request->session()->put('sales_filter_filtro', $sales_filter_filtro);
        $request->session()->put('sales_filter_buscar', $sales_filter_buscar);

        $shop_id=$request->input('shop_id');
        return redirect("/dashboard/store/$shop_id/sales");
    }

    public function index($shop_id){
        $sales_filter_status= (SESSION::has('sales_filter_status'))? SESSION::get('sales_filter_status') : 0;
        $sales_filter_filtro= (SESSION::has('sales_filter_filtro'))? SESSION::get('sales_filter_filtro') : 'ninguno';
        $sales_filter_buscar= (SESSION::has('sales_filter_buscar'))? SESSION::get('sales_filter_buscar') : '';
    	
        $status=PuchasesStatus::all();
    	$shop=Shop::find($shop_id);
        
        $sales=null;
        //Si no hay filtros seleccionados
        if($sales_filter_status==0 AND $sales_filter_filtro=='ninguno') {
            $sales = Purchase::where('shop_id',$shop_id)->orderBy('created_at', 'desc')->paginate(10);
        }else{
            //hay al menos un filtro selccionado hay que ver las combinaciones

            //Si el filtro es por num compra ignoramos directamenmte los otros filtros
            if($sales_filter_filtro=='compra'){
                $num_compra = is_numeric($sales_filter_buscar)?$sales_filter_buscar:0;
                $sales = Purchase::where('id',$num_compra)->paginate(1);
            }else{
            //Este es cualquier filtro que no sea num de compra
                //si el filtro es cliente
                if($sales_filter_filtro=='cliente'){
                    //si es cliente pero no hay filtro d esttaus, buscamos solo con el cliente
                    $buscar=$sales_filter_buscar;
                    if($sales_filter_status==0){
                        $sales = Purchase::where('shop_id',$shop_id)
                                            ->with('customer')
                                            ->whereHas('customer', function (Builder $query) use($buscar) {
                                                $query->where('name', 'like', '%'.$buscar.'%');
                                            })
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(10);
                    }else{
                    //si es cliente pero y hay filtro de esttaus, buscamos con ambos filtro
                        $sales = Purchase::where([
                                                ['shop_id',$shop_id],
                                                ['status',$sales_filter_status]
                                            ])
                                            ->with('customer')
                                            ->whereHas('customer', function (Builder $query) use($buscar) {
                                                $query->where('name', 'like', '%'.$buscar.'%');
                                            })
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(10);
                    }
                }else{
                //si no es filtro de cliente (y por el if del nivel arriba tampoco es num compra)
                //buscamos solo con el filtro de Estatus
                    if($sales_filter_status)
                        $sales = Purchase::where([
                            ['shop_id',$shop_id],
                            ['status',$sales_filter_status]
                            ])->orderBy('created_at', 'desc')->paginate(10);
                }
            }
        }//if-else filtro

        $count_sales = $sales->total();
        return view('admin.sales.index',[
            'shop'=>$shop,
            'sales'=>$sales,
            'status'=>$status,
            'sales_filter_status'=>$sales_filter_status,
            'sales_filter_filtro'=>$sales_filter_filtro,
            'sales_filter_buscar'=>$sales_filter_buscar,
            'count_sales'=>$count_sales,
        ]);
    }

    public function view_sale ($shop_id, $sale_id){
        $purchase = Purchase::find($sale_id);
        $shop=Shop::find($shop_id);
        $customer = $purchase->customer;
        $sale_status= $this->saleStatus($purchase->status);         
        $existe_curso = false;

        $cursos=[];
        foreach ($purchase->PurchaseDetail as $data) {
           if($data->product->type_course){
            $existe_curso=true;

            $course_id = $data->product->course_id;

            $course = Course::findOrFail($course_id);
            $customer_course = CustomerCourse::where('course_id',$course_id)
                                                    ->where('customer_id',$customer->id)
                                                    ->get();
            $existe_asigancion = ($customer_course->isEmpty())?0:1;

            $tmp=[ 'curso_id'=> $course->id, 'curso'=> $course->name, 'asignado'=>$existe_asigancion ];
            array_push($cursos, $tmp);
           }
        }

        return view('admin.sales.view_sale',[
            'shop'=>$shop,
            'purchase'=>$purchase,
            'customer'=>$customer,
            'sale_status'=>$sale_status,
            'existe_curso'=>$existe_curso,
            'cursos'=>$cursos
        ]);
    }

    public function chat ($shop_id, $sale_id){
        $purchase = Purchase::find($sale_id);
        $shop=Shop::find($shop_id);
        $customer = $purchase->customer;
        $sale_status= $this->saleStatus($purchase->status);
        return view('admin.sales.chat',[
            'shop'=>$shop,
            'purchase'=>$purchase,
            'customer'=>$customer,
            'sale_status'=>$sale_status,
        ]);
    }

    public function editSale($shop_id, $sale_id){
        $shop=Shop::find($shop_id);
        $purchase = Purchase::find($sale_id);        
        $customer = $purchase->customer;
        $sale_status= $this->saleStatus($purchase->status); 

        return view('admin.sales.edit_sale',[
            'shop'=>$shop,
            'purchase'=>$purchase,
            'customer'=>$customer,
            'sale_status'=>$sale_status,
        ]);

    }
    
    public function editTracking($shop_id, $sale_id){
        $shop=Shop::find($shop_id);
        $purchase = Purchase::find($sale_id);        
        $customer = $purchase->customer;
        $sale_status= $this->saleStatus($purchase->status);        

        return view('admin.sales.edit_tracking',[
            'shop'=>$shop,
            'purchase'=>$purchase,
            'customer'=>$customer,
            'sale_status'=>$sale_status,
        ]);
    }


    public function editStatus($shop_id, $sale_id){
        $status_sales=PuchasesStatus::all();        
        $shop=Shop::find($shop_id);
        $purchase = Purchase::find($sale_id);        
        $customer = $purchase->customer;
        $sale_status= $this->saleStatus($purchase->status);        

        return view('admin.sales.edit_status',[
            'shop'=>$shop,
            'purchase'=>$purchase,
            'customer'=>$customer,
            'sale_status'=>$sale_status,
            'status_sales'=>$status_sales,
        ]);
    }

    public function updateStatus(Request $request){
        /*$this->validate($request,[
                'title'=>['required','max:100']
            ],
            [
                'title.required'=>'Por favor, ingrese un titulo para el script.',
                'title.max'=>'El titulo no debe ser mayor a 100 caracteres.',
        ]);*/

        $purchase = Purchase::find($request->input('purchase_id'));
        $shop = Shop::find($request->input('shop_id'));
        $purchase->status = $request->input('status');
        $purchase->save();


        Session::flash('alert', 'Status actualizado satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$shop->id."/sales");
    }

    public function updateTracking(Request $request){
        $this->validate($request,[
                'tracking_number'=>['required','max:50']
            ],
            [
                'tracking_number.required'=>'Por favor, ingrese un numero de tracking.',
                'tracking_number.max'=>'El numero de tracking no debe ser mayor a 50 caracteres.',
        ]);

        $purchase = Purchase::find($request->input('purchase_id'));
        $shop = Shop::find($request->input('shop_id'));
        
        $purchase->tracking_number = $request->input('tracking_number');
        $purchase->save();


        Session::flash('alert', 'Numero de tracking actualizado satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$shop->id."/sales");
    }
    
    public function removeShipping(Request $request){        
        $purchase = Purchase::find($request->input('purchase_id'));        
        $shipping=$purchase->shipping;
        $purchase->total = $purchase->total - $shipping; 
        $purchase->shipping=0;
        $purchase->status=14;
        $purchase->save();

        Session::flash('alert', 'Shipping removido satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$purchase->shop->id."/sales/edit/".$purchase->id);
    } 

    public function restoreShipping(Request $request){        
        $purchase = Purchase::find($request->input('purchase_id'));  
        //obtenemmos el costo del shipping relacionado a la tienda      
        $shipping=$purchase->shop->shipping->shipping_cost;
        $purchase->total = $purchase->total + $shipping; 
        $purchase->shipping=$shipping;
        $purchase->status=14;
        $purchase->save();
        Session::flash('alert', 'Shipping restaurado satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');
        return redirect("/dashboard/store/".$purchase->shop->id."/sales/edit/".$purchase->id);
    }

    public function updateTotalSale(Request $request){

        $this->validate($request,[
                'monto'=>['required','min:0']
            ],
            [
                'monto.required'=>'Por favor, ingrese un monto.',
                'monto.min'=>'El costo monto de la nota no puede ser menor a 0.',
        ]);
        
        $purchase_id = $request->input('purchase_id');    
        $tipo_modificacion = $request->input('tipo-modificacion');
        $monto=$request->input('monto');

        $purchase= Purchase::find($purchase_id);
        $total_original= $purchase->subtotal + $purchase->tax + $purchase->shipping;

        switch ($tipo_modificacion) {
            case 'total':
                    $descuento = $total_original-$monto;
                    $purchase->total = $monto;
                    $purchase->discount= $descuento;
                    $purchase->status=14;
                    $purchase->save();
                    Session::flash('alert', 'Total actualizado satisfactoriamente!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect("/dashboard/store/".$purchase->shop->id."/sales/edit/".$purchase->id);

                break;
            case 'monto':                    
                    $new_total= $total_original-$monto;
                    $purchase->total = $new_total; 
                    $purchase->discount= $monto;
                    $purchase->status=14;
                    $purchase->save();
                    Session::flash('alert', 'Total actualizado satisfactoriamente!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect("/dashboard/store/".$purchase->shop->id."/sales/edit/".$purchase->id);
                break;
            default:
                    Session::flash('alert', 'Ups! No se encontro un tipo de moficacion!');
                    Session::flash('alert-class', 'alert-warning');
                    return redirect("/dashboard/store/".$purchase->shop->id."/sales/edit/".$purchase->id);
                break;
        }

        


        
    }



    

    
}
