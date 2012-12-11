<?php

namespace view\js;

include("../../config.php");

define ("MAIN_JS", ROOT_PATH."view/pages/".$_SESSION['template']."/library/js/");

define ("PLUGIN_JS", ROOT_PATH."view/pages/".$_SESSION['template']."/library/plugins/");

define ("CAPSULE_JS", ROOT_PATH."library/capsule/");

ob_start("ob_gzhandler"); header("Cache-Control: public"); header("Expires: Sat, 31 Dec ".date("Y")." 05:00:00 GMT");

header('Content-type: text/javascript; charset="utf-8"', true); 

$main = scandir(MAIN_JS);

	foreach ($main as $key => $value) {
		if ($value != '.' && $value != '..') {
		readfile(MAIN_JS.$value);
		echo "\n";
		}
	}


$plugin = scandir(PLUGIN_JS);

	foreach ($plugin as $key => $value) {
		if ($value != '.' && $value != '..') {
		$javascript = scandir(PLUGIN_JS."$value");
			foreach ($javascript as $java => $script) {
			$path = pathinfo(PLUGIN_JS.$value."/".$script, PATHINFO_EXTENSION);
				if ($script != '.' && $script != '..' && $path == 'js') {
				readfile(PLUGIN_JS.$value."/".$script);
				echo "\n";
				}
			}
		}
	}

$capsule = scandir(CAPSULE_JS);

	foreach ($capsule as $key => $value) {
		if ($value != '.' && $value != '..') {
		if (is_dir(CAPSULE_JS."$value"."/js/")) {$javascript = scandir(CAPSULE_JS."$value"."/js/");} else {unset($javascript);}
			if (is_array($javascript)) {			    
				foreach ($javascript as $java => $script) {
				$path = pathinfo(CAPSULE_JS.$value."/".$script, PATHINFO_EXTENSION);
					if ($script != '.' && $script != '..' && $path == 'js') {
						if (!isset($_SESSION['admin']) && $script == 'admin.js' || !isset($_SESSION['admin']) && $script == 'var.js') {continue;}
						readfile(CAPSULE_JS.$value.'/js/'.$script);
						echo "\n";
					}
				}
			}
		}
	}

?>