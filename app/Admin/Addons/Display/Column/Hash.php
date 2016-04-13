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
 * Column for displaying hash values on Sleeping Owl.
 */
class Hash extends Text {
	/**
	 * Number of characters in which the hash will be divided.
	 *
	 * @var string
	 */
	protected $divider = 32;

	/**
	 * Function to set the number of characters that divide the hash value.
	 *
	 * @param  integer
	 * @return App\Admin\Addons\Display\Column\Hash
	 */
	public function setDivider($divider) {
		$this->divider = $divider;
		return $this;
	}

	/**
	 * Function to retrieve the rendered html.
	 *
	 * @return Illuminate\View\View
	 */
	public function render() {
		$params = array_merge($this->toArray(), ['divider' => $this->divider]);
		return view('admin::addons.display.column.hash', $params, []);
	}
}

} // end of "require" hack
