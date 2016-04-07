<?php

namespace App\Traits;

trait AutoModelSearch {

	//protected $search_targets = [];

	protected function get_search_results($query, $class_path = '\\App\\') {
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
