<?php

namespace framework\database\postgres;

use \framework\connection;
use \framework\debugger;

class update extends postgres {

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}
	
	public function execute() {
	
		$params = array();
		
		$query = "UPDATE " . $this->schema . "." . $this->tableName . " SET ";
		
		$i = 1;
		
			foreach ($this->column as $key => $value) {
			
				if (in_array($key,$this->dateColumn)) {
				if (empty($value)) {$value = null;}
				$params[] = $value;
				$query .= $key . " = to_timestamp($" . $i++ . ",'yyyy-mm-dd HH24:MI:SS'),";
				}
				else {
				if (empty($value)) {$value = null;}
				$params[] = $value;
				$query .= $key . " = $".$i++.",";
				}
			
			}
		
		$query  = substr($query, 0, -1);
		
		//Start to build the extended query for where if param 'whereClause' is not empty
		if (!empty($this->whereClause)) {

			if (is_array($this->whereClause)) {

			$y = 0;

			$query .= " WHERE ";

			$c = count($this->whereClause);

				foreach ($this->whereClause as $key => $value) {
					
					$y++;
					
					if (is_array($value) && !empty($value[1])) {

						if (strtoupper($value[2]) == 'IS NULL' || strtoupper($value[2]) == 'IS NOT NULL') {

						$query .= $value[0]." $value[1] ". $value[2];

						}
						else if (strtoupper($value[1]) == 'OR') {

						$query .= " $value[1] ";

						}
						else {
						
						$params[] = $value[2];
						
						$query .= $value[0]." $value[1] $".$i;

						}

					}
					else {
					
					$params[] = $value[2];
					
					$query .= $value[0]." = $".$i; 

					}

					if ($c != $y) {

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
	
}


?>