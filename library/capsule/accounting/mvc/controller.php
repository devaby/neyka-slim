<?php

namespace library\capsule\accounting\mvc;

class controller {

public $servitor;
    
	public function __call($method, $args) {

    var_dump($method);
    	
    return $this;
    	
    }
        
}
    
?>