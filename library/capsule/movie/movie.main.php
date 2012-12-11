<?php

namespace library\capsule\movie;

use \library\capsule\movie\mvc\model;
use \library\capsule\movie\mvc\view;
use \library\capsule\movie\mvc\controller;

class movie {
	   
   	public static function init($params,$rowDisplay,$width,$height,$category,$folder) {
   	return new view($params,$rowDisplay,$width,$height,$category,$folder);
   	}
   	
   	public function getCategory() {
   	return controller::getCategory();
   	}
   	
	public function getFolder() {
	return controller::getFolder();
	}
	
}


?>
