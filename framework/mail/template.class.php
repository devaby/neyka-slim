<?php

namespace framework\mail;

class template {

public $html;
	
	public function __construct($template = null) {
	$this->html = file_get_contents(ROOT_PATH."framework/mail/template/".$template."/index.html");
	}	

}

?>