<?php

namespace library\capsule\language;

use \framework\capsule;
use \framework\database\oracle\select;

class language extends capsule {

protected $data;
protected $view;

    public function __construct ($view) {
	
		parent::__construct(
		
		"Language",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/language/css/language.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/language/js/language.js' type='text/javascript'></script>"
	
		);
	
	$this->view = $view;
	
	self::init();
	
	}
	
	public function init() {
	
	$view 	 = $this->view;
	
	$select  = new select("*","CAP_LANGUAGE","","",""); $select->selectSingleTable(); 
	
	$display = new view($select->arrayResult); $display->$view();
			
	}

}

?>