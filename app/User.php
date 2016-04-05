<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Traits\ModelImage as ModelImage;
use Helper;

class User extends Authenticatable {

	use ModelImage;

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

	public function __construct(array $attributes = []) {
		$this->hash = Helper::generateHash();
		parent::__construct($attributes);
	}
}
