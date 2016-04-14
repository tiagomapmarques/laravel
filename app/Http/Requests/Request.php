<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;
use Helper;

/**
 * Base class for requests
 *
 * This class implements basic request functionality and should be the
 * base class for all requests in your application.
 */
abstract class Request extends FormRequest {
	/**
	 * Function to get the set of rules that all requests should obey.
	 *
	 * This function returns a set of rules that all requests should obey. It is
	 * intended to be overwritten but, if used, it returns a general purpose
	 * set of rules.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name'  => 'required|min:5|max:255',
			'email' => 'required|email',
			'image' => 'image|max:'.Helper::getUploadLimit(),
			'file'  => 'max:'.Helper::getUploadLimit(),
		];
	}
}
