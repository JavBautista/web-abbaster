<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
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
            'name'=>'required|max:100',
        ];
    }

    public function messages(){
        return [
            'name.required'=> 'Ingrese un nombre para la tienda.',
            'name.max'=> 'El nombre de la tienda no puede superar los 100 caracteres.',
        ];
    }
}
