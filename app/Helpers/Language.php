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
	 * HTML tag for when there are multiple lines in a translation.
	 *
	 * @var string
	 */
	protected static $translationHtmlTag = 'p';

	/**
	 * Function to get the HTML tag for when there are multiple lines in a translation.
	 *
	 * @param  string  $tag
	 * @return string
	 */
	public static function getTag() {
		return self::$translationHtmlTag;
	}

	/**
	 * Function to set the HTML tag for when there are multiple lines in a translation.
	 *
	 * @param  string  $tag
	 * @return string
	 */
	public static function setTag($tag) {
		self::$translationHtmlTag = $tag;
		return self::getTag();
	}

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
		$localeIsAvailable = in_array($locale, Language::getAll());
		if($localeIsAvailable) {
			$previousLocale = Language::get();
			Language::apply($locale);
		}
		$originalTranslation = trans($identifier);
		if($localeIsAvailable) {
			Language::apply($previousLocale);
		}

		if(is_array($originalTranslation)) {
			$translations = $originalTranslation;
		} else {
			$translations = [$originalTranslation];
		}

		$result = '';
		foreach($translations as $translation) {
			$phrase = explode('|', $translation);
			$phraseChoice = $choice;
			if(count($phrase)<$choice) {
				$phraseChoice = count($phrase);
			}
			if($phraseChoice<1) {
				$result .= $translation;
			} else {
				if(count($translations)>1) {
					$result .= '<'.self::$translationHtmlTag.'>'.
						$phrase[$phraseChoice-1].
						'</'.self::$translationHtmlTag.'>';
				} else {
					$result .= $phrase[$phraseChoice-1];
				}
			}
		}

		return $result;
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
