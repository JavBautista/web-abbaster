<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MessagesContact;
use Exception;
use Illuminate\Validation\Rule;

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
        try {
            $validatedData = $request->validate([
                'shop_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string',
                'g-recaptcha-response' => ['required', Rule::in([request('g-recaptcha-response')])],
            ]);

            $message = new MessagesContact();
            $message->read = 0;
            $message->shop_id = $validatedData['shop_id'];
            $message->name = $validatedData['name'];
            $message->email = $validatedData['email'];
            $message->phone = $validatedData['phone'];
            $message->message = $validatedData['message'];
            $message->save();

            return redirect()->back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto con usted.');
        } catch (Exception $e) {
            // Aquí puedes manejar la excepción como desees, por ejemplo, registrarla o redirigir con un mensaje de error.
            return redirect()->back()->with('error', 'Ha ocurrido un error al enviar el mensaje.');
        }
    }

    public function updateRead(Request $request){
        $message_id = $request->id;
        $message = MessagesContact::findOrfail($message_id);
        $message->read = 1;
        $message->save();
    }

}
