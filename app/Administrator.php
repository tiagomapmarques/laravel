<?php

namespace App;

use SleepingOwl\Admin\Auth\Administrator as BaseAdministrator;

class Administrator extends BaseAdministrator {
	/**
	 * The attributes that are searchable.
	 *
	 * @var array
	 */
	public static $searchable = [];
}
