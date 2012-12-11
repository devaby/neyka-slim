<?php

namespace library\capsule\rss\mvc;

class controller {

	public static function getCategory() {
	return model::fetchDataForOptionCategory();
	}
	
	public static function getContentCategory($text,$params,$rowDisplay,$category) {
	$content = new content($text,$params,$rowDisplay,$category);
	}

}

?>
