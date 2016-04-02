<?php

/* --------------------------------------------------------------------------
 *  Application Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register all of the routes for an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
 *
 * The 'web' middleware is used as the default if a Route is registered
 * without a group. But making it explicit is never harmful.
 *
 */
Route::group(['middleware' => ['web']], function () {

	Route::get('/', ['as' => 'root', 'uses' => 'DefaultController@index']);

	Route::get('/locale/{locale?}', function($locale = null) {
		Helper::applyLocale($locale);
		return redirect()->back();
	});

	// Routes for logged users only
	Route::group(['middleware' => ['auth']], function () {
		// Auth routes
		Route::get('logout', 'Auth\AuthController@getLogout');
	});

		// Routes for guests only
	Route::group(['middleware' => ['guest']], function () {
		// Auth routes
		Route::get('register', 'Auth\AuthController@getRegister');
		Route::post('register', 'Auth\AuthController@postRegister');
		Route::get('login', 'Auth\AuthController@getLogin');
		Route::post('login', 'Auth\AuthController@postLogin');
		Route::controllers([ 'password' => 'Auth\PasswordController' ]);
	});
});

/* --------------------------------------------------------------------------
 *  API Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register all of the routes for your application's
 * API. Do it the same way as if you were registering a regular route.
 * With just a pinch of salt in the group statement.
 *
 * A 404 error is given to all unregistered routes and you should always
 * register the API call with the "any" method - in order to standardise
 * the output and protect the API from polling requests.
 *
 * For debugging purposes only, you can change the middleware from "api"
 * to "api-permissive" in order to skip validations and throttling.
 *
 */
Route::group(['namespace' => 'API', 'prefix' => Config::get('app.api_prefix'), 'middleware' => ['api']], function() {

	Route::any('echo', 'DefaultAction@run');

	Route::group(['middleware' => ['auth']], function() {
		// API available for logged users only
	});
});
