<?php

namespace library\capsule\document\mvc;

use \framework\capsule;
use \framework\database\oracle\select;

class model extends capsule {
    
protected $data;
    
    public function __construct () {

		parent::__construct(
	
		"file",
		"Media Instrument, Inc Team",
		"This is the core audio",
		"<link href='library/capsule/document/css/document.css' rel='stylesheet' type='text/css' />",
		""
	
		);
    }
    
    public function fetchDataID($id) {
    $select = new select(
    "*",
    "CAP_MENU 
     LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID",
    array(array("CAP_LAN_COM_TYPE","=","menu"),array("CAP_LAN_COM_FKID","=","$id")),"",""); 
    
    $select->execute();
    	if(!empty($select->arrayResult)){
			foreach ($select->arrayResult as $key => $value) {
				if ($value != '.' || $value != '..') {
					if ($_SESSION[language] == $value[CAP_LAN_COM_LAN_ID]) {
					$array ['prime'] = $value[CAP_LAN_COM_VALUE];
					}
					else {
					$array [] = $value[CAP_LAN_COM_VALUE];
					}
				}
			}
		}

    return $array;
    
    }
    
    public function fetchData() {
	
	$select = new select("*","CAP_CONTENT","","","CAP_CON_CREATED ASC", "2 OFFSET 0");$select->execute();
	
	/*$query	= "SELECT * FROM $this->schema.CAP_CONTENT WHERE ROWNUM <= 2 ORDER BY CAP_CON_CREATED ASC";
        $result = oci_parse($this->oraConn, $query); oci_execute($result);
    */
    	foreach ($select->arrayResult as $key => $row) { 
		$array [] = array("id" => $row[CAP_CON_ID], "pages" => $row[CAP_CON_PAGES], "header" => $row[CAP_CON_HEADER], "content" => $row[CAP_CON_CONTENT]);
		}
	
	return $array;

	}
	
    public function fetchDataWithRowNumber($rowDisplay,$category) {
	$select = new select("*","CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID",array(array("CAP_CON_CAT_ID","=","$category")),"","CAP_CON_CREATED ASC", "0,$rowDisplay2");$select->execute();
	/*$query	= "SELECT * FROM $this->schema.CAP_CONTENT 
			   LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
			   WHERE ROWNUM <= $rowDisplay AND CAP_CON_CAT_ID = '$category' ORDER BY CAP_CON_CREATED ASC";
        $result = oci_parse($this->oraConn, $query); oci_execute($result);*/
    
    	foreach ($select->arrayResult as $key => $row) { 
		$array [] = array("id" => $row[CAP_CON_ID], "pages" => $row[CAP_CON_PAGES], "header" => $row[CAP_CON_HEADER], "content" => $row[CAP_CON_CONTENT]);
		}
	
	return $array;

	}
	
	public function fetchDataForOptionCategory() {
	
	/*$select = new select("*","CAP_CONTENT_CATEGORY","","","", "");$select->execute();
	
	/*$query	= "SELECT * FROM $this->schema.CAP_CONTENT_CATEGORY";
        $result = oci_parse($this->oraConn, $query); oci_execute($result);*/
    
    	/*foreach ($select->arrayResult as $key => $row) { 
		$array [] = array("id" => $row[CAP_CON_CAT_ID], "name" => $row[CAP_CON_CAT_NAME]);
		}*/
	
	//return $array;
	
	
	$group = model::grouping();
	
		foreach ($group[0][grouping] as $key => $value) {
                                      
                 $array []= self::recursiveFetchDataForOptionCategory($value,0);
                 //$newArray [] = self::array_flatten(self::recursiveFetchDataForOptionCategory($value,0));
         }	
         
         //$array = array_merge($array);
         $arrayN = array();
         foreach($array as $key => $value){
         	foreach($value as $keys => $values){
	         	$arrayN[]= array("id"=>$values[id],"name"=>$values[name]) ;
	        }
         }
         return $arrayN;
         //print_r($arrayN);
	
	}
			
	public function mergingArray($values){
		if(!isset($values[id])){
			foreach($values as $key => $value){
				$newArray[] = self::mergingArray($value);
				
			}
		}else{
			$newArray[] = $values;
		}
		
		
		return $newArray;
	}
	
	public function recursiveFetchDataForOptionCategory($group,$i=0,&$arrayInc=0,&$array=null){
		
		//print_r($group);
		for($j=0;$j < $i; $j++){
			$padding .="-";
		}
			self::recursiveFetchDataForOptionCategoryPrime($group,$padding,$arrayInc,$array);
			//$array [$arrayInc]= array("id" => $group[parent][CAP_GRO_ID], "name" => $padding.$group[parent][CAP_GRO_NAME]);
			$arrayInc++;
		
			if(isset($group['child'])){
	             $i++;
	            foreach ($group['child'] as $keys => $values) {
	                          
	              self::recursiveFetchDataForOptionCategory($values,$i,$arrayInc,$array);
	              
	              
	            }
	
	
	          }
        
          
          return $array;
	}
	
	public function recursiveFetchDataForOptionCategoryPrime($group,$padding,&$arrayInc,&$array){
		
		
		
			$array [$arrayInc]= array("id" => $group[parent][CAP_GRO_ID], "name" => $padding.$group[parent][CAP_GRO_NAME]);
			

	}
	
	public function fetchFolderFile() {
	
	$array = scandir(ROOT_PATH."library/content/file/");
  
	return $array;
	
	}
	
	public function fetchFileFromFolder($folder) {

	$scan = scandir(ROOT_PATH."library/content/file/".$folder);
	
		if (!empty($scan)) {
	
			foreach ($scan as $key => $value) {
		
				if ($value != '.' && $value != '..') {
				$array [] = "library/content/file/"."$folder/".$value;
				}
			
			}
		
		}

	return $array;
	
	}
	
	public function getFileName($filename){
		$select = new select("*","CAP_CONTENT_METADATA WHERE CAP_CON_MET_PATH = '".$filename."' AND CAP_CON_MET_HEADER = 'Judul Dokumen'","","","");
		$select->execute();
		
		return $select->arrayResult[0]['CAP_CON_MET_CONTENT'];
		
	}
    
    public function klasifikasi(){
		
		$select = new select("*","CAP_KLASIFIKASI",array(array("CAP_KLA_PARENT","","IS NULL")),"","");
		
		$select->execute();
		
		$result = $select->arrayResult;
		
		if(!empty($result)){
		
			foreach($select->arrayResult as $value){
			
				$theChild = self::getKlasifikasi($value['CAP_KLA_ID'],$theChild);
				$theItem  = self::getItemIP($value['CAP_KLA_ID']);
				
				if(empty($theChild) && empty($theItem)){
				
					$menuTree [] = array("parent" => $value);

					
				}elseif(!empty($theChild) && empty($theItem)){

					$menuTree [] = array("parent" => $value, "child" => $theChild);

				}elseif(empty($theChild) && !empty($theItem)){

					$menuTree [] = array("parent" => $value, "item" => $theItem);

				}else{
				
					$menuTree [] = array("parent" => $value, "item" => $theItem, "child" => $theChild);
					
				}
				
				unset($theItem);
				unset($theChild);
				
			}
			
		}
		
		$completeMenuList [] = array(
		
								   "klasifikasi" => $menuTree
								   
								   	);
								   	
		unset($menuTree);
		//print_r($completeMenuList);
		return $completeMenuList;		
		
	}
	
	public function getItemIP($klaID){
		
		if(!empty($klaID)){

			$select = new select("*","CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE
ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
LEFT JOIN CAP_CONTENT_METADATA ON CAP_CONTENT_METADATA.FK_CAP_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
WHERE CAP_KLASIFIKASI.CAP_KLA_ID = ".$klaID." AND LOWER(CAP_CON_MET_HEADER) = LOWER('JUDUL DOKUMEN')","","","");
			$select->execute();

			

				return $select->arrayResult;
				
				

			}

		}

	
	
	public function getKlasifikasi($parentID,&$menuTree){
		
		
		
		if(!empty($parentID)){
		
			$select = new select("*","CAP_KLASIFIKASI",array(array("CAP_KLA_PARENT","=","$parentID")),"","");
			
			$select->execute();
			
			if(!empty($select->arrayResult)){
				foreach($select->arrayResult as $keyItem=>$valueItem){
					$newID 		= $valueItem[CAP_KLA_ID];
					$array []	= $valueItem;
					$name  		= $valueItem;
					$theChild 	= self::getKlasifikasi($newID,$array[]);
					$theItem    = self::getItemIP($newID);
					
					if(empty($theChild) && empty($theItem)){
					
						$menuTree [] = array("parent" => $valueItem);

						
					}elseif(!empty($theChild) && empty($theItem)){

						$menuTree [] = array("parent" => $valueItem, "child" => $theChild);

					}elseif(empty($theChild) && !empty($theItem)){

						$menuTree [] = array("parent" => $valueItem, "item" => $theItem);

					}else{
					
						$menuTree [] = array("parent" => $valueItem, "item" => $theItem, "child" => $theChild);
						
					}
					unset($array);
					unset($theChild);
					unset($theItem);
				}
				
				
			}
			
		
		}
		return $menuTree;
		
		
	}
	
	public function grouping($grouping=null){
		if(!empty($grouping)){
			$select = new select("*","CAP_GROUPING",array(array("CAP_GRO_PARENT","=","$grouping")),"","");
		}else{
			$select = new select("*","CAP_GROUPING",array(array("CAP_GRO_PARENT","","IS NULL")),"","");
		}
		$select->execute();
		
		$result = $select->arrayResult;
		
		if(!empty($result)){
		
			foreach($select->arrayResult as $value){
			
				$theChild = self::getGrouping($value['CAP_GRO_ID'],$theChild);
				
				if(empty($theChild) && empty($theItem)){
				
					$menuTree [] = array("parent" => $value);

					
				}else{

					$menuTree [] = array("parent" => $value, "child" => $theChild);

				}
					
				
				
				unset($theItem);
				unset($theChild);
				
			}
			
		}
		
		$completeMenuList [] = array(
		
								   "grouping" => $menuTree
								   
								   	);
								   	
		unset($menuTree);
		//print_r($completeMenuList);
		return $completeMenuList;		
		
	}
	
	public function getGroupItemIP($groupID){
		
		if(!empty($groupID)){

			$select = new select("*","CAP_GRO_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE
ON CAP_GRO_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
LEFT JOIN CAP_GROUPING ON CAP_GROUPING.CAP_GRO_ID = CAP_GRO_LAN_COM.FK_GRO_ID
LEFT JOIN CAP_CONTENT_METADATA ON CAP_CONTENT_METADATA.FK_CAP_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
WHERE CAP_GROUPING.CAP_GRO_ID = ".$groupID." AND LOWER(CAP_CON_MET_HEADER) = LOWER('JUDUL DOKUMEN')","","","");

			$select->execute();

			

				$item = $select->arrayResult;
			if(!empty($item)){
				foreach($item as $key => $value){
					$select -> tableName 	= "CAP_CONTENT_METADATA";
					$select -> column 		= "*";
					$select -> whereClause	= array(array("FK_CAP_LAN_COM_ID","=","$value[CAP_LAN_COM_ID]"));
					
					$select-> execute();
					array_push($value, ["metadata"=>$select->arrayResult]);
					//$value	= ["metadata"=>$select->arrayResult];
					$array [] = $value ;
					
				}
			}
				return $array;

			}

		}
	
	public function getGrouping($parentID,&$menuTree){
		
		
		
		if(!empty($parentID)){
		
			$select = new select("*","CAP_GROUPING",array(array("CAP_GROUPING.CAP_GRO_PARENT","=","$parentID")),"","");
			
			$select->execute();
			
			if(!empty($select->arrayResult)){
				foreach($select->arrayResult as $keyItem=>$valueItem){
					$newID 		= $valueItem[CAP_GRO_ID];
					$array []	= $valueItem;
					$name  		= $valueItem;
					$theChild 	= self::getGrouping($newID,$array[]);
					$theItem    = self::getGroupItemIP($newID);
					
					if(empty($theChild) && empty($theItem)){
					
						$menuTree [] = array("parent" => $valueItem);

						
					}elseif(!empty($theChild) && empty($theItem)){

						$menuTree [] = array("parent" => $valueItem, "child" => $theChild);

					}elseif(empty($theChild) && !empty($theItem)){

						$menuTree [] = array("parent" => $valueItem, "item" => $theItem);

					}else{
					
						$menuTree [] = array("parent" => $valueItem, "item" => $theItem, "child" => $theChild);
						
					}
					unset($array);
					unset($theChild);
					unset($theItem);
				}
				
				
			}
			
		
		}
		return $menuTree;
		
		
	}

        
        

}
?>
