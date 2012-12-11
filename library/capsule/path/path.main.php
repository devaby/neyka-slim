<?php

namespace library\capsule\path;

use \library\capsule\path\mvc\model;
use \library\capsule\path\mvc\view;
use \library\capsule\path\mvc\controller;

class path {
	   
   	public static function init($params = null) {
    return new view($params);
   	}
  	
}


?>
