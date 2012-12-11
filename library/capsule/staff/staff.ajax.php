<?php

//Declaring namespace
namespace library\capsule\staff;

//Including Global Configuration
include_once('../../../config.php');

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
use \framework\token;
use \library\capsule\staff\lib\log;

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

//Starting Session
session_start();

$data     = $_POST['data']['data'];

$token    = $_POST['data']['capsuleCSRFToken'];

$control  = $_POST['data']['control'];

$getToken = token::checkToken($token);

$error    = ($getToken != $token) ? 'You may be a victim of a CSRF attack' : null;

if (!empty($error)): echo json_encode(array('response' => 'error', 'view' => 'You may be a victim of a CSRF attack')); log::logEvent('event',$error); return false; endif;

switch($control):
	
	/*
	* Default ajax response
	*/
	default:
	echo json_encode(array('response' => 'error', 'view' => 'no available controller'));
	break;
	
endswitch;

?>

