<?php

namespace framework\pattern\_singleton;

class memcache {

use \framework\pattern\singleton;

public $ttl 	= 600; 		// Time To Live
public $enabled = false; 	// Memcache enabled?
public $engine 	= null;
public $cache 	= null;
    
    public static function init() {

	    return self::getInstance();
	    		            	    	    
    }
    
    public function __construct() {
    
	    if (class_exists("\Memcache")):
    		
    		$class = reset(explode('.',end(explode('/',get_class($this)))));
    		
    			if (!isset($GLOBALS[$class])):

    			$this->engine = new \Memcache();
    			                                    
		            if ($this->engine->connect('localhost', 11211)): // Instead 'localhost' here can be IP
		            
		                $this->cache = true;
		                
		                $this->enabled = true;
		            
		            else:
		            
		            	$this->cache = false;
		                
		                $this->enabled = false;
		            
		            endif;
	            
	            endif;
            
            endif;
            	   
    }
    
    // get data from cache server
    public function getData($sKey) {
    
        $vData = $this->engine->get($sKey);
        
        return false === $vData ? null : $vData;
        
    }

    // save data to cache server
    public function setData($sKey, $vData) {

        //Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib).
        
        return $this->engine->set($sKey, $vData, 0, $this->ttl);
        
    }

    // delete data from cache server
    public function delData($sKey) {
    
        return $this->engine->delete($sKey);
        
    }
    
}

?>