<?php

namespace App\Http\Controllers\API;

/**
 * Class to implement an echo function on the API
 */
class DefaultAction extends API {
	/**
	 * The function that will run once the API is called.
	 *
	 * The execute function will be called when an API POST request is passed
	 * to this class by the routes file. Although it should call the "run" method,
	 * "run" method will call "execute" if the request is valid.
	 *
	 * @return string
	 */
	protected function execute() {
		return parent::execute();
	}
}
