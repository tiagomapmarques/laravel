<?php

namespace App\Http\Requests;

use Auth;
use Helper;

/**
 * User update request
 *
 * This class should be used for updates to User details, except passwords.
 */
class UserUpdateRequest extends Request {
	/**
	 * Function to allow or deny a specific request.
	 *
	 * This function should allow or deny a specific request made to the
	 * application based on who and what is being accessed, not the content of
	 * the request itself.
	 *
	 * @return boolean
	 */
	public function authorize() {
		return Auth::user();
	}

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
			'image' => 'image|max:'.Helper::getUploadLimit(),
		];
	}
}
