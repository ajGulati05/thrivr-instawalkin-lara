<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class CreateGuestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'firstname'=>'required|string',
        'lastname'=>'required|string',
        'email'=>'email|sometimes|nullable',
        'phone'=>'sometimes|string|min:17|max:17|nullable',
        'verify'=> ['sometimes',Rule::in([1,0])]
        ];
    }
}
