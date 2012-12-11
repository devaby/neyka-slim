<?php

namespace library\capsule\content\mvc;

use \framework\capsule;
use \framework\database\oracle\select;

class model extends capsule {
	
protected $data;
        
   public function __construct () {
	
		parent::__construct(
	
		"mainMenu",
		"Media Instrument, Inc Team",
		"This is the main menu",
		"<link href='library/capsule/content/css/content.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/content/js/content.js' type='text/javascript'></script>"
	
		);

	}

	
	public function fetchData() {
	
	$query = new select("*","CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
			   LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID",
			   array(
			   	array("CAP_CON_TYP_TYPE","=","content"),
			   	array("CAP_CON_PUBLISHED","=",'Y')
			   ),"","CAP_CON_CREATED DESC",2);
			   
	$query->execute();
	
		if (!empty($query->arrayResult)) {
		
		$select = new select("*","CAP_LANGUAGE_COMBINE","","","");
		
			foreach($query->arrayResult as $key => $value) {
				
				$select->whereClause = array(array("CAP_LAN_COM_FKID","=",$value['CAP_CON_ID']),array("CAP_LAN_COM_LAN_ID","=",$_SESSION['language']),array("CAP_LAN_COM_TYPE","=","content"));
				
				$select->execute();
				
				foreach($select->arrayResult as $key2 => $value2) {
					
					if ($value2['CAP_LAN_COM_COLUMN'] == 'header') {
	    			$header = $value2['CAP_LAN_COM_VALUE'];
	    			}
	    			else {
	    			$content = $value2['CAP_LAN_COM_VALUE'];
	    			}
					
				}
				
			$array [] = array("id" => $value['CAP_CON_ID'], "pages" => $value['CAP_CON_PAGES'], "header" => $header, "content" => $content);
		
			unset($header); unset($content);
				
			}
		
		}
	
	return $array;

	}
	
	public function fetchDataWithRowNumber($rowDisplay,$category) {
	
	$query = new select("*","CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
			   LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID",
			   array(
			   	array("CAP_CON_CAT_ID","=",$category),
			   	array("CAP_CON_PUBLISHED","=",'Y'),
			   	array("CAP_CON_TYP_TYPE","=","content")
			   ),"","CAP_CON_CREATED DESC",$rowDisplay);
			   
	$query->execute();
	
		if (!empty($query->arrayResult)):
		
		$select = new select("*","CAP_LANGUAGE_COMBINE","","","");
		
			foreach($query->arrayResult as $key => $value):
				
				$select->whereClause = array(array("CAP_LAN_COM_FKID","=",$value['CAP_CON_ID']),array("CAP_LAN_COM_LAN_ID","=",$_SESSION['language']),array("CAP_LAN_COM_TYPE","=","content"));
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
					foreach($select->arrayResult as $key2 => $value2):
						
						if ($value2['CAP_LAN_COM_COLUMN'] == 'header'):
						
		    			$header = $value2['CAP_LAN_COM_VALUE'];
		    			
		    			else:
		    			
		    			$content = $value2['CAP_LAN_COM_VALUE'];
		    			
		    			endif;
		    			
					endforeach;
					
				endif;
				
			$array [] = array("id" => $value['CAP_CON_ID'], "pages" => $value['CAP_CON_PAGES'], "header" => $header, "content" => $content);
		
			unset($header); unset($content);
				
			endforeach;
		
		endif;
	
	return $array;

	}
	
	public function fetchDataPaggingWithRowNumber($startData=1,$rowDisplay,$category,$tag = null) {
		$select = new select();
		
		$select->column ='DISTINCT *';
		
		$select->tableName = 'CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
			   LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
			   LEFT JOIN CAP_USER CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
			   LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
			   LEFT JOIN CAP_TAG_KEY ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_TAG_KEY.FK_LAN_COM_ID
			   LEFT JOIN CAP_GRO_LAN_COM ON CAP_GRO_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID';
				$select->whereClause = [["CAP_CON_TYP_TYPE","=","content"],["CAP_LAN_COM_COLUMN","=","header"],["CAP_CON_CAT_ID","=","$category"]];
				$select->orderClause = "CAP_CON_CREATED DESC";
				if(!empty($startData) && !empty($rowDisplay)):
				
					$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);

					$select->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
					
				endif;
				  $select->execute();
				 
				$data1 			= $select -> arrayResult;
				$totalPage 		= $select -> totalPage;
				$currentPage 	= $select -> currentPage;
			if(!empty($data1)){
					foreach ($data1 as $row) {
							
						/*$selects = new select("*","CAP_LANGUAGE_COMBINE 
											 WHERE 
				    	CAP_LAN_COM_FKID = $row[CAP_CON_ID] AND CAP_LAN_COM_LAN_ID = '".$_SESSION[language]."' AND CAP_LAN_COM_TYPE = 'content' ","","","");*/
						$select->column = "*";
						$select->tableName = "CAP_LANGUAGE_COMBINE";
						$select->whereClause = [["CAP_LAN_COM_FKID","=","$row[CAP_CON_ID]"],["CAP_LAN_COM_LAN_ID","=","$_SESSION[language]"],["CAP_LAN_COM_TYPE","=","content"]];
						$select->execute();
						$data2 = $select->arrayResult;
						if(!empty($data2)){
							foreach($data2 as $row2){
								if ($row2[CAP_LAN_COM_COLUMN] == 'header') {
					    				$header = $row2[CAP_LAN_COM_VALUE];
					    			}
					    			else {
					    				$content = $row2[CAP_LAN_COM_VALUE];
					    			}
					    			
								}
								
								$tanggal = $row[CAP_CON_DATEPUBLISHED];
				    			$publisher = $row[CAP_USE_FIRSTNAME];
				    			$id =  $row[CAP_CON_ID];
				    			$pages =  $row[CAP_CON_PAGES];
								
								$array [] = array("id" => $id, "pages" => $pages, "header" => $header, "content" => $content, "tanggal" => $tanggal, "publisher" => $publisher);
								unset($header); unset($content);
							
						}
					}
			}
				
	    		$arrayFinal [] = array("totalPage" => $totalPage,"currentPage"=>$currentPage ,"array"=> $array);
	    	
				return $arrayFinal ;
		

	}
		
	public function fetchDataForOptionCategory() {
	
	$domain = $GLOBALS['_neyClass']['sites']->domain();
	
	$select = new select('*','CAP_CONTENT_CATEGORY',[['FK_CAP_MAI_ID','=',$domain]],"",'CAP_CON_CAT_ID ASC'); $select->execute();
	
		foreach ($select->arrayResult as $key => $value) {
		
		$array [] = array("id" => $value['CAP_CON_CAT_ID'], "name" => $value['CAP_CON_CAT_NAME']);
		
		}
		
	return $array;
	
	/*$domain = $GLOBALS['_neyClass']['sites']->domain();
	
	$select = new select('*','CAP_GROUPING',"","",'CAP_GRO_ID ASC'); $select->execute();
		if(!empty($select->arrayResult)){
			foreach ($select->arrayResult as $key => $value) {
			
			$array [] = array("id" => $value['CAP_GRO_ID'], "name" => $value['CAP_GRO_NAME']);
			
			}
		}
		
	return $array;*/
	
	
	}
	
	public function countCommentOfContent($id){
		
		$select = new select("","","","","");
		
		$select->column = "COUNT(CAP_COM_ID) as COUNT";
		
		$select -> tableName = "CAP_COMMENT WHERE CAP_CONTENT_CAP_CON_ID = ".$id;
		
		$select-> execute();
		
		return $select->arrayResult;
		
		
	}
	
}


?>
