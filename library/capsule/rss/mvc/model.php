<?php

namespace library\capsule\rss\mvc;

use \framework\capsule;
use \framework\database\oracle\select;

class model extends capsule {
	
protected $data;
        
   public function __construct () {
	
		parent::__construct(
	
		"mainMenu",
		"Media Instrument, Inc Team",
		"This is the main menu",
		"<link href='library/capsule/content/css/rss.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/content/js/rss.js' type='text/javascript'></script>"
	
		);

	}

	
	public function fetchData() {
	
	$query	= "SELECT * FROM $this->schema.CAP_CONTENT 
			   LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID
			   WHERE ROWNUM <= 2 AND CAP_CON_TYP_TYPE = 'content' ORDER BY CAP_CON_CREATED DESC";
    $result = oci_parse($this->oraConn, $query); oci_execute($result);

    	while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
    	
    			$query2 = "SELECT * FROM $this->schema.CAP_LANGUAGE_COMBINE WHERE 
    	    	CAP_LAN_COM_FKID = $row[CAP_CON_ID] AND CAP_LAN_COM_LAN_ID = '".$_SESSION[language]."' AND CAP_LAN_COM_TYPE = 'content'";
    	
    	    	$result2 = oci_parse($this->oraConn, $query2); oci_execute($result2);
    	    	
    	    		while ($row2 = oci_fetch_array($result2, OCI_ASSOC | OCI_RETURN_LOBS)) {
    	    		
    	    			if ($row2[CAP_LAN_COM_COLUMN] == 'header') {
    	    			$header = $row2[CAP_LAN_COM_VALUE];
    	    			}
    	    			else {
    	    			$content = $row2[CAP_LAN_COM_VALUE];
    	    			}
    	    		
    	    		}
    	
    	
		$array [] = array("id" => $row[CAP_CON_ID], "pages" => $row[CAP_CON_PAGES], "header" => $header, "content" => $content);
		}
	
	return $array;

	}
	
	public function fetchDataWithRowNumber($rowDisplay,$category) {

	$query	= "SELECT * FROM $this->schema.CAP_CONTENT 
			   LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
			   LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID
			   WHERE ROWNUM <= $rowDisplay AND 
			   CAP_CON_CAT_ID = '$category' AND 
			   CAP_CON_TYP_TYPE = 'content'
			   ORDER BY CAP_CON_CREATED DESC";

        $result = oci_parse($this->oraConn, $query); oci_execute($result);
    
    	while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) {
    	
    	$query2 = "SELECT * FROM $this->schema.CAP_LANGUAGE_COMBINE WHERE 
    	CAP_LAN_COM_FKID = $row[CAP_CON_ID] AND CAP_LAN_COM_LAN_ID = '".$_SESSION[language]."' AND CAP_LAN_COM_TYPE = 'content'";

    	$result2 = oci_parse($this->oraConn, $query2); oci_execute($result2);
    	
    		while ($row2 = oci_fetch_array($result2, OCI_ASSOC | OCI_RETURN_LOBS)) {
    		
    			if ($row2[CAP_LAN_COM_COLUMN] == 'header') {
    			$header = $row2[CAP_LAN_COM_VALUE];
    			}
    			else {
    			$content = $row2[CAP_LAN_COM_VALUE];
    			}
    		
    		}
    	
		$array [] = array("id" => $row[CAP_CON_ID], "pages" => $row[CAP_CON_PAGES], "header" => $header, "content" => $content);
		
		unset($header); unset($content);
		
		}
	
	return $array;

	}
	
	public function fetchDataForOptionCategory() {
	
	$select = new select("*","CAP_CONTENT_CATEGORY ORDER BY CAP_CON_CAT_ID","","",""); $select->selectSingleTable();
	
		foreach ($select->arrayResult as $key => $value) {
		$array [] = array("id" => $value[CAP_CON_CAT_ID], "name" => $value[CAP_CON_CAT_NAME]);
		}
		
	return $array;
	
	}
	
}


?>
