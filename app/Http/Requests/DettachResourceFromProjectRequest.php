<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DettachResourceFromProjectRequest extends FormRequest
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
            'timekit_project_id'=>'required',
            'timekit_resource_id'=>'required'
        ];
    }
}
