<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Config;

class AdministratorAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		if(!Auth::user() || strpos(Auth::user()->role->name, Config::get('auth.admin_role_prefix'))!==0) {
			return redirect('/');
		}

		return $next($request);
	}
}
