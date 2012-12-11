<?php

namespace library\capsule\rss;

use \library\capsule\rss\mvc\model;
use \library\capsule\rss\mvc\view;
use \library\capsule\rss\mvc\controller;

class rss {
	   
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
