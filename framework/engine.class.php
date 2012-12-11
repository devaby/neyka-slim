<?php 

namespace framework;

use \framework\service\rssfeed;

class engine {

protected $type = array('rss','iphone','android');

	public static function init() {
	$engine = new self(); if (in_array($_GET["id"],$engine->type)) {self::$_GET["id"]();} else {self::html();}
	}
	
	public static function html() {
	$engine = new template(); pages::init($engine);
	}
	
	public static function rss() {
	return new rssfeed();
	}
	
	public static function iphone() {
	
	}
	
	public static function android() {
	
	}
	
}

?>