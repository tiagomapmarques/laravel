<?php

namespace App\Admin\Addons\Display\Column;

use SleepingOwl\Admin\Display\Column\Text as Text;

// TODO: check if bug is gone...
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Hash::class)) {

/**
 * Column for displaying hash values on Sleeping Owl
 */
class Hash extends Text {
	/**
	 * Number of characters in which the hash will be divided.
	 *
	 * @var integer
	 */
	protected $chars_per_line = 16;

	/**
	 * Main output variable from this class.
	 *
	 * @var string
	 */
	protected $result = '';

	/**
	 * Function to set the number of characters that divide the hash value.
	 *
	 * @param  integer  $chars_per_line
	 * @return \App\Admin\Addons\Display\Column\Hash
	 */
	public function setMaxCharactersPerLine($chars) {
		$this->chars_per_line = $chars;
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
		$hash_lines = str_split($this->getModelValue(), $this->chars_per_line);
		$this->result = implode('<br />', $hash_lines);
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$this->process();
		return view('admin::addons.display.column.hash', $this->toArray(), []);
	}
}

} // end of "require" hack
