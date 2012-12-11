<?php

namespace library\capsule\contact\mvc;

use \framework\capsule;
use \framework\validation;
use \framework\encryption;
use \framework\database\oracle\select;

class model extends capsule {

protected $data;

    public function __construct () {
	
		parent::__construct(
		
		"Text",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/contacts/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/contacts/js/share.js' type='text/javascript'></script>"
	
		);
			
	}
	
	public function sendMessage($message,$init) {
	
	$option = encryption::base64Decoding($init);
	
	$email  = $option[1]['Email Destination'];
		
	//$result = array_unique(self::validate($message));
	
	$result = array_unique($message);
	
		//if ($result[0] != 1) {
		//echo json_encode($result); die;
		//}	
	
	$to 	 = $email;
	$subject = "Message From: ".$message[0];
	$content = $message[3];
	$from 	 = $message[1];
	$headers = "From:" . $from;
	
	mail($to,$subject,$content,$headers);
					
	}
	
	public function validate($message) {
	
	$error = array(); $validator = new validation();
		
		//Check whether name is set
		if ($validator->setData($message[0])->is_empty()) {
		array_push($error, 'name');
		}
		
		//Check whether email is set
		if ($validator->setData($message[1])->is_empty()) {
		array_push($error, 'email');
		}
		
		//Check whether telephone is set
		if ($validator->setData($message[2])->is_empty()) {
		array_push($error, 'telephone');
		}
		
		//Check whether the email format is right
		if (!$validator->setData($message[1])->email()) {
		array_push($error, 'email');
		}
		
		//Check whether the telephone number exceeding 12 character
		if (!$validator->setData($message[2])->setSizeLimit(12)->size()) {
		array_push($error, 'telephone');
		}
		
		//If there is nothing wrong, flag the variable to true/1
		if (empty($error)) {
		array_push($error, 1);
		}
	
	return $error;
	
	}

}

?>