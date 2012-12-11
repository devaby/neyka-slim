<?php

$info = array(
		"execute" 	=> '\library\capsule\user\user::init("{view}");',
		"option"	=> array("view"	=> array("type" => "select", "value" => array('normal','integrasi','image','name')))
		);

return $info;

?>