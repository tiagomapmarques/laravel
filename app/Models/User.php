<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Role;
use App\Traits\ImagePathing as ImagePathing;
use Config;
use File;
use Helper;

/**
 * User model
 *
 * This class provides an interface for the database table "users".
 */
class User extends Authenticatable {

	use ImagePathing;

	/**
	 * The attributes that are searchable.
	 *
	 * @var array
	 */
	public static $searchable = [
		'name', 'email',
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'hash', 'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Model boot function override.
	 *
	 * @return void
	 */
	protected static function boot() {
		parent::boot();
		// before saving a new user to the database
		static::creating(function($User) {
			$User->hash = Helper::generateHash();
			if(is_null($User->password)) {
				$User->password = bcrypt($User->email);
			}
			if(is_null($User->role_id)) {
				$Role_user = Role::where('name', 'user')->first();
				$User->role()->associate($Role_user);
			}
			if(is_null($User->image)) {
				$User->image = '';
			}
			if(strpos($User->image, Config::get('sleeping_owl.imagesUploadDirectory'))>=0) {
				$User->moveImage(null, true);
			}
		});
		// before updating a new user in the database
		static::updating(function($User) {
			if(is_null($User->image)) {
				$User->image = '';
			}
			if(strpos($User->image, Config::get('sleeping_owl.imagesUploadDirectory'))>=0) {
				$User->moveImage(null, true);
			}
		});
	}

	/**
	 * Function to return the User's role as an Eloquent relationship.
	 *
	 * This function returns the actual Role of the user.
	 * It will also return an \App\Models\Role if it is used as a class property.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function role() {
		return $this->belongsTo(Role::class);
	}

	/**
	 * Function to check if the User is an administrator.
	 *
	 * @return boolean
	 */
	public function isAdmin() {
		return strpos($this->role->name, Config::get('auth.admin_role_prefix'))===0;
	}

	/**
	 * Function to return a valid image for the User.
	 *
	 * This function will either return the User image or, if there is none,
	 * the default image for the User class.
	 *
	 * @return boolean
	 */
	public function getImage() {
		if(!$this->image || $this->image==='' || !file_exists($this->image)) {
			return self::default_image();
		}
		return $this->image;
	}

	/**
	 * Function to re-locate the User image.
	 *
	 * Function to re-locate the User image to a specified location. If none
	 * is provided, the file will just be moved to the default image location
	 * for the User class. This function just updates the User model and does
	 * not update the database. Manual saving is required.
	 *
	 * @param  string|null  $location
	 * @param  boolean      $filename
	 * @return boolean
	 */
	public function moveImage($location = null, $filename = false) {
		if(is_null($this->image) || $this->image==='') {
			return false;
		}
		if(is_null($location)) {
			$location = self::images_path();
		}
		if($filename) {
			$path = explode('.', $this->image);
			$filename = Helper::generateRandomFilename().'.'.$path[count($path)-1];
		}
		else {
			$path = explode(DIRECTORY_SEPARATOR, $this->image);
			$filename = $path[count($path)-1];
		}

		$destination = $location.DIRECTORY_SEPARATOR.$filename;
		File::move($this->image, $destination);
		$this->image = $destination;
	}

	/**
	 * Function to return all Users from the database.
	 *
	 * @param  array    $columns
	 * @param  boolean  $users
	 * @param  boolean  $admins
	 * @return array
	 */
	public static function all($columns = ['*'], $users = true, $admins = false) {
		$function = '';
		if($users && $admins) {
			$function = 'all';
		}
		else if($users && !$admins) {
			$function = 'allUser';
		}
		else if(!$users && $admins) {
			$function = 'allAdmin';
		}
		else {
			return [];
		}
		$Roles = Role::$function(['id']);
		$role_ids = Helper::toSimpleArray($Roles, 'id');
		return parent::all($columns)->whereIn('role_id', $role_ids);
	}
}
