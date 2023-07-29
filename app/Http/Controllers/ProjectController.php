<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ImageProject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str as Str;

class ProjectController extends Controller
{
    public function generateUniqueSlug($name, $currentSlug = null){
        $slug = Str::slug($name);

        // Verificar si el slug existe en la base de datos, excluyendo el slug actual (en caso de actualización)
        $query = Project::where('slug', $slug);
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
            $count = Project::where('slug', $newSlug)->count();
            $suffix++;
        }

        return $newSlug;
    }

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

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required'
          ]);
        $project = new Project;
        $project->active = $request->active;
        $project->show_home = $request->show_home;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->slug = $this->generateUniqueSlug($request->title);;
        $project->save();
           
    }

    public function update(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required'
          ]);

        $project = Project::findOrFail($request->project_id);
        $project->active = $request->active;
        $project->show_home = $request->show_home;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->slug = $this->generateUniqueSlug($request->name, $project->slug);;
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
        //eliminamos imagene principal
        $file = $project->getImageFileNameAttribute($project->image);
        $exists  = Storage::disk('public')->exists('projects/' . $file);
        if($exists){
            Storage::disk('public')->delete('projects/' . $file);
        }
        //eliminamos video si existe
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

    public function storeVideo(Request $request){
        $project_id=$request->project_id;
        $folder = "proyectos";
        $project = Project::findOrFail($project_id);
        $project_path = Storage::disk('s3')->put($folder, $request->file('video'), 'public');
        $project->url_video = $project_path;
        $project->save();
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
