<?php

namespace App\Admin\Addons\Display\Column;

use Language;
use App\Admin\Addons\Display\Column\Reference as Reference;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Translatable::class)) {

/**
 * Column for displaying a translation of a value on Sleeping Owl
 */
class Translatable extends Reference {
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
	 * Class constructor.
	 *
	 * @param  string  $name
	 * @param  string|null  $label
	 */
	public function __construct($name, $translatable, $label = null) {
		parent::__construct($name, $label);
		$this->reference_class_translatable = $translatable;
	}

	/**
	 * Function to set the quantity of the translation.
	 *
	 * @param  integer  $number
	 * @return \App\Admin\Addons\Display\Column\Translatable
	 */
	public function setChoice($number) {
		$this->choice = $number;
		return $this;
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	protected function process() {
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
		$this->result = Language::trans(
			$this->prefix.'.'.$translation_string,
			$this->choice
		);
	}
}

} // end of "require" hack
