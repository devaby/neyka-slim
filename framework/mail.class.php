<?php

namespace framework;

use framework\mail\template;

class mail {

public $to,$subject,$content,$from,$headers,$message,$template,$data;
	
	public function setTo($data) {
	$this->to = $to;
	}
	
	public function setSubject() {
	
	}
	
	public function template() {
	$this->content = new template($this->template);
	}
	
	public function send() {
	
		if (mail($this->to,$this->subject,$this->content,"From: ".$this->from)) {
		return 1;
		}
		else {
		return 0;
		}
	
	}

}

?>