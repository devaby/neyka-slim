<?php

namespace library\capsule\accounting\lib\check;

use \framework\user;
use \framework\database\oracle\select;
use \library\capsule\accounting\lib\log;

class transaction {

	
	public function balance() {
    	
    	$select = new select();
    	
    	$select->column = "SUM(CAP_ACC_COA_POS_DB) AS DEBIT, SUM(CAP_ACC_COA_POS_CR) AS CREDIT";
    	
    	$select->tableName = "
    	CAP_ACCOUNTING_COA_POSTING 
        LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM 
        ON CAP_ACCOUNTING_COA_POSTING.FK_CAP_ACC_TRA_ITE_ID = CAP_ACCOUNTING_TRANSACTION_ITEM.CAP_ACC_TRA_ITE_ID
        LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE 
        ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
        LEFT JOIN CAP_ACCOUNTING_TRANSACTION 
        ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID";
    	
    	$select->whereClause = [["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]];
    	
    	$result = $select->execute();

    	   if ($result):
    	       	   
    	   $debit  = round($select->arrayResult[0]['DEBIT'],2);
    	   
    	   $credit = round($select->arrayResult[0]['CREDIT'],2);
    	   
    	       if ($debit !== $credit):
    	       
    	       $db = 'db: ' . number_format($debit,2);
    	       
    	       $cr = 'cr: ' . number_format($credit,2);
    	       
    	       $tl = $db . ' ' . $cr;
    	       
    	       log::setLog('error','warning!! debit and credit is not balanced ('.$tl.')',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
    	       
    	       return false;
    	       
    	       else:
    	       
    	       return true;
    	       
    	       endif;
    	   
    	   endif;
    	
	}
    
}
    
?>