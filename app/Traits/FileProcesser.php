<?php

namespace App\Traits;

trait FileProcesser {
	/**
	 * Function to zip a list of files to to a specified folder.
	 *
	 * This function takes a list of files and zips them with or without folder
	 * structure to a specified folder. The archive's name must also be given.
	 *
	 * @param  array    $files
	 * @param  string   $path
	 * @param  string   $filename
	 * @param  boolean  $overwrite
	 * @param  boolean  $full_hierarchy
	 * @return boolean
	 */
	protected function createZip($files, $path, $filename, $overwrite = false, $full_hierarchy = false) {
		if(is_null($files) || !is_array($files) || count($files)<1) {
			return false;
		}
		$valid_files = array();
		foreach($files as $file) {
			if(file_exists($file)) {
				if($full_hierarchy) {
					$valid_files[] = [ $file, $file ];
				}
				else {
					$split = explode(DIRECTORY_SEPARATOR, $file);
					$value = array_splice($split, count($split)-1, 1);
					$valid_files[] = [ $file, $value[0] ];
				}
			}
		}
		if(count($valid_files)<1) {
			return false;
		}

		$zip = new \ZipArchive();
		if($zip->open($path.DIRECTORY_SEPARATOR.$filename, $overwrite? \ZIPARCHIVE::OVERWRITE : \ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		foreach($valid_files as $file) {
			$zip->addFile($file[0], $file[1]);
		}

		$zip->close();
		return file_exists($path.DIRECTORY_SEPARATOR.$filename);
	}

	/**
	 * Function to move an uploaded file from a php temp folder to a new one.
	 *
	 * This function should be called after a file is uploaded through,
	 * for example, a form. It moves the file from the assigned php temp folder
	 * to a specified path. The file's new name must also be given.
	 *
	 * @param  \Illuminate\Http\UploadedFile  $file
	 * @param  string                         $path
	 * @param  string                         $filename
	 * @return boolean
	 */
	protected function processFile($file, $path, $filename) {
		if(!$file->isValid()) {
			return false;
		}
		$file->move($path, $filename);
		return true;
	}

	/**
	 * Function to process an uploaded image and move it to a specified folder.
	 *
	 * This function should be called after an image is uploaded through,
	 * for example, a form. It moves the image from the assigned php temp folder
	 * to a specified path while also converting/croping/resizing it as desired.
	 * The image's new name must also be given.
	 *
	 * @param  \Illuminate\Http\UploadedFile  $file
	 * @param  string                         $path
	 * @param  string                         $filename
	 * @param  string                         $extension
	 * @param  integer                        $width
	 * @param  integer                        $height
	 * @param  integer                        $quality
	 * @return boolean
	 */
	protected function processImage($file, $path, $filename, $extension, $width = null, $height = null, $quality = 75) {
		$valid = $this->processFile($file, $path, $filename);
		if(!$valid) {
			return false;
		}

		$img = Image::make($path.DIRECTORY_SEPARATOR.$filename);
		if(is_null($width) && is_null($height)) {
			$width = $img->width();
		}

		if(!is_null($width) && !is_null($height)) {
			$img->fit($width, $height, function($constraint) {
				$constraint->upsize();
			});
		}
		else {
			$img->resize($width, $height);
		}

		$img->encode($extension, $quality);
		$img->save($path.DIRECTORY_SEPARATOR.$filename);
		return true;
	}
}
