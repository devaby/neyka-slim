<?php

namespace framework\database\oracle;

use \framework\connection;

class update {

public $database;

	public function __construct($column = null,$tableName = null,$whereClause = null,$whereID = null,$orderClause = null) {
                        
        $database = "\\framework\\database\\".DATABASE."\\update";
        
        $this->database = new $database($column,$tableName,$whereClause,$whereID,$orderClause);

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