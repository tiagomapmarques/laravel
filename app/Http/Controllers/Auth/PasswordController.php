<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Class to handle the password reset requests
 *
 * This controller is responsible for handling password reset requests
 * and uses a simple trait to include this behavior. You're free to
 * explore this trait and override any methods you wish to tweak.
 */
class PasswordController extends Controller {

	use ResetsPasswords;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->middleware('guest');
	}
}
