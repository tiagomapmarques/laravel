<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

/**
 * CSRF verification middleware
 *
 * This middleware makes sure that only requests sent with a valid token are
 * allowed through the routes that are grouped under this class.
 */
class VerifyCsrfToken extends BaseVerifier {
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		//
	];
}
