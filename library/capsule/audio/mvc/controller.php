<?php

namespace library\capsule\audio\mvc;

class controller {

	public static function getCategory() {
	$audio = new model(); return $audio->fetchDataForOptionCategory();
	}
	
	public static function getFolder() {
	return model::fetchFolderAudio();
	}
	
}

?>
