<?php

namespace library\capsule\user\mvc;

use \framework\user;

if ($_GET['logout'] == true) {session_destroy(); header('location:index.php');}

class view extends model {

protected $params;

    public function __construct($params) {
    
    parent::__construct();
    
    	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    	$this->optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
   	 	}
        
    $this->params = $params; if ($this->params == '{view}') {self::normal();} else {self::$params();}
        
    }
    
    public function normal() {
    
    $view  = "asa";
    
    $view .= $this->optionGear;
        
    echo $view;
    
	}
	
	
	public function integrasi() {
    
    //$insertData = model::integrasiData();
            $view  = "asa";
    
    $view .= $this->optionGear;
      
    echo $view;
    
	}
	
	public function image() {
		
	$user  = unserialize($_SESSION['user']); $id = $user->getID(); $type = $user->getLoginType();
	
	$view  = $this->optionGear;
	
	if (empty($id)) {$view .= "<img class='user-image-normal-round' src='view/pages/".DEFAULT_TEMPLATE."/images/user.png'>"; echo $view; return false;} if ($type != 'internal') {$img = $user->getID();} else {$img = $user->getImage();}
	
	$view .= "<img class='user-image-normal' src='https://graph.facebook.com/" . $img . "/picture'>";
	
	echo $view;
	
	}
	
	public function name() {
		
	$user  = unserialize($_SESSION['user']); 
	$id    = $user->getID();
	$name  = $user->getName();
	$hook  = $user->getHook();
	$view  = $this->optionGear;
		
		if (empty($id) && $name == 'guest'):
			
			$view = "
			<div class='pull-right btn-group'>
			<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#'><i class='icon-user icon-white'></i> ".ucwords($user->getName())."  <span class='caret'></span></a>
			<ul class='dropdown-menu'>
			   
				<li><a href='?id=admin'>Login</a></li>
				<li><a href='?id=3761'>Registration</a></li>
				
			</ul>
			</div>";
			/*
			$view = "
			<div class='pull-right btn-group'>
			<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#'><i class='icon-user icon-white'></i> ".ucwords($user->getName())."  <span class='caret'></span></a>
			<ul class='dropdown-menu'>
			   
				<li><a href='?id=admin'>Login</a></li>
				<li><a href='?id=3761'>Registration</a></li>
				<<li><a href='#'>Edit Profile</a></li>
				<li><a href='#'>Task <span class='badge badge-info'>30</span></a></li>
				<li><a href='#'>Messages <span class='badge badge-info'>2</span></a></li>
				<li class='divider'></li>
				<li><a href='#'>My Finance</a></li>
				<li class='divider'></li>
				<li><a href='index.php?id=logout'>Sign out</a></li>
			</ul>
			</div>";
			/*
			$view  = "<div>
					  <img class='user-image-normal-round' src='view/pages/".DEFAULT_TEMPLATE."/images/user.png'>
					  <span login='no'>" . ucwords($user->getName()) . "</span>
					  <span>|</span>
					  <span><a href='index.php?id=logout'>Logout</a></span></div>";
					*/		
		else:
		
		$check = $this->id = $id; $check = $this->checkUser();  $result = $check['CAP_USE_ROL_NAME'];
		
			foreach($this->getRole($result) as $value):
				
				$view = "
			<div class='pull-right btn-group'>
			<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#' SSID='".$user->getID()."'>".ucwords($user->getName())." <span class='caret'></span></a>
			<ul class='dropdown-menu'>
			
				<li><a href='#'>Edit Profile</a></li>
				<li><a href='#'>Task <span class='badge badge-info'>30</span></a></li>
				<li><a href='#'>Messages <span class='badge badge-info'>2</span></a></li>
				<li class='divider'></li>
				<li><a href='#'>My Finance</a></li>
				<li class='divider'></li>
				<li><a href='index.php?id=logout'>Sign out</a></li>
			</ul>
			</div>";
				/*
				$view .= "<div>
						  <img class='user-image-normal' src='https://graph.facebook.com/" . $img . "/picture'>
						  <span login='yes'  SSID='".$user->getID()."'>" . ucwords($user->getName()) . "</span>
						  <!--<span class='user-name-separator'>|</span>
						  <span><a href='index.php?id=".$value['FK_CAP_MEN_ID']."'>My Account</a></span>-->
						  <span class='user-name-separator'>|</span>
						  <span><a href='index.php?id=logout'>Logout</a></span></div>";
						  */
			endforeach;
		
		endif;

	echo $view;
	
	}
	    
}

?>
