<?php
/**
 * Function to generate a random string.
 *
 * @param  integer  $length
 * @param  boolean  $case_sensitive
 * @return string
 */
function generateRandomString($length = 32, $case_sensitive = false) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	if($case_sensitive) {
		$characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
function generateRandomFilename() {
	return date('YmdHis').'_'.generateRandomString();
}
