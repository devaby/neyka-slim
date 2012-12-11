<?php

$info = [
		'execute' => '\library\capsule\staff\staff::init("{view}","{domain}");',
		'option'  => ['view' => ['type' => 'select', 'value' => ['normal','profile','table']],
					  'domain' => ['type' => 'data select', 'value' => '\library\capsule\staff\staff::getDomain']
					 ]
		];

return $info;

?>

