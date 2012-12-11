<?php

$info = array(
		"execute" 	=> '\library\capsule\login\login::init("{view}");',
		"option"	=> array("view"	=> array("type" => "select", "value" => array('normal','pertanian','staff', 'staffSite',  )))
		);

return $info;

?>