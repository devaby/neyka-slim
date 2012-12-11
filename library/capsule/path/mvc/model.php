<?php

namespace library\capsule\path\mvc;

use \framework\capsule;
use \framework\database\oracle\select;

class model extends capsule {

protected $data;
public $path = array();

    public function __construct () {
	
		parent::__construct(
		
		"Path",
		"Asacreative, Inc Team",
		"This is the path capsule",
		"<link href='library/capsule/share/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/share/js/share.js' type='text/javascript'></script>"
	
		);
			
	}
	
	public function setData($data) {
	$this->data = $data;
	return $this;
	}
	
	public function getMyPath($path = null) {
	
		if ($path == 1) {$path = $this->data;}
	
	$select = new select("*",
	"CAP_MENU
	LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
	LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID",
	array(array("CAP_MENU.CAP_MEN_ID","=",$path),array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_TYPE","=","menu"),array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_LAN_ID","=",$_SESSION['language']),array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_COLUMN","=","CAP_MEN_NAME")),"","");
	
	$select->execute();

		if (!empty($select->arrayResult[0]['CAP_MEN_PARENT'])) {
		
		$this->path [] = array($select->arrayResult[0]['CAP_MEN_ID'],$select->arrayResult[0]['CAP_LAN_COM_VALUE'],$select->arrayResult[0]['CAP_PAGES_CAP_PAG_ID']);
		
		self::getMyPath($select->arrayResult[0]['CAP_MEN_PARENT']);
		
		}
		else {
		
		$this->path [] = array($select->arrayResult[0]['CAP_MEN_ID'],$select->arrayResult[0]['CAP_LAN_COM_VALUE']);
		
		}
			
	}
	
	public function getEntityName() {
		
		$select = new select("*","CAP_ACCOUNTING_USER_ACCOUNT",[["CAP_ACC_USE_ACC_ID","=",$_SESSION['ACCOUNTING-ACCOUNT']]],"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
				
	}

}

?>