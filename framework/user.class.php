<?php

namespace framework;

use \framework\database\oracle\select;

class user {

protected $data;
protected $profile = array();
protected $hook    = array();
protected $action  = array();

	public function init() {
	
		if (!isset($_SESSION['user'])):
		
			$_SESSION['user'] = serialize(new user());
		
		endif;
		
		$user = self::getUser(); $id = $user->getID();

		if (empty($id)):
			
			$select = new select("*","CAP_USER_ROLE",[["CAP_USE_ROL_NAME","=","guest"]]); $select->execute();
			
			$data 	= array(
						  'id'		  => null,
						  'name'	  => 'guest',
						  'email'	  => null,
						  'img'		  => $img, 
						  'role' 	  => $select->arrayResult[0]['CAP_USE_ROL_ID'], 
						  'loginType' =>'internal'
						  );
				
			$user->putData($data)->putProfile()->emptyData();
			
			$_SESSION['user'] = serialize($user);
			
		endif;
		
	}
	
	public function getUser() {
		
		return unserialize($_SESSION['user']);
		
	}
	
	public function putData($data) {
	$this->data = $data;
	return $this;
	}
	
	public function putProfile() {
	$this->profile = $this->data;
	return $this;
	}
	
	public function putHook() {
	$this->hook = $this->data;
	return $this;
	}
	
	public function emptyData() {
	$this->data = '';
	return $this;
	}
	
	public function getProfile() {
	return $this->profile;
	}
	
	public function getID() {
	return $this->profile['id'];
	}
	
	public function getName() {
	return $this->profile['name'];
	}
	
	public function getSiteID() {
	return $this->profile['siteid'];
	}
	
	public function getPersonalSiteID() {
	return $this->profile['privatesiteid'];
	}
	
	public function getEmail() {
	return $this->profile['email'];
	}
	
	public function getLoginType() {
	return $this->profile['loginType'];
	}
	
	public function getImage() {
	return $this->profile['img'];
	}
	
	public function getRole() {
	return $this->profile['role'];
	}
	
	public function getHook() {
	return $this->hook;
	}
	
	public function getSitesAdmin() {
	
	$select = new select('FK_CAP_MAI_ID','CAP_USER',[['CAP_USE_ID','=',self::getID()]]);
	
	$select->execute();
	
	return $select->arrayResult[0]['FK_CAP_MAI_ID'];
	
	}

}

?>