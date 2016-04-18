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
	 * @param  boolean  $case_sensitive
	 * @param  boolean  $additional_chars
	 * @return string
	 */
	public static function string($length = 32, $case_sensitive = false, $additional_chars = false) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		if($case_sensitive) {
			$characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		if($additional_chars) {
			$characters .= '-_';
		}
		$characters_length = strlen($characters);
		$random_string = '';
		for ($i = 0; $i < $length; $i++) {
			$random_string .= $characters[rand(0, $characters_length - 1)];
		}
		return $random_string;
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
