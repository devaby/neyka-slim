<?php

namespace framework\database\oracle;

use \framework\connection;

class oracle extends connection {

public $oraConn;
public $column;
public $tableName;
public $whereClause;
public $orderClause;
public $arrayResult;
public $singleResult;
public $content;
public $whereID;
public $language;
public $dateColumn = array("CAP_CON_CREATED");

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause,$database = DATABASE) {
				
        $this->oraConn      = $this->$database();
		$this->column 		= $column;
		$this->tableName	= $tableName;
		$this->whereClause	= $whereClause;
		$this->whereID		= $whereID;
		$this->orderClause	= $orderClause;
	
	}

}



?>