<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClinicRequest extends FormRequest
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
            'name' => 'required|string',
            'address' => 'required|string|min:5',
            'locality' => 'required|string|min:3',
            'province' => 'required|string|min:3',
            'country' => 'required|string|min:3',
            'post_code' => 'required|string',
            'phone' => 'string|min:9|nullable',
            'fax' => 'string|min:9|nullable',
            'percentage' => 'required|integer|min:1|max:100'
        ];
    }
}
