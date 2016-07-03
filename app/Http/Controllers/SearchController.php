<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Http\Controllers\API\Search as Search;

/**
 * Class to implement the search controller
 */
class SearchController extends Controller {
	/**
	 * Function to get the view for the index action.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request) {
		return view('search.index', [
			'_navigation_search' => false,
			'_search_text' => $request->q,
			'_search_results' => (new Search())->query($request->q)
		]);
	}
}
