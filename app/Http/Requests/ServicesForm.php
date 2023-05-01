<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Service;

class ServicesForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $service = Service::find($this->route('services/update'));

     dd($service && $this->auth()->user()->can('update', $service));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        
        ];
    }
}
