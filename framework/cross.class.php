<?php

namespace framework;

use \capsule\main\parser;

class cross {

public $site;

	public function __construct($mySite) {
	$this->site = $mySite;
	}

	public function getAllWebContent() {
	echo file_get_contents($this->site);
	}
	
	public function getBodyWebContent() {	
	$site = file_get_html($this->site);	$site->attribute = null;
	
	echo "<table class='inpariTable'>".$site->find('table', 0)->innertext."</table>";
	}

}


?>