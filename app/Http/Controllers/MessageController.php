<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Customer;

class MessageController extends Controller
{
    //--------------------------------------------------------------------------
    //Metodos del Customer Dashboard
    public function store(Request $request){
		if(!$request->ajax()) return redirect('/');

    	Message::create([
    		'user_id'=>$request->user_id,
			'message'=>$request->message,
			'reply'=>$request->reply,
			'status'=>0,
        ]);
    }

    public function getUserMessages(Request $request, $user_id){
    	if(!$request->ajax()) return redirect('/');
    	$messages = Message::where('user_id',$user_id)->get();
        return $messages;
    }

    //--------------------------------------------------------------------------
    //Metodos del Admin Dashboard
    public function indexAdminMessagesCustomer(){
        return view('admin.messages.index');
    }
    public function getUsersMessages(Request $request){
        if(!$request->ajax()) return redirect('/');
        $users_messages = Message::join('users','users.id','=','messages.user_id')
                    ->select('messages.user_id','users.name')
                    ->groupBy('messages.user_id')
                    ->get();
        //$customer = Customer::all();
        return [
            'users_messages'=>$users_messages,
        ];
    }

    public function getMessagesCustomer(Request $request, $user_id){
        if(!$request->ajax()) return redirect('/');
        $messages = Message::where('user_id',$user_id)->orderBy('id','asc')->get();
        return [
            'messages'=>$messages,
        ];
    }
}
