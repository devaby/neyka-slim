<?php

namespace library\capsule\contact;

use \library\capsule\contact\mvc\model;
use \library\capsule\contact\mvc\view;
use \library\capsule\contact\mvc\controller;

class contact {
	   
   	public static function init($text,$email,$params) {
    return new view($text,$email,$params);      	   	
   	}
   	
   	public static function sendMessage($message,$init) {
   	model::sendMessage($message,$init);
   	}
	
}


?>
