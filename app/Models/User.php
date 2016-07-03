<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Administrator;
use App\Models\Role;
use App\Traits\FilePathing as FilePathing;
use Config;
use File;
use Helper;
use Generate;

/**
 * User model
 *
 * This class provides an interface for the database table "users".
 */
class User extends Authenticatable {

	use FilePathing;

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
		// define FilePathing variables for User image
		self::$baseFilePath = 'images';
		self::$childClassFileAttribute = 'image';
		// before saving a new User to the database
		static::creating(function($User) {
			$User->hash = Generate::hash();
			if(is_null($User->password)) {
				$User->password = bcrypt($User->email);
			}
			if(is_null($User->role_id)) {
				$User->role()->associate(Role::where('model', 'User')->first());
			}
			if(strpos($User->image, Config::get('sleeping_owl.imagesUploadDirectory'))>=0) {
				$User->moveFile(null, true);
			}
		});
		// before updating a User in the database
		static::updating(function($User) {
			if(strpos($User->image, Config::get('sleeping_owl.imagesUploadDirectory'))>=0) {
				$User->moveFile(null, true);
			}
		});
		// before deleting a User from the database
		static::deleting(function($User) {
			File::delete($User->image);
		});
	}

	/**
	 * Function to return the User's role as an Eloquent relationship.
	 *
	 * This function returns the actual Role of the User.
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
	 * Function to get the images files path.
	 *
	 * @return string
	 */
	public static function imagesPath() {
		return self::filesPath();
	}

	/**
	 * Function to the image file for the User.
	 *
	 * @return string
	 */
	public function getImage() {
		return $this->getFile();
	}

	/**
	 * Function to help querying the database for Users.
	 *
	 * @param  array  $columns
	 * @param  array  $roleIds
	 * @return array
	 */
	protected static function _all($columns = ['*'], $roleIds) {
		return parent::all($columns)->whereIn('role_id', $roleIds);
	}

	/**
	 * Function to return all Users from the database.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public static function all($columns = ['*']) {
		$Roles = Role::allUser(['id']);
		$roleIds = Helper::toSimpleArray($Roles, 'id');
		return self::_all($columns, $roleIds);
	}

	/**
	 * Function to return all Users from the database, regardless of their role.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public static function allRaw($columns = ['*']) {
		return parent::all($columns);
	}

	/**
	 * Function to restrict the scope of User's admin page to Users only.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return void
	 */
	public function scopeUser($query) {
		$query->where('role_id', Helper::toSimpleArray(Role::allUser('id'),'id'));
	}

	/**
	 * Function to restrict the scope of User's admin page to Administrators only.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return void
	 */
	public function scopeAdmin($query) {
		$query->where('role_id', Helper::toSimpleArray(Role::allAdmin('id'),'id'));
	}
}
