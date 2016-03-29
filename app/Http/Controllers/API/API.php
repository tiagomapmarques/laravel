<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class API extends Controller {
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
	 * It parses the request, looking for GET or POST parameters to store
	 * and calls the execute method.
	 * This method is final and should not be overwritten.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string
	 */
	public final function run(Request $request) {
		$this->request = $request;
		$array = $this->request->request->all();
		foreach($array as $key => $item) {
			$this->parameters[$key] = $item;
		}
		return $this->execute();
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
