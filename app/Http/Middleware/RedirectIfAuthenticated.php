<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Guest authentication middleware
 *
 * This middleware makes sure that only guests are allowed through the
 * routes that are grouped under this class.
 */
class RedirectIfAuthenticated {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		if(Auth::guard($guard)->check()) {
			return redirect()->back();
		}

		return $next($request);
	}
}
