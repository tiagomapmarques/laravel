<?php

namespace App\Http\Controllers;

use App\Traits\AutoModelSearch as AutoModelSearch;
use Illuminate\Http\Request;

class SearchController extends Controller {

	use AutoModelSearch;

	/**
	 * Models to be be automatically included in the search
	 *
	 * @var array
	 */
	protected $search_targets = [
		'user'
	];

	public function index(Request $request) {
		return view('search.index', [
			'_navigation_search' => false,
			'_search_text' => $request->q,
			'_search_results' => $this->get_search_results($request->q)
		]);
	}
}
