<?php

//Declaring namespace
namespace library\capsule\search;

//Including Global Configuration
include_once('../../../config.php');

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

//Starting Session
session_start();

switch($_POST[control]) {

	case "getSearchResult":
	search::getSearchResult($_POST[text]);
	break;

	default:
	echo "no available controller";
	break;

}
