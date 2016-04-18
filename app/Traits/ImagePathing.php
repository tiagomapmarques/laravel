<?php

namespace App\Traits;

use File;
use Generate;

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
	 * Class image path under base image path.
	 *
	 * @var string|boolean
	 */
	protected static $class_image_folder = false;

	/**
	 * Default image file located under every classes' image path.
	 *
	 * @var string
	 */
	protected static $default_image_name = 'default.jpg';

	/**
	 * Default class attribute to be called to get the image file location.
	 *
	 * @var string
	 */
	protected static $class_image_attribute = 'image';

	/**
	 * Function to retrieve the image path the class.
	 *
	 * This function retrieves the specific path for the images of this class.
	 * It is implemented to retrieve a specific path for every child class.
	 *
	 * @return string
	 */
	public static function imagesPath() {
		if(self::$class_image_folder===false || !is_string(self::$class_image_folder) || strlen(self::$class_image_folder)<1) {
			$child_class_array = explode('\\', get_called_class());
			$class_folder = strtolower($child_class_array[count($child_class_array)-1]);
		}
		else {
			$class_folder = self::$class_image_folder;
		}
		return self::$base_image_path.DS.$class_folder;
	}

	/**
	 * Function to retrieve the default image for the class.
	 *
	 * @return string
	 */
	public static function defaultImage() {
		return self::imagesPath().DS.self::$default_image_name;
	}

	/**
	 * Function to return a valid image for the User.
	 *
	 * This function will either return the User image or, if there is none,
	 * the default image for the User class.
	 *
	 * @return boolean
	 */
	public function getImage() {
		$image_attribute = self::$class_image_attribute;
		$image = $this->$image_attribute;
		if(!$image || $image==='' || !file_exists($image)) {
			return self::defaultImage();
		}
		return $image;
	}

	/**
	 * Function to re-locate the User image.
	 *
	 * Function to re-locate the User image to a specified location. If none
	 * is provided, the file will just be moved to the default image location
	 * for the User class. This function just updates the User model and does
	 * not update the database. Manual saving is required.
	 *
	 * @param  string|null  $location
	 * @param  boolean      $filename
	 * @return boolean
	 */
	public function moveImage($location = null, $filename = false) {
		$image_attribute = self::$class_image_attribute;
		$image = $this->$image_attribute;
		if(is_null($image) || $image==='') {
			return false;
		}
		if(is_null($location)) {
			$location = self::imagesPath();
		}
		if($filename) {
			$path = explode('.', $image);
			$filename = Generate::filename().'.'.$path[count($path)-1];
		}
		else {
			$path = explode(DS, $image);
			$filename = $path[count($path)-1];
		}

		$destination = $location.DS.$filename;
		File::move($image, $destination);
		$this->$image_attribute = $destination;
	}
}
