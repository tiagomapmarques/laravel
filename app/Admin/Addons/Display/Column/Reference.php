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
	protected $referenceClass = null;

	/**
	 * Attribute of the class that is referenced by the $name attribute.
	 *
	 * @var string|null
	 */
	protected $referenceClassAttribute = null;

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
		$nameSplit = explode('_', $name);
		if(count($nameSplit)<2) {
			return false;
		}
		$model = 'App\\Models\\'.ucfirst($nameSplit[0]);
		$attr = $nameSplit[1];
		$value = $this->getModelValue();

		if(!class_exists($model)) {
			return false;
		}

		$modelPlural = str_plural($nameSplit[0]);
		if(class_exists($model) && Schema::hasColumn($modelPlural, $attr)) {
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
		$this->referenceClass = $class;
		$this->referenceClassAttribute = $attribute;
		return $this;
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	protected function process() {
		// get the referenced object's value
		$model = $this->referenceClass;
		$modelAttribute = $this->referenceClassAttribute;
		$value = $this->getModelValue();
		$this->result = $model::where($modelAttribute, $value)->first()->$modelAttribute;
	}
}

} // end of "require" hack
