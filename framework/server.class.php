<?php

namespace framework;

class server {

	public function __construct() {
		$_SESSION['url'] = $_SERVER['REQUEST_URI'];
		$_SESSION['dir'] = $_SERVER['DOCUMENT_ROOT'];
		$_SESSION['ref'] = $_SERVER['HTTP_REFERER'];
	}
	
	protected function baseURL() {
		$currentPath 	= $_SERVER['PHP_SELF'];
		$hostName 		= $_SERVER['HTTP_HOST']; 
		$pathInfo 		= pathinfo($currentPath); 
		$protocol 		= strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
		return $protocol.$hostName.$pathInfo['dirname']."/";
	}
		
	protected function setSession($page) {

		if ($page == "super administrator") { 
		$_SESSION['name']  = $page[0]['CAP_USE_FIRSTNAME'];
		$_SESSION['role']  = $page[0]['CAP_USE_ROL_ID'];
		$_SESSION['roleName']  = $page[0]['CAP_USE_ROL_NAME'];
		print_r($_SESSION);
		return false;
		header("Location: " . self::baseURL());
		}
		else if ($page == "logout") {
		session_destroy();
		header("Location: " . self::baseURL());
		}
		
	}
	
	protected function setSessionAdministrator($page) {
	
		if (is_array($page)) {

		$_SESSION['admin'] 	   = "yes";
		$_SESSION['name']  	   = $page[0]['CAP_USE_FIRSTNAME'];
		$_SESSION['role']  	   = $page[0]['CAP_USE_ROL_ID'];
		$_SESSION['roleName']  = $page[0]['CAP_USE_ROL_NAME'];
		header("Location: " . self::baseURL());

		}
		
	}
	
	protected function setSessionUser($page) {
		
		if (is_array($page)) {

		$_SESSION['name']  	  = $page[0]['CAP_USE_FIRSTNAME'];
		$_SESSION['role']  	  = $page[0]['CAP_USE_ROL_ID'];
		$_SESSION['roleName'] = $page[0]['CAP_USE_ROL_NAME'];
		header("Location: ?id=". $page[0]['FK_CAP_MEN_ID']);

		}
		
	}

	protected function setSessionAdminMultiRole($page) {
		
		if (is_array($page)) {

		$_SESSION['admin'] 	  = $page[0];
		$_SESSION['role']  	  = $page[0];
		$_SESSION['roleName'] = $page[1];
		$_SESSION['roleset']  = true;
		header("Location: " . self::baseURL());
		
		}
		
	}

	protected function setSessionUserMultiRole($page) {
		
		if (is_array($page)) {

		$_SESSION['role']  	  = $page[0];
		$_SESSION['roleName'] = $page[1];
		$_SESSION['roleset']  = true;
		
		header("Location: ".strtolower(str_replace(' ','-',$page[1]))."/". $page[2]);
		
		}
		
	}
	
	protected function gotoAdminPage() {
	header("Location: " . self::baseURL() . "?id=admin");
	}
	
	protected function setLanguage($language) {
		$_SESSION['language'] = $language;
	}
	
	public function destroySession() {
		session_destroy();
	}
	
	public function sessionChecker($page) {
		self::setSession($page);
	}
	
	public function setAdministratorSession($page) {
		self::setSessionAdministrator($page);
	}
	
	public function setUserSession($page) {
		self::setSessionUser($page);
	}

	public function setAdminSessionMultiRole($page) {
		self::setSessionAdminMultiRole($page);
	}

	public function setUserSessionMultiRole($page) {
		self::setSessionUserMultiRole($page);
	}
	
	public function adminPage($page) {
		self::gotoAdminPage($page);
	}
	
	public function returnBaseURL() {
		return self::baseURL();
	}
	
	public function setDefaultLanguage($language) {
		self::setLanguage($language);
	}
	
	public function getDefaultlanguage() {
		return $_SESSION['language'];
	}
	
	public function scriptTime() { 
    	$a = explode (' ',microtime()); return(double) $a[0] + $a[1]; 
    } 
	
	public function init() {
		return new server();
	}
    
	public function getUserEmail() {
		return $_SESSION['email'];
	}
	
}

?>