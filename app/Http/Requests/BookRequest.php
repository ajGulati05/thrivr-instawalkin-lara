<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'timekit_resource_id' => 'required',
            'graph' => "required",
            'customer_id' => 'required',
            "customer_name" => 'required',
            'customer_email' => "required",
            'start' => 'required',
            'end' => "required",
            'what' => "required",
            'where' => "random where",
            'description' => 'required'
        ];
    }
}
