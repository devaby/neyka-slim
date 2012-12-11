<?php

namespace library\capsule\audio;

use \library\capsule\audio\mvc\model;
use \library\capsule\audio\mvc\view;
use \library\capsule\audio\mvc\controller;

class audio {
	   
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
