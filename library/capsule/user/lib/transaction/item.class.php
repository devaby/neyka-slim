<?php

namespace library\capsule\accounting\lib\transaction;

use \framework\user;
use \library\capsule\accounting\lib\log;

class item {

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
    public function getItemType($type) {
        
        $this->db['select']->column      = "*";
		
		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE";
		
		$this->db['select']->whereClause = [["CAP_ACC_TRA_ITE_TYP_NAME","=",strtoupper($type)]];
		
		$this->db['select']->execute();
		
		return $this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_TYP_ID'];
        
    }
    
    /**
    * Returns the last inserted item from database or false if insert operation is failed
    *
    * @return mixed(int | false)
    */
	public function create($data) {		
    			
		$type = $this->getItemType($data['typ']);

		$last = (!empty($data['lst'])) ? $data['lst'] : null;

		$this->db['insert']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
		
		$this->db['insert']->whereClause = "CAP_ACC_TRA_ITE_ID";
		
        $this->db['insert']->column      = [
										    "FK_CAP_ACC_ITE_ID"	 		=> $data['tid'],
										    "CAP_ACC_TRA_ITE_RATE" 		=> $data['prc'],
										    "CAP_ACC_TRA_ITE_QTY"  		=> $data['qty'],
										    "CAP_ACC_TRA_ITE_AMOUNT"  	=> $data['amo'],
										    "FK_CAP_ACC_COA_ID"			=> $data['coa'],
										    "FK_CAP_ACC_TRA_ID"			=> $data['lid'],
										    "CAP_ACC_TRA_ITE_DESC" 		=> $data['des'],
										    "CAP_ACC_TRA_ITE_POSITION" 	=> $data['pos'],
										    "FK_CAP_ACC_TRA_ITE_TYP_ID"	=> $type,
										    "FK_CAP_ACC_TRA_ITE_ID"		=> $last,
										    "FK_CAP_ACC_TRA_ID_PAYMENT" => $data['pay']
										   ];
        
		$lastID = $this->db['insert']->execute();
		
		if (is_numeric($lastID) && !empty($lastID)):
		    
		    log::setLog('event','item id no. '. $lastID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
		    return $lastID;
		  
        else:
		    
		    log::setLog('event','item id failed to create, reason: ' . $lastID,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
            return false;
		  
        endif;
    	
	}
	
	public function update($data) {
    	
    	$type = $this->getItemType($data['typ']);

		$last = (!empty($data['lst'])) ? $data['lst'] : null;

		$this->db['update']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
		
		$this->db['update']->whereClause = [
											["FK_CAP_ACC_TRA_ID","=",$data['lid']],
											["FK_CAP_ACC_TRA_ITE_TYP_ID","=",$type],
											["CAP_ACC_TRA_ITE_ID","=",$data['pid']]
										   ];

        $this->db['update']->column      = [
										    "FK_CAP_ACC_ITE_ID"	 		=> $data['tid'],
										    "CAP_ACC_TRA_ITE_RATE" 		=> $data['prc'],
										    "CAP_ACC_TRA_ITE_QTY"  		=> $data['qty'],
										    "CAP_ACC_TRA_ITE_AMOUNT"  	=> $data['amo'],
										    "FK_CAP_ACC_COA_ID"			=> $data['coa'],
										    "CAP_ACC_TRA_ITE_DESC" 		=> $data['des'],
										    "CAP_ACC_TRA_ITE_POSITION" 	=> $data['pos'],
										    "FK_CAP_ACC_TRA_ITE_TYP_ID"	=> $type,
										    "FK_CAP_ACC_TRA_ITE_ID"		=> $last,
										    "FK_CAP_ACC_TRA_ID_PAYMENT" => $data['pay']
										   ];
        
		$lastID = $this->db['update']->execute();
		
		if (is_resource($lastID)):
		    
		    log::setLog('event','item id no. '. $data['pid'] . ' updated',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
		    return $data['pid'];
		  
        else:
		    
		    log::setLog('event','item id failed to update, reason: ' . $lastID,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
            return false;
		  
        endif;
    	
	}

	/**
    * check if line item is exist in the database
    *
    * @return mixed(int | false)
    */
	public function isExist($pid,$type,$itemPid = null) {

		$type = $this->getItemType($type);

		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
		
			if (!empty($itemPid)):

			$this->db['select']->whereClause = [
												["FK_CAP_ACC_TRA_ID","=",$pid],
												["FK_CAP_ACC_TRA_ITE_TYP_ID","=",strtoupper($type)],
												["CAP_ACC_TRA_ITE_ID","=",$itemPid]
											   ];

			else:

			$this->db['select']->whereClause = [
												["FK_CAP_ACC_TRA_ID","=",$pid],
												["FK_CAP_ACC_TRA_ITE_TYP_ID","=",strtoupper($type)]
											   ];	

			endif;
		
		$this->db['select']->execute();
		
		if (!empty($this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_ID'])): 

			return $this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_ID'];

		else:
		    
		    log::setLog('event','item id no. '. $itemPid . ' is not exist',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
			return false;

		endif;

	}

	/**
    * check if line item is exist in the database
    *
    * @return mixed(int | false)
    */
	public function childIsExist($pid,$type,$parent = null) {

		$type = $this->getItemType($type);

		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
		
		$this->db['select']->whereClause = [
											["FK_CAP_ACC_TRA_ID","=",$pid],
											["FK_CAP_ACC_TRA_ITE_TYP_ID","=",strtoupper($type)],
											["FK_CAP_ACC_TRA_ITE_ID","=",$parent]
										   ];

		
		$this->db['select']->execute();
		
		if (!empty($this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_ID'])): 

			return $this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_ID'];

		else:

			return false;

		endif;

	}

	public function purge($id) {

		if (!empty($id)):
		
			foreach ($id as $key => $value):
			
			$this->db['select']->column      = "*";
			
			$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID";
			
			$this->db['select']->whereClause = [["CAP_ACC_TRA_ITE_ID","=",$value],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]];
			
			$this->db['select']->execute();
			
				if (!empty($this->db['select']->arrayResult)):
				
				$this->db['delete']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
			
				$this->db['delete']->whereClause = [["CAP_ACC_TRA_ITE_ID","=",$value]];
			
				$deleteResult = $this->db['delete']->execute();
				
					if (!$deleteResult):
				    
				    $error [] = 'Failed to delete line item';
				    					
					$i++;
											
					endif;
				
				else:
				
				$error [] = 'There is line item with that id';
				
				$i++;
				
				endif;
			
			endforeach;
		
		endif;

	if ($i == 0):

	return true;

	else:

	return false;

	endif;

	}
    
}
    
?>