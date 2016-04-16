<?php

namespace App\Admin\Addons\Display\Column;

use Helper;
use SleepingOwl\Admin\Display\Column\Text as Text;

// TODO: check if bug is gone...
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Translatable::class)) {

/**
 * Column for displaying a translation of a value on Sleeping Owl
 */
class Translatable extends Text {
	/**
	 * Name of translation file to be used.
	 *
	 * @var string
	 */
	protected $prefix = 'database';

	/**
	 * Character that separates entities on the translation string.
	 *
	 * @var string
	 */
	protected $divider = '-';

	/**
	 * Quantity of the translation (singular, plural, ...).
	 *
	 * @var integer
	 */
	protected $choice = 1;

	public function setChoice($number) {
		$this->choice = $number;
		return $this;
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$model_array = explode('\\',get_class($this->model));
		$model_name = strtolower($model_array[count($model_array)-1]);
		$translation = Helper::trans(
			$this->prefix.'.' .
				$model_name.$this->divider .
				$this->name.$this->divider .
				$this->getModelValue(),
			$this->choice
		);
		return view(
			'admin::addons.display.column.translatable',
			$this->toArray() + ['translation' => $translation],
			[]
		);
	}
}

} // end of "require" hack
