<?php

namespace library\capsule\user\lib;

use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\update;
use \framework\database\oracle\delete;

class transaction {

protected static $_instance;

	public static function getInstance() {
	
        if (null === self::$_instance):
        
            self::$_instance = new self();
            
        endif;

    return self::$_instance;
        
    }
            
}
    
?>