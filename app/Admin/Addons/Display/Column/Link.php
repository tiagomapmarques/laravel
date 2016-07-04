<?php

namespace App\Admin\Addons\Display\Column;

use SleepingOwl\Admin\Display\Column\Custom as Custom;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Link::class)) {

/**
 * Column for displaying the return of a boolean function on Sleeping Owl
 */
class Link extends Custom {
	/**
	 * Class reference of the $name attribute.
	 *
	 * @var string
	 */
	protected $htmlClasses = 'link';

	/**
	 * Prefix for the link.
	 *
	 * @var string
	 */
	protected $linkPrefix = '/';

	/**
	 * Class reference of the $name attribute.
	 *
	 * @var string
	 */
	protected $attribute;

	/**
	 * Class reference of the $name attribute.
	 *
	 * @var string
	 */
	protected $text;

	/**
	 * Class constructor.
	 *
	 * @param  string  $attribute
	 * @param  string|null  $label
	 * @param  string|null  $text
	 */
	public function __construct($attribute, $label = null, $text = null) {
		parent::__construct($label);
		$this->attribute = $attribute;
		$this->text = $text;
		$this->setCallback(function($Object) {
			$attr = $this->attribute;
			$prefix = $this->linkPrefix;
			if(method_exists($Object, $attr)) {
				$result = $Object->$attr();
			} else if(property_exists($Object, $attr)) {
				$result = $object->$attr;
			} else {
				$result = '';
			}
			$text = is_null($this->text)? $result : $this->text;
			return '<a class="'.$this->htmlClasses.'" href="'.$prefix.$result.'">'.$text.'</a>';
		});
	}

	/**
	 * Function to set the link prefix.
	 *
	 * @param  string  $prefix
	 */
	public function setPrefix($prefix) {
		$this->linkPrefix = $prefix;
	}
}

} // end of "require" hack
