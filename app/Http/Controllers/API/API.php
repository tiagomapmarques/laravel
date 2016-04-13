<?php

namespace App\Http\Controllers\API;

use Helper;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

/**
 * Class to extend in order to implement an API command.
 */
abstract class API extends BaseController {
	/**
	 * A copy of the full request for later access.
	 *
	 * @var \Illuminate\Http\Request
	 */
	protected $request = null;

	/**
	 * The parsed arguments of the original request.
	 *
	 * @var array
	 */
	protected $parameters = Array();

	/**
	 * The default error to be returned when request is not POST.
	 *
	 * @var string
	 */
	protected $default_error = 404;

	/**
	 * Constructor for all API classes.
	 *
	 * Function to create an API instance. Also sets the locale in order
	 * for it not to be ambiguous during processing.
	 */
	public function __construct() {
		Helper::applyLocale();
		//parent::__construct(); // BaseController has no construct
	}

	/**
	 * The API component's point of entry.
	 *
	 * It parses the request, looking for POST parameters to store
	 * and calls the execute method. It only accepts POST requests but
	 * should always receive all requests as to standardise the response.
	 * This method is final and should not be overwritten.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return string
	 */
	public final function run(Request $request) {
		if($request->isMethod('post')) {
			$this->request = $request;
			$array = $this->request->request->all();
			foreach($array as $key => $item) {
				if($key!=='_token') {
					$this->parameters[$key] = $item;
				}
			}
			return $this->execute();
		}
		else {
			abort($this->$default_error);
		}
	}

	/**
	 * The API component's method that executes the desired API code.
	 *
	 * Method that executes the desired API code.
	 * This method should be overwritten by all sub-classes as its default
	 * behaviour is to echo all the parameters of the original request.
	 *
	 * @return string
	 */
	protected function execute() {
		return json_encode($this->parameters);
	}
}
