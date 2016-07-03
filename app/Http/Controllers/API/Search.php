<?php

namespace App\Http\Controllers\API;

use App\Traits\ModelSearch as ModelSearch;

/**
 * Class to implement an echo function on the API
 */
class Search extends API {

	use ModelSearch;

	/**
	 * Models to be be automatically included in the search.
	 *
	 * @var array
	 */
	protected $searchTargets = [
		'user'
	];

	/**
	 * Function to get all search results from models.
	 *
	 * @param  string  $string
	 * @return string
	 */
	public function query($string) {
		return $this->searchResults($string);
	}

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
		$searchString = array_key_exists('q', $this->parameters) ? $this->parameters['q'] : null;
		return json_encode($this->query($searchString));
	}
}
