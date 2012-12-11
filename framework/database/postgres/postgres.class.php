<?php

namespace framework\database\postgres;

use \framework\connection;
use \framework\debugger;

class postgres extends connection {

public $trace,$oraConn,$column,$tableName,$whereClause,$orderClause,$limitClause,$arrayResult,$singleResult,$content,$whereID,$language;
public $dateColumn = array("CAP_CON_CREATED");

	public function __construct($column 		= null,
								$tableName 		= null,
								$whereClause 	= null,
								$whereID 		= null,
								$orderClause 	= null,
								$limitClause 	= null,
								$database 		= DATABASE) {
				
        $this->oraConn      = $this->$database();
		$this->column 		= $column;
		$this->tableName	= $tableName;
		$this->whereClause	= $whereClause;
		$this->whereID		= $whereID;
		$this->orderClause	= $orderClause;
		$this->limitClause	= $limitClause;
		$this->trace		= new debugger();
	
	}
	
	public function transactionStart() {
		
		pg_query($this->oraConn, 'BEGIN');
		
	}
	
	public function transactionSuccess() {
		
		pg_query($this->oraConn, 'COMMIT');
		
	}
	
	public function transactionFailed() {
		
		pg_query($this->oraConn, 'ROLLBACK');
		
	}

}



?>