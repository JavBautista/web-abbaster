<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Service;
use App\ServiceImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function generateUniqueSlug($name, $currentSlug = null){
        $slug = Str::slug($name);

        // Verificar si el slug existe en la base de datos, excluyendo el slug actual (en caso de actualización)
        $query = Service::where('slug', $slug);
        if ($currentSlug) {
            $query->where('slug', '!=', $currentSlug);
        }
        $count = $query->count();

        // Si el slug no existe, retornarlo
        if ($count == 0) {
            return $slug;
        }

        // Si el slug existe, generar uno nuevo con un sufijo numérico
        $suffix = 1;
        while ($count > 0) {
            $newSlug = $slug . '-' . $suffix;
            $count = Service::where('slug', $newSlug)->count();
            $suffix++;
        }

        return $newSlug;
    }

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
        $services = Service::with('images')
            ->where('shop_id',$shop_id)
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
            'name' => 'required|max:255'
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
                $service->slug = $this->generateUniqueSlug($request->name);
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
        $service->slug = $this->generateUniqueSlug($request->name, $service->slug);
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

    public function updateMainImage(Request $request){
        $request->validate([
            'main_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $service = Service::findOrFail($request->service_id);
        $file = $service->getImageFileNameAttribute($service->image);
        $exists  = Storage::disk('public')->exists('services/' . $file);
        if($exists){
            Storage::disk('public')->delete('services/' . $file);
        }

        $service->image = $request->file('main_image')->store('services', 'public');
        $service->save();

    }

    public function uploadOtherImage(Request $request){
        $request->validate([
            'other_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $image_srevice = new ServiceImage();
        $image_srevice->service_id  = $request->service_id;
        $image_srevice->image       = $request->file('other_image')->store('services', 'public');
        $image_srevice->save();
    }

    public function storeVideo(Request $request){
        $service_id=$request->service_id;
        $folder = "servicios";
        $service = Service::findOrFail($service_id);
        $service_path = Storage::disk('s3')->put($folder, $request->file('video'), 'public');
        $service->url_video = $service_path;
        $service->save();
    }

    public function deleteVideo(Request $request){
        $service = service::findOrfail($request->id);
        Storage::disk('s3')->delete($service->url_video);
        $service->url_video=null;
        $service->save();
    }

    public function getUrlVideo(Request $request){
        $service = service::findOrFail($request->service_id);
        return response()->json(['url' => Storage::disk('s3')->url($service->url_video) ]);

    }

    public function deleteOtherImage(Request $request){
        $image = ServiceImage::findOrfail($request->id);
        $file = $image->image;
        $exists = Storage::disk('public')->exists($file);
        if($exists){
            Storage::disk('public')->delete($file);
            $image->delete();
        }
    }
}
