<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\UserPasswordRequest as PasswordRequest;
use App\Http\Requests\UserUpdateRequest as UpdateRequest;
use App\User;
use File;
use Hash;
use Helper;
use Session;

class UserController extends Controller {

	public function index($hash = null) {
		// if(is_null($hash) && !Auth::user()) {
		// 	return redirect()->route('root');
		// }
		// else if(is_null($hash)) {
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

	public function update() {
		return view('user.update', [
			'_navigation_selected' => 'home',
			'_user_User' => Auth::user()
		]);
	}

	public function postUpdate(UpdateRequest $request) {
		$User = Auth::user();
		// rewrite all "fillable" properties of the User model
		$User->fill($request->all());

		// process image file, if there is one
		$file = $request->file('image');
		if(!is_null($file) && $file->isValid()) {
			$filename = Helper::generateRandomFilename().'.jpg';
			$file_was_written = $this->processImage(
				$file, User::images_path(), $filename,
				'jpg', $width = 500
			);
			if($file_was_written) {
				if(file_exists($User->image)) {
					// remove old image file to save disk space
					File::delete($User->image);
				}
				$User->image = User::images_path().DIRECTORY_SEPARATOR.$filename;
			}
		}

		$User->save();
		return redirect()->route('home');
	}

	public function password() {
		return view('user.password', [
			'_navigation_selected' => 'home',
			'_user_User' => Auth::user()
		]);
	}

	public function postPassword(PasswordRequest $request) {
		$User = Auth::user();
		if(!Hash::check($request->old_password, $User->password)) {
			Session::flash('error', Helper::trans('auth.error-old-password'));
			return redirect()->back();
		}
		if($request->password!==$request->password_confirmation) {
			Session::flash('error', Helper::trans('auth.error-password-match'));
			return redirect()->back();
		}

		$User->password = bcrypt($request->password);
		$User->save();
		Session::flash('message', Helper::trans('auth.message-password-change'));
		return redirect()->route('home');
	}
}
