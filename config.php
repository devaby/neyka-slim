<?php

//Session Save path inside neyka
ini_set('session.save_path', '/srv/www/cornc/framework/public/session');

//PHP Error log set
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);

//Starting Session
session_start();

//Fill this If Your App Is In Sub Folder
define("APP","/cornc/");

//Database abstraction
define("DATABASE","postgres");

//Setting Application Absolute Path
define("ROOT_PATH","/srv/www" . APP);

//Database public object storage
define("PUBLIC_OBJECT",ROOT_PATH."framework/public/object/");

//Debug level
define("DEBUG",true);

//Enable php output buffering
define("BUFFERING",true);

//Set default date time
define("TIMEZONE",date_default_timezone_set("Asia/Jakarta"));


//newline
