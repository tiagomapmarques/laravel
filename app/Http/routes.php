<?php

/* --------------------------------------------------------------------------
 *  Application Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register all of the routes for an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
 *
 */
Route::group(['middleware' => ['web']], function () {
	Route::get('/', function() {
		return view('welcome');
	});
});

/* --------------------------------------------------------------------------
 *  API Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register all of the routes for your application's
 * API. Do it the same way as if you were registering a regular route.
 * With just a pinch of salt in the group statement. Note that the default
 * action of any non-existing API call is an empty string.
 *
 * For debugging purposes only, you can change the middleware to
 * "api-permissive" in order to skip validations and throttling.
 *
 */
Route::group(['namespace' => 'API', 'prefix' => 'api', 'middleware' => ['api']], function() {

	Route::post('echo', 'DefaultAction@run');
});
