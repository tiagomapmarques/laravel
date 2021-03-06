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
		return '0.6-rc2';
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
		$finalArray = [];
		foreach($array as $key => $value) {
			$finalArray[] = $value->$attribute;
		}
		return $finalArray;
	}

	/**
	 * Turns an array of objects to an array of a certain Model.
	 *
	 * This function transforms an array of objects to an array of a certain Model.
	 * The first argument may simply be an array of primary keys or a collection
	 * of models themselves.
	 *
	 * @param  array   $array
	 * @param  string  $model
	 * @param  string  $primaryKey
	 * @return array
	 */
	public static function toModelArray($array, $model, $primaryKey = 'id') {
		$final_array = [];
		foreach($array as $key => $value) {
			if(isset($value->$primaryKey)) {
				$final_array[] = $model::find($value->$primaryKey);
			}
			else if(is_string($value) || is_numeric($value)) {
				$final_array[] = $model::find($value);
			}
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
		$maxUpload = Helper::bytesFromConfig(ini_get('upload_max_filesize'));
		//select post limit
		$maxPost = Helper::bytesFromConfig(ini_get('post_max_size'));
		//select memory limit
		$memoryLimit = Helper::bytesFromConfig(ini_get('memory_limit'));

		return floor(min($maxUpload, $maxPost, $memoryLimit) * $multiplier);
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
