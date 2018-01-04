<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicRequest extends CreateClinicRequest
{
	public function authorize(){
		return $this->user()->isAdmin() or $this->user()->isGod() or $this->user()->id == $this->clinic->user_id;
	}
}
