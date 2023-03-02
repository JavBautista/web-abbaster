<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'query'=>'required|max:100',
        ];
    }

    public function messages(){
        return[
            'query.required'=>'Ingrese el parametro a buscar',
            'query.max'=>'El parametro no puede ser mayor a 100 caracteres ',
        ];
    }
}
