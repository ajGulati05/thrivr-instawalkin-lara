<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class IntakeFormRequest extends FormRequest
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
        'address'=>'required_if:modifier,U|string',
        'phone' => 'required_if:modifier,U|string',
        'birthdate' =>'required_if:modifier,U|string',
        'referred_by' =>'sometimes|string',
        'physician_name' => 'sometimes|string',
        'allergies' =>'sometimes|string',
        'sports_activities' => 'sometimes|string',
        'current_medications' => 'sometimes|string',
        'medical_conditions' => 'sometimes|string',
        'care' =>'sometimes|string',
        'surgery' => 'sometimes|string',
        'fractures' =>'sometimes|string',
        'illness' => 'sometimes|string',
        'motor_workplace' => 'sometimes|string',
        'tests' => 'sometimes|string',
        'relieves' => 'sometimes|string',
        'aggravates' => 'sometimes|string',
        'consent' => ['required',Rule::in([1,0])],
        'modifier'=>['required',Rule::in(['C','U'])],
     
        ];
    }
}
