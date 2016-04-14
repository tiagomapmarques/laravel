<?php

namespace App\Traits;

/**
 * Automated model search
 *
 * Trait that can be used to extend a class' ability to search through another
 * class' objects, provided the class has a static "all" method that returns
 * an array.
 */
trait AutoModelSearch {
	/**
	 * Function to get all search results from models.
	 *
	 * This function retrieves all the results from models registered using the
	 * "search_targets" array of the class using this trait. It looks for
	 * "searchable" properties of models and compares them to each word from the
	 * given query.
	 * TODO: implement result relevance
	 *
	 * @param  string  $query
	 * @param  string  $class_path
	 * @return string
	 */
	protected function get_search_results($query, $class_path = '\\App\\Models\\') {
		$results = [];
		$targets = [];
		if(isset($this->search_targets) && is_array($this->search_targets)) {
			$targets = $this->search_targets;
		}
		foreach ($targets as $target) {
			$results[$target] = [];
			$class_name = $class_path.ucfirst($target);
			$all = $class_name::all();
			foreach ($all as $item) {
				if($this->check_result($class_name, $item, $query)) {
					$results[$target][] = $item;
				}
			}
		}
		return $results;
	}

	/**
	 * Function to check if a given item matches a general search criteria.
	 *
	 * @param  string                              $class
	 * @param  Illuminate\Database\Eloquent\Model  $object
	 * @param  string                              $string
	 * @param  string                              $separator
	 * @return boolean
	 */
	private function check_result($class, $object, $string, $separator = ' ') {
		if(is_null($string) || !is_string($string) || strlen($string)<=0) {
			return false;
		}
		$words = explode($separator, $string);
		foreach($words as $word) {
			if(strlen($word)>0) {
				foreach($class::$searchable as $attribute) {
					if(stripos($object->$attribute, $word)!==false) {
						return true;
					}
				}
			}
		}
		return false;
	}
}
