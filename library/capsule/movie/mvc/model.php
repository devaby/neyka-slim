<?php

namespace library\capsule\movie\mvc;

use \framework\capsule;
use \framework\database\oracle\select;

class model extends capsule {
    
protected $data;
    
    public function __construct () {

		parent::__construct(
	
		"video",
		"Media Instrument, Inc Team",
		"This is the main menu",
		"<link href='library/capsule/movie/css/movie.css' rel='stylesheet' type='text/css' />",
		"<script src='library/capsule/movie/js/movie.js' type='text/javascript'></script>"
	
		);
    }
    
    public function fetchData() {
	
		$select = new select("*","CAP_CONTENT","","","CAP_CON_CREATED ASC","2");
		
			if (!empty($select->arrayResult)):
			
				foreach ($select->arrayResult as $key => $row):
				
					$array [] = array("id" => $row['CAP_CON_ID'], "pages" => $row['CAP_CON_PAGES'], "header" => $row['CAP_CON_HEADER'], "content" => $row['CAP_CON_CONTENT']);
					
				endforeach;
				
			endif;
			
		return $array;
	
	}
	
    public function fetchDataWithRowNumber($rowDisplay,$category) {
	
		$select = new select("*","CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID",
				  array(array("CAP_CON_CAT_ID","=",$category)),"","CAP_CON_CREATED ASC","2");
		
			if (!empty($select->arrayResult)):
			
				foreach ($select->arrayResult as $key => $row):
				
					$array [] = array("id" => $row['CAP_CON_ID'], "pages" => $row['CAP_CON_PAGES'], "header" => $row['CAP_CON_HEADER'], "content" => $row['CAP_CON_CONTENT']);
					
				endforeach;
				
			endif;
			
		return $array;

	}
	
	public function fetchDataForOptionCategory() {
	
		$select = new select("*","CAP_CONTENT_CATEGORY","","","","");
		
			if (!empty($select->arrayResult)):
			
				foreach ($select->arrayResult as $key => $row):
				
					$array [] = array("id" => $row['CAP_CON_CAT_ID'], "name" => $row['CAP_CON_CAT_NAME']);
					
				endforeach;
				
			endif;
			
		return $array;
		
	}
	
	public function fetchFolderVideo() {
	
	$array = scandir(ROOT_PATH."library/content/video/");
	
	return $array;
	
	}
	
	public function fetchVideoFromFolder($folder) {

	$scan = scandir(ROOT_PATH."library/content/video/".$folder);
	
		if (!empty($scan)) {
	
			foreach ($scan as $key => $value) {
		
				if ($value != '.' && $value != '..') {
				$array [] = "library/content/video/"."$folder/".$value;
				}
			
			}
		
		}

	return $array;
	
	}
        
        
        

}
?>
