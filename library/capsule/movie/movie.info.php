<?php

$info = array(
		"execute" 	=> '\library\capsule\movie\movie::init("{view}","{row display}","{width}","{height}","{category}","{folder}");',
		"option"	=> array(
					   "view"			=> array("type" => "select", "value" => array('normal','boxvideo','multiple_boxvideo')),
					   "row display" 	=> array("type" => "input"),
					   "width" 			=> array("type" => "input"),
					   "height" 		=> array("type" => "input"),
					   "category"		=> array("type" => "data select", "value" => "\library\capsule\movie\movie::getCategory"),
					   "folder"			=> array("type" => "data folder", "value" => "\library\capsule\movie\movie::getFolder")
                       )
		);

return $info;

?>