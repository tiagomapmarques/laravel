<?php

namespace App\Admin\Addons\Display\Column;

use SleepingOwl\Admin\Display\Column\Custom as Custom;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Download::class)) {

/**
 * Column for displaying the return of a boolean function on Sleeping Owl
 */
class Download extends Custom {
	/**
	 * Class reference of the $name attribute.
	 *
	 * @var string
	 */
	protected $attribute;

	/**
	 * Class reference of the $name attribute.
	 *
	 * @var string
	 */
	protected $text;

	/**
	 * Class constructor.
	 *
	 * @param  string $attribute
	 * @param  string $text
	 * @param  string|null $label
	 */
	public function __construct($attribute, $text, $label = null) {
		parent::__construct($label);
		$this->attribute = $attribute;
		$this->text = $text;
		$this->setCallback(function($Object) {
			$text = $this->text;
			$attr = $this->attribute;
			if(method_exists($Object, $attr)) {
				$result = $Object->$attr();
			} else if(property_exists($Object, $attr)) {
				$result = $object->$attr;
			} else {
				$result = '';
			}
			return '<a class="btn btn-action btn-default" href="/'.$result.'">'.$text.'</a>';
		});
	}
}

} // end of "require" hack
