<?php

namespace App\Admin\Addons\Display\Column;

use SleepingOwl\Admin\Display\Column\Text as Text;

// TODO: check if bug is gone...
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\BoolFunction::class)) {

/**
 * Column for displaying the return of a boolean function on Sleeping Owl
 */
class BoolFunction extends Text {

	/**
	 * Override of function to avoid it accessing the $name attribute.
	 *
	 * @return null
	 */
	public function getModelValue() {
		return null;
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$class = get_class($this->model);
		$name = $this->name;
		$result = $class::find($this->model->id)->$name();
		return view(
			'admin::addons.display.column.boolfunction',
			$this->toArray() + ['result' => $result],
			[]
		);
	}
}

} // end of "require" hack
