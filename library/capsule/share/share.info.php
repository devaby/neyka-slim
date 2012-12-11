<?php
$info = array(
		"execute" 	=> '\library\capsule\share\share::init("{view}");',
		"option"	=> array("view"	=> array("type" => "select", "value" => array('normal','icon','smallIcon')))
		);

return $info;

?>