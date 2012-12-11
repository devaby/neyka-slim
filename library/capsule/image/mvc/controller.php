<?php

namespace library\capsule\image\mvc;

class controller {

	public static function getCategory() {
	$image = new model(); return $image->fetchDataForOptionCategory();
	}
	
	public static function getFolder() {
	return model::fetchFolderImage();
	}

}

?>
