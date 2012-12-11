<?php
$info = array(
		"execute" 	=> '\library\capsule\content\content::init("{text}","{view}","{row display}","{category}");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" =>    array('normal','single','lists','event','image','imageBox','contentTag','thumbnailContent','verticon','table','imageVerti','singleText','slider','Custom','blog')),
					   "row display" 	=> array("type" => "select", "value" => array(1,2,3,4,5,10,20)),
					   "category"		=> array("type" => "data select multi", "value" => "\library\capsule\content\content::getCategory")
					   )
		);

return $info;

?>