<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Config;

/**
 * Exception handler class
 */
class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		AuthorizationException::class,
		HttpException::class,
		ModelNotFoundException::class,
		ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e) {
		parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e) {
		$apiPrefix = Config::get('app.api_prefix');
		if(strlen($apiPrefix)<1) {
			$apiCheck = true;
		}
		else {
			$apiCheck = ($request->is($apiPrefix) || $request->is($apiPrefix.'/*'));
		}

		if(!Config::get('app.debug') && $apiCheck) {
			return '';
		}
		else {
			return parent::render($request, $e);
		}
	}
}
