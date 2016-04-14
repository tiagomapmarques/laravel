<?php

use App as App;
use Config as Config;
use Session as Session;

/**
 * LURK helper class
 *
 * This class is autoloaded in the composer in order to make general purpose
 * functions available to throughout all the application.
 */
class Helper {
	/**
	 * Function to retrieve the version of LURK.
	 *
	 * @return string
	 */
	public static function version() {
		return '0.4-beta2';
	}

	/**
	 * Function to translate single or multiple phrases.
	 *
	 * This function can be seen as an alias for the "trans" and "trans_choice"
	 * functions of Laravel. However, it will translate to the singular form
	 * by default, providing a singular way of getting the translation you want,
	 * without breaking your code if you update the translations.
	 *
	 * @param  string   $identifier
	 * @param  integer  $choice
	 * @return string
	 */
	public static function trans($identifier, $choice = 1) {
		$original_translation = trans($identifier);
		$phrase = explode('|', $original_translation);
		if(count($phrase)<$choice) {
			$choice = count($phrase);
		}
		if($choice<1) {
			return $original_translation;
		}
		return $phrase[$choice-1];
	}

	/**
	 * Function to get the locale from Session data.
	 *
	 * @return string
	 */
	public static function getLocale() {
		Helper::applyLocale();
		return Session::get('locale');
	}

	/**
	 * Function to set and apply a locale from Session data or a parameter.
	 *
	 * @param  string|null  $locale
	 * @return void
	 */
	public static function applyLocale($locale = null) {
		if(!is_null($locale) && is_string($locale) && strlen($locale)>0) {
			Session::put('locale', $locale);
		}
		if(!Session::has('locale')) {
			Session::put('locale', Config::get('app.fallback_locale'));
		}
		App::setLocale(Session::get('locale'));
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
	 * Function to return all available traslations (locales).
	 *
	 * @return array
	 */
	public static function getAllLocales() {
		$path = base_path().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'lang';
		$items = scandir($path);
		$folders = Array();
		foreach ($items as $item) {
			if(is_dir($path.DIRECTORY_SEPARATOR.$item) && $item!=='.' && $item!=='..') {
				$folders[] = $item;
			}
		}
		return $folders;
	}

	/**
	 * Function to generate a random string.
	 *
	 * @param  integer  $length
	 * @param  boolean  $case_sensitive
	 * @param  boolean  $additional_chars
	 * @return string
	 */
	public static function generateRandomString($length = 32, $case_sensitive = false, $additional_chars = false) {
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
	public static function generateRandomFilename() {
		return date('YmdHis').'_'.Helper::generateRandomString();
	}

	/**
	 * Function to generate a hash.
	 *
	 * @return string
	 */
	public static function generateHash() {
		return Helper::generateRandomString(64, true, true);
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
