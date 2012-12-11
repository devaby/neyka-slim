<?php

namespace library\capsule\accounting\lib;

class check {

public $servitor;
    
	public function __call($method, $args) {

    $class = '\\' . __CLASS__ . '\\' . $method;
        
        if (class_exists($class)):

            if (!isset($this->servitor->$method)):
            
                if (!is_object($this->servitor)): $this->servitor = new \stdClass(); endif;
            
                if (!is_object($this->servitor->$method)): $this->servitor->$method = new \stdClass(); endif;
            
                $this->servitor->$method = new $class();
            
            endif;
        
        else:
        
            foreach ($this->servitor as $value):

                if (method_exists($value, $method)):

                    return $value->$method($args);
                
                endif;
            
            endforeach;
                   
        endif;
    	
    return $this;
    	
    }
        
}
    
?>