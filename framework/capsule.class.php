<?php 

namespace framework;

use \framework\server;
use \framework\encryption;
use \framework\database\oracle\oracle;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\update;
use \framework\database\oracle\delete;

class capsule {

public $oraConn, $capName, $capCreator, $capDescription, $capCSS, $capJS;

	public function __construct ($capName = null,$capCreator = null,$capDescription = null,$capCSS = null,$capJS = null) {
        
		$this -> capName 		= $capName;
		$this -> capCreator 	= $capCreator;
		$this -> capDescription = $capDescription;
		$this -> capCSS 		= $capCSS;
		$this -> capJS 			= $capJS;
		
		self::declareCSSAndJS();
	
	}
        
    public function declareCSSAndJS () {
            
        //echo $this->capCSS;
        
        	if (is_array($this->capJS)) {
        		foreach ($this->capJS as $value) {
        		//echo $value;
        		}
        	}
        	else {
        	//echo $this->capJS;
        	}
            
    }
   
	
	public function init () {
		
		self::capsuleInstaller();
		
		//self::capsuleMenuInstaller();
		
		$sites = self::getSitesList();

		if (!empty($sites)):
		
		$db = ['insert' => new insert(), 'select' => new update(), 'update' => new update()];

			foreach ($sites as $value):

				self::pagesInstaller(null,$value['CAP_MAI_ID'],$value['CAP_MAI_TEMPLATE']);
				
				self::pagesDeleter($value['CAP_MAI_ID']);
				
			endforeach;
			
        self::pagesInstaller(null,null,'core');
				
        //self::pagesDeleter(null);

		endif;

		$language = server::getDefaultlanguage(); 
		
		if (empty($language)) {
		
		$data = new select("*","CAP_MAIN","","","");
		
		$data->execute();
		
		server::setDefaultLanguage($data->arrayResult['CAP_MAI_LANGUAGE']);
		
		}
					
	}
	
	public function getCapsuleList() {
	
		$capList = new select("*","CAP_LIST",array(array("CAP_LIS_STATUS","=","Active")),"","");
		$capList->execute();
		
		return $capList->arrayResult;
		
	}
	
	public function getCapsuleListForAdmin() {
	
		$capList = new select("*","CAP_LIST",array(array("CAP_LIS_STATUS","=","Active"),array("CAP_LIS_NAME","!=","admin")),"","");
		$capList->execute();
		
		return $capList->arrayResult;
		
	}
	
	public function getCapsuleListWhereClause($id) {
	
		$capList = new select("*","CAP_LIST",array(array("CAP_LIS_ID","=",$id)),"","");
		$capList->execute();
		
		return $capList->arrayResult;
		
	}
	
	public function capsuleMenuInstaller() {	
    	
    	$list = scandir(ROOT_PATH."library/capsule/"); 
    	
    	$db   = ['insert' => new insert(), 'select' => new select()];
        
        $db['insert']->transactionStart();
    	
    	foreach ($list as $value):
    	
    	$menu_installer = ROOT_PATH.'library/capsule/'.$value.'/install/sql.php';
    	    	
    	   if (file_exists($menu_installer)):
    	
        	$menu_installer_info = ROOT_PATH.'library/capsule/'.$value.'/install/menu.php';
        	
            	if (!is_numeric($menu_installer_info) && empty($menu_installer_info)):
            	        	
            	   foreach ($menu_installer_info['sql'] as $values):
            	   
            	       $db['insert']->tableName   = $menu_installer_info['table'];
            	       
            	       $db['insert']->column      = $menu_installer_info['column'];
            	       
            	       $db['insert']->whereClause = $menu_installer_info['id'];
            	   
            	   endforeach;
            	   
               endif;
    	   
    	   endif;
    	   
        endforeach;
    	
	}
	
	public function capsuleInstaller () {

		$list = scandir(ROOT_PATH."library/capsule/");
		
		$insertCapsule = new capsuleinsert();
		
			foreach ($list as $value) {
				if ($value != "." && $value != "..") {
				$insertCapsule->insertCapsuleList($value);
				}
			} 
			
		$insertCapsule->queryInsertCapsule();
	
	}

	public function pagesInstaller ($rootPages,$sites = null,$tmpl) {

		$primePath = ROOT_PATH."view/pages/".$tmpl."/";

		$relativePath = "view/pages/";
		
		$checkImages = explode("/",$rootPages);
				
		if ($checkImages[7] == 'images') {return false;}
		
		if (empty($rootPages)) {
		
		$list = @scandir($primePath);
		
		}
		else {
		
		$list = @scandir($rootPages);
		
		}

		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");
						
		$select = new select();
		
		$insert = new insert();
						
		if (!empty($list)) {
		
			foreach ($list as $value) {
			
			if ($value == '.' || $value == '..' || $value == 'library') {continue;}
			
			if (in_array($value,$whiteList)) {continue;}
			
				if (empty($rootPages)) {
				
				$absolutePath = $primePath.$value."/index.php";
								
				}
				else {

				$absolutePath = $rootPages.$value."/index.php";
								
				}
									
			$break = explode("/",$absolutePath);
			
			
			
			if (!file_exists($absolutePath)) { 
												
			unset($folderPath);
			
				for ($i = 1, $c = count($break);$i < $c; $i++) {
					if ($break[$i] != 'index.php') {
					$folderPath .= $break[$i]."/";
					}
				}
			
			self::pagesInstaller("/".$folderPath,$sites,$tmpl);

			continue;

			} 
			
			$relativePath = "view/pages/";
			
				for ($i = 1, $c = count($break);$i < $c; $i++) {
					if ($i > 5) {
					$relativePath .= $break[$i];
					}
					
					if ($i > 5 && $i != $c) {
					$relativePath .= "/";
					}
				}
			
			$relativePath = substr($relativePath, 0, -1);
			
			$select->column = "*";

			$select->tableName = "CAP_PAGES";
			
    			if (!empty($sites)):
    			
    			$select->whereClause = [["CAP_PAG_PATH","=",$relativePath],["CAP_PAG_SITES","=",$sites]];
    			
    			else:
    			
    			$select->whereClause = [["CAP_PAG_PATH","=",$relativePath],["CAP_PAG_SITES","","IS NULL"]];
    			
    			endif;
				
			$select->execute(); 

				if (empty($select->arrayResult)) {
				$insert->tableName = "CAP_PAGES";
				$insert->dateColumn = [];
				$insert->whereClause = "CAP_PAG_ID";
				$insert->column = ["CAP_PAG_NAME" => $value, "CAP_PAG_PATH" => $relativePath, "CAP_PAG_SITES" => $sites];
				$lastID = $insert->execute();
				}
			
			}
		
		}
				
	}
	
	public function pagesDeleter($sites = null) {
		
		$delete = new delete();
		
		$selectCurrentData = new select("*","CAP_PAGES","","",""); 
		
		$selectCurrentData->execute();
				
		if (!empty($selectCurrentData->arrayResult)) {

			foreach ($selectCurrentData->arrayResult as $value) {
				
			$path = explode("/",$value['CAP_PAG_PATH']);
				
			$path = "view/pages/".$path[2]."/".$path[3]."/".$path[4];

				if (!file_exists($value['CAP_PAG_PATH'])) {
				
				$delete->tableName   = "CAP_PAGES"; 
				
				    if ($sites !== null):
    				
    				$delete->whereClause = [["CAP_PAG_PATH","=",$value['CAP_PAG_PATH']],["CAP_PAG_SITES","=",$sites]];
    				
    				else:
    				
    				$delete->whereClause = [["CAP_PAG_PATH","=",$value['CAP_PAG_PATH']],["CAP_PAG_SITES","","IS NULL"]];

    				endif;
					    					    
				$delete->execute();
					    
				} 
																			
			}
		
		}
	
	}

	public function getSitesList() {
    	
    $domain = $GLOBALS['_neyClass']['sites']->domain();
        	
	$data = new select("*","CAP_MAIN",[["CAP_MAI_ID","=",$domain]],"","CAP_MAI_ID ASC"); $data->execute();
	
	return $data->arrayResult;
	
	}
	
}

class capsuleinsert {

public $table;
public $column;
public $value;
	
	public function insertCapsuleList($theValue) {
	$this->value [] = $theValue;
	}
	
	public function displayArrayCapsule() {
	//print_r($this->value);
	}
	
	public function queryInsertCapsule() {
	
	$delete = new delete("","CAP_LIST","","","");
	
	$delete->deleteTable();
	
	$insert = new insert(array(),"CAP_LIST","CAP_LIS_ID","","");

	$i = 1;
	
	$insert->transactionStart();
	
		foreach ($this->value as $value) {
		$number = $i++;
		$filename = ROOT_PATH."library/capsule/$value/$value".".info.php";
		
			if (file_exists($filename)) {
			$info 	= require_once ROOT_PATH."library/capsule/$value/$value".".info.php";
			$type 	= $info['type'];
			$exec 	= $info['execute'];
			$option = encryption::base64Encoding($info['option']);
			
				$insert->column = array(
					"CAP_LIS_ID" 		=> $number,
					"CAP_LIS_NAME" 	=> $value,
					"CAP_LIS_INCLUDE" => "library/capsule/$value/$value".".main.php",
					"CAP_LIS_STATUS" 	=> "Active",
					"CAP_LIS_INIT" 	=> $exec,
					"CAP_LIS_OPTION" 	=> $option,
					"CAP_LIS_TYPE" 	=> $type
				);
			
			$lastID = $insert->execute();
			
				if (!is_numeric($lastID) || empty($lastID)):
				
				$error = true;
				
				break;
				
				endif;
			
			}
			    	
    	unset($exec); unset($option);
    	
   	 	}
   	 	
   	if (!$error):
   	
   	$insert->transactionSuccess();
   	
   	else:
   	
   	$insert->transactionFailed();
   	
   	endif;
    		
	}

}


?>