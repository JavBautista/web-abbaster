<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Course;
use App\CourseVideo;
use Illuminate\Support\Facades\Storage;

class CourseVideoController extends Controller
{
    public function getCourseVideos(Request $request){
        if(!$request->ajax()) return redirect('/');

        $course_id=$request->course_id;
        $videos = CourseVideo::where('course_id',$course_id)
            ->orderBy('order','asc')
            ->paginate(20);

        return [
            'pagination'=>[
                'total'=> $videos->total(),
                'current_page'=> $videos->currentPage(),
                'per_page'=> $videos->perPage(),
                'last_page'=> $videos->lastPage(),
                'from'=> $videos->firstItem(),
                'to'=> $videos->lastItem(),
            ],
            'videos'=>$videos
        ];
    }//getCourseVideos()

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'video' => 'required|file|mimetypes:video/mp4,video/x-m4v,video/*',
        ]);

        $course_id=$request->course_id;
        $folder = "videos";
        $video = new CourseVideo;
        $video->course_id   = $course_id;
        $video->name        = $request->name;
        $video->description = $request->description;
        $video->order       = 0;
        $video_path         = Storage::disk('s3')->put($folder, $request->video, 'public');
        $video->video       = $video_path;
        $video->save();
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);
        $video = CourseVideo::findOrFail($request->video_id);
        $video->name        = $request->name;
        $video->description = $request->description;
        $video->save();
    }


    public function active(Request $request){
        $video = CourseVideo::findOrfail($request->id);
        $video->active = 1;
        $video->save();
    }

    public function deactive(Request $request){
        $video = CourseVideo::findOrfail($request->id);
        $video->active = 0;
        $video->save();
    }

    public function delete(Request $request){
        $video = CourseVideo::findOrfail($request->id);
        Storage::disk('s3')->delete($video->video);
        $video->delete();
    }

    public function getUrlVideo(Request $request){

        $video = CourseVideo::findOrfail($request->video_id);
        return response()->json(['url' => Storage::disk('s3')->url($video->video) ]);

    }

    public function updateOrder(Request $request)
    {
        $videos = $request->input('videos');
        foreach ($videos as $index => $video) {
            CourseVideo::where('id', $video['id'])
                ->update(['order' => $index + 1]);
        }
        return response()->json(['message' => 'Orden actualizado con éxito']);
    }
}
