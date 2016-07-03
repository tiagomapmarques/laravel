<?php

namespace App\Admin\Addons\Display\Column;

use \App\Admin\Addons\Display\Column\LurkBase as LurkBase;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Boolean::class)) {

/**
 * Column for displaying the return of a boolean function on Sleeping Owl
 */
class Boolean extends LurkBase {
	/**
	 * Font-awesome class to represent "true".
	 *
	 * @var string
	 */
	protected $faTrue = 'fa-check';

	/**
	 * Font-awesome class to represent "false".
	 *
	 * @var string
	 */
	protected $faFalse = 'fa-minus';

	/**
	 * Function to set the font-awesome class for "true".
	 *
	 * @param  string  $class
	 * @return \App\Admin\Addons\Display\Column\Boolean
	 */
	public function setTrueClass($class) {
		$this->faTrue = $class;
		return $this;
	}

	/**
	 * Function to set the font-awesome class for "false".
	 *
	 * @param  string  $class
	 * @return \App\Admin\Addons\Display\Column\Boolean
	 */
	public function setFalseClass($class) {
		$this->faFalse = $class;
		return $this;
	}

	/**
	 * Override of function to avoid it accessing the $name attribute
	 * during the toArray function on SleepingOwl\Admin\Display\Column\Text
	 *
	 * @return \App\Admin\Addons\Display\Column\Boolean
	 */
	public function getModelValue() {
		return '';
	}

	/**
	 * Function to return this object as an array.
	 *
	 * @return array
	 */
	public function toArray() {
		return parent::toArray() + [
			'fa_true'  => $this->faTrue,
			'fa_false' => $this->faFalse,
		];
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	protected function process() {
		$class = get_class($this->model);
		$name = $this->name;
		$object = $class::find($this->model->id);

		$this->result = '';
		if(method_exists($object, $name)) {
			$this->result = $object->$name();
		} else if(property_exists($object, $name)) {
			$this->result = $object->$name;
		}
	}
}

} // end of "require" hack
