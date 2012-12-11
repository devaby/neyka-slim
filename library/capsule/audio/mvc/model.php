<?php

namespace library\capsule\audio\mvc;

use \framework\capsule;

class model extends capsule {
    
protected $data;
    
    public function __construct () {

		parent::__construct(
	
		"audio",
		"Media Instrument, Inc Team",
		"This is the core audio",
		"<link href='library/capsule/audio/css/audio.css' rel='stylesheet' type='text/css' />",
		"<script src='library/capsule/audio/js/audio.js' type='text/javascript'></script>"
	
		);
    }
    
    public function fetchData() {
	
	$query	= "SELECT * FROM $this->schema.CAP_CONTENT WHERE ROWNUM <= 2 ORDER BY CAP_CON_CREATED ASC";
        $result = oci_parse($this->oraConn, $query); oci_execute($result);
    
    	while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
		$array [] = array("id" => $row[CAP_CON_ID], "pages" => $row[CAP_CON_PAGES], "header" => $row[CAP_CON_HEADER], "content" => $row[CAP_CON_CONTENT]);
		}
	
	return $array;

	}
	
    public function fetchDataWithRowNumber($rowDisplay,$category) {
	
	$query	= "SELECT * FROM $this->schema.CAP_CONTENT 
			   LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
			   WHERE ROWNUM <= $rowDisplay AND CAP_CON_CAT_ID = '$category' ORDER BY CAP_CON_CREATED ASC";
        $result = oci_parse($this->oraConn, $query); oci_execute($result);
    
    	while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
		$array [] = array("id" => $row[CAP_CON_ID], "pages" => $row[CAP_CON_PAGES], "header" => $row[CAP_CON_HEADER], "content" => $row[CAP_CON_CONTENT]);
		}
	
	return $array;

	}
	
	public function fetchDataForOptionCategory() {
	
	$query	= "SELECT * FROM $this->schema.CAP_CONTENT_CATEGORY";
        $result = oci_parse($this->oraConn, $query); oci_execute($result);
    
    	while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
		$array [] = array("id" => $row[CAP_CON_CAT_ID], "name" => $row[CAP_CON_CAT_NAME]);
		}
	
	return $array;
	
	}
	
	public function fetchFolderAudio() {
	
	$array = scandir(ROOT_PATH."library/content/audio/");
	
	return $array;
	
	}
	
	public function fetchAudioFromFolder($folder) {

	$scan = scandir(ROOT_PATH."library/content/audio/".$folder);
	
		if (!empty($scan)) {
	
			foreach ($scan as $key => $value) {
		
				if ($value != '.' && $value != '..') {
				$array [] = "library/content/audio/"."$folder/".$value;
				}
			
			}
		
		}

	return $array;
	
	}
        
        
        

}
?>
