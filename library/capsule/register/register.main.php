<?php

namespace library\capsule\register;

use \library\capsule\register\mvc\model;
use \library\capsule\register\mvc\view;
use \library\capsule\register\mvc\controller;

class register {
	   
   	public static function init($params) {
    return new view($params);      	   	
   	}
	
}


?>
