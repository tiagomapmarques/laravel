<?php

namespace App\Admin\Addons\Form\Element;

use Language;
use SleepingOwl\Admin\Form\Element\Select as Select;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Form\Element\TranslatableSelect::class)) {

/**
 * Column for displaying a translation of a value on Sleeping Owl
 */
class TranslatableSelect extends Select {
	/**
	 * Class reference of the $name attribute.
	 *
	 * @var string|null
	 */
	protected $referenceClass = null;

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
	protected $referenceClassTranslatable = null;

	/**
	 * Quantity of the translation (singular, plural, ...).
	 *
	 * @var integer
	 */
	protected $choice = 1;

	/**
	 * Class constructor.
	 *
	 * @param  string  $path
	 * @param  string  $translatable
	 * @param  string|null  $label
	 * @param  array|Model  $options
	 */
	public function __construct($path, $translatable, $label = null, $options = []) {
		parent::__construct($path, $label, $options);
		$this->guessModel($path);
		$this->referenceClassTranslatable = $translatable;
		$this->setLoadOptionsQueryPreparer(function($self, $query) {
			$primaryKey = $query->getModel()->getKeyName();
			$collection = $query->select([$primaryKey, $self->referenceClassTranslatable])->get();
			$translatable = $self->referenceClassTranslatable;
			$options = [];
			foreach($collection as $key => $value) {
				$options[$value->$primaryKey] = Language::trans(
					$self->prefix.
						'.'.$self->referenceClass.
						$self->divider.$translatable.
						$self->divider.$value->$translatable,
					$self->choice);
			}
			return $options;
		});
	}

	/**
	 * Function guess the model of the reference by
	 * the original classe's attribute given.
	 *
	 * @param  string  $name
	 * @return boolean
	 */
	private function guessModel($name) {
		$nameSplit = explode('_', $name);
		if(count($nameSplit)<2) {
			return false;
		}
		$model = 'App\\Models\\'.ucfirst($nameSplit[0]);

		if(!class_exists($model)) {
			return false;
		}

		$this->referenceClass = $nameSplit[0];
		$this->setModelForOptions(new $model);
		return true;
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
	* Function to override loadOptions from SleepingOwl\Admin\Form\Element\Select.
	*
	* @return void
	*/
	protected function loadOptions() {
		$repository = app(\SleepingOwl\Admin\Contracts\RepositoryInterface::class, [$this->getModelForOptions()]);
		$key = $repository->getModel()->getKeyName();
		$options = $repository->getQuery();

		if ($this->isEmptyRelation()) {
			$options->where($this->getForeignKey(), 0)->orWhereNull($this->getForeignKey());
		}

		if (count($this->fetchColumns) > 0) {
			$columns = array_merge([$key], $this->fetchColumns);
			$options->select($columns);
		}

		// call the pre load options query preparer if has be set
		if (! is_null($preparer = $this->getLoadOptionsQueryPreparer())) {
			$options = $preparer($this, $options);
		}

		$this->setOptions($options);
	}

	/**
	* Function to retrieve the rendered html.
	*
	* @return \Illuminate\View\View
	*/
	public function render() {
		return view('admin::addons.form.element.translatableselect', $this->toArray())
			->render();
	}
}

} // end of "require" hack
