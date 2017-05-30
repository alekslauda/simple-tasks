<?php

namespace Application\Models\Core;

class Registry {
	
	private $data = array();
	
	public function __set($index, $value) {
		$this->data[$index] = $value;
	}
	
	public function __get($index) {
		return $this->data[$index];
	}
	
	public function getData() {
		return $this->data;
	}
	
	
}