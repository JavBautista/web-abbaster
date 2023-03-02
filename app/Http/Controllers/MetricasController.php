<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewWeb;
use App\ViewsProduct;
use App\ViewsCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MetricasController extends Controller
{

    public function visitasWeb(Request $request){
    	return view('admin.metricas.visitas_web');
    }

    public function visitasWebRange(Request $request){
        return view('admin.metricas.visitas_web_range');
    }

    public function visitasWebMes(Request $request){
        return view('admin.metricas.visitas_web_mes');
    }

    public function visitasProducts(Request $request){
        return view('admin.metricas.visitas_products');
    }

    public function visitasCategories(Request $request){
        return view('admin.metricas.visitas_categories');
    }

    public function charts(Request $request){
        return view('admin.metricas.charts');
    }

    public function getVisitasWeb(Request $request){
        $day=Carbon::now();
        $day =$day->format('Y-m-d');
        $fecha= (isset($request->fecha))?$request->fecha:$day;
        $views = ViewWeb::where('day',$fecha)->get();
        return $views;
    }

    public function getVisitasWebRange(Request $request){
        $day=Carbon::now();
        $day =$day->format('Y-m-d');
        //Obtenemos el rango de fecha o generamos el dia actual por default
        $fecha_ini= ($request->fecha_ini)?$request->fecha_ini:$day;
        $fecha_fin= ($request->fecha_fin)?$request->fecha_fin:$day;
        //formateamos la fecha con Carbon
        $fecha_ini= Carbon::createFromFormat('Y-m-d H:i:s', $fecha_ini.' 00:00:00');
        $fecha_fin= Carbon::createFromFormat('Y-m-d H:i:s', $fecha_fin.' 23:59:59');

        $views = ViewWeb::select('views_web.day',DB::raw('count(views_web.id) as visitas'))
                ->groupBy('views_web.day')
                ->whereBetween('views_web.created_at', [$fecha_ini, $fecha_fin])
                ->orderby('views_web.day','asc')
                ->get();

        $views_count = $views?$views->count():0;
        $views_total =0;
        foreach ($views as $data){
            $views_total+=$data->visitas;

        }
        return [
            'views'=>$views,
            'views_count'=>$views_count,
            'views_total'=>$views_total,
        ];
    }


    public function getVisitasWebMes(Request $request){

        $views = ViewWeb::select(
                DB::raw('count(views) as visitas'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months"))
                ->groupBy('months')
                ->get();

        $views_count = $views?$views->count():0;
        $views_total =0;
        foreach ($views as $data){
            $views_total+=$data->visitas;

        }
        return [
            'views'=>$views,
            'views_count'=>$views_count,
            'views_total'=>$views_total,
        ];
    }
    public function getVisitasProductos(Request $request){
        $day=Carbon::now();
        $day =$day->format('Y-m-d');
        //Obtenemos el rango de fecha o generamos el dia actual por default
        $fecha_ini= ($request->fecha_ini)?$request->fecha_ini:$day;
        $fecha_fin= ($request->fecha_fin)?$request->fecha_fin:$day;
        //formateamos la fecha con Carbon
        $fecha_ini= Carbon::createFromFormat('Y-m-d H:i:s', $fecha_ini.' 00:00:00');
        $fecha_fin= Carbon::createFromFormat('Y-m-d H:i:s', $fecha_fin.' 23:59:59');
        //Query  WhereBetween
        $products = ViewsProduct::join('products','views_products.product_id','=','products.id')
                ->select('views_products.product_id',DB::raw('count(views_products.id) as visitas'),'products.name','products.key','products.image')
                ->groupBy('views_products.product_id')
                ->whereBetween('views_products.created_at', [$fecha_ini, $fecha_fin])
                ->orderby('visitas','desc')
                ->paginate(30);

        $products_count = $products?$products->count():0;

        return [
            'pagination'=>[
                'total'=> $products->total(),
                'current_page'=> $products->currentPage(),
                'per_page'=> $products->perPage(),
                'last_page'=> $products->lastPage(),
                'from'=> $products->firstItem(),
                'to'=> $products->lastItem(),
            ],
            'products'=>$products,
            'products_count'=>$products_count,
        ];
    }

    public function getVisitasCategorias(Request $request){
        $day=Carbon::now();
        $day =$day->format('Y-m-d');
        //Obtenemos el rango de fecha o generamos el dia actual por default
        $fecha_ini= ($request->fecha_ini)?$request->fecha_ini:$day;
        $fecha_fin= ($request->fecha_fin)?$request->fecha_fin:$day;
        //formateamos la fecha con Carbon
        $fecha_ini= Carbon::createFromFormat('Y-m-d H:i:s', $fecha_ini.' 00:00:00');
        $fecha_fin= Carbon::createFromFormat('Y-m-d H:i:s', $fecha_fin.' 23:59:59');
        //Query  WhereBetween

        $products = ViewsCategory::join('categories','views_categories.category_id','=','categories.id')
                ->select('views_categories.category_id',DB::raw('count(views_categories.id) as visitas'),'categories.name','categories.image')
                ->groupBy('views_categories.category_id')
                ->whereBetween('views_categories.created_at', [$fecha_ini, $fecha_fin])
                ->orderby('visitas','desc')
                ->paginate(30);

        $products_count = $products?$products->count():0;

        return [
            'pagination'=>[
                'total'=> $products->total(),
                'current_page'=> $products->currentPage(),
                'per_page'=> $products->perPage(),
                'last_page'=> $products->lastPage(),
                'from'=> $products->firstItem(),
                'to'=> $products->lastItem(),
            ],
            'products'=>$products,
            'products_count'=>$products_count,
        ];
    }

}
