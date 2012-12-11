<?php

namespace library\capsule\share;

use \library\capsule\share\mvc\model;
use \library\capsule\share\mvc\view;
use \library\capsule\share\mvc\controller;

class share {
	
   	public static function init($params) {
    return new view($params);
   	}
	
}


?>
