<?php

namespace library\capsule\accounting\lib\user;

use \framework\user;
use \library\capsule\accounting\lib\log;

class policy {

public $db;

    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function setHandler($db) {
        
        if (!isset($this->db)):
        
            $this->db = $db;
        
        endif;
                
    return $this;
        
    }
    
    /**
    * get the item line type
    *
    * @return mixed(int | false)
    */
    public function get($type) {
        
        $this->db['select']->column      = '*';
		
		$this->db['select']->tableName   = 'CAP_ACCOUNTING_USER_ACCOUNT_COMBINE
											LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_POLICY
											ON CAP_ACCOUNTING_USER_ACCOUNT_COMBINE.FK_CAP_ACC_USE_ACC_POL_ID = CAP_ACCOUNTING_USER_ACCOUNT_POLICY.CAP_ACC_USE_ACC_POL_ID';
		
		$this->db['select']->whereClause = [['FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],['FK_CAP_ACC_USE_ACC_POL_CAT_ID','=',strtoupper($type)]];
		
		$this->db['select']->execute();
		
		return strtolower($this->db['select']->arrayResult[0]['CAP_ACC_USE_ACC_POL_NAME']);
        
    }
    
}
    
?>