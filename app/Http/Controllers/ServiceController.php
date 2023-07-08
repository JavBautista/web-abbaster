<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request, $shop_id){
        $shop=Shop::find($shop_id);
        return view('admin.services.index',[
            'shop_id'=>$shop_id,
            'shop'=>$shop,
        ]);

    }

    public function getShopServices(Request $request){
        if(!$request->ajax()) return redirect('/');
        $shop_id=$request->shop_id;
        $services = Service::where('shop_id',$shop_id)
            ->orderBy('id','desc')
            ->paginate(10);

        return [
            'pagination'=>[
                'total'=> $services->total(),
                'current_page'=> $services->currentPage(),
                'per_page'=> $services->perPage(),
                'last_page'=> $services->lastPage(),
                'from'=> $services->firstItem(),
                'to'=> $services->lastItem(),
            ],
            'services'=>$services
        ];
    }//getShopServices()

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
          ]);
        $shop_id=$request->shop_id;
          try{
                $shop=Shop::find($shop_id);
                $service = new Service;
                $service->shop_id = $request->shop_id;
                $service->active = 1;
                $service->name = $request->name;
                $service->description = $request->description;
                $service->cost = $request->cost;
                $service->order_by = 0;
                /*$service->image = $request->image;
                $service->url_video = $request->url_video;
                $service->slug = $request->slug;
                */
                $service->save();

                return redirect()->route('dashboard.store.services.index',['shop_id'=>$shop_id])
                ->with('success','Curso registrado correctamente!');

            }catch(\Exception $e){

                return redirect()->route('dashboard.store.services.index',['shop_id'=>$shop_id])
                ->with('error','No se pudo registrar el curso. Error: '.$e->getMessage());
            }
    }

    public function update(Request $request){
        $service = Service::findOrfail($request->service_id);
        $service->name = $request->name;
        $service->description = $request->description;
        $service->cost = $request->cost;
        $service->save();
    }

    public function active(Request $request){
        $service = Service::findOrfail($request->id);
        $service->active = 1;
        $service->save();
    }

    public function deactive(Request $request){
        $service = Service::findOrfail($request->id);
        $service->active = 0;
        $service->save();
    }

    public function delete(Request $request){
        $service = Service::findOrfail($request->id);

        /*$videos_course= CourseVideo::where('course_id',$request->id)->get();
        foreach($videos_course as $vc){
            $video = CourseVideo::findOrFail($vc->id);
            Storage::disk('s3')->delete($video->video);
            $video->delete();
        }*/
        $service->delete();
    }
}
