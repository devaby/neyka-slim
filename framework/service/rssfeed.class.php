<?php

namespace framework\service;

use \framework\simple_html_dom;
use \framework\database\oracle\select;

class rssfeed {

protected $row   = 15;    //returning row for feeder
protected $type  = 'xml'; //option for output including xml and json
protected $dyn;
protected $obj;
protected $lang;
protected $data;

	public function __construct() {
	self::init(); self::check(); self::buildAndDeploy();
	}
	
	protected function init() {
	$this->obj = new select("*","CAP_LANGUAGE","","",""); $this->obj->selectSingleTable(); $this->dyn = $_GET['lang']; 
	foreach ($this->obj->arrayResult as $key => $value) {$this->lang [] = $value[CAP_LAN_ID];}
	}
	
	protected function check() {
	if (!in_array($this->dyn, $this->lang)) {die('Your Language Selection For Feeding Is Not Available');}
	}
	
	protected function buildAndDeploy() {
	
	header("Content-Type: text/xml");
	
	$rss 	= "<rss version='2.0'><channel><generator>Neyka Framework</generator><title>Shegaforex</title><link>http://shegaforex.com/</link>
			   <description>The Best and Safest Forex Broker</description><language>".$this->dyn."</language><copyright>Copyright 2011 shegaforex</copyright>";
	
	$select = new select("*","CAP_CONTENT LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						 WHERE CAP_LAN_COM_LAN_ID = '".$this->dyn."' AND CAP_LAN_COM_TYPE = 'content' AND CAP_LAN_COM_COLUMN = 'content' AND 
						 CAP_CON_PUBLISHED = 'Y' ORDER BY CAP_CON_CREATED DESC","","",""); $select->selectSingleTable();
	
	$html 	= new simple_html_dom();
	
		foreach ($select->arrayResult as $key => $value) {
		
		$i++; if($i == $this->row) {break;}
		
		$content  = $html->load($value[CAP_LAN_COM_VALUE]);
		
		$selectHeader = new select("*","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_LAN_ID = '".$this->dyn."' AND CAP_LAN_COM_TYPE = 'content' AND 
								   CAP_LAN_COM_COLUMN = 'header' AND CAP_LAN_COM_FKID = '$value[CAP_CON_ID]'","","",""); 
		
		$selectHeader->selectSingleTable(); $header = $selectHeader->arrayResult[0][CAP_LAN_COM_VALUE];
		
		$rss .= "
		
		<item>
			<title>".$header."</title>
			<description>".htmlentities(self::trimmingWords($html->plaintext))."</description>
			<link>http://".$_SERVER['SERVER_NAME'].APP."?id=".$value[CAP_CON_ID]."c</link>
			<pubDate>".date("D, d M Y H:i:s O", strtotime($value[CAP_CON_CREATED]))."</pubDate>
		</item>";
		
		}
	
	$rss .= "</channel>";
	
	$rss .= "</rss>";
	
	echo $rss;
	
	}
	
	public function trimmingWords($words) {
	
	$words = explode("\n",wordwrap($words, 30));
	
		foreach ($words as $value) {
		$i++; $newWords .= $value . " "; if ($i == 15) {break;}
		}
	
	return $newWords;
	
	}
	
	

}


?>