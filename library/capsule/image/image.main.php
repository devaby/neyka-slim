<?php

namespace library\capsule\image;

use \library\capsule\image\mvc\model;
use \library\capsule\image\mvc\view;
use \library\capsule\image\mvc\controller;

class image {
	   
   	public static function init($text,$params,$rowDisplay,$category,$folder) {
   	return new view($text,$params,$rowDisplay,$category,$folder);
   	}
   	
   	public function getCategory() {
   	return controller::getCategory();
   	}
   	
	public function getFolder() {
	return controller::getFolder();
	}
	
}


?>
