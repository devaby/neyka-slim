<?php

namespace library\capsule\accounting\lib\routine;

use \framework\user;
use \library\capsule\accounting\lib\log;

class inventory {

protected $db;
        
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
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function first_bill() {
        
        $this->db['select']->column      = 'CAP_ACC_TRA_DATE';
		
		$this->db['select']->tableName   = 'CAP_ACCOUNTING_TRANSACTION_ITEM
		                                    LEFT JOIN CAP_ACCOUNTING_ITEM ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
		
		$this->db['select']->whereClause = [
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','BILL'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','RECEIPT'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                           ];
                                           
        $this->db['select']->orderClause = 'CAP_ACC_TRA_DATE ASC'; 
        
        $this->db['select']->limitClause = 1; 
		
		$this->db['select']->execute();
		
		return $this->db['select']->arrayResult[0]['CAP_ACC_TRA_DATE'];
        
    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function rate($itemID,$startDate) {
        
        $firstDate = $this->first_bill();
        
        $this->db['select']->column      = 'SUM(CAP_ACC_TRA_ITE_QTY_INV) AS TOTAL';
		
		$this->db['select']->tableName   = 'CAP_ACCOUNTING_TRANSACTION_ITEM
		                                    LEFT JOIN CAP_ACCOUNTING_ITEM ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
		
		$this->db['select']->whereClause = [
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','BILL'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($firstDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','RECEIPT'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($firstDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','INVOICE'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($firstDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','SALES RECEIPT'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($firstDate))],
                                           ];
        
        $this->db['select']->execute();
        
        $qtyOnHand = $this->db['select']->arrayResult[0]['TOTAL'];                            
        
        $this->db['select']->column      = 'CAP_ACC_TRA_ITE_ID,
                                            CAP_ACC_TRA_ITE_QTY,
                                            CAP_ACC_TRA_ITE_RATE,
                                            CAP_ACC_TRA_ITE_AMOUNT,
                                            CAP_ACC_TRA_TYP_NAME,
                                            CAP_ACC_TRA_DATE,
                                            CAP_ACC_TRA_ITE_RATE_INV,
                                            CAP_ACC_TRA_ITE_VAL_INV,
                                            CAP_ACC_TRA_DATE';
		
		$this->db['select']->tableName   = 'CAP_ACCOUNTING_TRANSACTION_ITEM
		                                    LEFT JOIN CAP_ACCOUNTING_ITEM ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
		
		$this->db['select']->whereClause = [
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','BILL'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($startDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','RECEIPT'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','<=',date('Y-m-d',strtotime($startDate))],
                                           ];
                                           
        $this->db['select']->orderClause = 'CAP_ACC_TRA_DATE DESC'; 
        
        $this->db['select']->limitClause = 2; 
		
		$this->db['select']->execute();
		
		  if (!empty($this->db['select']->arrayResult)):
		  
		      $this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_QTY'] = $qtyOnHand;

		  endif;

		return [$qtyOnHand,$this->db['select']->arrayResult]; 
        
    }

    
    /**
    * get the item line type
    *
    * @return mixed(int | false)
    */
    public function value($itemID,$startDate,$method,$returnValueOnly) {
    
        //$lastVal = $this->rate($itemID,$startDate);
        
        $firstDate = $this->first_bill();
            
        $this->db['select']->column      = 'CAP_ACC_TRA_ITE_ID,CAP_ACC_TRA_ITE_QTY,CAP_ACC_TRA_ITE_RATE,CAP_ACC_TRA_ITE_AMOUNT,CAP_ACC_TRA_TYP_NAME,CAP_ACC_TRA_DATE,CAP_ACC_TRA_NUMBER';
		
		$this->db['select']->tableName   = 'CAP_ACCOUNTING_TRANSACTION_ITEM
		                                    LEFT JOIN CAP_ACCOUNTING_ITEM ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON 
		                                    CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
		                                    LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON 
		                                    CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
		
		$this->db['select']->whereClause = [
		                                    ['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','BILL'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','>=',date('Y-m-d',strtotime($firstDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','RECEIPT'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','>=',date('Y-m-d',strtotime($firstDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','INVOICE'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','>=',date('Y-m-d',strtotime($firstDate))],
                                    		
                                    		['','OR',''],
                                    		['CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                    		['CAP_ACC_TRA_TYP_NAME','=','SALES RECEIPT'],
                                    		['CAP_ACC_TRA_ITE_TYP_NAME','=','ITEM'],
                                    		['CAP_ACC_ITE_ID','=',$itemID],
                                    		['CAP_ACC_TRA_DATE','>=',date('Y-m-d',strtotime($firstDate))],                                    		
                                           ];
                                           
        $this->db['select']->orderClause = 'CAP_ACC_TRA_DATE, REGEXP_REPLACE(CAP_ACC_TRA_NUMBER, \'[^0-9]\', \'\', \'g\')::INT ASC'; 
        
        $this->db['select']->limitClause = null; 
		
		$this->db['select']->execute();

		if (!empty($this->db['select']->arrayResult)):

		  $execute = $this->$method($this->db['select']->arrayResult,$lastVal,$returnValueOnly);
		
		endif;

    return $execute;
				
    }
    
    /**
    * get the item line type
    *
    * @return mixed(int | false)
    */
    public function cost_correction($itemID,$startDate,$method = 'average',$returnValueOnly = false) {

        $commence = $this->value($itemID,$startDate,$method,$returnValueOnly);
        
        $this->db['select']->orderClause = null;
        
        if (!$returnValueOnly):
        	
            if ($commence > 0):
            
              return false;
            
            else:
            
              return true;
            
            endif;
        
        else:
        
        return $commence;
        
        endif;
        				        
    }
    
    /**
    * check if line item is exist in the database
    *
    * @return float | zero
    */
	public function average($data,$lastVal = null,$returnValueOnly) {

	   if (!empty($data)):
	   
	   $i = 0;
	   
	       /*
	      if (!empty($lastVal) && count($lastVal[1]) > 1):
	           
	         $lastQty = $lastVal[0];
	           
	         $lastVal = reset($lastVal[1]);

	         $qtys = $lastQty - $lastVal['CAP_ACC_TRA_ITE_QTY'];
	         
	         $amount = $lastVal['CAP_ACC_TRA_ITE_QTY'] * $lastVal['CAP_ACC_TRA_ITE_RATE'];
	         
	         $average = ($lastVal['CAP_ACC_TRA_ITE_VAL_INV'] - $amount) / $qtys;
	         
	         $amountReal = $qtys * $average;
        	      
	         $averageReal = $amountReal / $qtys;
	         
	         $result = $this->update(['id' => $lastVal['CAP_ACC_TRA_ITE_ID'], 'average' => $averageReal, 'value' => $amountReal]);
        	      
	         if (!$result): $i++; endif;
	         
	         $costLot [] = ['date' => date('Y-m-d',strtotime($lastVal['CAP_ACC_TRA_DATE'])), 'qty' => $qtys, 'average' => $averageReal, 'value' => $amountReal];
	       
	      endif;
	      */
	      
	      foreach ($data as $key => $value):
	      	      
    	      if ($value['CAP_ACC_TRA_TYP_NAME'] == 'BILL'):
    		      
        	      $qtys   += $value['CAP_ACC_TRA_ITE_QTY'];
        	      
        	      $amount  = $value['CAP_ACC_TRA_ITE_QTY'] * $value['CAP_ACC_TRA_ITE_RATE'];
        	      
        	      $average = $amount / $qtys;
        	      
        	      $amountReal += $qtys * $average;
        	      
        	      $averageReal = $amountReal / $qtys;
        	      
        	      if (!$returnValueOnly):
        	      
        	      $result = $this->update(['id' => $value['CAP_ACC_TRA_ITE_ID'], 'average' => $averageReal, 'value' => $amountReal]);
        	      
        	      if (!$result): $i++; endif;
        	      
        	      endif;
              
    	      else:
    	      
        	      $qtys -= $value['CAP_ACC_TRA_ITE_QTY'];
        	      		      
        	      $amountReal -= $value['CAP_ACC_TRA_ITE_QTY'] * $averageReal;
        	      
        	      if (!$returnValueOnly):
        	      
        	      $result = $this->update(['id' => $value['CAP_ACC_TRA_ITE_ID'], 'average' => $averageReal, 'value' => $amountReal],true);
        	      
        	      if (!$result): $i++; endif;
        	      
        	      endif;
    	      		      		      
    	      endif;
	      
	      $costLot [] = ['date' => date('Y-m-d',strtotime($value['CAP_ACC_TRA_DATE'])), 'qty' => $qtys, 'average' => $averageReal, 'value' => $amountReal, 'type' => strtolower($value['CAP_ACC_TRA_TYP_NAME']), 'number' => $value['CAP_ACC_TRA_NUMBER']];
	      
	      endforeach;
	      
	   endif;
	       
    if (!$returnValueOnly):
    
    return $i;
    
    else:
    
    return $costLot;
    
    endif;
		      
    }
    
    public function update($id,$coa = false) {
      
      $i = 0;
      
      $this->db['update']->column = ['CAP_ACC_TRA_ITE_RATE_INV' => $id['average'], 'CAP_ACC_TRA_ITE_VAL_INV' => $id['value']];
      
      $this->db['update']->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM';
      
      $this->db['update']->whereClause = [
                                          ['CAP_ACC_TRA_ITE_ID','=',$id['id']],
                                         ];
      
      $result = $this->db['update']->execute();
      
      if (!$result): $i++; endif;
      
      if ($coa):
      
      $this->db['select']->column = '*';
	  
	  $this->db['select']->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM 
	  LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
	  LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID';
	  
	  $this->db['select']->whereClause = [
                                          ['FK_CAP_ACC_TRA_ITE_ID','=',$id['id']],
                                          ['FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                          ['CAP_ACC_TRA_ITE_TYP_NAME','=','INVENTORY']
                                         ];
                                         
      $this->db['select']->execute();
      
      
      $this->db['update']->column = ['CAP_ACC_COA_POS_CR' => $this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_QTY']*$id['average']];
      
      $this->db['update']->tableName = "CAP_ACCOUNTING_COA_POSTING";
      
      $this->db['update']->whereClause = [['FK_CAP_ACC_TRA_ITE_ID','=',$this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_ID']]];
      
      $result = $this->db['update']->execute();
      
      if (!$result): $i++; endif;
      
      $this->db['select']->column = '*';
	  
	  $this->db['select']->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM 
	  LEFT JOIN CAP_ACCOUNTING_TRANSACTION ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
	  LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID';
	  
	  $this->db['select']->whereClause = [
                                          ['FK_CAP_ACC_TRA_ITE_ID','=',$id['id']],
                                          ['FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']],
                                          ['CAP_ACC_TRA_ITE_TYP_NAME','=','COGS']
                                         ];
                                         
      $this->db['select']->execute();
      
      
      $this->db['update']->column = ['CAP_ACC_COA_POS_DB' => $this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_QTY']*$id['average']];
      
      $this->db['update']->tableName = "CAP_ACCOUNTING_COA_POSTING";
      
      $this->db['update']->whereClause = [['FK_CAP_ACC_TRA_ITE_ID','=',$this->db['select']->arrayResult[0]['CAP_ACC_TRA_ITE_ID']]];
      
      $result = $this->db['update']->execute();
      
      if (!$result): $i++; endif;
      
      endif;
      
      if ($i > 0):
      
        return false;
      
      else:
      
        return true;
      
      endif;
	
	}
	
    
}
    
?>