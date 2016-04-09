<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AutoModelSearch as AutoModelSearch;

class SearchController extends Controller {

	use AutoModelSearch;

	protected $search_targets = [
		'user'
	];

	public function index(Request $request) {
		return view('search.index', [
			'_navigation_search' => false,
			'_search_text' => $request->q,
			'_seacrh_results' => $this->get_search_results($request->q)
		]);
	}
}
