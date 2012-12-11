<?php

namespace framework\database\postgres;

use \framework\connection;
use \framework\debugger;

class select extends postgres {

	public function __construct($column = null,$tableName = null,$whereClause = null,$whereID = null,$orderClause = null,$limitClause = null) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause,$limitClause);
	
	}

	public function execute () {
		
		$params = array();

		$table  = explode("JOIN",$this->tableName);
		
		$i = 0;
		
		$c = count($table);
		
			foreach ($table as $key => $value) {
			
			$i++;	
			
				if ($c != $i) {

					$rebuildQuery .= ltrim($value) . " JOIN " . $this->schema .".";
						
				}
				else {
					
					$rebuildQuery .= ltrim($value);
					
				}
															
			}
			
		$this->tableName = $rebuildQuery;
		
		$query	= "SELECT " . $this->column . " FROM " . $this->schema . "." . $this->tableName;

		//Start to build the extended query for where if param 'whereClause' is not empty
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
						
						if (empty($value[2])): $value[2] = null; endif;
						
						$params[] = $value[2];
						
						$query .= $value[0]." $value[1] $".$y++;

						}

					}
					else if (is_array($value) && !empty($value[1])) {

						if (strtoupper($value[1]) == 'OR') {

						$query .= " $value[1] ";

						}
						else {
						
						if (empty($value[2])): $value[2] = null; endif;
						
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

		//Start to build the extended query for order by if param 'orderClause' is not empty
		if (!empty($this->orderClause)) {

		$z = 0;

			if (is_array($this->orderClause)) {
			
				$query .= " ORDER BY ";

				$c = count($this->orderClause);

				foreach ($this->orderClause as $key => $value) {

				$z++;

					$query .= "$".$i;

					if ($c != $z) {

					$query .= ",";
						
					}
				
				$y++;
				
				}

			}
			else {

			$query .= " ORDER BY ".$this->orderClause;

			}

		}
		
		if (!empty($this->limitClause)) {
		
			$query .= " LIMIT ".$this->limitClause;
		
		}

		$result	= pg_query_params($this->oraConn,$query,$params); 
		
		
		if (!$result) {
			 
			 debugger::write();
			 			 		          		     
		     return false;
		    
		} 
				
			while ($row = pg_fetch_assoc($result)) { 

			$array [] = array_change_key_case($row, CASE_UPPER);
			
			}
						
			$this->arrayResult = $array; 
			
			$this->query = $query;
			
		return true;

	}
	
}

?>
