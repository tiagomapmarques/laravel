<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;
use Helper;

abstract class Request extends FormRequest {

	// public function authorize() {
	// 	return true;
	// }

	public function rules() {
		return [
			'name'  => 'required|min:5|max:255',
			'email' => 'required|email',
			'image' => 'image|max:'.Helper::getUploadLimit(),
			'file'  => 'max:'.Helper::getUploadLimit(),
		];
	}
}
