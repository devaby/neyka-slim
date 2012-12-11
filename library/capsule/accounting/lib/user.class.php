<?php

namespace library\capsule\accounting\lib;

class user {

protected static $_instance;

	public static function getInstance() {
	
        if (null === self::$_instance):
        
            self::$_instance = new self();
            
        endif;

    return self::$_instance;
        
    }
            
}
    
?>