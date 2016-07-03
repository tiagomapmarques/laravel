<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\UserPasswordRequest as PasswordRequest;
use App\Http\Requests\UserUpdateRequest as UpdateRequest;
use App\Models\User;
use File;
use Generate;
use Hash;
use Language;
use Session;

/**
 * Class to implement the User controller
 */
class UserController extends Controller {
	/**
	 * Function to get the view for the index action.
	 *
	 * @param  string|null  $hash
	 * @return \Illuminate\View\View|Illuminate\Http\RedirectResponse
	 */
	public function index($hash = null) {
		if(is_null($hash)) {
			$hash = Auth::user()->hash;
		}

		$User = User::where('hash', $hash)->first();
		if(is_null($User)) {
			return redirect()->route('root');
		}

		return view('user.index', [
			'_navigation_selected' => 'home',
			'_user_User' => $User
		]);
	}

	/**
	 * Function to get the view for the update action.
	 *
	 * @return \Illuminate\View\View
	 */
	public function update() {
		return view('user.update', [
			'_navigation_selected' => 'home',
			'_user_User' => Auth::user()
		]);
	}

	/**
	 * Function to update the User (except its' password) through a POST request.
	 *
	 * @param  \App\Http\Requests\UserUpdateRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postUpdate(UpdateRequest $request) {
		$User = Auth::user();
		// rewrite all "fillable" properties of the User model
		$User->fill($request->all());

		// process image file, if there is one
		$file = $request->file('image');
		if(!is_null($file) && $file->isValid()) {
			$filename = Generate::filename().'.jpg';
			$fileWasWritten = $this->processImage(
				$file, User::imagesPath(), $filename,
				'jpg', 640, 640
			);
			if($fileWasWritten) {
				if(file_exists($User->image)) {
					// remove old image file to save disk space
					File::delete($User->image);
				}
				$User->image = User::imagesPath().DS.$filename;
			}
		}

		$User->save();
		return redirect()->route('home');
	}

	/**
	 * Function to get the view for the password action.
	 *
	 * @return \Illuminate\View\View
	 */
	public function password() {
		return view('user.password', [
			'_navigation_selected' => 'home',
			'_user_User' => Auth::user()
		]);
	}

	/**
	 * Function to update the User's password through a POST request.
	 *
	 * @param  \App\Http\Requests\UserPasswordRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postPassword(PasswordRequest $request) {
		$User = Auth::user();
		if(!Hash::check($request->old_password, $User->password)) {
			Session::flash('error', Language::trans('auth.error-old-password'));
			return redirect()->back();
		}
		if($request->password!==$request->password_confirmation) {
			Session::flash('error', Language::trans('auth.error-password-match'));
			return redirect()->back();
		}

		$User->password = bcrypt($request->password);
		$User->save();
		Session::flash('message', Language::trans('auth.message-password-change'));
		return redirect()->route('home');
	}
}
