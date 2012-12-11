<?php

namespace framework;

define("APP","/pertanian/");

define("ROOT_PATH","/var/www" . APP);

include("/var/www/pertanian/framework/autoload.class.php");
include("/var/www/pertanian/framework/user.class.php");

use \library\capsule\core\crontab\jobStatus\jobStatusLogic;

session_start(); autoload::init();

	//for ($i = 0; $i < 30; $i++) {

		jobStatusLogic::execute();
		
		//sleep(10);
		
	//}

?>