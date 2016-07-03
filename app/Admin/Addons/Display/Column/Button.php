<?php

namespace App\Admin\Addons\Display\Column;

use \App\Admin\Addons\Display\Column\Link as Link;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Button::class)) {

/**
 * Column for displaying the return of a boolean function on Sleeping Owl
 */
class Button extends Link {
	/**
	 * Class constructor.
	 *
	 * @param  string  $attribute
	 * @param  string|null  $label
	 * @param  string|null  $text
	 */
	public function __construct($attribute, $label = null, $text = null) {
		parent::__construct($attribute, $label, $text);
		$this->htmlClasses = 'btn btn-action btn-default';
	}
}

} // end of "require" hack
