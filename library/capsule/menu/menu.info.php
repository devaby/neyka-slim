<?php
$info = array(
		"execute" 	=> '\library\capsule\menu\menu::init("{set}","{view}");',
		"option"	=> array(
					   "set"  => array("type" => "data select", "value" => "\library\capsule\menu\mvc\model::getMenuSetForOption"),
					   "view" => array("type" => "select", "value" => array('normal', 'bootstrap', 'centum', 'campaign')),
					  
					   )
		);


return $info;

?>