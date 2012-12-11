<?php

namespace framework\pattern;

trait singleton {

public static $object = [];

protected static $_instance = null;

    public static function getInstance() {
    		
		if (!in_array(get_class($this),self::$object)):

	    	self::$object[] = $class;
	        
	        static::$_instance = new static();
	        
	    endif;
                
    return static::$_instance;
        
    }

    protected function __construct() {
    
        echo "Constructor in Singleton trait - construction class of " . get_class($this) . "\n";
        
    }

    protected function __clone() {

    }
    
}