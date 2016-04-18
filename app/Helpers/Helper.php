<?php

use Config as Config;
use Request as Request;

/**
 * Lurk helper class
 *
 * This class is autoloaded in the composer in order to make general purpose
 * functions available to throughout all the application.
 */
class Helper {
	/**
	 * Function to retrieve the version of Lurk.
	 *
	 * @return string
	 */
	public static function version() {
		return '0.4-beta2';
	}

	/**
	 * Function check if the current route is an admin route.
	 *
	 * @return boolean
	 */
	public static function routeIsAdmin() {
		$prefix = Config::get('sleeping_owl.url_prefix');
		return Request::is($prefix) || Request::is($prefix.'/*');
	}

	/**
	 * Turns an array of objects to a regular array from the attribute given.
	 *
	 * @param  array   $array
	 * @param  string  $attribute
	 * @return array
	 */
	public static function toSimpleArray($array, $attribute) {
		$final_array = [];
		foreach($array as $key => $value) {
			$final_array[] = $value->$attribute;
		}
		return $final_array;
	}

	/**
	 * Function to predict the maximum upload limit in bytes, KB or MB.
	 *
	 * This function will get the lowest value from three locations:
	 * upload_max_filesize, post_max_size and memory_limit. The lowest value
	 * will be the reliable upload limit of the application.
	 *
	 * @param  string  $magnitude
	 * @return integer
	 */
	public static function getUploadLimit($magnitude = 'KB') {
		$magnitude = strtolower($magnitude);
		if($magnitude==='b' || $magnitude==='bytes') {
			$multiplier = 1;
		}
		else if($magnitude==='kb' || $magnitude==='kbytes'|| $magnitude==='kilobytes') {
			$multiplier = 1 / 1024;
		}
		else if($magnitude==='mb' || $magnitude==='mbytes'|| $magnitude==='megabytes') {
			$multiplier = 1 / (1024*1024);
		}
		else {
			return null;
		}
		//select maximum upload size
		$max_upload = Helper::bytesFromConfig(ini_get('upload_max_filesize'));
		//select post limit
		$max_post = Helper::bytesFromConfig(ini_get('post_max_size'));
		//select memory limit
		$memory_limit = Helper::bytesFromConfig(ini_get('memory_limit'));

		return floor(min($max_upload, $max_post, $memory_limit) * $multiplier);
	}

	/**
	 * Function to retrieve the number of bytes from a configuration.
	 *
	 * @param  string  $val
	 * @return integer
	 */
	private static function bytesFromConfig($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}
}
