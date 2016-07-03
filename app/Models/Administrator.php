<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Administrator model
 *
 * This class provides an interface for the database table "users" with
 * administrator roles ony.
 */
class Administrator extends User {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are searchable.
	 *
	 * @var array
	 */
	public static $searchable = [];

	/**
	 * Model boot function override.
	 *
	 * @return void
	 */
	protected static function boot() {
		// before saving a new administrator to the database
		static::creating(function($User) {
			if(is_null($User->role_id)) {
				$User->role()->associate(Role::where('model', 'Administrator')->first());
			}
		});
		// only launch the User boot function after
		parent::boot();
	}

	/**
	 * Function to return all Administrators from the database.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public static function all($columns = ['*']) {
		$Roles = Role::allAdmin(['id']);
		$roleIds = Helper::toSimpleArray($Roles, 'id');
		return parent::_all($columns, $roleIds);
	}
}
