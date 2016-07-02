<?php

namespace App\Admin\Addons\Display\Column;

use SleepingOwl\Admin\Display\Column\Text as Text;

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
abstract class LurkBase extends Text {
	/**
	 * Main output variable from this class.
	 *
	 * @var string
	 */
	protected $result = '';

	/**
	 * Base string for the display column view.
	 *
	 * @var string
	 */
	protected $view_base = 'admin::addons.display.column.';

	/**
	 * Base string for the display column view.
	 *
	 * @var string
	 */
	protected $view_class = '';

	/**
	 * Constructor for the LurkBase class.
	 *
	 * @param  string $name
	 * @param  string|null $label
	 */
	public function __construct($name, $label = null) {
		parent::__construct($name, $label);
		$called_class = explode('\\', strtolower(get_called_class()));
		$this->view_class = $called_class[count($called_class)-1];
	}

	/**
	 * Function to return this object as an array.
	 *
	 * @return array
	 */
	public function toArray() {
		return parent::toArray() + [
			'result' => $this->result,
		];
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	abstract protected function process();

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$this->process();
		return view($this->view_base.$this->view_class, $this->toArray(), []);
	}
}

} // end of "require" hack
