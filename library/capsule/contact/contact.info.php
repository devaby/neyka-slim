<?php

$info = array(
		"execute" 	=> '\library\capsule\contact\contact::init("{text}","{email}","{view}");',
		"option"	=> array("text"					=> array("type" => "input"),
							 "email destination"	=> array("type" => "input"),
							 "view"					=> array("type" => "select", "value" => array('normal','quickBlackContact')))
		);

return $info;

?>