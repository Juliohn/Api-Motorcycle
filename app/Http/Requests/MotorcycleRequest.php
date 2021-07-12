<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotorcycleRequest extends FormRequest
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

    public function rules()
    {
        return [
            'id'              =>'sometimes|required|exists:motorcycles,id,deleted_at,NULL',
            'name'            =>'required|min:5|max:100',
            'price'           =>"required",
            'quantity'        =>'sometimes|required|min:1|numeric',
        ];
    }

    public function messages()
    {
        return [
              'id.exists' => "Invalid data",
              'name.required' => "The field name is required",
              'price.required' => "The field price is required",
              'quantity.required' => "The field quantity is required",
              'quantity.min' => "The field quantity minimum is 1",
        ];
    }
}
