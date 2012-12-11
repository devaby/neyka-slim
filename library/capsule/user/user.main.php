<?php

namespace library\capsule\user;

use \library\capsule\user\mvc\model;
use \library\capsule\user\mvc\view;
use \library\capsule\user\mvc\controller;

class user {
	
   	public static function init($params) {
    return new view($params);
   	}
	
}


?>
