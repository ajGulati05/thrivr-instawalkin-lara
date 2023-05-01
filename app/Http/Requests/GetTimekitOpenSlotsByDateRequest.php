<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTimekitOpenSlotsByDateRequest extends FormRequest
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
            'project_id' => 'required',
            'timeslot_increments' => 'required',
            'constraints' => 'required', //be careful that could be null
        ];
    }
}
