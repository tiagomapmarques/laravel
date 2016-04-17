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
	 * Font-awesome class to represent "true".
	 *
	 * @var string
	 */
	protected $fa_true = 'fa-check';

	/**
	 * Font-awesome class to represent "false".
	 *
	 * @var string
	 */
	protected $fa_false = 'fa-minus';

	/**
	 * Main output variable from this class.
	 *
	 * @var string
	 */
	protected $result = '';

	/**
	 * Function to set the font-awesome class for "true".
	 *
	 * @return \App\Admin\Addons\Display\Column\BoolFunction
	 */
	public function setTrueClass($class) {
		$this->fa_true = $class;
		return $this;
	}

	/**
	 * Function to set the font-awesome class for "false".
	 *
	 * @return \App\Admin\Addons\Display\Column\BoolFunction
	 */
	public function setFalseClass($class) {
		$this->fa_false = $class;
		return $this;
	}

	/**
	 * Override of function to avoid it accessing the $name attribute.
	 *
	 * @return \App\Admin\Addons\Display\Column\BoolFunction
	 */
	public function getModelValue() {
		return $this;
	}

	/**
	 * Function to return this object as an array.
	 *
	 * @return array
	 */
	public function toArray() {
		return parent::toArray() + [
			'fa_true'  => $this->fa_true,
			'fa_false' => $this->fa_false,
			'result'   => $this->result,
		];
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	private function process() {
		$class = get_class($this->model);
		$name = $this->name;
		$this->result = $class::find($this->model->id)->$name();
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$this->process();
		return view('admin::addons.display.column.boolfunction', $this->toArray(), []);
	}
}

} // end of "require" hack
