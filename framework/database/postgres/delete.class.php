<?php

namespace framework\database\postgres;

use \framework\connection;
use \framework\debugger;

class delete extends postgres {

	public function __construct($column = null,$tableName = null,$whereClause = null,$whereID = null,$orderClause = null) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}
	
	public function execute(){
	
		$params = array();
				
		$query  .= "DELETE FROM " . $this->schema . "." . $this->tableName ;
		
		if (!empty($this->whereClause)) {

			if (is_array($this->whereClause)) {
			
			$y = 1; $x = 0;

			$query .= " WHERE ";

			$c = count($this->whereClause);

				foreach ($this->whereClause as $key => $value) {
					
					$x++;
					
					if (is_array($value) && empty($value[1])) {
						
						if (strtoupper($value[2]) == 'IS NULL' || strtoupper($value[2]) == 'IS NOT NULL') {

						$query .= $value[0]." $value[1] ". $value[2];

						}
						else {
						
						$params[] = $value[2];
						
						$query .= $value[0]." $value[1] $".$y++;

						}

					}
					else if (is_array($value) && !empty($value[1])) {

						if (strtoupper($value[1]) == 'OR') {

						$query .= " $value[1] ";

						}
						else {
						
						$params[] = $value[2];
						
						$query .= $value[0]." $value[1] $".$y++;

						}

					}
					else {
					
					$params[] = $value[2];
					
					$query .= $value[0]." = $".$y++; 

					}
					
					if ($c != $x) {

					$query .= " AND ";
						
					}
					
					if (strtoupper($value[1]) == 'OR') {

					$query = substr($query, 0, -14);

					$query .= " OR ";
						
					}
				
				$i++;
				
				}

			}
			else {

			$query .= " WHERE ".$this->whereClause;

			}

		}
		
		$result	= pg_query_params($this->oraConn,$query,$params); 
		
		if (!$result) {
			 
			 debugger::write();
			 			 		          		     
		     return false;
		    
		}
		
	$this->query = $query;
		
	return $result;

	}
	
	public function deleteRow() {
	
		$query  = "DELETE FROM " . $this->schema . "." . $this->tableName . " WHERE " . $this->whereClause . " = " . $this->whereID;
		
		return $result	= pg_query($this->oraConn, $query);
	
	}
	
	public function deleteRowMultipleWhere() {
	
		$query  = "DELETE FROM " . $this->schema . "." . $this->tableName . " WHERE " . $this->whereClause;
		
		return $result	= pg_query($this->oraConn, $query); 
	
	}
	
	public function deleteTable() {
	
		$query  = "TRUNCATE TABLE " . $this->schema . "." . $this->tableName;
		
		return $result	= pg_query($this->oraConn, $query); 
	
	}

}


?>