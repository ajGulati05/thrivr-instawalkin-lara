<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CovidFormRequest extends FormRequest
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
        'name'=>'required_if:modifier,U|string',
        'active' => ['required',Rule::in([1,0])],
        'testing'=>'required_if:modifier,U|string',
        'symptoms' => 'sometimes|string',
        'exposure' =>'sometimes|string',
        'travel' =>'sometimes|string',
        'precautions' => 'sometimes|string',
        'contact' =>'sometimes|string',
        'actions' => 'sometimes|string',
        'consent' => ['required',Rule::in([1,0])],
        'modifier'=>['required',Rule::in(['C','U'])],
     
        ];
    }
}
