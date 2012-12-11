<?php
$info = array(
		"execute" 	=> '\library\capsule\rss\rss::init("{text}","{view}","{row display}","{url}");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" => array('normal','lists','event','image','imageBox','contentTag','verticon','table','forex')),
					   "row display" 	=> array("type" => "select", "value" => array(1,2,5,10,20)),
					   "url"			=> array("type" => "input"),
					   )
		);

return $info;

?>