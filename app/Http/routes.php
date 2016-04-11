<?php

/* --------------------------------------------------------------------------
 *  Application Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register all of the routes for an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
 *
 * The 'web' middleware is used as the default if a Route is registered with
 * no group. Making it explicit will break error messages in authentication.
 *
 */
Route::get('/', ['as' => 'root', 'uses' => 'RootController@index']);

Route::get('/search', ['as' => 'search', 'uses' => 'SearchController@index']);

Route::get('/locale/{locale?}', ['as' => 'locale', 'uses' => function($locale = null) {
	Helper::applyLocale($locale);
	return redirect()->back();
}]);

// Routes for logged users only
Route::group(['middleware' => ['auth']], function () {
	// User routes
	Route::get('user/update', ['as' => 'user.update', 'uses' => 'UserController@update']);
	Route::post('user/update', ['uses' => 'UserController@postUpdate']);
	Route::get('user/password', ['as' => 'user.password', 'uses' => 'UserController@password']);
	Route::post('user/password', ['uses' => 'UserController@postPassword']);
	Route::get('home', ['as' => 'home', 'uses' => 'UserController@index']);

	// Auth routes
	Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']); //getLogout does not work
});

// Routes for guests only
Route::group(['middleware' => ['guest']], function () {
	// Auth routes
	Route::get('register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
	Route::post('register', ['as' => 'register_post', 'uses' => 'Auth\AuthController@postRegister']);
	Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
	Route::post('login', ['as' => 'login_post', 'uses' => 'Auth\AuthController@postLogin']);
	Route::get('password/reset/{token?}', ['as' => 'password_reset', 'uses' => 'Auth\PasswordController@getReset']);
	Route::post('password/email', ['as' => 'password_email_post', 'uses' => 'Auth\PasswordController@postEmail']);
	Route::post('password/reset', ['as' => 'password_reset_post', 'uses' => 'Auth\PasswordController@postReset']);
});

// Routes for all users

// User routes
Route::get('user/{hash?}', ['as' => 'user', 'uses' => 'UserController@index']);

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
