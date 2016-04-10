<?php

use App as App;
use Config as Config;
use Session as Session;

class Helper {
	/**
	 * Function to retrieve the version of LURK.
	 *
	 * @return string
	 */
	public static function version() {
		return '0.3-beta1';
	}

	/**
	 * Function to translate single or multiple phrases.
	 *
	 * @return void
	 */
	public static function trans($id, $choice = 1) {
		$phrase = explode('|', trans($id));
		return $phrase[$choice-1];
	}

	/**
	 * Function to get the locale from Session data.
	 *
	 * @return void
	 */
	public static function getLocale() {
		Helper::applyLocale();
		return Session::get('locale');
	}

	/**
	 * Function to set and apply the locale from Session data.
	 *
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
	 * Function to predict the maximum upload limit in butes, KB or MB.
	 * The default return value is in KB.
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
