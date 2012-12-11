<?php

namespace library\capsule\accounting;

use \library\capsule\accounting\mvc\model;
use \library\capsule\accounting\mvc\view;
use \library\capsule\accounting\mvc\controller;

class accounting {
    
   	public static function init($params = null) {
    return new view($params);
   	}
   	
   	//Coa controller start here
   	
   	public static function form_createCoa($params) {
	return new view($params);
   	}
   	
   	public static function form_updateCoa($params,$data) {
	return new view($params,$data);
   	}
   	
   	public static function form_deleteCoa($params) {
	return new view($params);
   	}
   	
   	public static function table_coa($params) {
	return new view($params);
   	}
   	
   	public static function createCoa($params) {
	return model::createCoa($params);
   	}
   	
   	public static function updateCoa($params) {
	return model::updateCoa($params);
   	}
   	
   	public static function deleteCoa($params) {
	return model::deleteCoa($params);
   	}
   	
   	//Item controller start here
   	
   	public static function form_createItem($params) {
	return new view($params);
   	}
   	
   	public static function form_updateItem($params,$data) {
	return new view($params,$data);
   	}
   	
   	public static function form_deleteItem($params) {
	return new view($params);
   	}
   	
   	public static function table_item($params) {
	return new view($params);
   	}
   	
   	public static function createItem($params) {
	return model::createItem($params);
   	}
   	
   	public static function updateItem($params) {
	return model::updateItem($params);
   	}
   	
   	public static function deleteItem($params) {
	return model::deleteItem($params);
   	}
  	
  	public static function form_user_accountAdd($params) {
	return model::createUserAccount($params);
   	}
   	
   	//Transaction controller start here
   	
   	public static function transaction_table($params) {
	return new view(str_replace('#','',str_replace('-','_',$params)));
   	}
   	
   	public static function invoice_create($params) {
	return model::invoice_create($params);
   	}
   	
   	public static function invoice_update($params) {
	return model::invoice_update($params);
   	}
   	
   	public static function bill_create($params) {
	return model::bill_create($params);
   	}
   	
   	public static function bill_update($params) {
	return model::bill_update($params);
   	}
   	
   	public static function salesreceipt_create($params) {
	return model::salesreceipt_create($params);
   	}
   	
   	public static function salesreceipt_update($params) {
	return model::salesreceipt_update($params);
   	}
   	
   	public static function receipt_create($params) {
	return model::receipt_create($params);
   	}
   	
   	public static function receipt_update($params) {
	return model::receipt_update($params);
   	}
   	
   	public static function transfer_create($params) {
	return model::transfer_create($params);
   	}
   	
   	public static function transfer_update($params) {
	return model::transfer_update($params);
   	}
   	
   	public static function payment_create($params) {
	return model::payment_create($params);
   	}
   	
   	public static function payment_update($params) {
	return model::payment_update($params);
   	}
   	
   	public static function paybill_create($params) {
	return model::paybill_create($params);
   	}
   	
   	public static function paybill_update($params) {
	return model::paybill_update($params);
   	}
   	
}


?>
