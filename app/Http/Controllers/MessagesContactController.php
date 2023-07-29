<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MessagesContact;

class MessagesContactController extends Controller
{
    public function index(){
        return view('admin.messages_contact_form.index');
    }

    public function get(){
        $messages = MessagesContact::with('shop')->orderBy('read','ASC')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        return [
            'pagination'=>[
                'total'=> $messages->total(),
                'current_page'=> $messages->currentPage(),
                'per_page'=> $messages->perPage(),
                'last_page'=> $messages->lastPage(),
                'from'=> $messages->firstItem(),
                'to'=> $messages->lastItem(),
            ],
            'messages'=>$messages
        ];
    }

    public function store(Request $request){
        $message = new MessagesContact();
        $message->read    = 0;
        $message->shop_id = $request->shop_id;
        $message->name    = $request->name;
        $message->email   = $request->email;
        $message->phone   = $request->phone;
        $message->message = $request->message;
        $message->save();
        return redirect()->back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto con usted.');
    }

    public function updateRead(Request $request){
        $message_id = $request->id;
        $message = MessagesContact::findOrfail($message_id);
        $message->read = 1;
        $message->save();
    }

}
