<?php

namespace library\capsule\image\mvc;

use \framework\capsule;
use \framework\database\oracle\select;

class model extends capsule {
	
protected $data;
        
     public function __construct () {
	
		parent::__construct(
	
		"mainMenu",
		"Media Instrument, Inc Team",
		"This is the main menu",
		"<link href='library/capsule/image/css/image.css' rel='stylesheet' type='text/css'/>",
		""
	
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
	
	public function fetchDataForUserCategory($category) {

	if (empty($category)) {return false;}
	
		foreach($category as $key => $value) {
			
			if (!empty($value)) {$newCategory [] = $value;}
			
		}
	
	foreach ($newCategory as $value) {
		
	$query	= "SELECT * FROM $this->schema.CAP_CONTENT_CATEGORY WHERE CAP_CON_CAT_ID = '$value'";
	$result = oci_parse($this->oraConn, $query);
	
		if ($value != '{category}') {
	
		oci_execute($result);
	
	   		while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
	    		if (in_array($row[CAP_CON_CAT_ID],$newCategory)) {
				$array [] = array("id" => $row[CAP_CON_CAT_ID], "name" => $row[CAP_CON_CAT_NAME]);
				}
			}
		
		}
	
	}
	
	return $array;
		
	}
	
	public function fetchFolderByUserCategory($category) {
	
	if (!empty($category)) {
	
		foreach($category as $key => $value) {
			
			if (!empty($value)) {
			
			$newCategory [] = $value['id'];

			$query	= "SELECT * FROM $this->schema.CAP_CONTENT WHERE FK_CAP_CONTENT_CATEGORY = $value[id]";
			$result = oci_parse($this->oraConn, $query); oci_execute($result);
	        
	   			while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
								
					$folder [] = $row['CAP_CON_CONTENT'];

				}
			
			$array [] = array("id" => $value[id], "name" => $value[name], "folder" => $folder);
			
			}
		
		unset($folder);
		
		}
		
	}
	
	return $array;
		
	}
	
	public function fetchFolderImage() {
	
	$array = scandir(ROOT_PATH."library/content/image/");
	
	return $array;
	
	}
	
	public function fetchImageFromFolder($folder) {
	
	$scan = scandir(ROOT_PATH."library/content/image/".$folder);
	
		foreach ($scan as $key => $value) {
		
			if ($value != '.' && $value != '..') {
			$array [] = "library/content/image/"."$folder/".$value;
			}
			
		}
	
	return $array;
	
	}
	
	public function fetchContentData($path) {
	$select = new select("*","CAP_CONTENT_METADATA WHERE CAP_CON_MET_PATH = '$path'","","",""); $select->selectSingleTable();
	return $select->arrayResult;
	
	}
        
}
  ?>
