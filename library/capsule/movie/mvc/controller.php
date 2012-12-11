<?php

namespace library\capsule\movie\mvc;

class controller {

	public static function getCategory() {
	$video = new model(); return $video->fetchDataForOptionCategory();
	}
	
	public static function getFolder() {
	return model::fetchFolderVideo();
	}
	
}

?>
