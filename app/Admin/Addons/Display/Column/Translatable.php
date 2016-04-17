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
	 * Class that is referenced by the $name attribute.
	 *
	 * @var string|null
	 */
	protected $reference_class = null;

	/**
	 * Attribute of the class that is referenced by the $name attribute.
	 *
	 * @var string|null
	 */
	protected $reference_class_attribute = null;

	/**
	 * Attribute inside the referenced class that should be translated.
	 *
	 * @var string|null
	 */
	protected $reference_class_translatable = null;

	/**
	 * Quantity of the translation (singular, plural, ...).
	 *
	 * @var integer
	 */
	protected $choice = 1;

	/**
	 * Main output variable from this class.
	 *
	 * @var string
	 */
	protected $result = '';

	/**
	 * Function to set an outside reference for the translation.
	 *
	 * @return \App\Admin\Addons\Display\Column\Translatable
	 */
	public function setReference($class, $attribute, $translatable) {
		$this->reference_class = $class;
		$this->reference_class_attribute = $attribute;
		$this->reference_class_translatable = $translatable;
		return $this;
	}

	/**
	 * Function to set the quantity of the translation.
	 *
	 * @return \App\Admin\Addons\Display\Column\Translatable
	 */
	public function setChoice($number) {
		$this->choice = $number;
		return $this;
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
	private function process() {
		// set model and attributes as if there was no reference class
		$model = get_class($this->model);
		$translatable = $this->name;
		$value = $this->getModelValue();
		$translation_string = '';

		// if there is a reference class, get the referenced object's value
		if(!is_null($this->reference_class)) {
			$model = $this->reference_class;
			$model_attr = $this->reference_class_attribute;
			$translatable = $this->reference_class_translatable;
			$value = $model::where($model_attr, $value)->first()->$translatable;
		}

		// build the translation string
		$model_array = explode('\\',$model);
		$model_name = strtolower($model_array[count($model_array)-1]);
		$translation_string =
			$model_name.$this->divider .
			$translatable.$this->divider .
			$value;

		// preform the translation
		$this->result = Helper::trans(
			$this->prefix.'.'.$translation_string,
			$this->choice
		);
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$this->process();
		return view('admin::addons.display.column.translatable', $this->toArray(), []);
	}
}

} // end of "require" hack
