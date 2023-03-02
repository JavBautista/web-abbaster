<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
	public function index(){
		return view('admin.users.index');
	}

    public function register(){
        return view('admin.users.register');
    }

	public function getUsers(Request $request){
		//if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $filtro_tipo = $request->filtro_tipo;
        $filtro_estatus = $request->filtro_estatus;

        $roles = Role::all();
		$users = User::join('role_user','role_user.user_id','=','users.id')
                ->join('roles','roles.id','=','role_user.role_id')
                ->select('users.id','users.active','users.name','users.email','users.created_at','roles.description as name_role' )
                ->filtroTipo($filtro_tipo)
                ->filtroStatus($filtro_estatus)
                ->filtroBuscar($buscar,$criterio)
                ->orderBy('users.id','desc')
                ->paginate(10);
        return [
            'pagination'=>[
                'total'=> $users->total(),
                'current_page'=> $users->currentPage(),
                'per_page'=> $users->perPage(),
                'last_page'=> $users->lastPage(),
                'from'=> $users->firstItem(),
                'to'=> $users->lastItem(),
            ],
            'users'=>$users,
            'roles'=>$roles,
        ];
	}

	public function storeUser(Request $request){
		if(!$request->ajax()) return redirect('/');
		$this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[
                'name.required'=>'No se puede guardar nombre vacio.',
                'email.required'=>'No se puede guardar email vacio.',
                'password.required'=>'No se puede guardar password vacio.',
                'name.string'=>'Campo nombre debe ser de tipo cadena.',
                'email.string'=>'Campo email debe ser de tipo cadena.',
                'password.string'=>'Campo password debe ser de tipo cadena.',
                'email.email'=>'El formato del email no es correcto.',
                'name.max'=>'Campo nombre no debe ser mayor a 255 caracteres.',
                'email.max'=>'Campo email no debe ser mayor a 255 caracteres.',
                'password.min'=>'Campo password debe tener minimo 6 caracteres.',
                'email.unique'=>'El email proporcionado ya existe en la BD.',
        ]);

		$user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'active' => 1,
        ]);
        $user->roles()
        	->attach(Role::where('name', $request->rol)->first());
	}



	public function updateUserInfo(Request $request){
		if(!$request->ajax()) return redirect('/');
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
        ],[
                'name.required'=>'No se puede guardar nombre vacio.',
                'email.required'=>'No se puede guardar email vacio.',
                'name.string'=>'Campo nombre debe ser de tipo cadena.',
                'email.string'=>'Campo email debe ser de tipo cadena.',
                'email.email'=>'El formato del email no es correcto.',
                'name.max'=>'Campo nombre no debe ser mayor a 255 caracteres.',
                'email.max'=>'Campo email no debe ser mayor a 255 caracteres.',
                'email.unique'=>'El email proporcionado ya existe en la BD.',
        ]);
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

	}

    public function updateUserPassword(Request $request){
        if(!$request->ajax()) return redirect('/');
        $this->validate($request,[
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[
            'password.required'=>'No se puede guardar password vacio.',
            'password.string'=>'Campo password debe ser de tipo cadena.',
            'password.min'=>'Campo password debe tener minimo 6 caracteres.',
        ]);
        $user = User::findOrFail($request->id);
        $user->password = bcrypt($request->password);
        $user->save();
    }

    public function updateUserActivar(Request $request){
        $user = User::findOrFail($request->id);
        $user->active = 1;
        $user->save();

    }

    public function updateUserDesactivar(Request $request){
        $user = User::findOrFail($request->id);
        $user->active = 0;
        $user->save();
    }

    public function deleteUser(Request $request){
        $user = User::findOrFail($request->id);
        $user->roles()->detach();
        $user->delete();
    }

}
