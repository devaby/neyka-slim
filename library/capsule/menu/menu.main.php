<?php 

namespace library\capsule\menu;

use \library\capsule\menu\mvc\model;
use \library\capsule\menu\mvc\view;
use \library\capsule\menu\mvc\controller;

class menu {

	public static function init($set,$params) {
        return new view($set,$params);
    }
 
}
 
?>
