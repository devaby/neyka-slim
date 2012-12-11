<?php 

namespace framework;

abstract class neyka {

	public static function start() {
	self::init();
	}
	
	public static function startAjax() {
	self::initAjax();
	}
	
	protected static function init() {
	self::initCore(); self::initPattern(); self::initServer(); self::initUser(); self::initToken(); self::initTemplate();
	}
	
	protected static function initAjax() {
	self::initCore(); self::initPattern(); self::initServer(); self::initUser(); self::initToken();
	}
	
	protected static function initCore() {
	include ROOT_PATH.'view/pages/main.info.php'; include ROOT_PATH.'framework/autoload.class.php'; autoload::init(); debugger::init();
	}
	
	protected static function initServer() {
	server::init();
	}
	
	protected static function initPattern() {
	pattern::init();
	}
	
	protected static function initUser() {
	user::init();
	}
	
	protected static function initTemplate() {
	engine::init();
	}
	
	protected static function initSites(){
	sites::init();
	}
	
	protected static function initToken(){
	token::init();
	}

}

?>