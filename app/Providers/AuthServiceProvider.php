<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use AdminTemplate;

/**
 * Authentication service provider
 *
 * Class where you can bootstrap or register your own modules on the auth
 * service provider.
 */
class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any application authentication / authorization services.
	 *
	 * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
	 * @return void
	 */
	public function boot(GateContract $gate) {
		$this->registerPolicies($gate);

		// add the navbar for the admin section
		view()->composer(AdminTemplate::getTemplateViewPath('_partials.header'), function($view) {
			$view->getFactory()->inject(
				'navbar.right', view('auth.__nav', ['_nav_style' => 'margin-right: 15px;'])
			);
		});
	}
}
