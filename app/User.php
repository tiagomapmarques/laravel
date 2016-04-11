<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Role;
use App\Traits\ImagePathing as ImagePathing;
use Config;
use Helper;

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
		static::creating(function($User) {
			$User->hash = Helper::generateHash();
			if(is_null($User->role_id)) {
				$Role_user = Role::where('name', 'user')->first();
				$User->role()->associate($Role_user);
			}
		});
	}

	/**
	 * Function to return the User's role as an Eloquent relationship.
	 *
	 * This function returns the actual Role of the user.
	 * It will also return an App\Role if it is used as a class property.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
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
	 * Function to return either the default image or the User image
	 *
	 * @return boolean
	 */
	public function image() {
		if($this->image==='' || !file_exists($this->image)) {
			return self::default_image();
		}
		return $this->image;
	}
}
