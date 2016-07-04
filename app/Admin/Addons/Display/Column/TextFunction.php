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
if(!class_exists(\App\Admin\Addons\Display\Column\TextFunction::class)) {

/**
 * Column for displaying hash values on Sleeping Owl
 */
class TextFunction extends LurkBase {
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
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	protected function process() {
		$class = get_class($this->model);
		$name = $this->name;
		$Object = $class::find($this->model->id);

		$this->result = '';
		if(!is_null($Object)) {
			$this->result = $Object->$name();
		}
	}
}

} // end of "require" hack
