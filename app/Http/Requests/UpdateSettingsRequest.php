<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
	public function authorize(){
		return $this->user()->isAdmin() or $this->user()->id == auth()->user()->id;
	}

  public function rules()
  {
    $rules = [
      'pdf_color' => 'required|string|min:7|max:7',
      'default_percentage' => 'required|integer|between:1,100',
      'default_retention' => 'required|integer|between:1,100'
    ];

    // if($this->get('custom_logo')):
    //   $rules = array_merge($rules, [
    //     'custom_logo' => 'mimes:jpg,jpeg,png',
    //   ]);
    // endif;

    return $rules;
  }
}
