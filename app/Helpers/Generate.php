<?php
/**
 * Lurk generator class
 *
 * This class is autoloaded in the composer in order to make random generation
 * functions available to throughout all the application.
 */
class Generate {
	/**
	 * Function to generate a random string.
	 *
	 * @param  integer  $length
	 * @param  boolean  $caseSensitive
	 * @param  boolean  $additionalChars
	 * @return string
	 */
	public static function string($length = 32, $caseSensitive = false, $additionalChars = false) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		if($caseSensitive) {
			$characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		if($additionalChars) {
			$characters .= '-_';
		}
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * Function to generate a random filename with a datetime stamp prefix.
	 *
	 * @return string
	 */
	public static function filename() {
		return date('YmdHis').'_'.Generate::string();
	}

	/**
	 * Function to generate a 32 length 64 chars each hash.
	 *
	 * @return string
	 */
	public static function hash() {
		return Generate::string(32, true, true);
	}
}
