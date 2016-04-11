<?php

namespace App\Http\Requests;

use Auth;

class UserPasswordRequest extends Request {

	public function authorize() {
		return Auth::user();
	}

	public function rules() {
		return [
			'old_password' => 'required|min:1',
			'password' => 'required|min:6',
			'password_confirmation' => 'required|min:6',
		];
	}
}
