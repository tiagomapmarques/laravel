<?php

namespace App\Traits;

use File;
use Generate;

/**
 * File pathing
 *
 * Trait that can be used to implement a base (and standerdised) path for
 * files. It will also provide you with a default file.
 */
trait FilePathing {
	/**
	 * Base file path under public folder.
	 *
	 * @var string
	 */
	protected static $base_file_path = 'files';

	/**
	 * Class file path under base file path.
	 *
	 * @var string|boolean
	 */
	protected static $class_file_folder = false;

	/**
	 * Default file located under every classes' file path.
	 *
	 * @var string
	 */
	protected static $default_file_name = 'default.jpg';

	/**
	 * Default class attribute to be called to get the file location.
	 *
	 * @var string
	 */
	protected static $child_class_file_attribute = 'file';

	/**
	 * Function to retrieve the file path the class.
	 *
	 * This function retrieves the specific path for the files of this class.
	 * It is implemented to retrieve a specific path for every child class.
	 *
	 * @return string
	 */
	public static function filesPath() {
		if(self::$class_file_folder===false || !is_string(self::$class_file_folder) || strlen(self::$class_file_folder)<1) {
			$child_class_array = explode('\\', get_called_class());
			$class_folder = strtolower($child_class_array[count($child_class_array)-1]);
		}
		else {
			$class_folder = self::$class_file_folder;
		}
		return self::$base_file_path.DS.$class_folder;
	}

	/**
	 * Function to retrieve the default file for the class.
	 *
	 * @return string
	 */
	public static function defaultFile() {
		return self::filesPath().DS.self::$default_file_name;
	}

	/**
	 * Function to return a valid file for the child class Object.
	 *
	 * This function will either return the Object file or, if there is none,
	 * the default file for the child class.
	 *
	 * @return string
	 */
	public function getFile() {
		$file_attribute = self::$child_class_file_attribute;
		$file = (string)($this->$file_attribute);
		if(!$file || $file==='' || !file_exists($file)) {
			return self::defaultFile();
		}
		return $file;
	}

	/**
	 * Function to re-locate the child class' Object file.
	 *
	 * Function to re-locate the child class' Object file to a specified location.
	 * If none is provided, the file will just be moved to the default file
	 * location for the child class. This function just updates the User model
	 * and does not update the database. Manual saving is required.
	 *
	 * @param  string|null  $location
	 * @param  boolean      $filename
	 * @return boolean
	 */
	public function moveFile($location = null, $filename = false) {
		$file_attribute = self::$child_class_file_attribute;
		$file = $this->$file_attribute;
		if(is_null($file) || $file==='') {
			return false;
		}
		if(is_null($location)) {
			$location = self::filesPath();
		}
		if($filename) {
			$path = explode('.', $file);
			$filename = Generate::filename().'.'.$path[count($path)-1];
		}
		else {
			$path = explode(DS, $file);
			$filename = $path[count($path)-1];
		}

		$destination = $location.DS.$filename;
		File::move($file, $destination);
		$this->$file_attribute = $destination;
	}
}
