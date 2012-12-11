<?php

namespace framework;

class pattern {

public $path;

    public static function init() {
    
    $path = ROOT_PATH."framework/pattern/_singleton/*.class.php"; 
        
    	foreach (glob($path) as $filename) {
	    	
	    	$object = reset(explode('.',end(explode('/',$filename))));
	    	
	    	$class  = '\\framework\\pattern\\_singleton\\'.reset(explode('.',end(explode('/',$filename))));
	    	
    		if ($singleton = call_user_func_array([$class,'init'],[])):

	    			$GLOBALS['_neyClass'][$object] = $singleton;
    			    		
    		endif;

		}
		           		            
    }

    protected function __construct() {
    
        echo "Constructor in Singleton trait - construction class of " . get_class($this) . "\n";
        
    }

    protected function __clone() {



    }
    
}