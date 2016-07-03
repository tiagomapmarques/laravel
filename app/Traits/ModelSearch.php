<?php

namespace App\Traits;

/**
 * Model search
 *
 * Trait that can be used to extend a class' ability to search through another
 * class' objects, provided the class has a static "all" method that returns
 * an array.
 */
trait ModelSearch {
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
	 * @param  string  $classPath
	 * @return string
	 */
	protected function searchResults($query, $classPath = '\\App\\Models\\') {
		$results = [];
		$targets = [];
		if(isset($this->searchTargets) && is_array($this->searchTargets)) {
			$targets = $this->searchTargets;
		}
		foreach ($targets as $target) {
			$results[$target] = [];
			$className = $classPath.ucfirst($target);
			$all = $className::all();
			foreach ($all as $item) {
				if($this->checkResult($className, $item, $query)) {
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
	private function checkResult($class, $object, $string, $separator = ' ') {
		if(is_null($string) || !is_string($string) || strlen($string)<=0) {
			return false;
		}
		$words = explode($separator, $string);
		foreach($words as $word) {
			if(strlen($word)>0) {
				$searchAttributes = [];
				if(property_exists($class, 'searchable') && is_array($class::$searchable)) {
					$searchAttributes = $class::$searchable;
				}
				foreach($searchAttributes as $attribute) {
					if(stripos($object->$attribute, $word)!==false) {
						return true;
					}
				}
			}
		}
		return false;
	}
}
