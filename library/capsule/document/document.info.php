<?php
$info = array(
		"execute" 	=> '\library\capsule\document\document::init("{text}","{view}","{row display}","{grouping}","{folder}","$_GET[id]");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" => array('normal','table','full','showUndangUndang')),
					   "row display" 	=> array("type" => "select", "value" => array(1,2,5,10,20)),
					   "grouping"		=> array("type" => "data select", "value" => "\library\capsule\document\document::getCategory"),
					   "folder"			=> array("type" => "data folder", "value" => "\library\capsule\document\document::getFolder")
					   )
		);

return $info;

?>