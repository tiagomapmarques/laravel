<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * Cookie encryptation middleware
 *
 * This middleware makes sure all cookies that are used are encrypted.
 */
class EncryptCookies extends BaseEncrypter {
	/**
	 * The names of the cookies that should not be encrypted.
	 *
	 * @var array
	 */
	protected $except = [
		//
	];
}
