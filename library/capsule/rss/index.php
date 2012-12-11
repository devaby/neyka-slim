<?php

//Declaring Namespace
namespace framework;

//Starting Session
session_start();

//Fill this If Your App Is In Sub Folder
define("APP","/sega/");

//Setting Application Absolute Path
define("ROOT_PATH",$_SERVER['DOCUMENT_ROOT'] . APP);

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
neyka::start();

?>

