<?php
$info = array(
		"execute" 	=> '\library\capsule\register\register::init("{view}");',
		"option"	=> array("view"	=> array("type" => "select", "value" => array('normal','accounting_register')))
		);

return $info;

?>