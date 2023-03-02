<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Course;
use App\CourseVideo;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request, $shop_id){
        $shop=Shop::find($shop_id);
        return view('admin.courses.index',[
            'shop_id'=>$shop_id,
            'shop'=>$shop,
        ]);

    }

    public function adminCourse(Request $request){
        $shop_id = $request->shop_id;
        $course_id = $request->course_id;

        $shop=Shop::findOrfail($shop_id);
        $course=Course::findOrfail($course_id);
        $videos=CourseVideo::where('course_id',$course_id)->get();

        return view('admin.courses.admin_course',[
            'shop'=>$shop,
            'shop_id'=>$shop_id,
            'course_id'=>$course_id,
            'course'=>$course,
            'videos'=>$videos
        ]);

    }

    public function getShopCourses(Request $request){
        if(!$request->ajax()) return redirect('/');
        $shop_id=$request->shop_id;
        $courses = Course::where('shop_id',$shop_id)
            ->orderBy('id','desc')
            ->paginate(10);

        return [
            'pagination'=>[
                'total'=> $courses->total(),
                'current_page'=> $courses->currentPage(),
                'per_page'=> $courses->perPage(),
                'last_page'=> $courses->lastPage(),
                'from'=> $courses->firstItem(),
                'to'=> $courses->lastItem(),
            ],
            'courses'=>$courses
        ];
    }//getShopCourses()

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
          ]);
        $shop_id=$request->shop_id;
          try{
                $shop=Shop::find($shop_id);

                $course = new Course;
                $course->shop_id = $request->shop_id;
                $course->name = $request->name;
                $course->description = $request->description;
                $course->save();

                return redirect()->route('dashboard.store.courses.index',['shop_id'=>$shop_id])
                ->with('success','Curso registrado correctamente!');

            }catch(\Exception $e){

                return redirect()->route('dashboard.store.courses.index',['shop_id'=>$shop_id])
                ->with('error','No se pudo registrar el curso. Error: '.$e->getMessage());
            }
    }

    public function update(Request $request){
        $course = Course::findOrfail($request->course_id);
        $course->name = $request->name;
        $course->description = $request->description;
        $course->save();
    }

    public function active(Request $request){
        $course = Course::findOrfail($request->id);
        $course->active = 1;
        $course->save();
    }

    public function deactive(Request $request){
        $course = Course::findOrfail($request->id);
        $course->active = 0;
        $course->save();
    }

    public function delete(Request $request){
        $course = Course::findOrfail($request->id);

        $videos_course= CourseVideo::where('course_id',$request->id)->get();
        foreach($videos_course as $vc){
            $video = CourseVideo::findOrFail($vc->id);
            Storage::disk('s3')->delete($video->video);
            $video->delete();
        }
        $course->delete();
    }

    public function storeVideo(Request $request){
        //dd($request->video);
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'video' => 'required|mimetypes:video/mp4,video/x-flv,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
          ]);
        $shop_id=$request->shop_id;
        $course_id=$request->course_id;
          try{
                $shop=Shop::find($shop_id);

                $folder = "videos";

                $video = new CourseVideo;
                $video->course_id = $request->course_id;
                $video->name = $request->name;
                $video->description = $request->description;
                $video->order = 0;
                $video_path = Storage::disk('s3')->put($folder, $request->video, 'public');
                $video->video = $video_path;
                $video->save();

                return redirect()->route('dashboard.store.course.admin',['shop_id'=>$shop_id,'course_id'=>$course_id])
                ->with('success','Se guardo correctamente!');

            }catch(\Exception $e){

                return redirect()->route('dashboard.store.course.admin',['shop_id'=>$shop_id,'course_id'=>$course_id])
                ->with('error','No se pudo guardar. Error: '.$e->getMessage());
            }
    }

    public function destroyVideo(Request $request){
        $video_id=$request->video_id;
        $shop_id=$request->shop_id;
        $course_id=$request->course_id;
        try{
             $video = CourseVideo::findOrFail($video_id);
             Storage::disk('s3')->delete($video->video);

             $video->delete();

            return redirect()->route('dashboard.store.course.admin',['shop_id'=>$shop_id,'course_id'=>$course_id])
            ->with('success','Post eliminado correctamente!');

        }catch(\Exception $e){

            return redirect()->route('dashboard.store.course.admin',['shop_id'=>$shop_id,'course_id'=>$course_id])
            ->with('error','No se pudo eliminar el post. Error: '.$e->getMessage());
        }


    }

}
