<?php

namespace App\Http\Controllers;

use App\Script;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ScriptsController extends Controller
{
    public function index(){
    	$scripts = Script::paginate(10);
    	return view('admin.scripts.index',[
    		'scripts'=>$scripts,
    	]);
    }



    public function add(){
    	return view('admin.scripts.add');
    }

    public function create(Request $request){

    	$this->validate($request,[
    			'title'=>['required','max:100']
    		],
    		[
    			'title.required'=>'Por favor, ingrese un titulo para el script.',
    			'title.max'=>'El titulo no debe ser mayor a 100 caracteres.',
    	]);

    	$script = Script::create([
    		'title'=>$request->input('title'),
    		'content'=>$request->input('content'),
    		'status'=>$request->input('status'),
    	]);

    	Session::flash('alert', 'Script creado satisfactoriamente!');
		Session::flash('alert-class', 'alert-success');

    	return redirect("/dashboard/scripts");
    }

    public function view($script_id){
    	$script=Script::find($script_id);
        return view('admin.scripts.view',[
            'script'=>$script,
        ]);
    }
    public function edit($script_id){
    	$script=Script::find($script_id);
        return view('admin.scripts.edit',[
            'script'=>$script,
        ]);
    }
    public function update(Request $request){
        //dd($request);
        $this->validate($request,[
                'title'=>['required','max:100']
            ],
            [
                'title.required'=>'Por favor, ingrese un titulo para el script.',
                'title.max'=>'El titulo no debe ser mayor a 100 caracteres.',
        ]);

        $script = Script::find($request->input('script_id'));
        $script->title=$request->input('title');
        $script->content=$request->input('content');
        $script->status=$request->input('status');
        
        $script->save();

        Session::flash('alert', 'Script actualizado satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');

        return redirect("/dashboard/scripts");
    }

    public function remove($script_id){
    	$script=Script::find($script_id);
        return view('admin.scripts.remove',[
            'script'=>$script,
        ]);
    }

    public function delete(Request $request){
        
        $script = Script::find($request->input('script_id'));
        $script->save();

        Session::flash('alert', 'Script actualizado satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');

        return redirect("/dashboard/scripts");
    }

    #--------------------------------------------------------------------------------------
    public function usersIndex(){
        $scripts = Script::where('status',0)->paginate(10);
        return view('admin_users.scripts.index',[
            'scripts'=>$scripts,
        ]);
    }

    public function usersShowScript($script_id){
        $script= Script::find($script_id);
        return view('admin_users.scripts.show',[
            'script'=>$script,
        ]);
    }
   
}
