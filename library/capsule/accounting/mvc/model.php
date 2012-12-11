<?php

namespace library\capsule\accounting\mvc;

use \framework\capsule;
use \framework\user;
use \framework\server;
use \framework\encryption;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\update;
use \framework\database\oracle\delete;
use \library\capsule\accounting\lib\log;

class model extends capsule {

public $data;
public static $steward;

    public function __construct () {
	
		parent::__construct(
		
		"Accounting",
		"Asacreative, Inc Team",
		"This is the accounting capsule",
		"<link href='library/capsule/accounting/css/accounting.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/accounting/js/accounting.js' type='text/javascript'></script>"
	
		);
			
	}
	
	public static function __callStatic($object, $args) {
    
    	$class  = array_slice(explode('\\',__NAMESPACE__), 0, -1);
    	
    	$class  = '\\' . implode("\\", $class) . '\\' . 'lib' . '\\' . $object . '\\' . $args[0];

    	if (class_exists($class)):

    	   if (!is_object(self::$steward)): self::$steward = new \stdClass(); endif;
    	   
    	   if (!is_object(self::$steward->$object)): self::$steward->$object = new \stdClass(); endif;
    	       	   
    	       if (!isset(self::$steward->$object->$args[0])):

        	       self::$steward->$object->$args[0] = new $class(); 
        	           	   
        	   endif;

    	   return self::$steward->$object->$args[0];
        	       	    	
    	endif;
    	    	
	}
				
	public function getCoa() {
				
		$select = new select('*','CAP_ACCOUNTING_COA LEFT JOIN CAP_ACCOUNTING_COA_TYPE ON CAP_ACCOUNTING_COA.FK_CAP_ACC_COA_TYP_ID = CAP_ACCOUNTING_COA_TYPE.CAP_ACC_COA_TYP_ID',[['FK_CAP_ACC_USE_ACC_ID','=',$_SESSION['ACCOUNTING-ACCOUNT']]],'','CAP_ACC_COA_TYP_TYPE,CAP_ACC_COA_CODE ASC'); 
		
		$select->execute();
		
		if (!empty($select->arrayResult)):
		
		$i = 0;
		
		$data = $select->arrayResult;
		
		$select->orderClause = null;
		
			foreach ($data as $key => $value):
			
			$select->column    = 'SUM(CAP_ACC_COA_POS_DB) AS DEBIT, SUM(CAP_ACC_COA_POS_CR) AS CREDIT';
			
			$select->tableName = 'CAP_ACCOUNTING_COA_POSTING';
			
			$select->whereClause = [['FK_CAP_ACC_COA_ID','=',$value['CAP_ACC_COA_ID']],['CAP_ACC_COA_POS_DATECREATED','>=',date('Y-01-01 00:00:00')],['CAP_ACC_COA_POS_DATECREATED','<=',date('Y-12-31 23:59:59')]];
			
			$select->execute();
			
				if (!empty($select->arrayResult)):

				$data[$i]['DEBIT']  =  $select->arrayResult[0]['DEBIT'];
				
				$data[$i]['CREDIT'] =  $select->arrayResult[0]['CREDIT'];
				
				endif;
			
			$i++;
			
			endforeach;
		
		endif;
		
		return json_encode($data);
		
	}
	
	public function getCoaType() {
		
		$select = new select("*","CAP_ACCOUNTING_COA_TYPE","","","CAP_ACC_COA_TYP_ID ASC"); $select->execute();
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getCoaTypeGroup() {
		
		$select = new select("DISTINCT(CAP_ACC_COA_TYP_TYPE)","CAP_ACCOUNTING_COA_TYPE","","","CAP_ACC_COA_TYP_TYPE ASC"); $select->execute();
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getAllCoaData() {
		
		$select = new select("*","CAP_ACCOUNTING_COA 
		LEFT JOIN CAP_ACCOUNTING_COA_TYPE ON CAP_ACCOUNTING_COA.FK_CAP_ACC_COA_TYP_ID = CAP_ACCOUNTING_COA_TYPE.CAP_ACC_COA_TYP_ID",
		[["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]],"","CAP_ACC_COA_TYP_TYPE ASC"); 
		
		$select->execute();
				
		return json_encode($select->arrayResult);
		
	}
	
	public function getCoaData() {
		
		$select = new select("*","CAP_ACCOUNTING_COA 
		LEFT JOIN CAP_ACCOUNTING_COA_TYPE ON CAP_ACCOUNTING_COA.FK_CAP_ACC_COA_TYP_ID = CAP_ACCOUNTING_COA_TYPE.CAP_ACC_COA_TYP_ID",
		[["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_COA_ID","=",$this->data]],"","CAP_ACC_COA_TYP_TYPE ASC"); 
		
		$select->execute();
				
		return json_encode($select->arrayResult[0]);
		
	}
	
	public function getCoaCurrencyAccount() {
		
		$select = new select("*","CAP_ACCOUNTING_COA 
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_COA.FK_CAP_ACC_USE_ACC_CUR_ID = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACCOUNTING_COA.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACCOUNTING_COA.CAP_ACC_COA_ID","=",$this->data]],
		"","");
		
		$select->execute();
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getItem() {
		
		$select = new select("*",
		"CAP_ACCOUNTING_ITEM
		LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID",
		[["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]],"","CAP_ACC_ITE_TYP_NAME ASC");
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
			
			$oldArray = $select->arrayResult;
			
			$i = 0;
			
				foreach ($oldArray as $key => $value):
				
				$newArray [$i] = $value;
				
				$select->tableName = "CAP_ACCOUNTING_ITEM_COA 
				LEFT JOIN CAP_ACCOUNTING_COA ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
				
				$select->whereClause = [["FK_CAP_ACC_ITE_ID","=",$value['CAP_ACC_ITE_ID']],["CAP_ACC_ITE_COA_TYP_NAME","=","PURCHASE"]];
				
				$select->orderClause = null;

					if ($select->execute()):

					$newArray [$i]['COA-PURCHASE'] = $select->arrayResult;
					
					endif;
					
				$select->tableName = "CAP_ACCOUNTING_ITEM_COA 
				LEFT JOIN CAP_ACCOUNTING_COA ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
				
				$select->whereClause = [["FK_CAP_ACC_ITE_ID","=",$value['CAP_ACC_ITE_ID']],["CAP_ACC_ITE_COA_TYP_NAME","=","SELLING"]];
				
				$select->orderClause = null;

					if ($select->execute()):

					$newArray [$i]['COA-SELLING'] = $select->arrayResult;
					
					endif;
					
				$select->tableName = "CAP_ACCOUNTING_ITEM_COA 
				LEFT JOIN CAP_ACCOUNTING_COA ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
				
				$select->whereClause = [["FK_CAP_ACC_ITE_ID","=",$value['CAP_ACC_ITE_ID']],["CAP_ACC_ITE_COA_TYP_NAME","=","COGS"]];
				
				$select->orderClause = null;

					if ($select->execute()):

					$newArray [$i]['COA-COGS'] = $select->arrayResult;
					
					endif;
					
				
				$i++;
				
				endforeach;
			
			endif;
		
		return json_encode($newArray);
		
	}
	
	public function getItemTax() {
		
		$select = new select("*",
		"CAP_ACCOUNTING_ITEM
		LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID",
		[["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],
		["CAP_ACC_ITE_TYP_NAME","=","TAX"]],"","CAP_ACC_ITE_TYP_NAME ASC");
		
		$select->execute();		
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getItemType() {
		
		$select = new select("*","CAP_ACCOUNTING_ITEM_TYPE","","","CAP_ACC_ITE_TYP_ID ASC"); 
		
		$select->execute();
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getItemData() {
		
		$select = new select("*",
		"CAP_ACCOUNTING_ITEM
		LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID",
		[["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_ITE_ID","=",$this->data]],"","CAP_ACC_ITE_TYP_NAME ASC");
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
			
			$oldArray = $select->arrayResult;
			
			$i = 0;
			
				foreach ($oldArray as $key => $value):
				
				$newArray [$i] = $value;
				
				$select->tableName = "CAP_ACCOUNTING_ITEM_COA 
				LEFT JOIN CAP_ACCOUNTING_COA ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
				
				$select->whereClause = [["FK_CAP_ACC_ITE_ID","=",$value['CAP_ACC_ITE_ID']],["CAP_ACC_ITE_COA_TYP_NAME","=","PURCHASE"]];
				
				$select->orderClause = null;

					if ($select->execute()):

					$newArray [$i]['COA-PURCHASE'] = $select->arrayResult;
					
					endif;
					
				$select->tableName = "CAP_ACCOUNTING_ITEM_COA 
				LEFT JOIN CAP_ACCOUNTING_COA ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
				
				$select->whereClause = [["FK_CAP_ACC_ITE_ID","=",$value['CAP_ACC_ITE_ID']],["CAP_ACC_ITE_COA_TYP_NAME","=","SELLING"]];
				
				$select->orderClause = null;

					if ($select->execute()):

					$newArray [$i]['COA-SELLING'] = $select->arrayResult;
					
					endif;
					
				$select->tableName = "CAP_ACCOUNTING_ITEM_COA 
				LEFT JOIN CAP_ACCOUNTING_COA ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON 
				CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
				
				$select->whereClause = [["FK_CAP_ACC_ITE_ID","=",$value['CAP_ACC_ITE_ID']],["CAP_ACC_ITE_COA_TYP_NAME","=","COGS"]];
				
				$select->orderClause = null;

					if ($select->execute()):

					$newArray [$i]['COA-COGS'] = $select->arrayResult;
					
					endif;
					
				
				$i++;
				
				endforeach;
			
			endif;
		
		return json_encode($newArray[0]);
				
	}
	
	public function getCurrency() {
		
		$select = new select("*","CAP_ACCOUNTING_CURRENCY","","","");
		
		$select->execute();
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getCurrencyAccount() {
		
		$select = new select("*","CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",[["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]],"","");
		
		$select->execute();
		
		return json_encode($select->arrayResult);
		
	}
	
	public function getSubjectAccount($id) {
	
		$select = new select("*","CAP_ACCOUNTING_SUBJECT_ACCOUNT","",array(array("fk_cap_use_id","=","$id")),""); $select->execute();
		
		$container = $select->arrayResult;
		
		return json_encode($container);
		
	}
	
	public function getContact($user){
			
		$select = new select("*","cap_accounting_contact 
LEFT JOIN cap_accounting_contact_type ON cap_accounting_contact.fk_cap_acc_con_typ_id = cap_accounting_contact_type.cap_acc_con_typ_id
LEFT JOIN cap_accounting_contact_additional ON cap_accounting_contact_additional.fk_cap_acc_con_id = cap_accounting_contact.cap_acc_con_id
LEFT JOIN cap_accounting_contact_sharing ON cap_accounting_contact_sharing.fk_cap_acc_con_id = cap_accounting_contact.cap_acc_con_id","","",""); $select->execute();
		//print_r($select);
		//echo $select->query;
		foreach($select->arrayResult as $key => $value){
			$newArray ['contact'][] = array("name" => $value['CAP_ACC_CON_CONTACT'],"email"=>$value['CAP_ACC_CON_EMAIL'], "phone" => "");
		}
		
		return $newArray;
	}
	
	public function getContactCustomer($user){
			
	$select = new select("*","
	CAP_ACCOUNTING_CONTACT 
	LEFT JOIN CAP_ACCOUNTING_CONTACT_TYPE ON CAP_ACCOUNTING_CONTACT.FK_CAP_ACC_CON_TYP_ID = CAP_ACCOUNTING_CONTACT_TYPE.CAP_ACC_CON_TYP_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_ADDITIONAL ON CAP_ACCOUNTING_CONTACT_ADDITIONAL.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_SHARING ON CAP_ACCOUNTING_CONTACT_SHARING.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
	[["CAP_ACC_CON_TYP_NAME","=","CUSTOMER"]],"",""); 
	
	$select->execute();
		
	return json_encode($select->arrayResult);
		
	}
	
	public function getContactCustomerWithOpenInvoice($user){
			
	$select = new select("*","
	CAP_ACCOUNTING_CONTACT 
	LEFT JOIN CAP_ACCOUNTING_CONTACT_TYPE ON CAP_ACCOUNTING_CONTACT.FK_CAP_ACC_CON_TYP_ID = CAP_ACCOUNTING_CONTACT_TYPE.CAP_ACC_CON_TYP_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_ADDITIONAL ON CAP_ACCOUNTING_CONTACT_ADDITIONAL.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_SHARING ON CAP_ACCOUNTING_CONTACT_SHARING.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
	[["FK_CAP_ACC_USE_ID","=",$user]],"",""); 
	
	$select->execute();
	
	   if (!empty($select->arrayResult)):
	   
	   $data = $select->arrayResult;
	   
	       foreach ($data as $key => $value):
	           
	           $select->column    = '*';
	           
	           $select->tableName = '
	           CAP_ACCOUNTING_TRANSACTION LEFT JOIN
	           CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
	           
	           $select->whereClause = [
                        	           ["CAP_ACC_TRA_TYP_NAME","=","INVOICE"],
                        	           ["FK_CAP_ACC_CON_ID","=",$value['CAP_ACC_CON_ID']]
                        	          ];
                        	          
               $select->orderClause = 'CAP_ACC_TRA_DATE ASC';
	           
	           $select->execute();
	           
	           if (!empty($select->arrayResult)):
	           
	               $calculate = $select->arrayResult;
	               
	               $result = null;
	               
	               foreach ($calculate as $key2 => $value2):
	                    
	                    $select->column    = 'SUM(CAP_ACC_TRA_ITE_AMOUNT) AS TOTAL';
	                    
	                    $select->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM';
        	            
        	            $select->whereClause = [["FK_CAP_ACC_TRA_ID_PAYMENT","=",$value2['CAP_ACC_TRA_ID']]];
        	            
        	            $select->orderClause = null;
                        
        	            $select->execute();
        	            
        	               if (!empty($select->arrayResult)):
        	               
        	                   $total = $value2['CAP_ACC_TRA_TOTAL'] - $select->arrayResult[0]['TOTAL'];

        	                   if ($total > 0):
        	                       
        	                       $value2['CAP_ACC_TRA_TOTALLEFT'] = $total;
        	                       
        	                       $result [] = $value2;
        	                       
        	                       $value['TRANSACTION-LIST'][] = $value2;
        	                   
        	                   endif;
        	               
        	               endif;
	               
	               endforeach;
	           
	               if (!empty($result)):
	               
	               $value['TRANSACTION-LIST'] = $result;
	               
	               $array [] = $value;
	               
	               endif;
	           	           
	           endif;
	       	       
	       endforeach;
	   
	   endif;
	   		
	return json_encode($array);
		
	}
	
	public function getContactCustomerWithOpenInvoiceEdited($user,$item){
    
    if (!empty($item)):
    
        foreach ($item as $key => $value):
                    
            $keys [$value['CAP_ACC_TRA_ID']] = $value['CAP_ACC_TRA_ID'];
        
        endforeach;
    
    endif;

	$select = new select("*","
	CAP_ACCOUNTING_CONTACT 
	LEFT JOIN CAP_ACCOUNTING_CONTACT_TYPE ON CAP_ACCOUNTING_CONTACT.FK_CAP_ACC_CON_TYP_ID = CAP_ACCOUNTING_CONTACT_TYPE.CAP_ACC_CON_TYP_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_ADDITIONAL ON CAP_ACCOUNTING_CONTACT_ADDITIONAL.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_SHARING ON CAP_ACCOUNTING_CONTACT_SHARING.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
	[["FK_CAP_ACC_USE_ID","=",$user]],"",""); 
	
	$select->execute();
	
	   if (!empty($select->arrayResult)):
	   
	   $data = $select->arrayResult;
	   
	       foreach ($data as $key => $value):
	           
	           $select->column    = '*';
	           
	           $select->tableName = '
	           CAP_ACCOUNTING_TRANSACTION LEFT JOIN
	           CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
	           
	           $select->whereClause = [
                        	           ["CAP_ACC_TRA_TYP_NAME","=","INVOICE"],
                        	           ["FK_CAP_ACC_CON_ID","=",$value['CAP_ACC_CON_ID']]
                        	          ];
                        	          
               $select->orderClause = 'CAP_ACC_TRA_DATE ASC';
	           
	           $select->execute();
	           
	           if (!empty($select->arrayResult)):
	           
	               $calculate = $select->arrayResult;
	               
	               $result = null;
	               
	               foreach ($calculate as $key2 => $value2):
	                    
	                    $select->column    = 'SUM(CAP_ACC_TRA_ITE_AMOUNT) AS TOTAL';
	                    
	                    $select->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM';
        	            
        	            $select->whereClause = [["FK_CAP_ACC_TRA_ID_PAYMENT","=",$value2['CAP_ACC_TRA_ID']]];
        	            
        	            $select->orderClause = null;
                        
        	            $select->execute();
        	            
        	               if (!empty($select->arrayResult)):
        	               
        	                   $total = $value2['CAP_ACC_TRA_TOTAL'] - $select->arrayResult[0]['TOTAL'];
        	                   
        	                   $check = @array_search($value2['CAP_ACC_TRA_ID'], $keys);

        	                   if ($total > 0 || $check):
        	                       
        	                       $value2['CAP_ACC_TRA_TOTALLEFT'] = $total;
        	                       
        	                       $result [] = $value2;
        	                       
        	                       $value['TRANSACTION-LIST'][] = $value2;
        	                   
        	                   endif;
        	               
        	               endif;
	               
	               endforeach;
	           
	               if (!empty($result)):
	               
	               $value['TRANSACTION-LIST'] = $result;
	               
	               $array [] = $value;
	               
	               endif;
	           	           
	           endif;
	       	       
	       endforeach;
	   
	   endif;
	   		
	return json_encode($array);
		
	}
	
	public function getContactCustomerWithOpenBill($user){

	$select = new select("*","
	CAP_ACCOUNTING_CONTACT 
	LEFT JOIN CAP_ACCOUNTING_CONTACT_TYPE ON CAP_ACCOUNTING_CONTACT.FK_CAP_ACC_CON_TYP_ID = CAP_ACCOUNTING_CONTACT_TYPE.CAP_ACC_CON_TYP_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_ADDITIONAL ON CAP_ACCOUNTING_CONTACT_ADDITIONAL.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_SHARING ON CAP_ACCOUNTING_CONTACT_SHARING.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
	[["FK_CAP_ACC_USE_ID","=",$user]],"",""); 
	
	$select->execute();
	
	   if (!empty($select->arrayResult)):
	   
	   $data = $select->arrayResult;
	   
	       foreach ($data as $key => $value):
	           
	           $select->column    = '*';
	           
	           $select->tableName = '
	           CAP_ACCOUNTING_TRANSACTION LEFT JOIN
	           CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
	           
	           $select->whereClause = [
                        	           ["CAP_ACC_TRA_TYP_NAME","=","BILL"],
                        	           ["FK_CAP_ACC_CON_ID","=",$value['CAP_ACC_CON_ID']]
                        	          ];
                        	          
               $select->orderClause = 'CAP_ACC_TRA_DATE ASC';
	           
	           $select->execute();
	           
	           if (!empty($select->arrayResult)):
	           
	               $calculate = $select->arrayResult;
	               
	               $result = null;
	               
	               foreach ($calculate as $key2 => $value2):
	                    
	                    $select->column    = 'SUM(CAP_ACC_TRA_ITE_AMOUNT) AS TOTAL';
	                    
	                    $select->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM';
        	            
        	            $select->whereClause = [["FK_CAP_ACC_TRA_ID_PAYMENT","=",$value2['CAP_ACC_TRA_ID']]];
        	            
        	            $select->orderClause = null;
                        
        	            $select->execute();
        	            
        	               if (!empty($select->arrayResult)):
        	               
        	                   $total = $value2['CAP_ACC_TRA_TOTAL'] - $select->arrayResult[0]['TOTAL'];

        	                   if ($total > 0):
        	                       
        	                       $value2['CAP_ACC_TRA_TOTALLEFT'] = $total;
        	                       
        	                       $result [] = $value2;
        	                       
        	                       $value['TRANSACTION-LIST'][] = $value2;
        	                   
        	                   endif;
        	               
        	               endif;
	               
	               endforeach;
	           
	               if (!empty($result)):
	               
	               $value['TRANSACTION-LIST'] = $result;
	               
	               $array [] = $value;
	               
	               endif;
	           	           
	           endif;
	       	       
	       endforeach;
	   
	   endif;
	   		
	return json_encode($array);
		
	}
	
	public function getContactCustomerWithOpenBillEdited($user,$item){
    
    if (!empty($item)):
    
        foreach ($item as $key => $value):
                    
            $keys [$value['CAP_ACC_TRA_ID']] = $value['CAP_ACC_TRA_ID'];
        
        endforeach;
    
    endif;

	$select = new select("*","
	CAP_ACCOUNTING_CONTACT 
	LEFT JOIN CAP_ACCOUNTING_CONTACT_TYPE ON CAP_ACCOUNTING_CONTACT.FK_CAP_ACC_CON_TYP_ID = CAP_ACCOUNTING_CONTACT_TYPE.CAP_ACC_CON_TYP_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_ADDITIONAL ON CAP_ACCOUNTING_CONTACT_ADDITIONAL.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
	LEFT JOIN CAP_ACCOUNTING_CONTACT_SHARING ON CAP_ACCOUNTING_CONTACT_SHARING.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
	[["FK_CAP_ACC_USE_ID","=",$user]],"",""); 
	
	$select->execute();
	
	   if (!empty($select->arrayResult)):
	   
	   $data = $select->arrayResult;
	   
	       foreach ($data as $key => $value):
	           
	           $select->column    = '*';
	           
	           $select->tableName = '
	           CAP_ACCOUNTING_TRANSACTION LEFT JOIN
	           CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID';
	           
	           $select->whereClause = [
                        	           ["CAP_ACC_TRA_TYP_NAME","=","BILL"],
                        	           ["FK_CAP_ACC_CON_ID","=",$value['CAP_ACC_CON_ID']]
                        	          ];
                        	          
               $select->orderClause = 'CAP_ACC_TRA_DATE ASC';
	           
	           $select->execute();
	           
	           if (!empty($select->arrayResult)):
	           
	               $calculate = $select->arrayResult;
	               
	               $result = null;
	               
	               foreach ($calculate as $key2 => $value2):
	                    
	                    $select->column    = 'SUM(CAP_ACC_TRA_ITE_AMOUNT) AS TOTAL';
	                    
	                    $select->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM';
        	            
        	            $select->whereClause = [["FK_CAP_ACC_TRA_ID_PAYMENT","=",$value2['CAP_ACC_TRA_ID']]];
        	            
        	            $select->orderClause = null;
                        
        	            $select->execute();
        	            
        	               if (!empty($select->arrayResult)):
        	               
        	                   $total = $value2['CAP_ACC_TRA_TOTAL'] - $select->arrayResult[0]['TOTAL'];
        	                   
        	                   $check = @array_search($value2['CAP_ACC_TRA_ID'], $keys);

        	                   if ($total > 0 || $check):
        	                       
        	                       $value2['CAP_ACC_TRA_TOTALLEFT'] = $total;
        	                       
        	                       $result [] = $value2;
        	                       
        	                       $value['TRANSACTION-LIST'][] = $value2;
        	                   
        	                   endif;
        	               
        	               endif;
	               
	               endforeach;
	           
	               if (!empty($result)):
	               
	               $value['TRANSACTION-LIST'] = $result;
	               
	               $array [] = $value;
	               
	               endif;
	           	           
	           endif;
	       	       
	       endforeach;
	   
	   endif;
	   		
	return json_encode($array);
		
	}
	
	public function getUser() {
		
		return unserialize($_SESSION['user']); 
		
	}
	
	public function checkUser() {
    
    $user 	   = $this->getUser(); 
    
    $userName  = $user->getID(); 
    
    $loginType = $user->getLoginType();
    
    	if ($loginType == 'internal'):
    	
    	$select = new select("*","CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID",[["CAP_USE_ID","=",$userName]],"","");
    	
    	else:
    	
    	$select = new select("*","CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID",[["CAP_USE_ID_FACEBOOK","=",$userName]],"","");
    	
    	endif;
    
    $select->execute();
    
    return $select->arrayResult[0];
        
    }
    
    public function getRole($role) {
    
	    $select = new select("*","CAP_USER_ROLE",[["CAP_USE_ROL_NAME","=",$role]],"","","2"); $select->execute();
	    
	    return $select->arrayResult;
	    
    }
    
    public function attachAccountingUserHook($user) {
	    	    
	    $userID = $user->getID();
	    
	    $select = new select("*","CAP_ACCOUNTING_USER_ACCOUNT",[["FK_CAP_ACC_USE_ID","=",$userID]],"","");
	    
	    $select->execute();
	    
	    	if (!empty($select->arrayResult)):
	    
	    	$user->putData($select->arrayResult)->putHook()->emptyData();
	    	
	    	return $select->arrayResult;
	    	
	    	endif;
	    
    }
	
	public function createCoa($data) {
		
		if (!empty($data)):
			
			/*
		    * Validation area
		    *
		    * @return mixed
		    */
		    if (!is_numeric($data['code']) || empty($data['code'])):
		    
		    $error [] = ['code' => 'Code cannot be empty and can only contain number'];
		    
		    endif;
		    
		    if (empty($data['name'])):
		    
		    $error [] = ['name' => 'Name cannot be empty'];
		    
		    endif;
		    
		    if (empty($data['type'])):
		    
		    $error [] = ['type' => 'Type cannot be empty'];
		    
		    endif;
		    						
			if (!empty($error)):
			
			echo json_encode(array("response" => "error", "token" => $_SESSION['xss'], "error" => $error));
			
			return false;
				
			endif;
			
			$insert = new insert();
			
			$insert->tableName = "CAP_ACCOUNTING_COA";
			
			$insert->column = array(
							  "CAP_ACC_COA_CODE" 		=> $data['code'],
							  "CAP_ACC_COA_NAME" 		=> strtoupper($data['name']),
							  "CAP_ACC_COA_DESC" 		=> strtoupper($data['description']),
							  "FK_CAP_ACC_COA_TYP_ID" 	=> strtoupper($data['type']),
							  "FK_CAP_ACC_USE_ACC_ID" 	=> $_SESSION['ACCOUNTING-ACCOUNT'],
							  "CAP_ACC_COA_NUMBER"		=> strtoupper($data['number']),
							  "CAP_ACC_COA_DATECREATED" => date("Y-m-d H:i:s"));
							  
			$insert->whereClause = "CAP_ACC_COA_ID";
			
			$insert->dateColumn  = ["CAP_ACC_COA_DATECREATED"];
			
			$lastID = $insert->execute();
			
			if (is_numeric($lastID) && !empty($lastID)):
			
			echo json_encode(array("response" => "success", "token" => $_SESSION['xss']));
			
			else:
			
			echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
			
			endif;
							  
		
		endif;
		
	}
	
	public function updateCoa($data) {
		
		if (!empty($data)):
			
			/*
		    * Validation area
		    *
		    * @return mixed
		    */
		    if (!is_numeric($data['code']) || empty($data['code'])):
		    
		    $error [] = ['code' => 'Code cannot be empty and can only contain number'];
		    
		    endif;
		    
		    if (empty($data['name'])):
		    
		    $error [] = ['name' => 'Name cannot be empty'];
		    
		    endif;
		    
		    if (empty($data['type'])):
		    
		    $error [] = ['type' => 'Type cannot be empty'];
		    
		    endif;
		    						
			if (!empty($error)):
			
			echo json_encode(array("response" => "error", "token" => $_SESSION['xss'], "error" => $error));
			
			return false;
				
			endif;
			
			$update = new update();
			
			$update->tableName = "CAP_ACCOUNTING_COA";
			
			$update->column = array(
							  "CAP_ACC_COA_CODE" 		=> $data['code'],
							  "CAP_ACC_COA_NAME" 		=> strtoupper($data['name']),
							  "CAP_ACC_COA_DESC" 		=> strtoupper($data['description']),
							  "FK_CAP_ACC_USE_ACC_ID" 	=> $_SESSION['ACCOUNTING-ACCOUNT'],
							  "CAP_ACC_COA_NUMBER"		=> strtoupper($data['number']),
							  "CAP_ACC_COA_DATEUPDATED" => date("Y-m-d H:i:s"));
							  
			$update->whereClause = [["CAP_ACC_COA_ID","=",$data['id']],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]];
			
			$update->dateColumn  = ["CAP_ACC_COA_DATEUPDATED"];
						
			$lastID = @$update->execute();
						
			if (!$lastID):
			
			echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
			
			else:
			
			echo json_encode(array("response" => "success", "token" => $_SESSION['xss']));
						
			endif;
							  
		
		endif;
		
	}
	
	public function deleteCoa($data) {
		
		if (!empty($data)):
			
			/*
		    * Validation area
		    *
		    * @return mixed
		    */
		    $delete = new delete();
		    
		    $delete->transactionStart();

		    foreach ($data as $key => $value):
		    
		    $delete->tableName   = "CAP_ACCOUNTING_COA";
		    		    
		    $delete->whereClause = [["CAP_ACC_COA_ID","=",$value],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]];
		    
		    $result = @$delete->execute();
		    
		    if (!$result): $i++; endif;
		    
		    endforeach;
		    
			    if (empty($i)):
			    
			    $delete->transactionSuccess();
			    
			    echo json_encode(array("response" => "success", "token" => $_SESSION['xss']));
			    
			    else:
			    
			    $delete->transactionFailed();
			    
			    echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
			    
			    endif;
		    										  
		
		endif;
		
	}
	
	public function createItem($data) {
		
		if (empty($data)):
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		return false;
		
		endif;
					
		/*
	    * Validation area
	    *
	    * @return mixed
	    */
	    if (!is_numeric($data['code']) || empty($data['code'])):
	    
	    $error [] = ['code' => 'Code cannot be empty and can only contain number'];
	    
	    endif;
	    
	    if (empty($data['name'])):
	    
	    $error [] = ['name' => 'Name cannot be empty'];
	    
	    endif;
	    
	    if (empty($data['type'])):
	    
	    $error [] = ['type' => 'Type cannot be empty'];
	    
	    endif;
	    						
		if (!empty($error)):
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss'], "error" => $error));
		
		return false;
			
		endif;
				
		$insert = new insert();
		
		$insert->transactionStart();
				
		$tableAccountingItemCoaFirst = [
									   "CAP_ACC_ITE_NAME" 			=> $data['name'],
									   "CAP_ACC_ITE_CODE" 			=> $data['code'],
									   "CAP_ACC_ITE_DESC" 			=> $data['description'],
									   "CAP_ACC_ITE_MEASURE"		=> $data['unit-measurement'],
									   "FK_CAP_ACC_ITE_TYP_ID" 		=> $data['type'],
									   "FK_CAP_ACC_USE_ACC_ID" 		=> $_SESSION['ACCOUNTING-ACCOUNT'],
									   "CAP_ACC_ITE_DATECREATED"	=> date("Y-m-d H:i:s")
									   ];
		
		$insert->tableName   = "CAP_ACCOUNTING_ITEM";
		
		$insert->dateColumn  = ["CAP_ACC_ITE_DATECREATED"];
		
		$insert->whereClause = "CAP_ACC_ITE_ID";
		
		$insert->column 	 = $tableAccountingItemCoaFirst;
		
		$lastID = $insert->execute();
				
			if (is_numeric($lastID) && !empty($lastID)):
			
			$i = 0;
			
			$insert->tableName   = "CAP_ACCOUNTING_ITEM_COA";
			
			$insert->whereClause = "CAP_ACC_ITE_COA_ID";
			
			$tableAccountingItemCoaPurc = [
										   "CAP_ACC_ITE_COA_RATE" 		=> $data['purchase-unit-price'],
										   "FK_CAP_ACC_COA_ID" 			=> $data['account-purchase'],
										   "FK_CAP_ACC_ITE_COA_TYP_ID" 	=> 1,
										   "FK_CAP_ACC_ITE_TAX_ID" 		=> $data['purchase-tax'],
										   "CAP_ACC_ITE_COA_PERCENT" 	=> $data['percentage'],
										   "FK_CAP_ACC_ITE_ID"			=> $lastID
										  ];
										  			
			$insert->column = $tableAccountingItemCoaPurc;
			
			$lastIDPurc = $insert->execute();
			
			$i += (!is_numeric($lastIDPurc) || empty($lastIDPurc)) ? 1 : 0;
										  
			$tableAccountingItemCoaSale = [
										   "CAP_ACC_ITE_COA_RATE" 		=> $data['sales-unit-price'],
										   "FK_CAP_ACC_COA_ID" 			=> $data['account-sales'],
										   "FK_CAP_ACC_ITE_COA_TYP_ID" 	=> 2,
										   "FK_CAP_ACC_ITE_TAX_ID" 		=> $data['sales-tax'],
										   "CAP_ACC_ITE_COA_PERCENT" 	=> $data['percentage'],
										   "FK_CAP_ACC_ITE_ID"			=> $lastID
										  ];
										  
			$insert->column = $tableAccountingItemCoaSale;
			
			$lastIDSale = $insert->execute();
			
			$i += (!is_numeric($lastIDSale) || empty($lastIDSale)) ? 1 : 0;
			
				if (!empty($data['cogs'])):
			
				$tableAccountingItemCoaCogs = [
											   "FK_CAP_ACC_COA_ID" 			=> $data['cogs'],
											   "FK_CAP_ACC_ITE_COA_TYP_ID" 	=> 3,
											   "FK_CAP_ACC_ITE_ID"			=> $lastID
											  ];
											  
				$insert->column = $tableAccountingItemCoaCogs;
				
				$lastIDCogs = $insert->execute();
				
				$i += (!is_numeric($lastIDCogs) || empty($lastIDCogs)) ? 1 : 0;
			
				endif;
										  
			endif;
			
			if (empty($i)):
			    
			    $insert->transactionSuccess();
			    
			    echo json_encode(array("response" => "success", "token" => $_SESSION['xss']));
			    
			    else:
			    
			    $insert->transactionFailed();
			    
			    echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
			    
			 endif;
		
	}
	
	public function updateItem($data) {
		
		if (empty($data)):
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		return false;
		
		endif;
		
		/*
	    * Validation area
	    *
	    * @return mixed
	    */
	    if (!is_numeric($data['code']) || empty($data['code'])):
	    
	    $error [] = ['code' => 'Code cannot be empty and can only contain number'];
	    
	    endif;
	    
	    if (empty($data['name'])):
	    
	    $error [] = ['name' => 'Name cannot be empty'];
	    
	    endif;
	    
	    if (empty($data['type'])):
	    
	    $error [] = ['type' => 'Type cannot be empty'];
	    
	    endif;
	    						
		if (!empty($error)):
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss'], "error" => $error));
		
		return false;
			
		endif;
				
		$update = new update();
		
		$update->transactionStart();
				
		$tableAccountingItemCoaFirst = [
									   "CAP_ACC_ITE_NAME" 			=> $data['name'],
									   "CAP_ACC_ITE_CODE" 			=> $data['code'],
									   "CAP_ACC_ITE_DESC" 			=> $data['description'],
									   "CAP_ACC_ITE_MEASURE"		=> $data['unit-measurement'],
									   "CAP_ACC_ITE_DATEUPDATED"	=> date("Y-m-d H:i:s")
									   ];
		
		$update->tableName   = "CAP_ACCOUNTING_ITEM";
		
		$update->dateColumn  = ["CAP_ACC_ITE_DATEUPDATED"];
		
		$update->whereClause = [["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_ITE_ID","=",$data['id']]];
		
		$update->column 	 = $tableAccountingItemCoaFirst;
		
		$lastID = $update->execute();
								
			if (is_resource($lastID)):
			
			$i = 0;
			
			$update->tableName   = "CAP_ACCOUNTING_ITEM_COA";
			
			$update->whereClause = [["FK_CAP_ACC_ITE_ID","=",$data['id']],["FK_CAP_ACC_ITE_COA_TYP_ID","=",1]];
			
			$tableAccountingItemCoaPurc = [
										   "CAP_ACC_ITE_COA_RATE" 	 => $data['purchase-unit-price'],
										   "FK_CAP_ACC_COA_ID" 		 => $data['account-purchase'],
										   "FK_CAP_ACC_ITE_TAX_ID" 	 => $data['purchase-tax'],
										   "CAP_ACC_ITE_COA_PERCENT" => $data['percentage'],
										  ];
										  			
			$update->column = $tableAccountingItemCoaPurc;
			
			$lastIDPurc = $update->execute();
			
			$i += (!$lastIDPurc) ? 1 : 0;
										  
			$tableAccountingItemCoaSale = [
										   "CAP_ACC_ITE_COA_RATE" 	 => $data['sales-unit-price'],
										   "FK_CAP_ACC_COA_ID" 		 => $data['account-sales'],
										   "FK_CAP_ACC_ITE_TAX_ID" 	 => $data['sales-tax'],
										   "CAP_ACC_ITE_COA_PERCENT" => $data['percentage'],
										  ];
										  
			$update->column = $tableAccountingItemCoaSale;
			
			$update->whereClause = [["FK_CAP_ACC_ITE_ID","=",$data['id']],["FK_CAP_ACC_ITE_COA_TYP_ID","=",2]];
			
			$lastIDSale = $update->execute();
			
			$i += (!$lastIDSale) ? 1 : 0;
			
				if (!empty($data['cogs'])):
			
				$tableAccountingItemCoaCogs = [
											   "FK_CAP_ACC_COA_ID" => $data['cogs']
											  ];
											  
				$update->column = $tableAccountingItemCoaCogs;
				
				$update->whereClause = [["FK_CAP_ACC_ITE_ID","=",$data['id']],["FK_CAP_ACC_ITE_COA_TYP_ID","=",3]];
				
				$lastIDCogs = $update->execute();
				
				$i += (!$lastIDCogs) ? 1 : 0;
			
				endif;
										  
			endif;
			
			if (empty($i)):
			    
			    $update->transactionSuccess();
			    
			    echo json_encode(array("response" => "success", "token" => $_SESSION['xss']));
			    
			    else:
			    
			    $update->transactionFailed();
			    
			    echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
			    
			 endif;
		
	}
	
	public function deleteItem($data) {
		
		if (!empty($data)):
			
			/*
		    * Validation area
		    *
		    * @return mixed
		    */
		    $delete = new delete();
		    
		    $delete->transactionStart();

		    foreach ($data as $key => $value):
		    
		    $delete->tableName   = "CAP_ACCOUNTING_ITEM";
		    		    
		    $delete->whereClause = [["CAP_ACC_ITE_ID","=",$value],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]];
		    
		    $result = @$delete->execute();
		    
		    if (!$result): $i++; endif;
		    
		    endforeach;
		    
			    if (empty($i)):
			    
			    $delete->transactionSuccess();
			    
			    echo json_encode(array("response" => "success", "token" => $_SESSION['xss']));
			    
			    else:
			    
			    $delete->transactionFailed();
			    
			    echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
			    
			    endif;
		    										  
		
		endif;
		
	}
	
	public function getAllInvoice() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","INVOICE"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
		
		if (!empty($select->arrayResult)):
	           
            $calculate = $select->arrayResult;
            
            $result = null;
            
            foreach ($calculate as $key => $value):
                
                $select->column    = 'SUM(CAP_ACC_TRA_ITE_AMOUNT) AS TOTAL';
                
                $select->tableName = 'CAP_ACCOUNTING_TRANSACTION_ITEM';
                
                $select->whereClause = [["FK_CAP_ACC_TRA_ID_PAYMENT","=",$value['CAP_ACC_TRA_ID']]];
                
                $select->orderClause = null;
                
                $select->execute();
                
                   if (!empty($select->arrayResult)):
                   
                       $total  = $value['CAP_ACC_TRA_TOTAL'] - $select->arrayResult[0]['TOTAL'];
                                                              
                       $value['CAP_ACC_TRA_TOTAL'] = $total;
                       
                       $value['CAP_ACC_TRA_TOTALLEFT'] = $select->arrayResult[0]['TOTAL'];
                                                                 
                   endif;
                        
            $array [] = $value;
            
            endforeach;
                                   
        endif;
	    
    return json_encode($array);
	
	}
	
	public function getInvoiceByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","INVOICE"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				$i = 0;
				
					foreach ($data[0]['ITEM-TRANSACTION'] as $key => $value):
					
					$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
					LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
					LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
					LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
					
					$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","DISCOUNT"],["FK_CAP_ACC_TRA_ITE_ID","=",$value['CAP_ACC_TRA_ITE_ID']]];
					
					$select->orderClause = null;
					
					$select->execute();
					
					$select->arrayResult = (empty($select->arrayResult)) ? null : $select->arrayResult;
					
					$data[0]['ITEM-TRANSACTION'][$i]['DISCOUNT'] = $select->arrayResult;
					
					$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
					LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
					LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
					LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
					
					$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","TAX"],["FK_CAP_ACC_TRA_ITE_ID","=",$value['CAP_ACC_TRA_ITE_ID']]];
					
					$select->execute();
					
					$select->arrayResult = (empty($select->arrayResult)) ? null : $select->arrayResult;
					
					$data[0]['ITEM-TRANSACTION'][$i]['TAX'] = $select->arrayResult;
					
					$i++;
					
					endforeach;
				
				endif;	
							
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getAllSalesReceipt() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","SALES RECEIPT"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
	    
		return json_encode($select->arrayResult);
	
	}
	
	public function getSalesReceiptByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","SALES RECEIPT"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				$i = 0;
				
					foreach ($data[0]['ITEM-TRANSACTION'] as $key => $value):
					
					$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
					LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
					LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
					LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
					
					$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","DISCOUNT"],["FK_CAP_ACC_TRA_ITE_ID","=",$value['CAP_ACC_TRA_ITE_ID']]];
					
					$select->orderClause = null;
					
					$select->execute();
					
					$select->arrayResult = (empty($select->arrayResult)) ? null : $select->arrayResult;
					
					$data[0]['ITEM-TRANSACTION'][$i]['DISCOUNT'] = $select->arrayResult;
					
					$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
					LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
					LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
					LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
					
					$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","TAX"],["FK_CAP_ACC_TRA_ITE_ID","=",$value['CAP_ACC_TRA_ITE_ID']]];
					
					$select->execute();
					
					$select->arrayResult = (empty($select->arrayResult)) ? null : $select->arrayResult;
					
					$data[0]['ITEM-TRANSACTION'][$i]['TAX'] = $select->arrayResult;
					
					$i++;
					
					endforeach;
				
				endif;	
							
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getAllBill() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","BILL"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
	    
		return json_encode($select->arrayResult);
	
	}
	
	public function getBillByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","BILL"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				endif;
															
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getAllReceipt() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","RECEIPT"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
	    
		return json_encode($select->arrayResult);
	
	}
	
	public function getReceiptByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","RECEIPT"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				endif;
															
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getAllPayment() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","PAYMENT"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
	    
		return json_encode($select->arrayResult);
	
	}
	
	public function getPaymentByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","PAYMENT"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ACCOUNT"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ACCOUNT-TRANSACTION'] = $select->arrayResult;
				
				endif;
				
				$select->tableName = "
				CAP_ACCOUNTING_TRANSACTION_ITEM
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID_PAYMENT = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE 
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM 
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE 
				ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA 
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				endif;
															
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getAllPaybill() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","PAY BILL"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
	    
		return json_encode($select->arrayResult);
	
	}
	
	public function getPaybillByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","PAY BILL"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ACCOUNT"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ACCOUNT-TRANSACTION'] = $select->arrayResult;
				
				endif;
				
				$select->tableName = "
				CAP_ACCOUNTING_TRANSACTION_ITEM
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ID_PAYMENT = CAP_ACCOUNTING_TRANSACTION.CAP_ACC_TRA_ID
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE 
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM 
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE 
				ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA 
				ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				endif;
															
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getAllTransfer() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","TRANSFER"],["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]]); 
		
		$select->execute();
	    
		return json_encode($select->arrayResult);
	
	}
	
	public function getTransferByID() {

		$select = new select("*","CAP_ACCOUNTING_TRANSACTION 
		LEFT JOIN CAP_ACCOUNTING_TRANSACTION_TYPE ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_TYP_ID = CAP_ACCOUNTING_TRANSACTION_TYPE.CAP_ACC_TRA_TYP_ID
		LEFT JOIN CAP_ACCOUNTING_CONTACT ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_CON_ID = CAP_ACCOUNTING_CONTACT.CAP_ACC_CON_ID
		LEFT JOIN CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY ON CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_TRA_CURRENCY = CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.CAP_ACC_USE_ACC_CUR_ID
		LEFT JOIN CAP_ACCOUNTING_CURRENCY ON CAP_ACCOUNTING_USER_ACCOUNT_CURRENCY.FK_CAP_ACC_CUR_ID = CAP_ACCOUNTING_CURRENCY.CAP_ACC_CUR_ID",
		[["CAP_ACC_TRA_TYP_NAME","=","TRANSFER"],["CAP_ACCOUNTING_TRANSACTION.FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],["CAP_ACC_TRA_ID","=",$this->data]]); 
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
				
				$data = $select->arrayResult;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ACCOUNT"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ACCOUNT-TRANSACTION'] = $select->arrayResult;
				
				endif;
				
				$select->tableName = "CAP_ACCOUNTING_TRANSACTION_ITEM 
				LEFT JOIN CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_TRA_ITE_TYP_ID = CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE.CAP_ACC_TRA_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID
				LEFT JOIN CAP_ACCOUNTING_ITEM_TYPE ON CAP_ACCOUNTING_ITEM.FK_CAP_ACC_ITE_TYP_ID = CAP_ACCOUNTING_ITEM_TYPE.CAP_ACC_ITE_TYP_ID
				LEFT JOIN CAP_ACCOUNTING_COA ON CAP_ACCOUNTING_TRANSACTION_ITEM.FK_CAP_ACC_COA_ID = CAP_ACCOUNTING_COA.CAP_ACC_COA_ID";
				
				$select->whereClause = [["FK_CAP_ACC_TRA_ID","=",$this->data],["CAP_ACC_TRA_ITE_TYP_NAME","=","ITEM"]];
				
				$select->orderClause = "FK_CAP_ACC_ITE_ID,CAP_ACC_TRA_ITE_POSITION ASC";
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
				$data[0]['ITEM-TRANSACTION'] = $select->arrayResult;
				
				endif;
															
			endif;
	    
		return json_encode($data[0]);
	
	}
	
	public function getTransactionID($select,$name) {
		
		$select->column      = "*";
		
		$select->tableName   = "CAP_ACCOUNTING_TRANSACTION_ITEM_TYPE";
		
		$select->whereClause = [["CAP_ACC_TRA_ITE_TYP_NAME","=",$name]];
		
		$select->execute();
		
		return $select->arrayResult[0]['CAP_ACC_TRA_ITE_TYP_ID'];
		
	}
	
	public function calculateInvoiceTotal($item) {

    	if (!empty($item['line item'])):
				
			foreach ($item['line item'] as $key => $value):
			
			if (empty($value['id'])): continue; endif; unset($discount);
			
			$lineTax       = str_replace(',','',$value['tax']);
			$linePrice     = str_replace(',','',$value['price']);
			$lineQty       = str_replace(',','',$value['qty']);
			$lineDisc      = str_replace(',','',$value['discount']);
			$taxDecimal    = (100+$lineTax) / 100;
			$linePriceInc  = ($linePrice / $taxDecimal); 	// Rate after tax ex. 1.811818181818
			$lineAmountOri = round(($linePrice * $lineQty),2); 		// Original Amount when input
			$linePriceIncR  = round(($value['price']/$taxDecimal),2);
			$linePriceIncD  = round(($linePriceIncR*$value['qty']),2);
			$lineBaseDisc   = round(($linePrice*$lineQty) * ((100 - $lineDisc) / 100),2);
    		$lineBaseDisc2   = round($lineAmountOri-$lineBaseDisc,2);
    		$lineBaseAmount  = round($lineAmountOri-$lineBaseDisc2,2);		
    		$total           = round($lineBaseAmount / $taxDecimal,2);

				if (strtolower($value['accounting-item-category']) == 'tax'):

				    $lineAmount = str_replace(',','',$value['amount']);

				else:

				    $lineAmount = round($linePrice*$lineQty,2);

				endif;
				
				if (!empty($value['discount'])):
				   
				   $discount = round(($linePriceIncR*$item['qty'] * ((100 - $value['discount']) / 100)),2);
				   
				   $discount = round(($linePriceIncD - $discount),2);
				   
				   $discount = (!empty($value['discount'])) ? $discount : 0;
					
				endif;
				
				if ($item['globaltax'] == 'exclude'):
				    
				    $discount = round(self::discountCalculation($lineAmountOri,$value['discount']),2);
				    
				    $lineAmountAfterDiscount = $lineAmountOri - $discount;
				    
    				$tax =  $lineAmountAfterDiscount * ($lineTax / 100);
    				
    				if (strtolower($value['accounting-item-category']) != 'sub total'):
    				
    				$price  = $linePrice;
    				
    				endif;
    				
    				$totalAmount += round( ($lineAmountOri - $discount) + $tax, 4 ); // Receivables Amount
														
				elseif ($item['globaltax'] == 'include'):
																						    										                                            				    $tax    =  round(($lineBaseAmount / $taxDecimal) * ($lineTax / 100),2);
    				
    				if (strtolower($value['accounting-item-category']) != 'sub total'):
    				
    				$price  = $linePriceInc;
    
    				endif;
    				    				
    				$totalAmount += round($total+$tax,2);
				
				else:
				    
				    $discount = round(self::discountCalculation($lineAmountOri,$value['discount']),2);
				    
    				$lineAmountAfterDiscount = $lineAmountOri - $discount;
				        				
    				if (strtolower($value['accounting-item-category']) != 'sub total'):
    				
    				$price  = $linePrice;

    				endif;
    								
    				$totalAmount += round( ($lineAmountOri - $discount), 4 ); // Receivables Amount

				endif;
				
				$log  = 'price: ' . $price . PHP_EOL;
				
				$log .= 'qty: ' . $lineQty . PHP_EOL;
				
				$log .= 'line amount original: ' . $lineAmountOri . PHP_EOL;
				
				$log .= 'line price include: ' . $linePriceInc . PHP_EOL;
				
				$log .= 'amount before tax: ' . $dppP . PHP_EOL;
				
				$log .= 'amount after discount: ' . $dppPD . PHP_EOL;
				
				$log .= 'discount: ' . $discount . PHP_EOL;
				
				$log .= 'tax value: ' . $tax . PHP_EOL;
																		
				$log .= 'totalAmount: ' . $totalAmount . PHP_EOL;
				
				$log .= 'totalBasePrice: ' . $total . PHP_EOL;

				$log .= 'totalBaseAmount: ' . $lineBaseAmount . PHP_EOL;
				
				//log::setLog('event',$log,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			
			endforeach;
															
		endif;
		
    return $totalAmount;
    	
	}

	/*
	 * Calculating invoice per line item returning qty,price,amount,tax and discount value
	 * @Input is an array of $qty,$price,$disc,$tax,$globaltax,$item-category
	 *
	*/
	public function calculateInvoiceLineItem($item) {

		$taxDecimal     = (100+$item['tax'])/100;
		$linePriceInc   = ($item['price']/$taxDecimal);
		$lineAmountOri  = round(($item['price']*$item['qty']),2);
		$linePriceIncR  = round(($item['price']/$taxDecimal),2);
		$linePriceIncD  = round(($linePriceIncR*$item['qty']),2);
		$lineBaseDisc   = round(($item['price']*$item['qty']) * ((100 - $item['discount']) / 100),2);
		$lineBaseDisc2  = round($lineAmountOri-$lineBaseDisc,2);
		$lineBaseAmount = round($lineAmountOri-$lineBaseDisc2,2);		
		$total          = round($lineBaseAmount / $taxDecimal,2);
				
		if ($item['globaltax'] == 'exclude'):
		    
			$discount = (!empty($item['discount'])) ? round(self::discountCalculation($lineAmountOri,$item['discount']),4) : 0;

			$lineAmountAfterDiscount = $lineAmountOri - $discount;

			$tax    =  $lineAmountAfterDiscount * ($item['tax'] / 100);

			$price  = (strtolower($item['item-category']) != 'sub total') ? $item['price'] : null;

			$amount = round($lineAmountOri,4); // Receivables Amount

		elseif ($item['globaltax'] == 'include'):
		    
		    $discount = round(($linePriceIncR*$item['qty'] * ((100 - $item['discount']) / 100)),2); 
		    
		    $discount = round(($linePriceIncD - $discount),2);
		    
			$discount = (!empty($item['discount'])) ? $discount : 0;

			$tax    = round(($lineBaseAmount / $taxDecimal) * ($item['tax'] / 100),2);
			
			$price  = (strtolower($item['item-category']) != 'sub total') ? $linePriceInc : null;
			
			$amount = $total+$discount; // Receivables Amount

		else:

			$discount = (!empty($item['discount'])) ? round(self::discountCalculation($lineAmountOri,$item['discount']),4) : 0;

			$lineAmountAfterDiscount = $lineAmountOri - $discount;

			$price  = (strtolower($item['item-category']) != 'sub total') ? $item['price'] : null;

			$amount = round($lineAmountOri, 4 ); // Receivables Amount

		endif;
														
	$amount = (strtolower($item['item-category']) == 'tax' || strtolower($item['item-category']) == 'sub total') ? $item['amount'] : $amount;
	
	$log  = 'type: ' . strtolower($item['item-category']) . PHP_EOL;

	$log .= 'price: ' . $lineBaseDisc . PHP_EOL;
				
	$log .= 'qty: ' . $lineBaseDisc2 . PHP_EOL;
	
	$log .= 'line amount original: ' . $lineAmountOri . PHP_EOL;
	
	$log .= 'line price include: ' . $lineBaseAmount . PHP_EOL;
	
	$log .= 'amount before tax: ' . $dppP . PHP_EOL;
	
	$log .= 'amount after discount: ' . $dppPD . PHP_EOL;
				
	$log .= 'discount: ' . $discount . PHP_EOL;
	
	$log .= 'tax value: ' . $tax . PHP_EOL;
															
	$log .= 'totalAmount: ' . $amount . PHP_EOL;
	
	$log .= 'totalBasePrice: ' . $total . PHP_EOL;
	
	$log .= 'totalBaseAmount: ' . $lineBaseAmount . PHP_EOL;
	
	//log::setLog('event',$log,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);

	return ['price' => $price, 'qty' => $item['qty'], 'discount' => $discount, 'tax' => $tax, 'amount' => $amount];

	}

	public function getTaxDiscInvoiceCoaID($select,$id) {

	$select->tableName = "CAP_ACCOUNTING_ITEM 
	LEFT JOIN CAP_ACCOUNTING_ITEM_COA ON CAP_ACCOUNTING_ITEM.CAP_ACC_ITE_ID = CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_ID
	LEFT JOIN CAP_ACCOUNTING_ITEM_COA_TYPE ON CAP_ACCOUNTING_ITEM_COA.FK_CAP_ACC_ITE_COA_TYP_ID = CAP_ACCOUNTING_ITEM_COA_TYPE.CAP_ACC_ITE_COA_TYP_ID";
	
	$select->whereClause = [
								["CAP_ACC_ITE_ID","=",$id],
								["FK_CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']],
								["CAP_ACC_ITE_COA_TYP_NAME","=","SELLING"]
						   ];
	
	$select->execute();
	
	return $select->arrayResult[0]['FK_CAP_ACC_COA_ID'];

	}
	
	public function invoice_create($data) {

		$i = 0;
		
		$db       = ['select' => new select(), 'insert' => new insert(), 'update' => new update()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');
		
		$total    = self::calculateInvoiceTotal($data);
		
		$invoice  = self::transaction('header')->setHandler($db)->create('invoice',$data,$total);
				
		$i = (!is_numeric($invoice)) ? $i + 1 : $i;
		
		if (is_numeric($invoice)):
		
		    $lineItem = [
		                 'des' => "INVOICE NUMBER ".$data['number'],
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $invoice,
            		     'typ' => 'account'
            		    ];
		
		    $receivable = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($receivable)) ? $i + 1 : $i;
			
			if (is_numeric($receivable)):

				self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => $total, 'credit' => null, 'itemID' => $receivable]);
				
				$routine = self::routine('inventory')->setHandler($db);
				
				foreach ($data['line item'] as $key => $value):

					if (empty($value['id'])): continue; endif;

						$lineTax      = str_replace(',','',$value['tax']);
						$linePrice    = str_replace(',','',$value['price']);
						$lineQty      = str_replace(',','',$value['qty']);
						$lineDisc     = str_replace(',','',$value['discount']);
						$lineAmount   = str_replace(',','',$value['amount']);
						$arrayItem    = ['qty' => $lineQty, 'price' => $linePrice, 'discount' => $lineDisc, 'tax' => $lineTax, 'amount' => $lineAmount, 'globaltax' => $data['globaltax'], 'item-category' => $value['accounting-item-category']];
						$calculation  = self::calculateInvoiceLineItem($arrayItem);

					$price    = $calculation['price'];
			         
			        $quantity = $calculation['qty'];

			        $discount = $calculation['discount'];

			        $tax      = $calculation['tax'];
			         
			        $amount   = $calculation['amount'];
			         			         
			        $lineItem = [
			                      'tid' => $value['id'],                         // item id
        		                  'des' => strtoupper($value['description']),    // description
                    		      'qty' => $quantity,                            // quantity
                    		      'prc' => $price,                               // price
                    		      'amo' => $amount,                              // amount
                    		      'coa' => $value['account'],                    // coa account
                    		      'lid' => $invoice,                             // last bill id
                    		      'pos' => $value['position'],                   // position
                    		      'typ' => 'item',                                // type of line item
                    		      'tra' => 'invoice'
                    		     ];
                    		     
                 $item = self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => null, 'credit' => $amount, 'itemID' => $item]);
			         
				     	 if (!empty($value['tax-id']) && $data['globaltax'] != 'nontaxable'):

				     	 $taxID    = self::getTaxDiscInvoiceCoaID($db['select'],$value['tax-id']);

				     	 $lineItem = [
				                      'tid' => $value['tax-id'],                     // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $lineTax,                             // price
	                    		      'amo' => $tax,                              	 // amount
	                    		      'coa' => $taxID,                    			 // coa account
	                    		      'lid' => $invoice,                             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'tax'
	                    		     ];
	                    		     
	                 	 $taxIDC = self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($taxIDC)) ? $i + 1 : $i;

	                 	 self::transaction('ledger')->create(['coaID' => $taxID, 'debit' => null, 'credit' => $tax, 'itemID' => $taxIDC]);

	                 	 endif;

	                 	 if (!empty($value['discount-id'])):

	                 	 $discID   = self::getTaxDiscInvoiceCoaID($db['select'],$value['discount-id']);

				     	 $lineItem = [
				                      'tid' => $value['discount-id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $lineDisc,                            // price
	                    		      'amo' => $discount,                            // amount
	                    		      'coa' => $discID,                    			 // coa account
	                    		      'lid' => $invoice,                             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'discount'
	                    		     ];
	                    		     
	                 	 $discIDC = self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($discIDC)) ? $i + 1 : $i;

	                 	 self::transaction('ledger')->create(['coaID' => $discID, 'debit' => $discount, 'credit' => null, 'itemID' => $discIDC]);

	                 	 endif;
	                 	 
	                 	 $cogs = self::transaction('item')->coa($value['id'],'cogs');
	                 	 
	                 	 $cogsQty = (is_numeric($item)) ?  self::transaction('item')->sum($value['id'],'qty',$data['date']) : null;
	                 	 	
                         $cogsAmo = (is_numeric($item)) ?  self::transaction('item')->sum($value['id'],'amount',$data['date']) : null;
                        
                         $avrRate = (!empty($cogsQty) && $cogsAmo) ? round($cogsAmo / $cogsQty,2) : 0;
                        
                         $avrAmo = (!empty($avrRate)) ? round($avrRate * $quantity,2) : 0;

	                 	 if (!empty($cogs) && is_numeric($cogs)):
	                 	 		                 	 		                 	 		                 	 	              	 		                 	 	
	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $cogs,                    			 // coa account
	                    		      'lid' => $invoice,             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'cogs',
	                    		     ];
	                    		     
	                    	$cogsIDC = self::transaction('item')->create($lineItem);

	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
							if (is_numeric($cogs) && !empty($cogs) && is_numeric($cogsIDC) && !empty($cogsIDC)): 
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $cogs, 'debit' => $avrAmo, 'credit' => null, 'itemID' => $cogsIDC]);
														
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         		                    	
	                 	 endif;
	                 	 
	                 	 $inven = self::transaction('item')->coa($value['id'],'purchase');
	                 	 
	                 	 if (!empty($inven) && is_numeric($inven)):
				         					         	
	                 	 	$lineItem = [
				                      'tid' => $value['id'],    // item id
	                    		      'qty' => $quantity,		// quantity
	                    		      'prc' => $avrRate,        // price
	                    		      'amo' => $avrAmo,         // amount
	                    		      'coa' => $inven,          // coa account
	                    		      'lid' => $invoice,        // last bill id
	                    		      'lst' => $item,           // type of line item
	                    		      'typ' => 'inventory',
	                    		     ];

	                    	$cogsIDC = self::transaction('item')->create($lineItem);
	                    	
	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
							if (is_numeric($inven) && !empty($inven) && is_numeric($cogsIDC) && !empty($cogsIDC)): 
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $inven, 'debit' => null, 'credit' => $avrAmo, 'itemID' => $cogsIDC]);
							
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         					         	
				        endif;
				        
				        $itemTyp = self::transaction('item')->type($value['id']); 

        	               if ($itemTyp == 'inventory'): 
        				
        	                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
        	                   
        	                   $i = (!$faulty) ? $i + 1 : $i;
        	               
        	               endif;

			         endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$invoice);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;
		
	}

	public function invoice_update($data) {

		$i  = 0;
		
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 

		$db ['insert']->transactionStart();

		$db ['update']->transactionStart();

		$db ['delete']->transactionStart();
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');

		if (!empty($data['deleted-line-item'])):

			$result = self::transaction('item')->setHandler($db)->purge($data['deleted-line-item']);

			$i = (!$result) ? $i + 1 : $i;

		endif;
		
		$total   = self::calculateInvoiceTotal($data);
		
		$invoice = self::transaction('header')->setHandler($db)->update('invoice',$data,$total);
				
		$i = (!$invoice) ? $i + 1 : $i;
		
		if ($invoice):
					
			$invoice  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');

		    $lineItem = [
		                 'des' => "INVOICE NUMBER ".$data['number'], 
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $invoice
            		    ];
		
		    $receivable = (is_numeric($invoice)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
			
			$i = (!is_numeric($receivable) || empty($receivable)) ? $i + 1 : $i;
			
			if (is_numeric($receivable) && !empty($receivable)):

				self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => $total, 'credit' => null, 'itemID' => $invoice]);
				
				$routine = self::routine('inventory')->setHandler($db);
				
				foreach ($data['line item'] as $key => $value):

				if (empty($value['id'])): continue; endif;

				$lineTax      = str_replace(',','',$value['tax']);
				$linePrice    = str_replace(',','',$value['price']);
				$lineQty      = str_replace(',','',$value['qty']);
				$lineDisc     = str_replace(',','',$value['discount']);
				$lineAmount   = str_replace(',','',$value['amount']);
				
				$arrayItem    = ['qty' 			 => $lineQty, 
								 'price' 		 => $linePrice, 
								 'discount' 	 => $lineDisc, 
								 'tax' 			 => $lineTax, 
								 'amount' 		 => $lineAmount, 
								 'globaltax' 	 => $data['globaltax'], 
								 'item-category' => $value['accounting-item-category']
								];
									
				$calculation  = self::calculateInvoiceLineItem($arrayItem);

				$price    = $calculation['price'];
		         
		        $quantity = $calculation['qty'];

		        $discount = $calculation['discount'];

		        $tax      = $calculation['tax'];
		         
		        $amount   = $calculation['amount'];
		        
		        $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
		        
		        $lineItem = [
		                      'tid' => $value['id'],                         // item id
    		                  'des' => strtoupper($value['description']),    // description
                		      'qty' => $quantity,                            // quantity
                		      'prc' => $price,                               // price
                		      'amo' => $amount,                              // amount
                		      'coa' => $value['account'],                    // coa account
                		      'lid' => $data['transaction-pid'],             // last bill id
                		      'pos' => $value['position'],                   // position
                		      'typ' => 'item',                               // type of line item
                		      'pid' => $item,
                		      'tra' => 'invoice'
                		     ];

                 $item = (is_numeric($item) && !empty($value['item-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         	 if (is_numeric($item) && !empty($value['item-pid'])): 

			         		 self::transaction('ledger')->update(['coaID' => $value['account'], 'debit' => null, 'credit' => $amount, 'itemID' => $item]);

			         	 else:

			         		 self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => null, 'credit' => $amount, 'itemID' => $item]);

			         	 endif;
			         
				     	 if (!empty($value['tax-id']) && $data['globaltax'] != 'nontaxable'):

				     	 $taxid    = self::transaction('item')->isExist($data['transaction-pid'],'tax',$value['tax-pid']);

				     	 $taxID    = self::getTaxDiscInvoiceCoaID($db['select'],$value['tax-id']);

				     	 $lineItem = [
				                      'tid' => $value['tax-id'],                     // item id
	                    		      'qty' => 1,						  	 		 // quantity
	                    		      'prc' => $lineTax,                             // price
	                    		      'amo' => $tax,                              	 // amount
	                    		      'coa' => $taxID,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'tax',
	                    		      'pid' => $taxid
	                    		     ];
	                    		     
	                 	 $taxIDC = (is_numeric($taxid) && !empty($value['tax-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($taxIDC)) ? $i + 1 : $i;

		                 	 if (is_numeric($taxIDC) && !empty($value['tax-pid'])): 

				         		self::transaction('ledger')->update(['coaID' => $taxID, 'debit' => null, 'credit' => $tax, 'itemID' => $taxIDC]);

				         	 else:

				         		self::transaction('ledger')->create(['coaID' => $taxID, 'debit' => null, 'credit' => $tax, 'itemID' => $taxIDC]);

				         	 endif;

				         else:

				         	$taxid  = self::transaction('item')->childIsExist($data['transaction-pid'],'tax',$item);

				         	if (is_numeric($taxid) && !empty($taxid)):

				         	$result = self::transaction('item')->purge([$taxid]);

				         	$i = (!$result) ? $i + 1 : $i;

				         	endif;

	                 	 endif;

	                 	 if (!empty($value['discount-id'])):

	                 	 $discid   = self::transaction('item')->isExist($data['transaction-pid'],'discount',$value['discount-pid']);

	                 	 $discID   = self::getTaxDiscInvoiceCoaID($db['select'],$value['discount-id']);

				     	 $lineItem = [
				                      'tid' => $value['discount-id'],                // item id
	                    		      'qty' => 1,						  	 		 // quantity
	                    		      'prc' => $lineDisc,                            // price
	                    		      'amo' => $discount,                            // amount
	                    		      'coa' => $discID,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'discount',
	                    		      'pid' => $discid
	                    		     ];
	                    		     
	                 	 $discIDC = (is_numeric($discid) && !empty($value['discount-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($discID)) ? $i + 1 : $i;

	                 	 	 if (is_numeric($discID) && !empty($value['discount-pid'])): 

				         		self::transaction('ledger')->update(['coaID' => $discID, 'debit' => $discount, 'credit' => null, 'itemID' => $discIDC]);
				         		
				         	 else:

				         		self::transaction('ledger')->create(['coaID' => $discID, 'debit' => $discount, 'credit' => null, 'itemID' => $discIDC]);

				         	 endif;

				         else:

				         	$discid  = self::transaction('item')->childIsExist($data['transaction-pid'],'discount',$item);

				         	if (is_numeric($discid) && !empty($discid)):

				         	$result = self::transaction('item')->purge([$discid]);

				         	$i = (!$result) ? $i + 1 : $i;

				         	endif;

	                 	 endif;
	                 	 
	                 	 $itemTyp = self::transaction('item')->type($value['id']); 
	                 	 
	                 	 if ($itemTyp != 'inventory'): 
	                 	 
	                 	     $nonCogs  = self::transaction('item')->childIsExist($data['transaction-pid'],'cogs',$item);
	                 	     
	                 	     $nonInv   = self::transaction('item')->childIsExist($data['transaction-pid'],'inventory',$item);
	                 	     
	                 	     if (is_numeric($nonCogs) && !empty($nonCogs)):

				         	 $result = self::transaction('item')->purge([$nonCogs]);

				         	 $i = (!$result) ? $i + 1 : $i;

				         	 endif;
				         	 
				         	 if (is_numeric($nonInv) && !empty($nonInv)):

				         	 $result = self::transaction('item')->purge([$nonInv]);

				         	 $i = (!$result) ? $i + 1 : $i;

				         	 endif;
	                 	 
	                 	     continue; 
	                 	 
	                 	 endif;
	                 	 	                 	 	                 	 	                 	 
	                 	 $cogs = self::transaction('item')->coa($value['id'],'cogs');

	                 	 $cogsQty = (is_numeric($item) && !empty($value['id'])) ?  self::transaction('item')->sum($value['id'],'qty',$data['date']) : null;
	                 	 	
                         $cogsAmo = (is_numeric($item) && !empty($value['id'])) ?  self::transaction('item')->sum($value['id'],'amount',$data['date']) : null;
                        
                         $avrRate = (!empty($cogsQty) && $cogsAmo) ? round($cogsAmo / $cogsQty,2) : 0;
                        
                         $avrAmo = (!empty($avrRate)) ? round($avrRate * $quantity,2) : 0;

	                 	 if (!empty($cogs) && is_numeric($cogs)):
	                 	 	
	                 	 	$cogsID   = self::transaction('item')->isExist($data['transaction-pid'],'cogs',$item,true);

	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $cogs,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'cogs',
	                    		      'pid' => $cogsID
	                    		     ];
	                    		     
	                    	$cogsIDC = (is_numeric($cogsID) && !empty($cogsID)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
	                    	$cogsLedgerID = self::transaction('ledger')->isExist($cogsID);

							if (is_numeric($cogs) && !empty($cogs) && is_numeric($cogsID) && !empty($cogsID) && $cogsLedgerID): 
							
							$cogsLedger = self::transaction('ledger')->update(['coaID' => $cogs, 'debit' => $avrAmo, 'credit' => null, 'itemID' => $cogsIDC]);
							
							else:
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $cogs, 'debit' => $avrAmo, 'credit' => null, 'itemID' => $cogsIDC]);
							
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         		                    	
	                 	 endif;
	                 	 
	                 	 $inven = self::transaction('item')->coa($value['id'],'purchase');
	                 	 
	                 	 if (!empty($inven) && is_numeric($inven)):
				         	
	                 	 	$cogsID   = self::transaction('item')->isExist($data['transaction-pid'],'inventory',$item,true);

	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $inven,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'inventory',
	                    		      'pid' => $cogsID
	                    		     ];

	                    	$cogsIDC = (is_numeric($cogsID) && !empty($cogsID)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
	                    	
	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
	                    	$cogsLedgerID = self::transaction('ledger')->isExist($cogsID);

							if (is_numeric($inven) && !empty($inven) && is_numeric($cogsID) && !empty($cogsID) && $cogsLedgerID): 
							
							$cogsLedger = self::transaction('ledger')->update(['coaID' => $inven, 'debit' => null, 'credit' => $avrAmo, 'itemID' => $cogsIDC]);
							
							else:
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $inven, 'debit' => null, 'credit' => $avrAmo, 'itemID' => $cogsIDC]);
							
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         					         	
				        endif;
				        
				        $itemTyp = self::transaction('item')->type($value['id']); 

        	               if ($itemTyp == 'inventory'): 
        				
        	                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
        	                   
        	                   $i = (!$faulty) ? $i + 1 : $i;
        	               
        	               endif;
	                 	 	                 	 
			         endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();

		$db ['update']->transactionSuccess();

		$db ['delete']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();

		$db ['update']->transactionFailed();

		$db ['delete']->transactionFailed();

		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;

	}
	
	public function bill_create($data) {
								
		$i     = 0;
				
		$db    = ['select' => new select(), 'insert' => new insert(), 'update' => new update()]; $db ['insert']->transactionStart();
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');
		
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->create('bill',$data,$total);

		$i = (!is_numeric($bill)) ? $i + 1 : $i;
		
		if (is_numeric($bill)):
		
		    $lineItem = [
		                 'des' => "BILL NUMBER ".$data['number'],
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $bill,
            		     'typ' => 'account'
            		    ];
		
		    $payable  = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable)):
			
			self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $payable]);
			
			$routine = self::routine('inventory')->setHandler($db);
			
			     foreach ($data['line item'] as $key => $value):
			         
			         if (empty($value['id']) &&  empty($value['account'])): continue; endif;
			         
			         $price    = str_replace(',','',$value['price']);
			         
			         $quantity = str_replace(',','',$value['qty']);
			         
			         $amount   = round($price*$quantity,2);
			         			         
			         $lineItem = [
			                      'tid' => $value['id'],                         // item id
        		                  'des' => strtoupper($value['description']),    // description
                    		      'qty' => $quantity,                            // quantity
                    		      'prc' => $price,                               // price
                    		      'amo' => $amount,                              // amount
                    		      'coa' => $value['account'],                    // coa account
                    		      'lid' => $bill,                                // last bill id
                    		      'pos' => $value['position'],                   // position
                    		      'typ' => 'item',								 // type of line item
                    		      'tra' => 'bill'                                
                    		     ];
                    		     
                 $item = self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
			         
			         endif;
			     
			     $itemTyp = self::transaction('item')->type($value['id']); 

	               if ($itemTyp == 'inventory'): 
				
	                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
	                   
	                   $i = (!$faulty) ? $i + 1 : $i;
	               
	               endif;
			     
			     endforeach;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$bill);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:

		$db ['insert']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}
	
	public function bill_update($data) {
		
		$i  = 0;
		
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 

		$db ['insert']->transactionStart();

		$db ['update']->transactionStart();

		$db ['delete']->transactionStart();
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');

		if (!empty($data['deleted-line-item'])):

			$result = self::transaction('item')->setHandler($db)->purge($data['deleted-line-item']);

			$i = (!$result) ? $i + 1 : $i;

		endif;
		
		$total = self::calculateStandardLineItem($data['line item']);
		
		$bill  = self::transaction('header')->setHandler($db)->update('bill',$data,$total);
				
		$i = (!$bill) ? $i + 1 : $i;
		
		if ($bill):
					
			$bill  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');

		    $lineItem = [
		                 'des' => "BILL NUMBER ".$data['number'], 
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $bill
            		    ];
		
		    $payable = (is_numeric($bill)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
			
			$i = (!is_numeric($payable) || empty($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable) && !empty($payable)):

				self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $bill]);
				
				$routine = self::routine('inventory')->setHandler($db);
				
				foreach ($data['line item'] as $key => $value):
				
				    if (empty($value['id']) &&  empty($value['account'])): continue; endif;

					$price    = str_replace(',','',$value['price']);
			         
                    $quantity = str_replace(',','',$value['qty']);
                    
                    $amount   = round($price*$quantity,2);
                    
                    $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
                                        			         
                    $lineItem = [
                              'tid' => $value['id'],                         // item id
                              'des' => strtoupper($value['description']),    // description
                    	      'qty' => $quantity,                            // quantity
                    	      'prc' => $price,                               // price
                    	      'amo' => $amount,                              // amount
                    	      'coa' => $value['account'],                    // coa account
                    	      'lid' => $data['transaction-pid'],             // last bill id
                    	      'pos' => $value['position'],                   // position
                    	      'typ' => 'item',                               // type of line item
                    	      'pid' => $item,                                
                    	      'tra' => 'bill'
                    	     ];
                    	     
                     $item = (is_numeric($item) && !empty($value['item-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

                     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
                     if (is_numeric($item)): 
                     
                     	 if (is_numeric($item) && !empty($value['item-pid'])): 
                    
                     		 self::transaction('ledger')->update(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                    
                     	 else:
                    
                     		 self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                    
                     	 endif;
                     	 
                    endif;
				
				$itemTyp = self::transaction('item')->type($value['id']); 

	               if ($itemTyp == 'inventory'): 
				
	                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
	                   
	                   $i = (!$faulty) ? $i + 1 : $i;
	               
	               endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();

		$db ['update']->transactionSuccess();

		$db ['delete']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();

		$db ['update']->transactionFailed();

		$db ['delete']->transactionFailed();

		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;
		
	}
	
	public function salesreceipt_create($data) {

		$i = 0;
		
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');
		
		$total    = self::calculateInvoiceTotal($data);
		
		$invoice  = self::transaction('header')->setHandler($db)->create('sales receipt',$data,$total);
				
		$i = (!is_numeric($invoice)) ? $i + 1 : $i;
		
		if (is_numeric($invoice)):
		
		    $lineItem = [
		                 'des' => "SALES RECEIPT NUMBER ".$data['number'],
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $invoice,
            		     'typ' => 'account'
            		    ];
		
		    $receivable = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($receivable)) ? $i + 1 : $i;
			
			if (is_numeric($receivable)):

				self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => $total, 'credit' => null, 'itemID' => $receivable]);
				
				$routine = self::routine('inventory')->setHandler($db);
				
				foreach ($data['line item'] as $key => $value):

					if (empty($value['id'])): continue; endif;

						$lineTax      = str_replace(',','',$value['tax']);
						$linePrice    = str_replace(',','',$value['price']);
						$lineQty      = str_replace(',','',$value['qty']);
						$lineDisc     = str_replace(',','',$value['discount']);
						$lineAmount   = str_replace(',','',$value['amount']);
						$arrayItem    = ['qty' => $lineQty, 'price' => $linePrice, 'discount' => $lineDisc, 'tax' => $lineTax, 'amount' => $lineAmount, 'globaltax' => $data['globaltax'], 'item-category' => $value['accounting-item-category']];
						$calculation  = self::calculateInvoiceLineItem($arrayItem);

					$price    = $calculation['price'];
			         
			        $quantity = $calculation['qty'];

			        $discount = $calculation['discount'];

			        $tax      = $calculation['tax'];
			         
			        $amount   = $calculation['amount'];
			         			         
			        $lineItem = [
			                      'tid' => $value['id'],                         // item id
        		                  'des' => strtoupper($value['description']),    // description
                    		      'qty' => $quantity,                            // quantity
                    		      'prc' => $price,                               // price
                    		      'amo' => $amount,                              // amount
                    		      'coa' => $value['account'],                    // coa account
                    		      'lid' => $invoice,                             // last bill id
                    		      'pos' => $value['position'],                   // position
                    		      'typ' => 'item'                                // type of line item
                    		     ];
                    		     
                 $item = self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => null, 'credit' => $amount, 'itemID' => $item]);
			         
				     	 if (!empty($value['tax-id']) && $data['globaltax'] != 'nontaxable'):

				     	 $taxID    = self::getTaxDiscInvoiceCoaID($db['select'],$value['tax-id']);

				     	 $lineItem = [
				                      'tid' => $value['tax-id'],                     // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $lineTax,                             // price
	                    		      'amo' => $tax,                              	 // amount
	                    		      'coa' => $taxID,                    			 // coa account
	                    		      'lid' => $invoice,                             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'tax'
	                    		     ];
	                    		     
	                 	 $taxIDC = self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($taxIDC)) ? $i + 1 : $i;

	                 	 self::transaction('ledger')->create(['coaID' => $taxID, 'debit' => null, 'credit' => $tax, 'itemID' => $taxIDC]);

	                 	 endif;

	                 	 if (!empty($value['discount-id'])):

	                 	 $discID   = self::getTaxDiscInvoiceCoaID($db['select'],$value['discount-id']);

				     	 $lineItem = [
				                      'tid' => $value['discount-id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $lineDisc,                            // price
	                    		      'amo' => $discount,                            // amount
	                    		      'coa' => $discID,                    			 // coa account
	                    		      'lid' => $invoice,                             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'discount'
	                    		     ];
	                    		     
	                 	 $discIDC = self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($discIDC)) ? $i + 1 : $i;

	                 	 self::transaction('ledger')->create(['coaID' => $discID, 'debit' => $discount, 'credit' => null, 'itemID' => $discIDC]);

	                 	 endif;
	                 	 
	                 	 $cogs = self::transaction('item')->coa($value['id'],'cogs');
	                 	 
	                 	 $cogsQty = (is_numeric($item)) ?  self::transaction('item')->sum($value['id'],'qty',$data['date']) : null;
	                 	 	
                         $cogsAmo = (is_numeric($item)) ?  self::transaction('item')->sum($value['id'],'amount',$data['date']) : null;
                        
                         $avrRate = (!empty($cogsQty) && $cogsAmo) ? round($cogsAmo / $cogsQty,2) : 0;
                        
                         $avrAmo = (!empty($avrRate)) ? round($avrRate * $quantity,2) : 0;

	                 	 if (!empty($cogs) && is_numeric($cogs)):
	                 	 		                 	 		                 	 		                 	 	              	 		                 	 	
	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $cogs,                    			 // coa account
	                    		      'lid' => $invoice,             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'cogs',
	                    		     ];
	                    		     
	                    	$cogsIDC = self::transaction('item')->create($lineItem);

	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
							if (is_numeric($cogs) && !empty($cogs) && is_numeric($cogsIDC) && !empty($cogsIDC)): 
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $cogs, 'debit' => $avrAmo, 'credit' => null, 'itemID' => $cogsIDC]);
														
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         		                    	
	                 	 endif;
	                 	 
	                 	 $inven = self::transaction('item')->coa($value['id'],'purchase');
	                 	 
	                 	 if (!empty($inven) && is_numeric($inven)):
				         					         	
	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $inven,                    			 // coa account
	                    		      'lid' => $invoice,             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'inventory',
	                    		     ];

	                    	$cogsIDC = self::transaction('item')->create($lineItem);
	                    	
	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
							if (is_numeric($inven) && !empty($inven) && is_numeric($cogsIDC) && !empty($cogsIDC)): 
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $inven, 'debit' => null, 'credit' => $avrAmo, 'itemID' => $cogsIDC]);
							
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         					         	
				        endif;
				        
				        $itemTyp = self::transaction('item')->type($value['id']); 

        	               if ($itemTyp == 'inventory'): 
        				
        	                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
        	                   
        	                   $i = (!$faulty) ? $i + 1 : $i;
        	                   
        	               endif;

			         endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$invoice);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();

		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;
		
	}

	public function salesreceipt_update($data) {

		$i  = 0;
		
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');

		$db ['insert']->transactionStart();

		$db ['update']->transactionStart();

		$db ['delete']->transactionStart();

		if (!empty($data['deleted-line-item'])):

			$result = self::transaction('item')->setHandler($db)->purge($data['deleted-line-item']);

			$i = (!$result) ? $i + 1 : $i;

		endif;
		
		$total   = self::calculateInvoiceTotal($data);
		
		$invoice = self::transaction('header')->setHandler($db)->update('sales receipt',$data,$total);
				
		$i = (!$invoice) ? $i + 1 : $i;
		
		if ($invoice):
					
			$invoice  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');

		    $lineItem = [
		                 'des' => "SALES RECEIPT NUMBER ".$data['number'], 
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $invoice
            		    ];
		
		    $receivable = (is_numeric($invoice)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
			
			$i = (!is_numeric($receivable) || empty($receivable)) ? $i + 1 : $i;
			
			if (is_numeric($receivable) && !empty($receivable)):

				self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => $total, 'credit' => null, 'itemID' => $invoice]);

				$routine = self::routine('inventory')->setHandler($db);

				foreach ($data['line item'] as $key => $value):

					if (empty($value['id'])): continue; endif;

						$lineTax      = str_replace(',','',$value['tax']);
						$linePrice    = str_replace(',','',$value['price']);
						$lineQty      = str_replace(',','',$value['qty']);
						$lineDisc     = str_replace(',','',$value['discount']);
						$lineAmount   = str_replace(',','',$value['amount']);
						$arrayItem    = ['qty' => $lineQty, 'price' => $linePrice, 'discount' => $lineDisc, 'tax' => $lineTax, 'amount' => $lineAmount, 'globaltax' => $data['globaltax'], 'item-category' => $value['accounting-item-category']];
						$calculation  = self::calculateInvoiceLineItem($arrayItem);

					$price    = $calculation['price'];
			         
			        $quantity = $calculation['qty'];

			        $discount = $calculation['discount'];

			        $tax      = $calculation['tax'];
			         
			        $amount   = $calculation['amount'];
			        
			        $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
			        
			        $lineItem = [
			                      'tid' => $value['id'],                         // item id
        		                  'des' => strtoupper($value['description']),    // description
                    		      'qty' => $quantity,                            // quantity
                    		      'prc' => $price,                               // price
                    		      'amo' => $amount,                              // amount
                    		      'coa' => $value['account'],                    // coa account
                    		      'lid' => $data['transaction-pid'],             // last bill id
                    		      'pos' => $value['position'],                   // position
                    		      'typ' => 'item',                               // type of line item
                    		      'pid' => $item
                    		     ];

                 $item = (is_numeric($item) && !empty($value['item-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         	 if (is_numeric($item) && !empty($value['item-pid'])): 

			         		 self::transaction('ledger')->update(['coaID' => $value['account'], 'debit' => null, 'credit' => $amount, 'itemID' => $item]);

			         	 else:

			         		 self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => null, 'credit' => $amount, 'itemID' => $item]);

			         	 endif;
			         
				     	 if (!empty($value['tax-id']) && $data['globaltax'] != 'nontaxable'):

				     	 $taxid    = self::transaction('item')->isExist($data['transaction-pid'],'tax',$value['tax-pid']);

				     	 $taxID    = self::getTaxDiscInvoiceCoaID($db['select'],$value['tax-id']);

				     	 $lineItem = [
				                      'tid' => $value['tax-id'],                     // item id
	                    		      'qty' => 1,						  	 		 // quantity
	                    		      'prc' => $lineTax,                             // price
	                    		      'amo' => $tax,                              	 // amount
	                    		      'coa' => $taxID,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],                 // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'tax',
	                    		      'pid' => $taxid
	                    		     ];
	                    		     
	                 	 $taxIDC = (is_numeric($taxid) && !empty($value['tax-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($taxIDC)) ? $i + 1 : $i;

		                 	 if (is_numeric($taxIDC) && !empty($value['tax-pid'])): 

				         		self::transaction('ledger')->update(['coaID' => $taxID, 'debit' => null, 'credit' => $tax, 'itemID' => $taxIDC]);

				         	 else:

				         		self::transaction('ledger')->create(['coaID' => $taxID, 'debit' => null, 'credit' => $tax, 'itemID' => $taxIDC]);

				         	 endif;

				         else:

				         	$taxid  = self::transaction('item')->childIsExist($data['transaction-pid'],'tax',$item);

				         	if (is_numeric($taxid) && !empty($taxid)):

				         	$result = self::transaction('item')->purge([$taxid]);

				         	$i = (!$result) ? $i + 1 : $i;

				         	endif;

	                 	 endif;

	                 	 if (!empty($value['discount-id'])):

	                 	 $discid   = self::transaction('item')->isExist($data['transaction-pid'],'discount',$value['discount-pid']);

	                 	 $discID   = self::getTaxDiscInvoiceCoaID($db['select'],$value['discount-id']);

				     	 $lineItem = [
				                      'tid' => $value['discount-id'],                // item id
	                    		      'qty' => 1,						  	 		 // quantity
	                    		      'prc' => $lineDisc,                            // price
	                    		      'amo' => $discount,                            // amount
	                    		      'coa' => $discID,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'discount',
	                    		      'pid' => $discid
	                    		     ];
	                    		     
	                 	 $discIDC = (is_numeric($discid) && !empty($value['discount-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

	                 	 $i = (!is_numeric($discID)) ? $i + 1 : $i;

	                 	 	 if (is_numeric($discID) && !empty($value['discount-pid'])): 

				         		self::transaction('ledger')->update(['coaID' => $discID, 'debit' => $discount, 'credit' => null, 'itemID' => $discIDC]);
				         		
				         	 else:

				         		self::transaction('ledger')->create(['coaID' => $discID, 'debit' => $discount, 'credit' => null, 'itemID' => $discIDC]);

				         	 endif;

				         else:

				         	$discid  = self::transaction('item')->childIsExist($data['transaction-pid'],'discount',$item);

				         	if (is_numeric($discid) && !empty($discid)):

				         	$result = self::transaction('item')->purge([$discid]);

				         	$i = (!$result) ? $i + 1 : $i;

				         	endif;

	                 	 endif;
	                 	 
	                 	 $itemTyp = self::transaction('item')->type($value['id']); 
	                 	 
	                 	 if ($itemTyp != 'inventory'): 
	                 	 
	                 	     $nonCogs  = self::transaction('item')->childIsExist($data['transaction-pid'],'cogs',$item);
	                 	     
	                 	     $nonInv   = self::transaction('item')->childIsExist($data['transaction-pid'],'inventory',$item);
	                 	     
	                 	     if (is_numeric($nonCogs) && !empty($nonCogs)):

				         	 $result = self::transaction('item')->purge([$nonCogs]);

				         	 $i = (!$result) ? $i + 1 : $i;

				         	 endif;
				         	 
				         	 if (is_numeric($nonInv) && !empty($nonInv)):

				         	 $result = self::transaction('item')->purge([$nonInv]);

				         	 $i = (!$result) ? $i + 1 : $i;

				         	 endif;
	                 	 
	                 	     continue; 
	                 	 
	                 	 endif;
	                 	 	                 	 
	                 	 $cogs    = self::transaction('item')->coa($value['id'],'cogs');
 
	                 	 $cogsQty = (is_numeric($item) && !empty($value['id'])) ?  self::transaction('item')->sum($value['id'],'qty',$data['date']) : null;
	                 	 	
                         $cogsAmo = (is_numeric($item) && !empty($value['id'])) ?  self::transaction('item')->sum($value['id'],'amount',$data['date']) : null;
                        
                         $avrRate = (!empty($cogsQty) && $cogsAmo) ? round($cogsAmo / $cogsQty,2) : 0;
                        
                         $avrAmo = (!empty($avrRate)) ? round($avrRate * $quantity,2) : 0;

	                 	 if (!empty($cogs) && is_numeric($cogs)):
	                 	 	
	                 	 	$cogsID   = self::transaction('item')->isExist($data['transaction-pid'],'cogs',$item,true);

	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $cogs,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'cogs',
	                    		      'pid' => $cogsID
	                    		     ];
	                    		     
	                    	$cogsIDC = (is_numeric($cogsID) && !empty($cogsID)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
	                    	$cogsLedgerID = self::transaction('ledger')->isExist($cogsID);

							if (is_numeric($cogs) && !empty($cogs) && is_numeric($cogsID) && !empty($cogsID) && $cogsLedgerID): 
							
							$cogsLedger = self::transaction('ledger')->update(['coaID' => $cogs, 'debit' => $avrAmo, 'credit' => null, 'itemID' => $cogsIDC]);
							
							else:
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $cogs, 'debit' => $avrAmo, 'credit' => null, 'itemID' => $cogsIDC]);
							
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         		                    	
	                 	 endif;
	                 	 
	                 	 $inven = self::transaction('item')->coa($value['id'],'purchase');
	                 	 
	                 	 if (!empty($inven) && is_numeric($inven)):
				         	
	                 	 	$cogsID   = self::transaction('item')->isExist($data['transaction-pid'],'inventory',$item,true);

	                 	 	$lineItem = [
				                      'tid' => $value['id'],                // item id
	                    		      'qty' => $quantity,						  	 // quantity
	                    		      'prc' => $avrRate,                              // price
	                    		      'amo' => $avrAmo,                              // amount
	                    		      'coa' => $inven,                    			 // coa account
	                    		      'lid' => $data['transaction-pid'],             // last bill id
	                    		      'lst' => $item,                              	 // type of line item
	                    		      'typ' => 'inventory',
	                    		      'pid' => $cogsID
	                    		     ];

	                    	$cogsIDC = (is_numeric($cogsID) && !empty($cogsID)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
	                    	
	                    	$i = (!is_numeric($cogsIDC)) ? $i + 1 : $i;
	                    	
	                    	$cogsLedgerID = self::transaction('ledger')->isExist($cogsID);

							if (is_numeric($inven) && !empty($inven) && is_numeric($cogsID) && !empty($cogsID) && $cogsLedgerID): 
							
							$cogsLedger = self::transaction('ledger')->update(['coaID' => $inven, 'debit' => null, 'credit' => $avrAmo, 'itemID' => $cogsIDC]);
							
							else:
							
							$cogsLedger = self::transaction('ledger')->create(['coaID' => $inven, 'debit' => null, 'credit' => $avrAmo, 'itemID' => $cogsIDC]);
							
							endif;
				         	 
				         	$i = (!$cogsLedger) ? $i + 1 : $i;
				         					         	
				        endif;
				        
				        $itemTyp = self::transaction('item')->type($value['id']); 

        	               if ($itemTyp == 'inventory'): 
        				
        	                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
        	                   
        	                   $i = (!$faulty) ? $i + 1 : $i;
        	                   
        	               endif;

			         endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();

		$db ['update']->transactionSuccess();

		$db ['delete']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();

		$db ['update']->transactionFailed();

		$db ['delete']->transactionFailed();

		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;

	}
	
	public function receipt_create($data) {
								
		$i  = 0;
				
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');
		
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->create('receipt',$data,$total);

		$i = (!is_numeric($bill)) ? $i + 1 : $i;
		
		if (is_numeric($bill)):
		
		    $lineItem = [
		                 'des' => "RECEIPT NUMBER ".$data['number'],
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $bill,
            		     'typ' => 'account'
            		    ];
		
		    $payable  = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable)):
			
			self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $payable]);
			
			$routine = self::routine('inventory')->setHandler($db);
			
			     foreach ($data['line item'] as $key => $value):
			         
			         if (empty($value['id']) &&  empty($value['account'])): continue; endif;
			         
			         $price    = str_replace(',','',$value['price']);
			         
			         $quantity = str_replace(',','',$value['qty']);
			         
			         $amount   = round($price*$quantity,2);
			         			         
			         $lineItem = [
			                      'tid' => $value['id'],                         // item id
        		                  'des' => strtoupper($value['description']),    // description
                    		      'qty' => $quantity,                            // quantity
                    		      'prc' => $price,                               // price
                    		      'amo' => $amount,                              // amount
                    		      'coa' => $value['account'],                    // coa account
                    		      'lid' => $bill,                                // last bill id
                    		      'pos' => $value['position'],                   // position
                    		      'typ' => 'item'                                // type of line item
                    		     ];
                    		     
                 $item = self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
			         
			         endif;
			         
			     $itemTyp = self::transaction('item')->type($value['id']); 

			       if ($itemTyp == 'inventory'): 
                
                   $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
                   
                   $i = (!$faulty) ? $i + 1 : $i;
                   
                   endif;
			     
			     endforeach;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$bill);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:

		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}
	
	public function receipt_update($data) {
		
		$i  = 0;
		
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 
		
		$inventoryPolicy = self::user('policy')->setHandler($db)->get('inventory');

		$db ['insert']->transactionStart();

		$db ['update']->transactionStart();

		$db ['delete']->transactionStart();

		if (!empty($data['deleted-line-item'])):

			$result = self::transaction('item')->setHandler($db)->purge($data['deleted-line-item']);

			$i = (!$result) ? $i + 1 : $i;

		endif;
		
		$total    = self::calculateStandardLineItem($data['line item']);
		
		$receipt  = self::transaction('header')->setHandler($db)->update('receipt',$data,$total);
				
		$i = (!$receipt) ? $i + 1 : $i;
		
		if ($receipt):
					
			$receipt  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');

		    $lineItem = [
		                 'des' => "RECEIPT NUMBER ".$data['number'], 
            		     'qty' => 1,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $receipt
            		    ];
		
		    $payable = (is_numeric($receipt)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
			
			$i = (!is_numeric($payable) || empty($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable) && !empty($payable)):

				self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $receipt]);

				$routine = self::routine('inventory')->setHandler($db);

				foreach ($data['line item'] as $key => $value):
				
				    if (empty($value['id']) &&  empty($value['account'])): continue; endif;

					$price    = str_replace(',','',$value['price']);
			         
                    $quantity = str_replace(',','',$value['qty']);
                    
                    $amount   = round($price*$quantity,2);
                    
                    $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
                                        			         
                    $lineItem = [
                              'tid' => $value['id'],                         // item id
                              'des' => strtoupper($value['description']),    // description
                    	      'qty' => $quantity,                            // quantity
                    	      'prc' => $price,                               // price
                    	      'amo' => $amount,                              // amount
                    	      'coa' => $value['account'],                    // coa account
                    	      'lid' => $data['transaction-pid'],             // last bill id
                    	      'pos' => $value['position'],                   // position
                    	      'typ' => 'item',                               // type of line item
                    	      'pid' => $item                                
                    	     ];
                    	     
                     $item = (is_numeric($item) && !empty($value['item-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
                     
                     $i    = (!is_numeric($item)) ? $i + 1 : $i;
                     
                     if (is_numeric($item)): 
                     
                     	 if (is_numeric($item) && !empty($value['item-pid'])): 
                    
                     		 self::transaction('ledger')->update(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                    
                     	 else:
                    
                     		 self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                    
                     	 endif;
                     	 
                    endif;
                    
                    $itemTyp = self::transaction('item')->type($value['id']); 

                    if ($itemTyp == 'inventory'): 
                    
                       $faulty = $routine->cost_correction($value['id'],$data['date'],$inventoryPolicy);
                       
                       $i = (!$faulty) ? $i + 1 : $i;
                       
                    endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();

		$db ['update']->transactionSuccess();

		$db ['delete']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();

		$db ['update']->transactionFailed();

		$db ['delete']->transactionFailed();

		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;
		
	}
	
	public function transfer_create($data) {
								
		$i     = 0;
				
		$db    = ['select' => new select(), 'insert' => new insert()]; $db ['insert']->transactionStart();
		
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->create('transfer',$data,$total);

		$i = (!is_numeric($bill)) ? $i + 1 : $i;
		
		if (is_numeric($bill)):
		
		    $lineItem = [
		                 'des' => "TRANSFER NUMBER ".$data['number'],
            		     'qty' => null,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $bill,
            		     'typ' => 'account'
            		    ];
		
		    $payable  = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable)):
			
			self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $payable]);
			
			     foreach ($data['line item'] as $key => $value):
			         
			         if (empty($value['id']) &&  empty($value['account'])): continue; endif;
			         
			         $price    = str_replace(',','',$value['price']);
			         
			         $quantity = str_replace(',','',$value['qty']);
			         
			         $amount   = round($price*$quantity,2);
			         			         
			         $lineItem = [
			                      'tid' => $value['id'],                         // item id
        		                  'des' => strtoupper($value['description']),    // description
                    		      'qty' => null,                                 // quantity
                    		      'prc' => $price,                               // price
                    		      'amo' => $amount,                              // amount
                    		      'coa' => $value['account'],                    // coa account
                    		      'lid' => $bill,                                // last bill id
                    		      'pos' => $value['position'],                   // position
                    		      'typ' => 'item'                                // type of line item
                    		     ];
                    		     
                 $item = self::transaction('item')->create($lineItem);

			     $i = (!is_numeric($item)) ? $i + 1 : $i;
			     
			         if (is_numeric($item)): 
			         
			         self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
			         
			         endif;
			     
			     endforeach;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$bill);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:

		$db ['insert']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}
	
	public function transfer_update($data) {

		$i  = 0;
		
		$db = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 

		$db ['insert']->transactionStart();

		$db ['update']->transactionStart();

		$db ['delete']->transactionStart();

		if (!empty($data['deleted-line-item'])):

			$result = self::transaction('item')->setHandler($db)->purge($data['deleted-line-item']);

			$i = (!$result) ? $i + 1 : $i;

		endif;
		
		$total    = self::calculateStandardLineItem($data['line item']);
		
		$receipt  = self::transaction('header')->setHandler($db)->update('transfer',$data,$total);
				
		$i = (!$receipt) ? $i + 1 : $i;
		
		if ($receipt):
					
			$receipt  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');

		    $lineItem = [
		                 'des' => "TRANSFER NUMBER ".$data['number'], 
            		     'qty' => null,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $receipt
            		    ];
		
		    $payable = (is_numeric($receipt)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
			
			$i = (!is_numeric($payable) || empty($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable) && !empty($payable)):

				self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $receipt]);

				foreach ($data['line item'] as $key => $value):
				
				    if (empty($value['id']) &&  empty($value['account'])): continue; endif;

					$price    = str_replace(',','',$value['price']);
			         
                    $quantity = str_replace(',','',$value['qty']);
                    
                    $amount   = round($price*$quantity,2);
                    
                    $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
                                        			         
                    $lineItem = [
                              'tid' => $value['id'],                         // item id
                              'des' => strtoupper($value['description']),    // description
                    	      'qty' => null,                                 // quantity
                    	      'prc' => $price,                               // price
                    	      'amo' => $amount,                              // amount
                    	      'coa' => $value['account'],                    // coa account
                    	      'lid' => $data['transaction-pid'],             // last bill id
                    	      'pos' => $value['position'],                   // position
                    	      'typ' => 'item',                               // type of line item
                    	      'pid' => $item                                
                    	     ];
                    	     
                     $item = (is_numeric($item) && !empty($value['item-pid'])) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
                     
                     $i    = (!is_numeric($item)) ? $i + 1 : $i;
                     
                     if (is_numeric($item)): 
                     
                     	 if (is_numeric($item) && !empty($value['item-pid'])): 
                    
                     		 self::transaction('ledger')->update(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                    
                     	 else:
                    
                     		 self::transaction('ledger')->create(['coaID' => $value['account'], 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                    
                     	 endif;
                     	 
                    endif;
				
				endforeach;

			endif;

		endif;
		
		$balance = self::check('transaction')->balance();
			
		if ($i == 0 && $balance):
				
		$db ['insert']->transactionSuccess();

		$db ['update']->transactionSuccess();

		$db ['delete']->transactionSuccess();

		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
				
		$db ['insert']->transactionFailed();

		$db ['update']->transactionFailed();

		$db ['delete']->transactionFailed();

		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;
		
	}
	
	public function payment_create($data) {
								
		$i     = 0;
				
		$db    = ['select' => new select(), 'insert' => new insert(), 'update' => new update()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->create('payment',$data,$total);

		$i = (!is_numeric($bill)) ? $i + 1 : $i;
		
		if (is_numeric($bill)):
		
		    $lineItem = [
		                 'des' => "PAYMENT NUMBER ".$data['number'],
            		     'qty' => null,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $bill,
            		     'typ' => 'account'
            		    ];
		
		    $payable  = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable)):
			
			self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => $total, 'credit' => null, 'itemID' => $payable]);
			
    			if (!empty($data['line item'])):
    			
    			     foreach ($data['line item'] as $key => $value):
    			         
    			         if (empty($value['id'])): continue; endif;
    			         
    			         $price    = str_replace(',','',$value['price']);
    			         
    			         $quantity = str_replace(',','',$value['qty']);
    			         
    			         $amount   = round($price*$quantity,2);
    			         
    			         $account  = self::transaction('ledger')->setHandler($db)->pullID($value['id']);
    			         			         
    			         $lineItem = [
            		                  'des' => strtoupper($value['description']),    // description
                        		      'qty' => null,                                 // quantity
                        		      'prc' => $value['price-integer'],              // price
                        		      'amo' => $amount,                              // amount
                        		      'coa' => $account,                             // coa account
                        		      'lid' => $bill,                                // last bill id
                        		      'pos' => $value['position'],                   // position
                        		      'typ' => 'item',                               // type of line item
                        		      'pay' => $value['id']
                        		     ];
                        		     
                     $item   = self::transaction('item')->create($lineItem);
                     
                     $reduce = self::transaction('header')->setHandler($db)->paid('invoice',$value['id'],$amount);
    
    			     $i = (!is_numeric($item) || !$reduce) ? $i + 1 : $i;
    			     
    			         if (is_numeric($item) && $reduce): 
    			         
    			         self::transaction('ledger')->create(['coaID' => $account, 'debit' => null, 'credit' => $amount, 'itemID' => $item]);
    			         
    			         endif;
    			     
    			     endforeach;
			     
			     endif;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$bill);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:

		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}
	
	public function payment_update($data) {
								
		$i   = 0;
		
		$db  = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$db ['delete']->transactionStart();
		
		$item = self::transaction('item')->setHandler($db)->all($data['transaction-pid'],'item');

		$data['deleted-line-item'] = null;
		
		if (!empty($data['line item'])):
    			
		     foreach ($data['line item'] as $key => $value):
		          
		          if (!empty($value['item-pid'])):
		          
		          $forbiddenID [] = $value['item-pid'];
		          
		          endif;
		     
		     endforeach;
    			     
        endif;

		if (!empty($item)):
    			
		      foreach ($item as $key => $value):
		          
		          $prim = $value['CAP_ACC_TRA_ITE_ID'];
		          
		          if (@!in_array($prim, $forbiddenID)):

		          $item = self::transaction('item')->isExist($data['transaction-pid'],'item',$prim);
		          		          
    		          if (is_numeric($item) && !empty($item)):
    		              		              
    		          $data['deleted-line-item'][] = $item;
    		                  		          
    		          endif;
		          
		          endif;
		      
		      endforeach;
        
        endif;
        
        $line = @array_unique($data['deleted-line-item']);
            			     
		if (!empty($line)):

			$result = self::transaction('item')->setHandler($db)->purge($line);

			$i = (!$result) ? $i + 1 : $i;

		endif;
				
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->update('payment',$data,$total);
		
		$i = (!$bill) ? $i + 1 : $i;
		
		if ($bill):
		    
		    $bill  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');
		    
		    $lineItem = [
		                 'des' => "PAYMENT NUMBER ".$data['number'], 
            		     'qty' => null,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $bill
            		    ];
		                
            $payable = (is_numeric($bill)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

			$i = (!is_numeric($payable) || empty($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable) && !empty($payable)):
			
			self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => $total, 'credit' => null, 'itemID' => $bill]);

    			if (!empty($data['line item'])):
    			
    			     foreach ($data['line item'] as $key => $value):

    			         if (empty($value['id'])): continue; endif;
    			         
    			         $price    = str_replace(',','',$value['price']);
    			         
    			         $quantity = str_replace(',','',$value['qty']);
    			         
    			         $amount   = round($price*$quantity,2);
    			         
    			         $account  = self::transaction('ledger')->setHandler($db)->pullID($value['id']);
    			         
    			         $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
    			         			         
    			         $lineItem = [
            		                  'des' => strtoupper($value['description']),    // description
                        		      'qty' => null,                                 // quantity
                        		      'prc' => $value['price-integer'],              // price
                        		      'amo' => $amount,                              // amount
                        		      'coa' => $account,                             // coa account
                        		      'lid' => $data['transaction-pid'],             // last bill id
                        		      'pos' => $value['position'],                   // position
                        		      'typ' => 'item',                               // type of line item
                        		      'pay' => $value['id'],
                        		      'pid' => $item
                        		     ];
                        
                        $item = (is_numeric($item) && !empty($value['item-pid'])) ? 
                        
                        self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
                    
                        $i = (!is_numeric($item)) ? $i + 1 : $i;
                    
                        if (is_numeric($item)): 
                        
                        	 if (is_numeric($item) && !empty($value['item-pid'])): 
                        
                        		 self::transaction('ledger')->update(['coaID' => $account, 'debit' => null, 'credit' => $amount, 'itemID' => $item]);
                        
                        	 else:
                        
                        		 self::transaction('ledger')->create(['coaID' => $account, 'debit' => null, 'credit' => $amount, 'itemID' => $item]);
                        
                        	 endif;
                        	 
                        endif;
                        		         			     
    			     endforeach;
			     
			     endif;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();
		
		$db ['delete']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
		
		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();
		
		$db ['delete']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}
	
	public function paybill_create($data) {
								
		$i     = 0;
				
		$db    = ['select' => new select(), 'insert' => new insert(), 'update' => new update()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->create('pay bill',$data,$total);

		$i = (!is_numeric($bill)) ? $i + 1 : $i;
		
		if (is_numeric($bill)):
		
		    $lineItem = [
		                 'des' => "PAYBILL NUMBER ".$data['number'],
            		     'qty' => null,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $bill,
            		     'typ' => 'account'
            		    ];
		
		    $payable  = self::transaction('item')->setHandler($db)->create($lineItem);
			
			$i = (!is_numeric($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable)):
			
			self::transaction('ledger')->setHandler($db)->create(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $payable]);
			
    			if (!empty($data['line item'])):
    			
    			     foreach ($data['line item'] as $key => $value):
    			         
    			         if (empty($value['id'])): continue; endif;
    			         
    			         $price    = str_replace(',','',$value['price']);
    			         
    			         $quantity = str_replace(',','',$value['qty']);
    			         
    			         $amount   = round($price*$quantity,2);
    			         
    			         $account  = self::transaction('ledger')->setHandler($db)->pullID($value['id']);
    			         			         
    			         $lineItem = [
            		                  'des' => strtoupper($value['description']),    // description
                        		      'qty' => null,                                 // quantity
                        		      'prc' => $value['price-integer'],              // price
                        		      'amo' => $amount,                              // amount
                        		      'coa' => $account,                             // coa account
                        		      'lid' => $bill,                                // last bill id
                        		      'pos' => $value['position'],                   // position
                        		      'typ' => 'item',                               // type of line item
                        		      'pay' => $value['id']
                        		     ];
                        		     
                     $item   = self::transaction('item')->create($lineItem);
                     
                     $reduce = self::transaction('header')->setHandler($db)->paid('invoice',$value['id'],$amount);
    
    			     $i = (!is_numeric($item) || !$reduce) ? $i + 1 : $i;
    			     
    			         if (is_numeric($item) && $reduce): 
    			         
    			         self::transaction('ledger')->create(['coaID' => $account, 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
    			         
    			         endif;
    			     
    			     endforeach;
			     
			     endif;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$bill);

		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:

		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}
	
	public function paybill_update($data) {
								
		$i   = 0;
		
		$db  = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()]; 
		
		$db ['insert']->transactionStart();
		
		$db ['update']->transactionStart();
		
		$db ['delete']->transactionStart();
		
		$item = self::transaction('item')->setHandler($db)->all($data['transaction-pid'],'item');

		$data['deleted-line-item'] = null;
		
		if (!empty($data['line item'])):
    			
		     foreach ($data['line item'] as $key => $value):
		          
		          if (!empty($value['item-pid'])):
		          
		          $forbiddenID [] = $value['item-pid'];
		          
		          endif;
		     
		     endforeach;
    			     
        endif;

		if (!empty($item)):
    			
		      foreach ($item as $key => $value):
		          
		          $prim = $value['CAP_ACC_TRA_ITE_ID'];
		          
		          if (@!in_array($prim, $forbiddenID)):

		          $item = self::transaction('item')->isExist($data['transaction-pid'],'item',$prim);
		          		          
    		          if (is_numeric($item) && !empty($item)):
    		              		              
    		          $data['deleted-line-item'][] = $item;
    		                  		          
    		          endif;
		          
		          endif;
		      
		      endforeach;
        
        endif;
        
        $line = @array_unique($data['deleted-line-item']);
            			     
		if (!empty($line)):

			$result = self::transaction('item')->setHandler($db)->purge($line);

			$i = (!$result) ? $i + 1 : $i;

		endif;
				
		$total = self::calculateStandardLineItem($data['line item']);
								
		$bill  = self::transaction('header')->setHandler($db)->update('pay bill',$data,$total);
		
		$i = (!$bill) ? $i + 1 : $i;
		
		if ($bill):
		    
		    $bill  = self::transaction('item')->setHandler($db)->isExist($data['transaction-pid'],'account');
		    
		    $lineItem = [
		                 'des' => "PAYBILL NUMBER ".$data['number'], 
            		     'qty' => null,
            		     'prc' => $total,
            		     'amo' => $total,
            		     'coa' => $data['account'],
            		     'lid' => $data['transaction-pid'],
            		     'typ' => 'account',
            		     'pid' => $bill
            		    ];
		                
            $payable = (is_numeric($bill)) ? self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);

			$i = (!is_numeric($payable) || empty($payable)) ? $i + 1 : $i;
			
			if (is_numeric($payable) && !empty($payable)):
			
			self::transaction('ledger')->setHandler($db)->update(['coaID' => $data['account'], 'debit' => null, 'credit' => $total, 'itemID' => $bill]);

    			if (!empty($data['line item'])):
    			
    			     foreach ($data['line item'] as $key => $value):

    			         if (empty($value['id'])): continue; endif;
    			         
    			         $price    = str_replace(',','',$value['price']);
    			         
    			         $quantity = str_replace(',','',$value['qty']);
    			         
    			         $amount   = round($price*$quantity,2);
    			         
    			         $account  = self::transaction('ledger')->setHandler($db)->pullID($value['id']);
    			         
    			         $item     = self::transaction('item')->isExist($data['transaction-pid'],'item',$value['item-pid']);
    			         			         
    			         $lineItem = [
            		                  'des' => strtoupper($value['description']),    // description
                        		      'qty' => null,                                 // quantity
                        		      'prc' => $value['price-integer'],              // price
                        		      'amo' => $amount,                              // amount
                        		      'coa' => $account,                             // coa account
                        		      'lid' => $data['transaction-pid'],             // last bill id
                        		      'pos' => $value['position'],                   // position
                        		      'typ' => 'item',                               // type of line item
                        		      'pay' => $value['id'],
                        		      'pid' => $item
                        		     ];
                        
                        $item = (is_numeric($item) && !empty($value['item-pid'])) ? 
                        
                        self::transaction('item')->update($lineItem) : self::transaction('item')->create($lineItem);
                    
                        $i = (!is_numeric($item)) ? $i + 1 : $i;
                    
                        if (is_numeric($item)): 
                        
                        	 if (is_numeric($item) && !empty($value['item-pid'])): 
                        
                        		 self::transaction('ledger')->update(['coaID' => $account, 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                        
                        	 else:
                        
                        		 self::transaction('ledger')->create(['coaID' => $account, 'debit' => $amount, 'credit' => null, 'itemID' => $item]);
                        
                        	 endif;
                        	 
                        endif;
                        		         			     
    			     endforeach;
			     
			     endif;
			
			endif;
			
        endif;
		
		$balance = self::check('transaction')->balance();

        if ($i == 0 && $balance):

		$db ['insert']->transactionSuccess();
		
		$db ['update']->transactionSuccess();
		
		$db ['delete']->transactionSuccess();
		
		$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['transaction-pid']);
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "id" => $crypt));
		
		else:
		
		$db ['insert']->transactionFailed();
		
		$db ['update']->transactionFailed();
		
		$db ['delete']->transactionFailed();
		
		echo json_encode(array("response" => "error", "token" => $_SESSION['xss']));
		
		endif;			
				
	}

	public function discountCalculation($amount,$discountrate) {
				
		$amountAfterDiscount = round($amount * ((100-$discountrate) / 100),2);
		
		return round($amount-$amountAfterDiscount,2);
		
	}
	
	public function createPosting($data) {
		
		$insert = new insert();
		
		$insert->transactionStart();
		
		$insert->tableName   = "CAP_ACCOUNTING_COA_POSTING";
		
		$insert->dateColumn  = ["CAP_ACC_COA_POS_DATECREATED"];
		
		$insert->whereClause = "CAP_ACC_COA_POS_ID";
		
		$insert->column = [
		
						  "FK_CAP_ACC_COA_ID" 	  => $data['coaID'],
						  "CAP_ACC_COA_POS_DB"    => $data['debit'],
						  "CAP_ACC_COA_POS_CR"    => $data['credit'],
						  "FK_CAP_ACC_TRA_ITE_ID" => $data['itemID'],
						  "CAP_ACC_COA_POS_DATECREATED" => date("Y-m-d H:i:s")
		
						  ];
						  
		$lastID = @$insert->execute();
		
		if (is_numeric($lastID) && !empty($lastID)):
			
			$insert->transactionSuccess();
			
			return true;
		
		else:
			
			$insert->transactionFailed();
			
			return false;
		
		endif;
		
	}
	
	public function updatePosting($data) {
		
		$update = new update();
		
		$update->transactionStart();
		
		$update->tableName   = "CAP_ACCOUNTING_COA_POSTING";
		
		$update->dateColumn  = ["CAP_ACC_COA_POS_DATEUPDATED"];
		
		$update->whereClause = [["FK_CAP_ACC_TRA_ITE_ID","",$data['itemID']]];
		
		$update->column = [
		
						  "FK_CAP_ACC_COA_ID" 	  => $data['coaID'],
						  "CAP_ACC_COA_POS_DB"    => $data['debit'],
						  "CAP_ACC_COA_POS_CR"    => $data['credit'],
						  "CAP_ACC_COA_POS_DATEUPDATED" => date("Y-m-d H:i:s")
		
						  ];
						  
		$lastID = $update->execute();
		
		if (is_resource($lastID) && !empty($lastID)):
			
			$update->transactionSuccess();
			
			return true;
		
		else:
			
			$update->transactionFailed();
			
			return false;
		
		endif;
		
	}
	
	public function setUserAccount(){
		$insert = new insert("","","","","");
		$insert->execute();
	}
	
	public function createUserAccount($data){
	
		$user	= unserialize($_SESSION['user']);
		$id 	= $user->getID();	
		$insert = new insert("","","","","");
		
		
		$insert->column 	= array(
							"cap_acc_serkey"=>$data[2],
							"cap_acc_phone"=>$data[3],
							"fk_cap_use_id"=>$id,
							"fk_cap_cou_id"=>101							) ;
		$insert->tableName 	= "cap_accounting_user"; 
		$insert->execute();
		echo $insert->query;
		$insert->column = array(
							"fk_cap_acc_use_id"=>$id,
							"cap_acc_use_acc_name"=>$data[2]							) ;
							$insert->tableName 	= "cap_accounting_user_account";
							$insert->execute();
		
	}
	
	public function getDecimalLength($number) {
		
	$length = strlen(substr(strrchr($number, "."), 1));
		
		if (empty($length)):
		
		return 2;
		
		else:
		
		return $length;
		
		endif;
				
	}
	
	public function bankerRound($x) {
		
		if ((floor($x*1000)-(10*floor($x*100))) > 4):
		
		  return ((floor($x*100)+1)/100); 
				
		else:
		
		  return (floor($x*100)/100); 
		
		endif;
		
	}
	
	public function calculateStandardLineItem($item) {
    	
    	if (!empty($item)):
				
			foreach ($item as $key => $value):
			
			$price = str_replace(',','',$value['price']);
			
			$qty   = str_replace(',','',$value['qty']);
			
				if (!empty($value['id'])):
				
				$total += round($price*$qty,2);
				
				elseif (!empty($value['account'])):
				
				$total += round($price*$qty,2);
				
				endif;
			
			$log  = PHP_EOL . 'price: ' . $price . PHP_EOL;
				
			$log .= 'qty: ' . $qty . PHP_EOL;
			
			$log .= 'total: ' . round($price*$qty,2) . PHP_EOL;
			
			//log::setLog('event',$log,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			
			endforeach;
			
		endif;
		
    return $total;
    	
	}
	
}

?>