<?php

namespace view\css;

include("../../config.php");

define ("PAGES_CSS", ROOT_PATH."view/pages/".$_SESSION['template'].'/library/css/'); 

define ("CAPSULE_CSS", ROOT_PATH."library/capsule/");

ob_start("ob_gzhandler");

header("Cache-Control: public");

header("Expires: Sat, 31 Dec 2012 05:00:00 GMT");

header('Content-type: text/css; charset="utf-8"', true); 

$pages = (is_dir(PAGES_CSS)) ? scandir(PAGES_CSS) : null; 

$capsule = (is_dir(CAPSULE_CSS)) ? scandir(CAPSULE_CSS) : null;

if (file_exists($_SESSION['template'].'/global.css')): readfile($_SESSION['template'].'/global.css'); endif;

if (!empty($pages)):

	foreach ($pages as $key => $value):

		if ($value != '.' && $value != '..' && is_dir(PAGES_CSS)):

			if (!file_exists(PAGES_CSS.$value)): continue; endif;
			
			readfile(PAGES_CSS.$value);
				
		endif;
	
	endforeach;
	
endif;

if (!empty($capsule)):

	foreach ($capsule as $key => $value):
			
		if ($value != '.' && $value != '..'):
		
		if (!file_exists(CAPSULE_CSS.$value.'/css/'.$value.'.css')): continue; endif;

		readfile(CAPSULE_CSS.$value.'/css/'.$value.'.css');
		
		echo "\n";
		
		endif;
		
	endforeach;

endif;

?>