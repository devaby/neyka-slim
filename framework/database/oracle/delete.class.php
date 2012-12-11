<?php

namespace framework\database\oracle;

use \framework\connection;

class delete {

public $args,$database;

	public function __construct($column = null,$tableName = null,$whereClause = null,$whereID = null,$orderClause = null) {
                
        $this->args = array($column,$tableName,$whereClause,$whereID,$orderClause);
        
        $database = "\\framework\\database\\".DATABASE."\\delete";
        
        $this->database = new $database($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4]);

	}
	
	public function __set($property, $value) {
    
	    if (property_exists($this->database, $property)) {
	    
	      $this->database->$property = $value;
	      
	    }

    return $this;
    
    }
    
    public function __get($property) {
    
	    if (property_exists($this->database, $property)) {
	    
	      return $this->database->$property;
	      
	    }
    
    }
    
    public function __isset($property) {
    
	    if (property_exists($this->database, $property)) {
	    
	      return $this->database->$property;
	      
	    }
    
    }
	
	public function __call($method, $args) {

		return call_user_func_array(array($this->database, $method), $args);
			
	}
	
}

?>