<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            "name" => 'required',
            "slug" => 'required',
            "graph" => 'required',
            "what" => 'required',
            "where" => 'required',
            "description" => 'required',
            "mode" => 'required',
            "length" => 'required',
            "from" => 'required',
            "to" => 'required',
            "buffer" => 'required',
            "ignore_all_day_events" => 'required',
            "manager_resource"=>'required'
        ];
    }
}
