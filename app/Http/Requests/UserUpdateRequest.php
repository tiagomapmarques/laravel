<?php

namespace App\Http\Requests;

use Auth;
use Helper;

class UserUpdateRequest extends Request {

	public function authorize() {
		return Auth::user();
	}

	public function rules() {
		return [
			'name'  => 'required|min:5|max:255',
			'image' => 'image|max:'.Helper::getUploadLimit(),
		];
	}
}
