<?php

namespace library\capsule\register\mvc;

use \framework\capsule;
use \framework\token;
use \framework\validation;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;

class model extends capsule {

protected $data;

    public function __construct () {
	
		parent::__construct(
		
		"Register",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/share/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/share/js/share.js' type='text/javascript'></script>"
	
		);
			
	}
	
	public function setParams($param, $value) {
	
	$this->$param = $value; return $this;
	
	}
	
	public function getCountryList() {
	
	$select = new select("*","CAP_COUNTRY","","",""); $select->execute(); return $select->arrayResult;
	
	}
	
	public function getCurrencyList() {
	
	$select = new select("*","CAP_CURRENCY","","",""); $select->execute(); return $select->arrayResult;
	
	}
	
	public function getLeverageList() {
	
	$select = new select("*","CAP_FOREX_LEVERAGE","","",""); $select->execute(); return $select->arrayResult;
	
	}
	
	public function processAccReg() {
				
		/*
		// Validation process of accounting registration member start here and
		// we are gonna check whether there is an error in the data submitted by user
		// and store the result into the $error variable as an array
		*/
		$validate = new validation();
		
		/*
		// csrf token checking
		// value must be same as last token
		*/
		$getToken = token::checkToken($this->data['CapsuleCSRFToken']);
		$error['csrf'] = $getToken != $this->data['CapsuleCSRFToken'] ?'You may be a victim of a CSRF attack' : null;
		
		/*
		// first name checking
		// value must not empty
		*/
		$error ['firstname'] = empty($this->data['firstname']) ? 'Firstname cannot be empty'  : null;
		
		/*
		// last name checking
		// value must not empty
		*/
		$error ['lastname'] = empty($this->data['lastname'])  ? 'Lastname cannot be empty'   : null;
		
		/*
		// email checking
		// must not empty and MX record had to be valid
		*/
		if (!empty($this->data['email'])):
			
			if (!$validate->setData($this->data['email'])->email($this->data['email'], TRUE)): $error ['email'] = "Email MX record is not valid"; endif;
		
		else:
		
		$error ['email'] = "Email cannot be empty";
		
		endif;
		
		/*
		// password checking
		// value must contain at least 6 character
		*/
		if (empty($this->data['password'])):

			$error ['password'] = "Password cannot be empty";

		elseif (strlen($this->data['password']) < 6):

			$error ['password'] = "Password at least 6 character";

		endif;							   
		
		/*
		// phone number checking
		// value must contain number only
		*/
		if (empty($this->data['phone'])):

			$error ['phone'] = "Phone cannot be empty";

		elseif (preg_match('/[^0-9]/', $this->data['phone'])):

			$error ['phone'] = "Phone can only contain number 0-9";
		
		elseif (strlen($this->data['phone']) < 6):

			$error ['phone'] = "Phone minimum value is 6 digit";
			
		elseif (strlen($this->data['phone']) > 15):

			$error ['phone'] = "Phone maximum value is 15 digit";

		endif;
		
		/*
		// country checking
		// value must not empty
		*/
		$error ['country']	 = empty($this->data['country']) ? 'Country cannot be empty' : null;
		
		/*
		// 'array_filter' will remove all array key that has an empty value
		*/
		$error = array_filter($error); 

		$_SESSION['accounting_register_error'] = !empty($error) ? $error : null;
		
		/*
		// We are going to store the user last input value here
		// the purpose for this method is to make the last input value
		// still available to the user, so they don't have to do it all over again
		*/
		$value ['firstname'] = !empty($this->data['firstname']) ? $this->data['firstname'] : null;
		$value ['lastname']  = !empty($this->data['lastname'])  ? $this->data['lastname']  : null;
		$value ['email']	 = !empty($this->data['email']) 	? $this->data['email'] 	   : null;
		$value ['password']	 = !empty($this->data['password'])  ? $this->data['password']  : null;
		$value ['phone']	 = !empty($this->data['phone']) 	? $this->data['phone'] 	   : null;
		$value ['country']	 = !empty($this->data['country'])   ? $this->data['country']   : null;
		
		/*
		// 'array_filter' will remove all array key that has an empty value
		*/
		$value = array_filter($value); 
		
		$_SESSION['accounting_register_value'] = !empty($value) ? $value : null;
		
		/*
		// We are not going to do data insertion process to the database
		// if the $error variable still contain some value!
		*/

		if (!empty($_SESSION['accounting_register_error'])): return false; endif;
		
		/*
		// let's start building the neccesary array for the database input
		// we'll be creating a new insert object
		*/
		$insert = new insert();
		
		/*
		// we'll be creating new select object and start
		// checking for the accounting role id
		*/
		$select = new select("*","CAP_USER_ROLE",[['UPPER(CAP_USE_ROL_NAME)','=','ACCOUNTING']]);
		
		$select->execute();
				
		$roleID = $select->arrayResult[0]['CAP_USE_ROL_ID'];
		
		/*
		// now we'll be setting up the first batch for cap_user table
		*/
		$insert->tableName = 'CAP_USER';
		
		$insert->column    = ['CAP_USE_FIRSTNAME'   => $value ['firstname'],
						   	  'CAP_USE_LASTNAME' 	=> $value ['lastname'],
						      'CAP_USE_EMAIL' 	  	=> $value ['email'],
						      'CAP_USE_USERNAME' 	=> $value ['email'],
						      'CAP_USE_PASSWORD' 	=> sha1($value ['password']),
						      'CAP_USE_STATUS' 	  	=> 'Active',
						      'CAP_USE_ROLE' 		=> $roleID,
						      'CAP_USE_DATECREATED' => date('Y-m-d H:i:s')];
		
		$insert->whereClause = 'CAP_USE_ID';
		
		$insert->dateColumn  = ['CAP_USER_DATECREATED'];
		
		$lastID = @$insert->execute();
				
		if (!is_numeric($lastID)):
		
		$_SESSION['accounting_register_error']['query-failed'] = 'Cannot process registration. Please try later.';

		return false;
				
		endif;
		
		/*
		// if the last insert is a success we're going to continue
		// preparing the second batch of cap_user_accounting
		// this part is also checking for the possible user web service key
		// it will first try combining firstname and lastname as original key
		// if there is already that kind of key, then it will generate random number
		// at the end of the original key until it find an empty 'spot'
		*/
		$originalKey		 = strtolower($value ['firstname']).'.'.strtolower($value ['lastname']);
		
		$select->tableName   = 'CAP_ACCOUNTING_USER';
		
		$select->whereClause = [['CAP_ACC_SERKEY','=',$originalKey]];
		
		$select->execute();
		
		if (!empty($select->arrayResult)):
		
		$loop = false;
		
			while (!$loop):
			
			$addonKey = rand(0,9);
			
			$select->whereClause = [['CAP_ACC_SERKEY','=',$originalKey.$addonKey]];
			
			$select->execute();
			
				if (empty($select->arrayResult)):
				
				$loop = true;
				
				$serviceKey = $originalKey.$addonKey;
				
				endif;
			
			endwhile;
		
		else:
		
		$serviceKey = $originalKey;
		
		endif;
		
		$insert->tableName = 'CAP_ACCOUNTING_USER';
		
		$insert->column    = ['CAP_ACC_PHONE'   => $value ['phone'],
						   	  'CAP_ACC_SERKEY' 	=> $serviceKey,
						      'FK_CAP_COU_ID' 	=> $value ['country'],
						      'FK_CAP_USE_ID'	=> $lastID];
		
		$insert->whereClause = null;
		
		$lastAccID = @$insert->execute();
		
		$select->tableName   = 'CAP_ACCOUNTING_USER';
		
		$select->whereClause = [['FK_CAP_USE_ID','=',$lastID]];
		
		$select->execute();
		
		if (empty($select->arrayResult)):
		
		$_SESSION['accounting_register_error']['query-failed'] = 'Cannot process registration. Please try later.';
		
		$delete = new delete("","CAP_USER",[['CAP_USE_ID','=',$lastID]]);
		
		$delete->execute();
		
		return false;
		
		endif;
		
		/*
		// if the data insertion is a success we delete our last input data
		// so the front end form will be back to it's original state, empty.
		*/
		unset($_SESSION['accounting_register_value']);
		
	}
	
}

?>