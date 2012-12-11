<?php

namespace library\capsule\accounting\lib\transaction;

use \framework\user;
use \library\capsule\accounting\lib\log;

class header {

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
    * @return int | false
    */
    public function getTransactionType($type) {		
        
        $this->db['select']->column      = "*";
		
		$this->db['select']->tableName   = "CAP_ACCOUNTING_TRANSACTION_TYPE";
		
		$this->db['select']->whereClause = [["CAP_ACC_TRA_TYP_NAME","=",strtoupper($type)]];
		
		$this->db['select']->execute();
		
		return $this->db['select']->arrayResult[0]['CAP_ACC_TRA_TYP_ID'];
        
    }
    
    /**
    * Returns the last inserted header from database or false if insert operation is failed
    *
    * @return int | false
    */
	public function create($type,$data,$total) {
		
		$header = $type;

		$type   = $this->getTransactionType($type);
		
		if (!empty($data['item-row'])): $row = $data['item-row']; endif;
		
		if (!empty($data['account-row'])): $row .= '/'.$data['account-row']; endif;
		
		$date   = (!empty($data['date'])) ? date("Y-m-d",strtotime($data['date'])) : null;
		
		$dateD  = (!empty($data['due-date'])) ? date("Y-m-d",strtotime($data['due-date'])) : null;
		                
    	$column = [
				  "CAP_ACC_TRA_DATECREATED" => date("Y-m-d H:i:s"),
				  "CAP_ACC_TRA_DATE" 	  	=> $date,
				  "CAP_ACC_TRA_DUEDATE"   	=> $dateD,
				  "CAP_ACC_TRA_NUMBER" 	  	=> $data['number'],
				  "FK_CAP_ACC_TRA_TYP_ID" 	=> $type,
				  "FK_CAP_ACC_USE_ACC_ID" 	=> $_SESSION['ACCOUNTING-ACCOUNT'],
				  "CAP_ACC_TRA_ROW" 	  	=> $row,
				  "FK_CAP_ACC_TRA_CURRENCY" => $data['currency'],
				  "FK_CAP_ACC_TRA_GLOBALTAX"=> $data['globaltax'],
				  "FK_CAP_ACC_CON_ID"		=> $data['customer-id'],
				  "CAP_ACC_TRA_TOTAL"		=> $total,
				  "CAP_ACC_TRA_TOTALLEFT"	=> 0
				  ];
		
		$this->db['insert']->tableName   = "CAP_ACCOUNTING_TRANSACTION";
		
		$this->db['insert']->dateColumn  = ["CAP_ACC_TRA_DATECREATED","CAP_ACC_TRA_DATE","CAP_ACC_TRA_DUEDATE"];
		
		$this->db['insert']->column      = $column;
		
		$this->db['insert']->whereClause = "CAP_ACC_TRA_ID";
		
		$lastID = $this->db['insert']->execute();
		
		  if (is_numeric($lastID) && !empty($lastID)):
		      
		      log::setLog('event',$header.' id no. '. $lastID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		      
		      return $lastID;
		  
		  else:
		      
		      log::setLog('event',$header.' id failed to create',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		      
		      return false;
		  
		  endif;
		    	
	}
	
	/**
    * Returns true for success insertion or false if insertion is failed
    *
    * @return true | false
    */
	public function update($type,$data,$total) {
    	
    	$header = $type;

		$type   = $this->getTransactionType($type);

		if (!empty($data['item-row'])): $row = $data['item-row']; endif;
		
		if (!empty($data['account-row'])): $row .= '/'.$data['account-row']; endif;
		
		$date   = (!empty($data['date'])) ? date("Y-m-d",strtotime($data['date'])) : null;
		
		$dateD  = (!empty($data['due-date'])) ? date("Y-m-d",strtotime($data['due-date'])) : null;
                
    	$column = [
				  "CAP_ACC_TRA_DATEUPDATED" => date("Y-m-d H:i:s"),
				  "CAP_ACC_TRA_DATE" 	  	=> $date,
				  "CAP_ACC_TRA_DUEDATE"   	=> $dateD,
				  "CAP_ACC_TRA_NUMBER" 	  	=> $data['number'],
				  "FK_CAP_ACC_TRA_TYP_ID" 	=> $type,
				  "FK_CAP_ACC_USE_ACC_ID" 	=> $_SESSION['ACCOUNTING-ACCOUNT'],
				  "CAP_ACC_TRA_ROW" 	  	=> $row,
				  "FK_CAP_ACC_TRA_CURRENCY" => $data['currency'],
				  "FK_CAP_ACC_TRA_GLOBALTAX"=> $data['globaltax'],
				  "FK_CAP_ACC_CON_ID"		=> $data['customer-id'],
				  "CAP_ACC_TRA_TOTAL"		=> $total
				  ];
		
		$this->db['update']->tableName   = "CAP_ACCOUNTING_TRANSACTION";
		
		$this->db['update']->dateColumn  = ["CAP_ACC_TRA_DATEUPDATED","CAP_ACC_TRA_DATE","CAP_ACC_TRA_DUEDATE"];
		
		$this->db['update']->column      = $column;

		$this->db['update']->whereClause = [
											["CAP_ACC_TRA_ID","=",$data['transaction-pid']],
											["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]
										   ];
		
		$lastID = $this->db['update']->execute();
		
		  if (is_resource($lastID)):
		      
		      log::setLog('event',$header.' id no. '. $data['transaction-pid']. ' updated',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		      
		      return true;
		  
		  else:
		      
		      log::setLog('event',$header.' id failed to update',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		      
		      return false;
		  
		  endif;
    	
	}
	
	public function paid($type,$id,$amount) {
	      
	      $column = [
				  "CAP_ACC_TRA_DATEUPDATED" => date("Y-m-d H:i:s"),
				  "CAP_ACC_TRA_TOTALLEFT"	=> $amount
				  ];
	      	      
	      $this->db['update']->tableName   = "CAP_ACCOUNTING_TRANSACTION";
		
	      $this->db['update']->dateColumn  = ["CAP_ACC_TRA_DATEUPDATED"];
	      
	      $this->db['update']->column      = $column;
	      
	      $this->db['update']->whereClause = [
											  ["CAP_ACC_TRA_ID","=",$id],
											  ["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]
										     ];
		
          $lastID = $this->db['update']->execute();
          
          if (is_resource($lastID)):
		      
		      log::setLog('event',$type.' id no. '. $id. ' paid with amount of '.number_format($amount,2),[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		      
		      return true;
		  
		  else:
		      
		      log::setLog('event',$type.' id no. '. $id. ' failed to paid',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		      
		      return false;
		  
		  endif;
	   
	}
    
}
    
?>