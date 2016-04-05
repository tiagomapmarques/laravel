<?php

namespace App\Traits;

trait ModelImage {

	protected static $base_image_path = 'images';

	/**
	 * Function to retrieve the image path the class.
	 *
	 * This function retrieves the specific path for the images of this class.
	 * It is implemented to retrieve a specific path for every child class.
	 *
	 * @return string
	 */
	public static function images_path() {
		$child_class_array = explode('\\', get_called_class());
		return public_path().
			DIRECTORY_SEPARATOR.self::$base_image_path.
			DIRECTORY_SEPARATOR.strtolower($child_class_array[count($child_class_array)-1]);
	}
}
