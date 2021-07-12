<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMotorcycleRequest extends FormRequest
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
            'motorcycle_id'   =>'required|exists:motorcycles,id,deleted_at,NULL',
            'quantity'        =>'required|min:1|numeric',
            'operation'       =>'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
              'motorcycle_id.exists'   => "Invalid data",
              'motorcycle_id.required' => "Invalid data",
              'quantity.required'      => "The field quantity is required",
              'quantity.min'           => "The field quantity minimum is 1",
              'operation.required'     => "The field type is required",
              'operation.in'           => "The field type is invalid",
        ];
    }
}
