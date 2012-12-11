<?php

namespace library\capsule\search\mvc;

use \framework\capsule;
use \framework\simple_html_dom;
use \framework\database\oracle\select;

class model extends capsule {

protected $data;

    public function __construct () {
	
		parent::__construct(
		
		"Language",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/search/css/search.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/search/js/search.js' type='text/javascript'></script>"
	
		);
			
	}
	
	public function getSearchData($text) {
	$select = new select(
	
	"*",
	"CAP_CONTENT
	LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
	WHERE CAP_LAN_COM_LAN_ID = '".$_SESSION['language']."' AND
	CAP_LAN_COM_TYPE = 'content' AND
	CAP_CON_PUBLISHED = 'Y' AND
	LOWER(CAP_LAN_COM_VALUE) LIKE LOWER('%$text%')
	ORDER BY CAP_CON_CREATED",
	"",
	"",
	""); 
	
	$select->execute(); 
	
	$html = new simple_html_dom();
	
	if (!empty($select->arrayResult)) {
	
		foreach ($select->arrayResult as $key => $value) {
		
		$content  = $html->load($value['CAP_LAN_COM_VALUE']);
		
		$selectHeader = new select(
		
		"*",
		"CAP_LANGUAGE_COMBINE
		WHERE CAP_LAN_COM_LAN_ID = '".$_SESSION['language']."' AND
		CAP_LAN_COM_TYPE = 'content' AND
		CAP_LAN_COM_COLUMN = 'header' AND
		CAP_LAN_COM_FKID = '$value[CAP_CON_ID]'",
		"",
		"",
		""); 
		
		$selectHeader->execute(); $header = $selectHeader->arrayResult[0]['CAP_LAN_COM_VALUE'];
				
		$array [] =  array("id" => $value[CAP_CON_ID]."c", "header" => $header,"content" => self::trimmingWords($html->plaintext));
		
		}
	
	}
	
	return $array;
	
	}
	
	public function trimmingWords($words) {
	
	$words = explode("\n",wordwrap($words, 10));
	
		foreach ($words as $value) {
		$i++; $newWords .= $value . " "; if ($i == 15) {break;}
		}
	
	return $newWords;
	
	}

}

?>