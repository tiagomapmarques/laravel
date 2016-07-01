<?php

namespace App\Admin\Addons\Display\Column;

use SleepingOwl\Admin\Display\Column\Text as Text;

// TODO: check if bug is gone...
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Reference::class)) {

/**
 * Column for displaying a reference of another class on Sleeping Owl
 */
class Reference extends Text {
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
	 * Main output variable from this class.
	 *
	 * @var string
	 */
	protected $result = '';

	/**
	 * Class constructor.
	 */
	public function __construct($name, $class, $label = null) {
		parent::__construct($name, $label);
		$this->reference_class = $class;
		$this->reference_class_attribute = $name;
	}

	/**
	 * Function to set the outside reference for the $name attribute.
	 *
	 * @return \App\Admin\Addons\Display\Column\Reference
	 */
	public function setReference($attribute) {
		$this->reference_class_attribute = $attribute;
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
		// get the referenced object's value
		$model = $this->reference_class;
		$model_attr = $this->reference_class_attribute;
		$value = $this->getModelValue();
		$this->result = $model::where($model_attr, $value)->first()->$model_attr;
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$this->process();
		return view('admin::addons.display.column.reference', $this->toArray(), []);
	}
}

} // end of "require" hack
