<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;

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
				$Role_user = Role::where('name', 'admin')->first();
				$User->role()->associate($Role_user);
			}
		});
		// only launch the user boot function after
		parent::boot();
	}

	/**
	 * Function to return all Administrators from the database.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public static function all($columns = ['*']) {
		return parent::all($columns, false, true);
	}
}
