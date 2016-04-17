<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Config;
use DB;

/**
 * Role model
 *
 * This class provides an interface for the database table "roles".
 */
class Role extends Model {
	/**
	 * The attributes that are searchable.
	 *
	 * @var array
	 */
	public static $searchable = [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'name', 'class',
	];

	/**
	 * Function to return all roles that are Administrators.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public static function allAdmin($columns = ['*']) {
		return DB::table('roles')
			->select($columns)
			->where('name', 'LIKE', Config::get('auth.admin_role_prefix'))
			->orWhere('name', 'LIKE', Config::get('auth.admin_role_prefix').'-%')
			->get();
	}

	/**
	 * Function to return all roles that are Users (non-Administrators).
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public static function allUser($columns = ['*']) {
		return DB::table('roles')
			->select($columns)
			->where('name', 'NOT LIKE', Config::get('auth.admin_role_prefix'))
			->where('name', 'NOT LIKE', Config::get('auth.admin_role_prefix').'-%')
			->get();
	}
}
