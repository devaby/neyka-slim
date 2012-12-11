<?php
$info = array(
		"execute" 	=> '\library\capsule\image\image::init("{text}","{view}","{row display}","{category}","{folder}");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" => array('normal','headline_category','client','horizontal','gallery','roll','single','sprites')),
					   "row display" 	=> array("type" => "select", "value" => array(1,2,5,10,20)),
					   "category"		=> array("type" => "data select multi", "value" => "\library\capsule\image\image::getCategory"),
					   "folder"			=> array("type" => "data folder", "value" => "\library\capsule\image\image::getFolder")
					   )
		);

return $info;

?>