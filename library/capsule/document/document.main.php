<?php

namespace library\capsule\document;

use \library\capsule\document\mvc\model;
use \library\capsule\document\mvc\view;
use \library\capsule\document\mvc\controller;

class document {
	   
   	public static function init($text,$params,$rowDisplay,$category,$folder,$id) {
   	return new view($text,$params,$rowDisplay,$category,$folder,$id);
   	}
   	
   	public function getCategory() {
   	return controller::getCategory();
   	}
   	
	public function getFolder() {
	return controller::getFolder();
	}
	
}


?>
