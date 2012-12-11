<?php

namespace library\capsule\accounting\lib\transaction;

use \framework\user;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\update;
use \library\capsule\accounting\lib\log;

class ledger {
    
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
    
	public function create($data) {
    	    			
		$this->db['insert']->tableName   = "CAP_ACCOUNTING_COA_POSTING";
		
		$this->db['insert']->dateColumn  = ["CAP_ACC_COA_POS_DATECREATED"];
		
		$this->db['insert']->whereClause = "CAP_ACC_COA_POS_ID";
		
		$this->db['insert']->column = [
		
						  "FK_CAP_ACC_COA_ID" 	  => $data['coaID'],
						  "CAP_ACC_COA_POS_DB"    => $data['debit'],
						  "CAP_ACC_COA_POS_CR"    => $data['credit'],
						  "FK_CAP_ACC_TRA_ITE_ID" => $data['itemID'],
						  "CAP_ACC_COA_POS_DATECREATED" => date("Y-m-d H:i:s")
		
						  ];
						  
		$lastID = $this->db['insert']->execute();
		
		if (is_numeric($lastID) && !empty($lastID)):
						
			log::setLog('event','posting id no. '. $lastID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			
			return true;
		
		else:
						
			log::setLog('event','posting id failed to create',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			
			return false;
		
		endif;
    	
	}
	
	public function update($data) {
    			
		$this->db['update']->tableName   = "CAP_ACCOUNTING_COA_POSTING";
		
		$this->db['update']->dateColumn  = ["CAP_ACC_COA_POS_DATEUPDATED"];
		
		$this->db['update']->whereClause = [["FK_CAP_ACC_TRA_ITE_ID","=",$data['itemID']]];
		
		$this->db['update']->column = [
		
						  "FK_CAP_ACC_COA_ID" 	  => $data['coaID'],
						  "CAP_ACC_COA_POS_DB"    => $data['debit'],
						  "CAP_ACC_COA_POS_CR"    => $data['credit'],
						  "CAP_ACC_COA_POS_DATEUPDATED" => date("Y-m-d H:i:s")
		
						  ];
						  
		$lastID = $this->db['update']->execute();
		
		if (is_resource($lastID) && !empty($lastID)):
						
			log::setLog('event','posting id no. '. $data['itemID'] . ' updated',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			
			return true;
		
		else:
						
			log::setLog('event','posting id failed to update',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			
			return false;
		
		endif;
    	
	}
	
	/**
    * check if line item is exist in the database
    *
    * @return mixed(int | false)
    */
	public function isExist($itemPid) {

		$this->db['select']->tableName   = "CAP_ACCOUNTING_COA_POSTING";
		
		$this->db['select']->whereClause = [["FK_CAP_ACC_TRA_ITE_ID","=",$itemPid]];	
		
		$this->db['select']->execute();
		
		if (!empty($this->db['select']->arrayResult[0]['CAP_ACC_COA_POS_ID'])): 

			return $this->db['select']->arrayResult[0]['CAP_ACC_COA_POS_ID'];

		else:
		    
		    log::setLog('event','coa item id no. '. $itemPid . ' is not exist',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
			return false;

		endif;

	}
	
	public function pullID($id) {
    	
    	$this->db['select']->arrayResult = null;
    	
    	$this->db['select']->tableName   = "
    	CAP_ACCOUNTING_TRANSACTION 
    	LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM ON 
    	CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID
    	LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON 
    	CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID";
		
		$this->db['select']->whereClause  = [["CAP_ACC_TRA_ITE_TYP_NAME","=","ACCOUNT"],["FK_CAP_ACC_TRA_ID","=",$id]];
		
		$this->db['select']->execute();
		
		if (!empty($this->db['select']->arrayResult)):
		  
		  $coaID = $this->db['select']->arrayResult[0]['FK_CAP_ACC_COA_ID'];
		  
		  log::setLog('event','pull coa id no. '.$coaID.' has been pulled',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		  
		  return $coaID;
		
		else:
		  
		  log::setLog('event','pull coa id no. '.$id.' failed to pulled',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		  
		  return false;
		
		endif;
    	
	}
    
}
    
?>