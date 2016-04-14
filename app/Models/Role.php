<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
