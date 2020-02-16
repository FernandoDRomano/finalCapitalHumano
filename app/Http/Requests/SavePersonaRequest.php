<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePersonaRequest extends FormRequest
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
            'nombre' => 'required|max:255|min:3',
            'apellido' => 'required|max:255|min:3',
            'dni' => 'numeric|required|digits_between:7,8',
            'fechaNacimiento' => 'required',
            'direccion' => 'required|min:5|max:255'
        ];
    }
}
