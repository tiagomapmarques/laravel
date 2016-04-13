<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/**
 * Class responsible for the authorisation process.
 *
 * This controller handles the registration of new users, as well as the
 * authentication of existing users. By default, this controller uses
 * a simple trait to add these behaviors.
 */
class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login/registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return App\Models\User
	 */
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}
}
