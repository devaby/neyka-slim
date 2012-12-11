<?php
$info = array(
		"execute" 	=> 'new \library\capsule\language\language("normal");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" => array('normal','autumn','event','image','imageBox','contentTag' )),
					   "row display" 	=> array("type" => "select", "value" => array(1,2,5,10,20)),
					   "category"		=> array("type" => "data select", "value" => "\library\capsule\content\contentController::getCategory")
					   )
		);

return $info;

?>