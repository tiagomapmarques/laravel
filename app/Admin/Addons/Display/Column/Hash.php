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
	protected $chars_per_line = 32;

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
	 * Function to retrieve the rendered html.
	 *
	 * @return \Illuminate\View\View
	 */
	public function render() {
		$hash_lines = str_split($this->getModelValue(), $this->chars_per_line);
		$result = implode('<br />', $hash_lines);
		return view(
			'admin::addons.display.column.hash',
			$this->toArray() + ['result' => $result],
			[]
		);
	}
}

} // end of "require" hack
