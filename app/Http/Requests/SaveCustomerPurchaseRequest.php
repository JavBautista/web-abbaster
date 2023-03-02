<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCustomerPurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tienda'=>'required',
            'mail'=>'required|max:100|email',
            'name'=>'required',
            'phone'=>'required|max:15',
            'movil'=>'required|max:15',
            'zip_code'=>'required|integer|max:99999',
            'address'=>'required',
            'number_out'=>'required',
            'district'=>'required',
            'city'=>'required',
            'state'=>'required',
            'reference'=>'required',
            'detail'=>'required',
        ];
    }

    public function messages(){
        return [
            'tienda.required'=>'Ocurrio un error al obtener el valor de la tienda.',
            
            'mail.required'=>'Este campo es obligatorio.',
            'mail.max'=>'Este campo no puede tener mas de 100 caracteres.',
            'mail.email'=>'El email no tiene un formato correcto.',

            'name.required'=>'Este campo es obligatorio.',
            
            'phone.required'=>'Este campo es obligatorio.',
            'phone.max'=>'Este no puede tener mas de 15 caracteres.',
            
            'movil.required'=>'Este campo es obligatorio.',
            'movil.max'=>'Este no puede tener mas de 15 caracteres.',
            
            'zip_code.required'=>'Este campo es obligatorio.',
            'zip_code.max'=>'Este campo no puede tener mas de 5 caracteres.',
            'zip_code.integer'=>'Este campo solo puede contener numeros.',

            'address.required'=>'Este campo es obligatorio.',
            'number_out.required'=>'Este campo es obligatorio.',

            'district.required'=>'Este campo es obligatorio.',
            'city.required'=>'Este campo es obligatorio.',
            'state.required'=>'Este campo es obligatorio.',
            'reference.required'=>'Este campo es obligatorio.',
            'detail.required'=>'Este campo es obligatorio.',
        ];
    }
}
