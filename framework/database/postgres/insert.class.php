<?php

namespace framework\database\postgres;

use \framework\connection;
use \framework\debugger;

class insert extends postgres {

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {

        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}
	
	public function execute() {
	
		$params = array();
				
		$query = "INSERT INTO " . $this->schema . "." . $this->tableName . " (";
		
			foreach ($this->column as $key => $value) {
			$query .= $key . ",";
			}
		
		$query  = substr($query, 0, -1); $query .= ")"; $query .= "VALUES (";
		
		$i = 1;
		
			foreach ($this->column as $key => $value) {
			
				if (in_array($key,$this->dateColumn)) {
				if (empty($value)) {$value = null;}
				$params[] = $value;
				$query .= "to_timestamp($" . $i++ . ",'yyyy-mm-dd HH24:MI:SS'),";
				}
				else {
				if (empty($value)) {$value = null;}
				$params[] = $value;
				$query .= "$" . $i++ . ",";
				}
			
			}
		
		$query  = substr($query, 0, -1); $query .= ")";
		
			if (!empty($this->whereClause)) {
		
				$query .= "RETURNING ".$this->whereClause;
				
			}

		$result	= pg_query_params($this->oraConn,$query,$params);

		if (!$result) {
				     			 
			 debugger::write();
			 			 		          		     
		     return false;
		    		    
		}
						
		$row = pg_fetch_array($result);

		$this->query = $query;
				
		return $row[0];
	
	}
	
}


?>