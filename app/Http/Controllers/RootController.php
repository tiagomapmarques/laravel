<?php

namespace App\Http\Controllers;

/**
 * Class to implement the controller for the root path of the application.
 */
class RootController extends Controller {
	/**
	 * Function to get the view for the index action.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {
		return view('root.index');
	}
}
