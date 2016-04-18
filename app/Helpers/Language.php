<?php

use App as App;
use Config as Config;
use Session as Session;

/**
 * Lurk language class
 *
 * This class is autoloaded in the composer in order to make locale related
 * functions available to throughout all the application.
 */
class Language {
	/**
	 * Function to translate single or multiple phrases.
	 *
	 * This function can be seen as an alias for the "trans" and "trans_choice"
	 * functions of Laravel. However, it will translate to the singular form
	 * by default, providing a singular way of getting the translation you want,
	 * without breaking your code if you update the translations. If you want,
	 * you can also specify a locale (regardless of what locale is applied).
	 *
	 * @param  string       $identifier
	 * @param  integer      $choice
	 * @param  string|null  $locale
	 * @return string
	 */
	public static function trans($identifier, $choice = 1, $locale = null) {
		$locale_is_available = in_array($locale, Language::getAll());
		if($locale_is_available) {
			$previous_locale = Language::get();
			Language::apply($locale);
		}
		$original_translation = trans($identifier);
		if($locale_is_available) {
			Language::apply($previous_locale);
		}
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
	public static function get() {
		Language::apply();
		return Session::get('locale');
	}

	/**
	 * Function to set and apply a locale from Session data or a parameter.
	 *
	 * @param  string|null  $locale
	 * @return void
	 */
	public static function apply($locale = null) {
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
	public static function getAll() {
		$path = base_path().DS.'resources'.DS.'lang';
		$items = scandir($path);
		$folders = Array();
		foreach ($items as $item) {
			if(is_dir($path.DS.$item) && $item!=='.' && $item!=='..') {
				$folders[] = $item;
			}
		}
		return $folders;
	}
}
