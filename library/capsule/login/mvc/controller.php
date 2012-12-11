<?php

namespace library\capsule\login\mvc;

use \framework\user;
use \framework\capsule;
use \framework\server;

class controller {

protected $username;
protected $password;
protected $url;

	public function __construct($username,$password,$lastURL) {
	$this->username = $username; $this->password = $password; $this->url = $lastURL;
	}
	
	public function check() {
	
		if (!empty($this->username) || !empty($this->password)) {
		
		$user = new model($this->username,$this->password); $user = $user->check(); 
			
			if(!empty($user)) {

				if ($user[0]['CAP_USE_ROL_NAME'] == 'super administrator') {
				
					$mainID = $user[0]['FK_MAI_ID'];
					$personalSiteID = $user[0]['FK_CAP_MAI_ID_LOCATION'];
				$data 	= array(
						  'id'		  => $user[0]['CAP_USE_ID'],
						  'name'	  => $user[0]['CAP_USE_FIRSTNAME']." ".$user[0]['CAP_USE_LASTNAME'],
						  'email'	  => $user[0]['CAP_USE_EMAIL'],
						  'img'		  => $img, 
						  'role' 	  => $user[0]['CAP_USE_ROLE'], 
						  'loginType' =>'internal',
						  'siteid'	  => $mainID,
						  'privatesiteid' => $personalSiteID,
						  );
				
				$users 	= unserialize($_SESSION['user']);
				$users->putData($data)->putProfile()->emptyData(); 
				$_SESSION['user'] = serialize($users);
				server::setAdministratorSession($user);
				
				}
				else {
					
						$mainID = $user[0]['FK_MAI_ID'];
						
						$personalSiteID = $user[0]['FK_CAP_MAI_ID_LOCATION'];
						
					if (!empty($user[0]['CAP_USE_ID_FACEBOOK'])):
					
						$img = $user[0]['CAP_USE_ID_FACEBOOK'];
						
					else:
					
						$img = 1;
						
					endif;
				
				$data 	= array(
						  'id'		  => $user[0]['CAP_USE_ID'],
						  'name'	  => $user[0]['CAP_USE_FIRSTNAME']." ".$user[0]['CAP_USE_LASTNAME'],
						  'email'	  => $user[0]['CAP_USE_EMAIL'],
						  'img'		  => $img, 
						  'role' 	  => $user[0]['CAP_USE_ROLE'], 
						  'loginType' =>'internal',
						  'siteid'	  => $mainID,
						  'privatesiteid' => $personalSiteID,
						  );
						  
				$users 	= unserialize($_SESSION['user']);
				$users->putData($data)->putProfile()->emptyData(); 
				$_SESSION['user'] = serialize($users);
				server::setUserSession($user);
				
				}
			
			}
			else {
			
				if ($user[0][CAP_USE_ROL_NAME] == 'super administrator') {
				server::adminPage("");
				}
				else {
				//echo "location: ".server::returnBaseURL().$this->url;
				//return false;
				header("location: ?".$this->url);	
				}
			
			//server::adminPage("");
			//echo "location: ".server::returnBaseURL("").$this->url;
			//return false;
			//header("location: ".server::returnBaseURL().$this->url);
			}
			
		}
	
	}

}

?>
