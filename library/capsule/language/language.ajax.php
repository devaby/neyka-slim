<?php

//Declaring namespace
namespace library\capsule\language;

//Starting Session
session_start();

switch($_POST[control]) {

	case "setDefaultLanguage":
	$_SESSION['language'] = $_POST[id];
	break;
	
	default:
	echo "no available controller";
	break;

}

?>