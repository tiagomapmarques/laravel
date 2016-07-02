<?php
/**
 * Lurk Date class
 *
 * This class is autoloaded in the composer in order to make locale related
 * functions available to throughout all the application.
 */
class Date {
	/**
	 * Function to transform a date to string.
	 *
	 * @param  string  $date
	 * @param  IntlDateFormatter  $dateFormat
	 * @return string
	 */
	public static function dateString($date, $dateFormat = IntlDateFormatter::LONG) {
		return self::dateTimeString($date, $dateFormat, IntlDateFormatter::NONE);
	}

	/**
	 * Function to transform a time to string.
	 *
	 * @param  string  $date
	 * @param  IntlDateFormatter  $timeFormat
	 * @return string
	 */
	public static function timeString($date, $timeFormat = IntlDateFormatter::SHORT) {
		return self::dateTimeString($date, IntlDateFormatter::NONE, $timeFormat);
	}

	/**
	 * Function to transform a date and/or timw to string.
	 *
	 * @param  string  $date
	 * @param  IntlDateFormatter  $dateFormat
	 * @param  IntlDateFormatter  $timeFormat
	 * @return string
	 */
	public static function dateTimeString($date, $dateFormat, $timeFormat) {
		$intlFormatter = new IntlDateFormatter(Language::get(), $dateFormat, $timeFormat);
		return $intlFormatter->format(new DateTime($date));
	}
}
