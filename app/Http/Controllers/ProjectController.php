<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ImageProject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str as Str;

class ProjectController extends Controller
{
    public function index(){
        return view('admin.projects.index');
    }
   
    public function getProjects(Request $request){
        //if(!$request->ajax()) return redirect('/');
        
        //$buscar = $request->buscar;
        //$criterio = $request->criterio;
        $projects = Project::with('images')
                //->where($criterio, 'like', '%'.$buscar.'%')
                ->orderBy('id','desc')
                ->paginate(5);
        return [
            'pagination'=>[
                'total'=> $projects->total(),
                'current_page'=> $projects->currentPage(),
                'per_page'=> $projects->perPage(),
                'last_page'=> $projects->lastPage(),
                'from'=> $projects->firstItem(),
                'to'=> $projects->lastItem(),
            ],
            'projects'=>$projects
        ];
    }

    private function generarRandSlug($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
        return $key;
    }

    private function generateNewSlugProduct($name){
        $sigue=true;
        $rand_str='';//la primera vez no generara nada, para conservar un slug mas limpio
        while($sigue){
            $new_slug=$rand_str;
            $new_slug.= Str::slug($name);
            $existe=Project::where('slug',$new_slug)->first();
            if(!$existe){
                $sigue=false;
                break;
            }
            $rand_str = $this->generarRandSlug(5);
            $rand_str .= '-';
        }
        return $new_slug;
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255'
          ]);

        $slug = $this->generateNewSlugProduct($request->title);
        
        $project = new Project;
        $project->active = $request->active;
        $project->show_home = $request->show_home;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->slug = $slug;
        $project->save();
           
    }

    public function update(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255'
          ]);

        $project = Project::findOrFail($request->project_id);
        $project->active = $request->active;
        $project->show_home = $request->show_home;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->save();
           
    }

    public function active(Request $request){
        $project = Project::findOrFail($request->id);
        $project->active = 1;
        $project->save();           
    }
    
    public function deactive(Request $request){
        $project = Project::findOrFail($request->id);
        $project->active=0;
        $project->save();           
    }
    
    public function showHome(Request $request){
        $project = Project::findOrFail($request->id);
        $project->show_home=1;
        $project->save();           
    }
    public function hideHome(Request $request){
        $project = Project::findOrFail($request->id);
        $project->show_home=0;
        $project->save();           
    }

    public function delete(Request $request){
        $project=Project::find($request->id);
        if($project->url_video){
            Storage::disk('s3')->delete($project->url_video);
        }
        $project->delete();
    }

    public function updateMainImage(Request $request){
        $request->validate([
            'main_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $project = Project::findOrFail($request->project_id);
        $file = $project->getImageFileNameAttribute($project->image);
        $exists  = Storage::disk('public')->exists('projects/' . $file);
        if($exists){
            Storage::disk('public')->delete('projects/' . $file);
        }

        $project->image = $request->file('main_image')->store('projects', 'public');
        $project->save();

    }

    public function uploadOtherImage(Request $request){
        $request->validate([
            'other_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $image_project = new ImageProject();
        $image_project->project_id  = $request->project_id;
        $image_project->image       = $request->file('other_image')->store('projects', 'public');
        $image_project->save();
    }

        /*$request->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/x-m4v,video/*',
        ]);*/
    public function storeVideo(Request $request){

        $videoFile = $request->file('video');

        return $videoFile;

        /*$project_id=$request->project_id;
        $folder = "proyectos";

        $project = Project::findOrFail($project_id);
        $project_path = Storage::disk('s3')->put($folder, $request->file('video'), 'public');
        $project->url_video = $project_path;
        $project->save();*/

        /*$project_id = $request->project_id;
        $folder = "video_test";

        $project = Project::findOrFail($project_id);
        $project_path = $request->file('video')->store($folder, 'public');
        $project->url_video = $project_path;
        $project->save();*/
    }

    public function deleteVideo(Request $request){
        $project = Project::findOrfail($request->id);
        Storage::disk('s3')->delete($project->url_video);
        $project->url_video=null;
        $project->save();
    }

    public function getUrlVideo(Request $request){
        $project = Project::findOrFail($request->project_id);
        return response()->json(['url' => Storage::disk('s3')->url($project->url_video) ]);

    }

    public function deleteOtherImage(Request $request){
        $image = ImageProject::findOrfail($request->id);
        $file = $image->image;
        $exists = Storage::disk('public')->exists($file);
        if($exists){
            Storage::disk('public')->delete($file);
            $image->delete();
        }
    }
}
