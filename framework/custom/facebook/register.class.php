<?php

namespace framework\custom\facebook;

use \framework\mail;
use \framework\server;
use \framework\generator;
use \framework\encryption;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;

class register {

public $appID 	   = "193808020175";
public $appSecret  = "8ac2f34eeff6ab417f7615a4b27fcc8f";
public $landingUrl = "http://4bwp.localtunnel.com/sega/";
public $siteUrl    = "http://4bwp.localtunnel.com/sega/framework/custom/facebook/authorize.class.php";
public $code,$dialogUrl,$fbUser,$data,$role;
	
	public function __construct($code) {
	$this->code = $code; if (empty($this->code)) {$this->createCSRFProtection();} else {$this->checkState();}
	}
	
	public function createCSRFProtection() {
	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); $this->oAuth();
	}
	
	public function oAuth() {
	$this->dialogUrl = "https://www.facebook.com/dialog/oauth?client_id=" . $this->appID . "&redirect_uri=" . urlencode($this->siteUrl) . "&state=" . $_SESSION['state']; $this->checkState();
	}
	
	public function checkState() {
	if($_REQUEST['state'] == $_SESSION['state']) {$this->getFacebookUserData();} else {$this->returnError();}
	}
	
	public function getFacebookUserData() {
	$token_url 		= "https://graph.facebook.com/oauth/access_token?"."client_id=".$this->appID."&redirect_uri=".urlencode($this->siteUrl)."&client_secret=".$this->appSecret."&code=".$this->code;
   	$response 		= file_get_contents($token_url); $params = null; parse_str($response, $params);
   	$graph_url 		= "https://graph.facebook.com/me?access_token=".$params['access_token']."";
   	$this->fbUser 	= json_decode(file_get_contents($graph_url)); $this->matchUserWithDatabaseRecord();
    }
    
    public function matchUserWithDatabaseRecord() {
    $fbUser = $this->fbUser;
	$select = new select("*","CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID WHERE CAP_USE_ID_FACEBOOK = '$fbUser->id'","","","");
	$select->selectSingleTable();
	$this->data = $select->arrayResult;
		if (empty($this->data)) {
		$this->registerNewUser();
		} 
		else {
		server::setUserSession($this->data);
		$this->role = $select->arrayResult[0]['CAP_USE_ROL_ID'];
		$this->returnToLandingPage();
		}
	}
	
	public function registerNewUser() {
	$fbUser = $this->fbUser; $select = new select("*","CAP_USER_ROLE WHERE CAP_USE_ROL_NAME = 'member'","","",""); $select->selectSingleTable(); $roleID = $select->arrayResult[0]['CAP_USE_ROL_ID'];
	$pass	= generator::password(); $encryption = encryption::sha1Encoding($pass);
	$data	= array(
			  "CAP_USE_FIRSTNAME" 	=> $fbUser->first_name,
			  "CAP_USE_LASTNAME" 	=> $fbUser->last_name,
			  "CAP_USE_EMAIL" 		=> $fbUser->email,
			  "CAP_USE_USERNAME" 	=> $fbUser->email,
			  "CAP_USE_PASSWORD" 	=> $encryption,
			  "CAP_USE_IMAGE" 		=> null,
			  "CAP_USE_STATUS" 		=> 'active',
			  "CAP_USE_ROLE"	 	=> $roleID,
			  "CAP_USE_ID_FACEBOOK" => $fbUser->id
			  );
	$insert = new insert($data,"CAP_USER","","","");
		if ($insert->insertMultipleRowWhereID() == NULL) {
		$select = new select("*","CAP_USER","","",""); $select->columnMaxID = "CAP_USE_ID"; $lastID = $select->returnMaxIDFromTable();
		$selectCheck = new select("*","CAP_FOREX_TYPE_USER WHERE CAP_FOR_TYP_USE_NAME = 'member'","","",""); $selectCheck->selectSingleTable(); $idMember = $selectCheck->arrayResult[0]['CAP_FOR_TYP_USE_ID'];
		$data 	= array("FK_CAP_USE_ID" => $lastID, "FK_CAP_FOR_TYP_USE_ID" => $idMember, "CAP_FOR_USE_AFFILIATE" => encryption::sha1Encoding("ShegaAffiliationID".$lastID));
		$insertForex = new insert($data,"CAP_FOREX_USER","","","");

		$select = new select("*","CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID WHERE CAP_USE_ID_FACEBOOK = '$fbUser->id'","","","");
		$select->selectSingleTable(); $this->role = $select->arrayResult[0]['CAP_USE_ROL_ID'];
		
			if ($insertForex->insertMultipleRowWhereID() == NULL) {
			$mail = new mail($fbUser->email,'Your Shegaforex Password',$pass,'shegaforex.com'); $mail->send();
			$this->returnToLandingPage();
			}
			
		}
		else {
		$this->returnDataEntryError();
		}
	}
	
	public function returnToLandingPage() {
	$fbUser = $this->fbUser;
	$data 	= array('id'=>$fbUser->id,'name'=>$fbUser->name,'email'=>$fbUser->email,'img'=>"<img src='https://graph.facebook.com/$fbUser->id/picture'>", 'role' => $this->role, 'loginType' => 'facebook');
	$user 	= unserialize($_SESSION['user']);
	$user->putData($data)->putProfile()->emptyData(); 
	$_SESSION['user'] = serialize($user);
	$_SESSION['role'] = $this->role;
	header('Location: http://4bwp.localtunnel.com/sega/');
	}
	
	public function returnError() {
	echo("The state does not match. You may be a victim of CSRF.");
	session_destroy();
	}
	
	public function returnDataEntryError() {
	echo("We are sorry. We cannot process your registration at this time.");
	}

}


?>