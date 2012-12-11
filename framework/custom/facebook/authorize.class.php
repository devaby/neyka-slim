<?php 

namespace framework;

define("APP","/sega/");

define("ROOT_PATH",$_SERVER['DOCUMENT_ROOT'] . APP);

include("../../autoload.class.php");
include("../../user.class.php");

session_start(); autoload::init();

use \framework\custom\facebook\register;

new register($_REQUEST["code"]);

?>