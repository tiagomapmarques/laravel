<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Traits\FileProcessing as FileProcessing;
use Language;

/**
 * Base class for controllers
 *
 * This class implements basic controller functionality and should be the
 * base class for all controllers in your application.
 */
abstract class Controller extends BaseController {

	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

	use FileProcessing;

	/**
	 * Constructor for all page controllers.
	 *
	 * Function to create a controller instance. Also sets the locale of the
	 * page in order for it not to be ambiguous during page processing.
	 */
	public function __construct() {
		Language::apply();
		//parent::__construct(); // BaseController has no construct
	}
}
