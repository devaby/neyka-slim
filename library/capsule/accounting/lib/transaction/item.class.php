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
    
    public function inventory($type,$inv) {
	    
	    $type = strtoupper($type);
	    
	    if ($type == 'INVOICE' || $type == 'SALES RECEIPT'):
	    
	    	return '-' . $inv;
	    	    
	    else:
	    
	    	return $inv;
	    
	    endif;
	    
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
    * get the item line type
    *
    * @return mixed(int | false)
    */
    public function all($transactionID,$type) {
        
        $type = $this->getItemType($type);
        
        $this->db['select']->column      = "*";
		
		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
		
		$this->db['select']->whereClause = [["FK_CAP_ACC_TRA_ID","=",$transactionID],["FK_CAP_ACC_TRA_ITE_TYP_ID","=",strtoupper($type)]];
		
		$this->db['select']->execute();
		
		return $this->db['select']->arrayResult;
        
    }
    
    /**
    * get the item line type
    *
    * @return mixed(string | false)
    */
    public function type($id) {
        
        $this->db['select']->column      = "*";
		
		$this->db['select']->tableName   = "CAP_ACCOUNTING_ITEM 
                                    		LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON 
                                    		CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID";
		
		$this->db['select']->whereClause = [["CAP_ACC_ITE_ID","=",$id],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]];
		
		$this->db['select']->execute();
		
        if (!empty($this->db['select']->arrayResult[0]['CAP_ACC_ITE_TYP_NAME'])):
        
          return strtolower($this->db['select']->arrayResult[0]['CAP_ACC_ITE_TYP_NAME']);
        
        else:
        
          return false;
        
        endif;
        
    }
    
    /**
    * Returns the last inserted item from database or false if insert operation is failed
    *
    * @return mixed(int | false)
    */
	public function create($data) {		
    	
    	$ityp = strtoupper($data['typ']);
    	
		$type = $this->getItemType($ityp);
		
		$inv  = $this->inventory($data['tra'],$data['qty']);
		
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
										    "FK_CAP_ACC_TRA_ID_PAYMENT" => $data['pay'],
										    "CAP_ACC_TRA_ITE_QTY_INV"	=> $inv
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
    	
    	$ityp = strtoupper($data['typ']);
    	
		$type = $this->getItemType($ityp);
		
		$inv  = $this->inventory($data['tra'],$data['qty']);

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
										    "FK_CAP_ACC_TRA_ID_PAYMENT" => $data['pay'],
										    "CAP_ACC_TRA_ITE_QTY_INV"	=> $inv
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
	public function isExist($pid,$type,$itemPid = null,$parent = false) {

		$type = $this->getItemType($type);

		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM";
		
			if (!empty($itemPid) && !$parent):

			$this->db['select']->whereClause = [
												["FK_CAP_ACC_TRA_ID","=",$pid],
												["FK_CAP_ACC_TRA_ITE_TYP_ID","=",strtoupper($type)],
												["CAP_ACC_TRA_ITE_ID","=",$itemPid]
											   ];

			elseif (!empty($itemPid) && $parent):

			$this->db['select']->whereClause = [
												["FK_CAP_ACC_TRA_ID","=",$pid],
												["FK_CAP_ACC_TRA_ITE_TYP_ID","=",strtoupper($type)],
												["FK_CAP_ACC_TRA_ITE_ID","=",$itemPid]
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
		    
		    log::setLog('event','item id transaction no. '. $pid . ' is not exist',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
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
	
	/**
    * return the item coa id
    *
    * @return mixed(int | false)
    */
	public function coa($pid,$type) {

		$this->db['select']->tableName   = "CAP_ACCOUNTING_ITEM_COA 
		LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
		
		$this->db['select']->whereClause = [
											["FK_CAP_ACC_ITE_ID","=",$pid],
											["CAP_ACC_ITE_COA_TYP_NAME","=",strtoupper($type)]
										   ];

		
		$this->db['select']->execute();
		
		if (!empty($this->db['select']->arrayResult[0]['FK_CAP_ACC_COA_ID'])): 
		  
		    log::setLog('event','coa id no. '. $pid . ' exist',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		  
			return $this->db['select']->arrayResult[0]['FK_CAP_ACC_COA_ID'];

		else:

			return false;

		endif;

	}
	
	/**
    * check if line item is exist in the database
    *
    * @return true | false
    */
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
				    
				    $error .= 'Failed to delete line item id no '.$value;
				    					
					$i++;
											
					endif;
				
				else:
				
				$error .= 'There is line item with that id no '.$value;
				
				$i++;
				
				endif;
			
			endforeach;
		
		endif;

	if ($i == 0):
	
	log::setLog('event','item id no. '. $data['pid'] . ' updated',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
	
	return true;

	else:
	
	log::setLog('event','item id no. '. $data['pid'] . ' updated',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
	
	return false;

	endif;

	}
	
	/**
    * check if line item is exist in the database
    *
    * @return float | zero
    */
	public function sum($id,$type,$date = null) {
		
		$mapper = ['qty' => 'CAP_ACC_TRA_ITE_QTY_INV', 'rate' => 'CAP_ACC_TRA_ITE_RATE', 'amount' => 'CAP_ACC_TRA_ITE_AMOUNT'];
		
		$this->db['select']->column = "SUM(".$mapper[$type].") as TOTAL";
			
		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID";
		
		if (empty($date)):
		
		$this->db['select']->whereClause = [
                                    		["FK_CAP_ACC_ITE_ID","=",$id],
                                    		["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_TRA_TYP_NAME','=','BILL'],
                                    		['','OR',''],
                                    		["FK_CAP_ACC_ITE_ID","=",$id],
                                    		["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_TRA_TYP_NAME','=','RECEIPT'],
                                           ];
        
        else:
                
        $this->db['select']->whereClause = [
                                    		["FK_CAP_ACC_ITE_ID","=",$id],
                                    		["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_TRA_TYP_NAME','=','BILL'],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($date))],
                                    		['','OR',''],
                                    		["FK_CAP_ACC_ITE_ID","=",$id],
                                    		["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_TRA_TYP_NAME','=','RECEIPT'],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($date))],
                                           ];
                                     
        endif;
		
		$this->db['select']->execute();
				
		if (!empty($this->db['select']->arrayResult[0]['TOTAL'])): 

			return round($this->db['select']->arrayResult[0]['TOTAL'],2);

		else:

			return 0;

		endif;
		
	}
    
}
    
?>