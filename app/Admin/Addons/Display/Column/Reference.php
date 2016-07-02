<?php

namespace App\Admin\Addons\Display\Column;

use \App\Admin\Addons\Display\Column\LurkBase as LurkBase;
use Schema;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Reference::class)) {

/**
 * Column for displaying a reference of another class on Sleeping Owl
 */
class Reference extends LurkBase {
	/**
	 * Class reference of the $name attribute.
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
	 * Class constructor.
	 *
	 * @param  string  $name
	 * @param  string|null  $label
	 */
	public function __construct($name, $label = null) {
		parent::__construct($name, $label);
		$this->guessModelAndAttribute($name);
	}

	/**
	 * Function guess the model and attribute of the reference by
	 * the original classe's attribute given.
	 *
	 * @param  string  $name
	 * @return boolean
	 */
	private function guessModelAndAttribute($name) {
		$name_split = explode('_', $name);
		if(count($name_split)<2) {
			return false;
		}
		$model = 'App\\Models\\'.ucfirst($name_split[0]);
		$attr = $name_split[1];
		$value = $this->getModelValue();

		if(!class_exists($model)) {
			return false;
		}

		$model_plural = str_plural($name_split[0]);
		if(class_exists($model) && Schema::hasColumn($model_plural, $attr)) {
			$this->setReference($model, $attr);
			return true;
		}
		return false;
	}

	/**
	 * Function to set the outside reference for the $name attribute.
	 *
	 * @param  string  $class
	 * @param  string  $attribute
	 * @return \App\Admin\Addons\Display\Column\Reference
	 */
	public function setReference($class, $attribute) {
		$this->reference_class = $class;
		$this->reference_class_attribute = $attribute;
		return $this;
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	protected function process() {
		// get the referenced object's value
		$model = $this->reference_class;
		$model_attr = $this->reference_class_attribute;
		$value = $this->getModelValue();
		$this->result = $model::where($model_attr, $value)->first()->$model_attr;
	}
}

} // end of "require" hack
