<?php

//Declaring Namespace
namespace framework;

//Including Global Configuration
include_once('config.php');

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php';

//Gentlemen, Start Your Engine!
neyka::start();

?>