<?php

namespace library\capsule\content;

use \library\capsule\content\mvc\model;
use \library\capsule\content\mvc\view;
use \library\capsule\content\mvc\controller;

class content {
	   
   	public static function init($text,$params,$rowDisplay,$category) {
   	return new view($text,$params,$rowDisplay,$category);
   	}
   	
   	public function getContentCategory($text,$params,$rowDisplay,$category) {
   	return new view($text,$params,$rowDisplay,$category);
   	}
   	
	public function getCategory() {
	return controller::getCategory();
	}
	
	public function getLanguage() {
	return controller::getLanguage();
	}
	
}


?>
