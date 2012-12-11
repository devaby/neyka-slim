<?php

namespace framework;

class autoload {

	public static function init() {
	self::register();
	}
	
	protected static function register() {
	spl_autoload_register(__NAMESPACE__.'\autoload::autoLoad');
	}
	
	protected static function autoLoad($class) {

    $list = array(".php",".class.php",".controller.php",".model.php",".view.php",".interface.php",".main.php");
    
    	foreach ($list as $key => $value) {

    		if (file_exists(ROOT_PATH . str_replace("\\","/",$class) . "$value")) {

    		include_once ROOT_PATH . str_replace("\\","/",$class) . "$value";
    		
    		} 
    		
    	}    
    
    }

}

?>