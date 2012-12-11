<?php

namespace framework\database\factory;

use \framework\connection;

class factory {

protected $args,$abstract;

protected $mysql	= "framework\database\mysql\select";
protected $oracle	= "framework\database\oracle\select";
protected $postgres = "framework\database\postgres\select";

	public function __construct($column = null,$tableName = null,$whereClause = null,$whereID = null,$orderClause = null) {
                
        $this->args = array($column,$tableName,$whereClause,$whereID,$orderClause);

	}
	
	public function __call($method, $args) {
		
		switch(DATABASE) {
			
			case 'mysql':
			$instance = new \framework\database\mysql\select($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4]);
			$this->abstract = $instance;
			break;
			
			case 'oracle':
			$instance = new \framework\database\oracle\select($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4]);
			$this->abstract = $instance;
			break;
			
			case 'postgres':
			$instance = new \framework\database\postgres\select($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4]);
			$this->abstract = $instance;
			break;
			
		}

	return call_user_func_array(array($this->abstract, $method), $args);
			
	}
	
}

?>
