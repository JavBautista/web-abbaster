<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class MyLoginController extends Controller
{

    public function loginCustomer(Request $request){
        $this->validateLogin($request);
        $error=true;
        $error_msg='';
        $user = User::where('email',$request->email)->first();
        if($user){
            if($user->hasRole('user')){
                if(Auth::attempt(['email' => $request->email,'password' => $request->password, 'active'=>1 ])){
                    $error=false;
                }else{
                   $error_msg="Las credenciales proporcionadas no son correctas.";
                }

            }else{

                $error_msg="El usuario proporcionado no es de tipo cliente.";
            }
        }else{
            $error_msg="El usuario proporcionado no existe.";
        }
        return [
            'error'=>$error,
            'error_msg'=>$error_msg,
        ];



    }

    protected function validateLogin(Request $request){
        $this->validate($request,[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
