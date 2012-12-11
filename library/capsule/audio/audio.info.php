<?php
$info = array(
		"execute" 	=> '\library\capsule\audio\audio::init("{text}","{view}","{row display}","{category}","{folder}");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" => array('normal','horizontal','table')),
					   "row display" 	=> array("type" => "select", "value" => array(1,2,5,10,20)),
					   "category"		=> array("type" => "data select", "value" => "\library\capsule\audio\audio::getCategory"),
					   "folder"			=> array("type" => "data folder", "value" => "\library\capsule\audio\audio::getFolder")
					   )
		);

return $info;

?>