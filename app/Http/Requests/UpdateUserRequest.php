<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
	public function authorize(){
		return $this->user()->isAdmin() or $this->user()->id == auth()->user()->id;
	}

  public function rules()
  {
    $rules = [
      'name' => 'required|string',
      'surnames' => 'string',
      'nickname' => 'string|nullable',
      'nif' => 'min:9|string',
      'address' => 'required|string|min:2',
      'locality' => 'required|string|min:2',
      'province' => 'required|string|min:2',
      'country' => 'required|string|min:2',
      'post_code' => 'required|string',
      'phone' => 'string|min:9|nullable',
    ];

    if($this->get('password')):
      $rules = array_merge($rules, [
        'password' => 'string|min:6|nullable',
        'password_confirmation' => 'string|min:6|same:password'
      ]);
    endif;

    return $rules;
  }
}
