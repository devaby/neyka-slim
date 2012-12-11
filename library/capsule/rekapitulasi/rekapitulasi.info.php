<?php
$info = array(
		"execute" 	=> '\library\capsule\rekapitulasi\rekapitulasi::init("{view}");',
		"option"	=> array("view"	=> array("type" => "select", "value" => array('normal','dashboard','icon_rekap','detail')))
		);

return $info;

?>