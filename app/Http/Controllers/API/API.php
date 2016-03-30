<?php

namespace App\Http\Controllers\API;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

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
	 * The API component's point of entry.
	 *
	 * It parses the request, looking for POST parameters to store
	 * and calls the execute method. It only accepts POST requests but
	 * should always receive all requests as to standardise the response.
	 * This method is final and should not be overwritten.
	 *
	 * @param  \Illuminate\Http\Request  $request
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
			abort(404);
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