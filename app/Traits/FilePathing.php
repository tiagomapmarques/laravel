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
	protected static $baseFilePath = 'files';

	/**
	 * Class file path under base file path.
	 *
	 * @var string|boolean
	 */
	protected static $classFileFolder = false;

	/**
	 * Default file located under every classes' file path.
	 *
	 * @var string
	 */
	protected static $defaultFileName = 'default';

	/**
	 * Default file extension.
	 *
	 * @var string
	 */
	protected static $defaultFileExtension = '';

	/**
	 * Default class attribute to be called to get the file location.
	 *
	 * @var string
	 */
	protected static $childClassFileAttribute = 'file';

	/**
	 * Function to setup the FilePathing trait.
	 *
	 * @return void
	 */
	protected static function filePathingConfig($filePath, $attribute, $extension) {
		self::$baseFilePath = $filePath;
		self::$childClassFileAttribute = $attribute;
		self::$defaultFileExtension = $extension;
	}

	/**
	 * Function to retrieve the file path the class.
	 *
	 * This function retrieves the specific path for the files of this class.
	 * It is implemented to retrieve a specific path for every child class.
	 *
	 * @return string
	 */
	public static function filesPath() {
		if(self::$classFileFolder===false || !is_string(self::$classFileFolder) || strlen(self::$classFileFolder)<1) {
			$childClassArray = explode('\\', get_called_class());
			$classFolder = strtolower($childClassArray[count($childClassArray)-1]);
		}
		else {
			$classFolder = self::$classFileFolder;
		}
		return self::$baseFilePath.DS.$classFolder;
	}

	/**
	 * Function to retrieve the default file for the class.
	 *
	 * @return string
	 */
	public static function defaultFile() {
		return self::filesPath().DS.self::$defaultFileName.
			(self::$defaultFileExtension===''? '': '.'.self::$defaultFileExtension);
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
		$fileAttribute = self::$childClassFileAttribute;
		$file = (string)($this->$fileAttribute);
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
		$fileAttribute = self::$childClassFileAttribute;
		$file = $this->$fileAttribute;
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

		if(!is_dir($location) && !mkdir($location, 0777, true)) {
			return false;
		}

		$destination = $location.DS.$filename;
		File::move($file, $destination);
		$this->$fileAttribute = $destination;
		return true;
	}
}
