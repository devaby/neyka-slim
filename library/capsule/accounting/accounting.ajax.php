<?php

//Declaring namespace
namespace library\capsule\accounting;

//Including Global Configuration
include_once('../../../config.php');

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
use \framework\token;
use \library\capsule\accounting\lib\log;

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

//Starting Session
session_start();

$data     = $_POST['data']['data'];

$token    = $_POST['data']['capsuleCSRFToken'];

$control  = $_POST['data']['control'];

$getToken = token::checkToken($token);

$error 	  = ($getToken != $token) ? 'You may be a victim of a CSRF attack' : null;

if (!empty($error)): echo json_encode(array("response" => "error", "view" => "You may be a victim of a CSRF attack")); log::logEvent('event',$error); return false; endif;

switch($control) {

	/*
	* Coa controller start here
	*
	* @selector tag a[href=#accounting-actionbar_item-coa]
	* @action show modal window
	* @function displayModal
	*/
	case "form_createCoa":
	accounting::form_createCoa($control);
	break;
	
	case "form_updateCoa":
	accounting::form_updateCoa($control,$data);
	break;
	
	case "form_deleteCoa":
	accounting::form_deleteCoa($control);
	break;
	
	case "createCoa":
	accounting::createCoa($data);
	break;
	
	case "updateCoa":
	accounting::updateCoa($data);
	break;
	
	case "deleteCoa":
	accounting::deleteCoa($data);
	break;
	
	case "table_coa":
	accounting::table_coa($control);
	break;
	
	/*
	* Item controller start here
	*
	* @selector tag a[href=#accounting-actionbar_item-coa]
	* @action show modal window
	* @function displayModal
	*/
	case "form_createItem":
	accounting::form_createItem($control);
	break;
	
	case "form_updateItem":
	accounting::form_updateItem($control,$data);
	break;
	
	case "form_deleteItem":
	accounting::form_deleteItem($control);
	break;
	
	case "createItem":
	accounting::createItem($data);
	break;
	
	case "updateItem":
	accounting::updateItem($data);
	break;
	
	case "deleteItem":
	accounting::deleteItem($data);
	break;
	
	case "table_item":
	accounting::table_item($control);
	break;
	
	case "form_user_accountAdd":
	accounting::form_user_accountAdd($data);
	break;
	
	/*
	* Transaction invoice controller start here
	*
	* @selector tag a[href=#accounting-actionbar_item-coa]
	* @action show modal window
	* @function displayModal
	*/
	case "transaction_table":
	accounting::transaction_table($data);
	break;
	
	case "invoice_create":
	accounting::invoice_create($data);
	break;
	
	case "invoice_update":
	accounting::invoice_update($data);
	break;
		
	case "bill_create":
	accounting::bill_create($data);
	break;
	
	case "bill_update":
	accounting::bill_update($data);
	break;
	
	case "salesreceipt_create":
	accounting::salesreceipt_create($data);
	break;
	
	case "salesreceipt_update":
	accounting::salesreceipt_update($data);
	break;
	
	case "receipt_create":
	accounting::receipt_create($data);
	break;
	
	case "receipt_update":
	accounting::receipt_update($data);
	break;
	
	case "transfer_create":
	accounting::transfer_create($data);
	break;
	
	case "transfer_update":
	accounting::transfer_update($data);
	break;
	
	case "payment_create":
	accounting::payment_create($data);
	break;
	
	case "payment_update":
	accounting::payment_update($data);
	break;
		
	case "paybill_create":
	accounting::paybill_create($data);
	break;
	
	case "paybill_update":
	accounting::paybill_update($data);
	break;
			
	
	default:
	echo json_encode(array("response" => "error", "view" => "no available controller"));
	break;

}

?>