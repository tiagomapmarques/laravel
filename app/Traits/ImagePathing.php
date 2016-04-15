<?php

namespace App\Traits;

/**
 * Image pathing
 *
 * Trait that can be used to implement a base (and standerdised) path for
 * images. It will also provide you with a default image.
 */
trait ImagePathing {
	/**
	 * Base image path under public folder.
	 *
	 * @var string
	 */
	protected static $base_image_path = 'images';

	/**
	 * Base image path under public folder.
	 *
	 * @var boolean|false
	 */
	protected static $class_image_folder = false;

	/**
	 * Default image file located under every classes' image path.
	 *
	 * @var string
	 */
	protected static $default_image_name = 'default.jpg';

	/**
	 * Function to retrieve the image path the class.
	 *
	 * This function retrieves the specific path for the images of this class.
	 * It is implemented to retrieve a specific path for every child class.
	 *
	 * @return string
	 */
	public static function images_path() {
		if(self::$class_image_folder===false || !is_string(self::$class_image_folder) || strlen(self::$class_image_folder)<1) {
			$child_class_array = explode('\\', get_called_class());
			$class_folder = strtolower($child_class_array[count($child_class_array)-1]);
		}
		else {
			$class_folder = self::$class_image_folder;
		}
		return self::$base_image_path.DIRECTORY_SEPARATOR.$class_folder;
	}

	/**
	 * Function to retrieve the default image for the class.
	 *
	 * @return string
	 */
	public static function default_image() {
		return self::images_path().DIRECTORY_SEPARATOR.self::$default_image_name;
	}
}
