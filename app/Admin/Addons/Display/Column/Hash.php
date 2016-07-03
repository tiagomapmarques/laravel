<?php

namespace App\Admin\Addons\Display\Column;

use \App\Admin\Addons\Display\Column\LurkBase as LurkBase;

// TODO: get updates on the following github threads
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/pull/85
//       - https://github.com/LaravelRUS/SleepingOwlAdmin/issues/131
//
// AdminServiceProvider from SlpeeingOwl includes files by using "require"
// instead of "require_once", so it basically loads any custom class twice,
// which is a major bug. To counter this, we must check if our class exists
// before creating it.
if(!class_exists(\App\Admin\Addons\Display\Column\Hash::class)) {

/**
 * Column for displaying hash values on Sleeping Owl
 */
class Hash extends LurkBase {
	/**
	 * Number of characters in which the hash will be divided.
	 *
	 * @var integer
	 */
	protected $charsPerLine = 16;

	/**
	 * Function to set the number of characters that divide the hash value.
	 *
	 * @param  integer  $chars
	 * @return \App\Admin\Addons\Display\Column\Hash
	 */
	public function setMaxCharactersPerLine($chars) {
		$this->charsPerLine = $chars;
		return $this;
	}

	/**
	 * Function to perform this class' main action.
	 *
	 * @return void
	 */
	protected function process() {
		$hashLines = str_split($this->getModelValue(), $this->charsPerLine);
		$this->result = implode('<br />', $hashLines);
	}
}

} // end of "require" hack
