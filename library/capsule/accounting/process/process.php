<?php

namespace framework;

include('../../../../config.php');
include("../../../../framework/autoload.class.php");
include("../../../../framework/user.class.php");

session_start(); autoload::init();

	if (!empty($_POST['accounting-account-menu'])):
	
	$_SESSION['ACCOUNTING-ACCOUNT'] = base64_decode($_POST['accounting-account-menu']);
	
	endif;

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>