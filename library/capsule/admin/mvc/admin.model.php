<?php

namespace library\capsule\admin;

use \framework\capsule;
use \framework\encryption;
use \framework\file;
use \framework\video;
use \framework\server;
use \framework\user;
use \framework\misc;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\update;
use \framework\database\oracle\delete;

class admin extends capsule {

public $site;

		public function __construct () {
	
			parent::__construct(
			
			"admin Capsule",
			"Media Instrument, Inc Team",
			"This is the main menu",
			"<link href='library/capsule/admin/css/admin.css' rel='stylesheet' type='text/css' />",
			"<script src='library/capsule/admin/js/listener.js' type='text/javascript'></script>"
	
			);
			
        $this->site = substr(APP, 0, -1);
		
		}
		
		public function init($pageID,$page) {
			
			$buttons = view::showMenu($pageID,$page) . PHP_EOL;
			
			$admin  .= '<script type="text/javascript">' . PHP_EOL;
						
				$admin .= self::writeJS() . PHP_EOL; 
																	
			$admin .= '</script>' . PHP_EOL;

		return [$admin,$buttons];
		
		}
		
		public function showCSS() {
		return "<link href='library/capsule/admin/css/admin.css' rel='stylesheet' type='text/css' />";
		}
		
		public function showJS() {
		return "<script src='library/capsule/admin/js/listener.js' type='text/javascript'></script>";
		}
		
		public function writeJS() {
		
		$javascript  = adminJavascript::getScript(); 
		
		return $javascript;
		
		}
		
		public function searchsitesSet($id) {
		
			$select = new select('*','CAP_MAIN',[
								['CAP_MAI_DOMAIN','LIKE','%' . $id . '%'],
								['CAP_MAI_TYPE','','IS NULL'],
								]);
								
			$select->execute();
						
			return $select->arrayResult;
			
		}
		
		public function searchsubsitesSet($id) {
			
			$text = ltrim(rtrim($id[0]));
			
			$length = strlen($text);
			
			$select = new select('*','CAP_MAIN',[
									['CAP_MAI_PARENT','=',$id[1]],
									['CAP_MAI_DOMAIN','LIKE','%' . $text . '%'],
									['CAP_MAI_TYPE','=','SUB DOMAIN'],
									]);
			
				if (!empty($text) && $length <= 5):
				
					$select->limitClause = 200;				
				
				elseif (!empty($text) && $length >= 5):
				
					$select->limitClause = 200;
				
				else:
												
					$select->limitClause = 20;
								
				endif;
								
			$select->execute();

			return $select->arrayResult;
			
		}
		
		public function insertContent($set,$menuID,$lang,$langSet) {
		
			if (preg_match("/[0-9]/", $menuID)) {
				
				$select = new select("*","CAP_MENU",array(array("CAP_MEN_ID","=",$menuID)),"",""); 
				$select->execute();
				
				if (!empty($select->arrayResult['CAP_CONTENT_CAP_CON_ID'])) {
					echo json_encode(array("response"=>"Content saved","language"=>$language,"type"=>"insert","pageID"=>$select->arrayResult['CAP_CONTENT_CAP_CON_ID']));
					return false;
				}
				
			}
			else {
				
				$select = new select("*","CAP_CONTENT",array(array("CAP_CON_ID","=",$menuID)),"",""); 
				$select->execute();
				
				if (!empty($select->arrayResult['CAP_CON_ID'])) {
					echo json_encode(array("response"=>"Content saved","language"=>$language,"type"=>"insert","pageID"=>$select->arrayResult['CAP_CON_ID']."c"));
					return false;
				}
				
			}
				
		$user 	= unserialize($_SESSION['user']); 
		$userid = $user->getID();
		$set['column']['CAP_CON_CREATED'] = date("Y-m-d H:i:s");
		$set['column']['CAP_USER_CAP_USE_ID'] = $userid;
		
		$column = $set['column']; $tableName = $set['tableName']; $whereClause = $set['whereClause']; $whereID = $set['whereID'];
		$data = new insert($column,$tableName,$whereClause,$whereID);
		$data->dateColumn= array("CAP_CON_CREATED");
		$lastID = $data->execute(); 

		$update = new update(array("CAP_CONTENT_CAP_CON_ID" => $lastID),"CAP_MENU",array(array("CAP_MEN_ID","=",$menuID)));

		$update->execute();
		
		$select = new select("*","CAP_LANGUAGE",array(array("CAP_LAN_ID","=",$lang)),"",""); 
		$select->execute();
		
			if (!empty($select->arrayResult)) {
				$language = $lang;
			}
			else {
				$language = $_SESSION['language'];
			}
		
			if (empty($lang)) {
			
			$insert   = new insert(
			array(
			"CAP_LAN_COM_COLUMN" 		=> "header",
			"CAP_LAN_COM_VALUE"		 	=> $set['column']['CAP_CON_HEADER'], 
			"CAP_LAN_COM_FKID"	 		=> $lastID,
			"CAP_LAN_COM_LAN_ID" 		=> $language,
			"CAP_LAN_COM_TYPE"	 		=> 'content'),
			"CAP_LANGUAGE_COMBINE","","","");
			$insert->execute();
		
			$insert   = new insert(
			array(
			"CAP_LAN_COM_COLUMN" 		=> "content",
			"CAP_LAN_COM_VALUE"		 	=> $set['column']['CAP_CON_CONTENT'],
			"CAP_LAN_COM_FKID"	 		=> $lastID,
			"CAP_LAN_COM_LAN_ID" 		=> $language,
			"CAP_LAN_COM_TYPE"	 		=> 'content'),
			"CAP_LANGUAGE_COMBINE","","","");
			$insert->execute();
			
			}			
			
			echo json_encode(array("response"=>"Content saved","language"=>$language,"type"=>"insert","pageID"=>$lastID));
		
		}
		
		public function updateContent($set,$lang,$langSet) {
		$column = $set[column]; $tableName = $set[tableName]; $whereClause = $set[whereClause]; $whereID = $set[whereID];
		$data = new update($column,$tableName,array(array($whereClause,"=",$whereID)),"",$orderClause); $data-> execute();
			
		$select = new select("*","CAP_LANGUAGE",array(array("CAP_LAN_ID","=",$lang)),"",""); 
		$select->execute();
		
			if (!empty($select->arrayResult)) {
				$language = $lang;
			}
			else {
				$language = server::getDefaultlanguage();
			}
			
			if (!empty($lang)) {
			
			$update   = new update(
			array(
			"CAP_LAN_COM_COLUMN" 		=> "header",
			"CAP_LAN_COM_VALUE"		 	=> $set['column']['CAP_CON_HEADER']),
			"CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=",$whereID),array("CAP_LAN_COM_COLUMN","=","header"),array("CAP_LAN_COM_LAN_ID","=",$language),array("CAP_LAN_COM_TYPE","=","content")),
			"","");
			$update->execute();
		
			$update   = new update(
			array(
			"CAP_LAN_COM_COLUMN" 		=> "content",
			"CAP_LAN_COM_VALUE"		 	=> $set['column']['CAP_CON_CONTENT']),
			"CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=",$whereID),array("CAP_LAN_COM_COLUMN","=","content"),array("CAP_LAN_COM_LAN_ID","=",$language),array("CAP_LAN_COM_TYPE","=","content")),
			"","");
			$update->execute();
			}
			else {
			
			$insert   = new insert(
			array(
			"CAP_LAN_COM_COLUMN" 		=> "header",
			"CAP_LAN_COM_VALUE"		 	=> $set[column][CAP_CON_HEADER], 
			"CAP_LAN_COM_FKID"	 		=> $whereID,
			"CAP_LAN_COM_LAN_ID" 		=> $language,
			"CAP_LAN_COM_TYPE"	 		=> 'content'),
			"CAP_LANGUAGE_COMBINE","","","");
			$insert->execute();
		
			$insert   = new insert(
			array(
			"CAP_LAN_COM_COLUMN" 		=> "content",
			"CAP_LAN_COM_VALUE"		 	=> $set[column][CAP_CON_CONTENT], 
			"CAP_LAN_COM_FKID"	 		=> $whereID,
			"CAP_LAN_COM_LAN_ID" 		=> $language,
			"CAP_LAN_COM_TYPE"	 		=> 'content'),
			"CAP_LANGUAGE_COMBINE","","","");
			$insert->execute();
			
			}
			
		echo json_encode(array("response"=>"Content saved","language"=>$language,"type"=>"update"));
		
		}
		
		public function insertInternalContent($id,$lang,$content) {
		
		$language = self::defaultLanguage();
		
			foreach ($content as $value) {
			
			if (empty($value)) {echo "Please complete the form"; die;}
			else if ($content[language] != $language) {echo "Language is not the same as default value which is " . strtoupper($language); die;}
			
			}
		
		$select = new select("*","CAP_CONTENT_TYPE WHERE CAP_CON_TYP_TYPE = 'content'","","",""); 
		$select->execute(); $typeID = $select->arrayResult[0][CAP_CON_TYP_ID];
		$insert   = new insert(
		array(
		"CAP_USER_CAP_USE_ID" 		=> 1,
		"FK_CAP_CONTENT_CATEGORY" 	=> $content[category], 
		"CAP_CON_PUBLISHED" 		=> $content[published],
		"CAP_CON_CREATED"	 		=> date("Y-m-d h:i:s"),
		"FK_CAP_CONTENT_TYPE" 		=> $typeID,
		"CAP_CON_PAGES"				=> $content[pages],
		"CAP_CON_HEADER"			=> $content[header]),
		"CAP_CONTENT","","","");
		$insert->insertRowToTable(); $insert->columnMaxID = "CAP_CON_ID"; $lastID = $insert->returnMaxIDFromTable();
		
		$insert   = new insert(
		array(
		"CAP_LAN_COM_COLUMN" 		=> "header",
		"CAP_LAN_COM_VALUE"		 	=> $content[header], 
		"CAP_LAN_COM_FKID"	 		=> $lastID,
		"CAP_LAN_COM_LAN_ID" 		=> $content[language],
		"CAP_LAN_COM_TYPE"	 		=> 'content'),
		"CAP_LANGUAGE_COMBINE","","","");
		$insert->insertRowToTable();
		
		$insert   = new insert(
		array(
		"CAP_LAN_COM_COLUMN" 		=> "content",
		"CAP_LAN_COM_VALUE"		 	=> $content[content], 
		"CAP_LAN_COM_FKID"	 		=> $lastID,
		"CAP_LAN_COM_LAN_ID" 		=> $content[language],
		"CAP_LAN_COM_TYPE"	 		=> 'content'),
		"CAP_LANGUAGE_COMBINE","","","");
		$insert->insertRowToTable(); 
		
		echo "Content saved";
		
		}
		
		public function editInternalContent($id,$lang,$content) {

			if (empty($id)) {echo "There's no id of the content"; die;}
			
			foreach ($content as $value) {
			
			if (empty($value)) {echo "Please complete the form"; die;}
			
			}
		
		$select1st = new select("*","CAP_CONTENT_TYPE WHERE CAP_CON_TYP_TYPE = 'content'","","",""); 
		$select1st->execute(); $typeID = $select1st->arrayResult[0][CAP_CON_TYP_ID];
		
		$select = new select(
		"*",
		"CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = '$id' AND CAP_LAN_COM_LAN_ID = '$content[language]' AND CAP_LAN_COM_TYPE = 'content'",
		"",
		"",
		""); 
		$select->execute();
				
		if (empty($select->arrayResult)) {
		
		$insert   = new insert(
		array(
		"CAP_LAN_COM_COLUMN" 		=> "header",
		"CAP_LAN_COM_VALUE"		 	=> $content[header], 
		"CAP_LAN_COM_FKID"	 		=> $id,
		"CAP_LAN_COM_LAN_ID" 		=> $content[language],
		"CAP_LAN_COM_TYPE"	 		=> 'content'),
		"CAP_LANGUAGE_COMBINE","","","");
		$insert->insertRowToTable();
		
		$insert   = new insert(
		array(
		"CAP_LAN_COM_COLUMN" 		=> "content",
		"CAP_LAN_COM_VALUE"		 	=> $content[content], 
		"CAP_LAN_COM_FKID"	 		=> $id,
		"CAP_LAN_COM_LAN_ID" 		=> $content[language],
		"CAP_LAN_COM_TYPE"	 		=> 'content'),
		"CAP_LANGUAGE_COMBINE","","","");
		$insert->insertRowToTable();
		
		}
		else {
		
		$update   = new update(
		array(
		"CAP_USER_CAP_USE_ID" 		=> 1,
		"FK_CAP_CONTENT_CATEGORY" 	=> $content[category], 
		"CAP_CON_PUBLISHED" 		=> $content[published],
		"CAP_CON_PAGES"				=> $content[pages],
		"CAP_CON_HEADER"			=> $content[header]),
		"CAP_CONTENT","CAP_CON_ID","$id","");
		$update->updateMultipleRowWhereID();
		
		$update   = new update(
		array(
		"CAP_LAN_COM_VALUE" => $content[header]),
		"CAP_LANGUAGE_COMBINE",
		"CAP_LAN_COM_FKID = '$id' AND 
		CAP_LAN_COM_LAN_ID = '$content[language]' AND 
		CAP_LAN_COM_TYPE = 'content' AND 
		CAP_LAN_COM_COLUMN = 'header'","","");
		$update->updateMultipleRowMultipleWhere();
		
		$update   = new update(
		array(
		"CAP_LAN_COM_VALUE" => $content[content]),
		"CAP_LANGUAGE_COMBINE",
		"CAP_LAN_COM_FKID = '$id' AND 
		CAP_LAN_COM_LAN_ID = '$content[language]' AND 
		CAP_LAN_COM_TYPE = 'content' AND 
		CAP_LAN_COM_COLUMN = 'content'","","");
		$update->updateMultipleRowMultipleWhere();
		
		}
		
		echo "Content saved";
				
		}
		
		public static function metadata($id) {
		
		$exploder   = explode("/",$id);
		$filename   = pathinfo($id, PATHINFO_FILENAME);
		$extension  = pathinfo($id, PATHINFO_EXTENSION);
		$realPath   = $exploder[4]."/".$exploder[5]."/".$exploder[6]."/".$exploder[7]."/".$filename.".".$extension;
		
		$select = new select("*","CAP_CONTENT_METADATA",array(array("CAP_CON_MET_PATH","=",$realPath)),"",""); $select->execute();
		return $select->arrayResult;
		}
		
		public static function getPagesList($getDomain = null) {
			//$domain 	= new select("*","CAP_MAIN","","","");$domain->execute();
								
			//foreach($domain->arrayResult as $key=>$value){
				$template 	= self::getDomainTemplate($getDomain);		
				
				$mainID		= self::getDomainID($getDomain);		 
			//}
			
			$select = new select("*","CAP_PAGES",[["CAP_PAG_PATH","LIKE","view/pages/".$template."%"],["CAP_PAG_SITES","=","$mainID"]],"",""); $select->execute();
			/*foreach($select->arrayResult as $keys => $values){
				
				$getPagesTemplate = explode('/',$values['CAP_PAG_PATH']);
				$getPagesTemplate = $getPagesTemplate[2];
				
				if($getPagesTemplate == $template){
					$buildNewArray [] = $values;
				}
				
			}*/
			//print_r($buildNewArray);
			//return $buildNewArray;
			return $select->arrayResult;
		}
		
		public static function getLanguageList() {
		$select = new select("*","CAP_LANGUAGE","","",""); $select->execute();
		return $select->arrayResult;
		}
		
		public static function getContentTypeList() {
		$select = new select("*","CAP_CONTENT_TYPE","","",""); $select->execute();
		return $select->arrayResult;
		}
		
		public static function getContentCategoryList() {
		$select = new select("*","CAP_CONTENT_CATEGORY","","",""); $select->execute();
		return $select->arrayResult;
		}
		
		public function loadCapsule($id) {
		$capsuleList = capsule::getCapsuleListWhereClause($id);
			if (strpos($capsuleList[0][CAP_LIS_INIT], "\"{view}\"") !== false) {
			$capsuleList = str_replace("\"{view}\"","\"normal\"",$capsuleList[0]['CAP_LIS_INIT']);
			}
			else {
			$capsuleList = $capsuleList[0][CAP_LIS_INIT];
			}
		return $capsuleList;
		}
		
		public function loadCapsuleWithOption($id,$array) {
		$capsuleList = capsule::getCapsuleListWhereClause($id);
		$capsuleList = $capsuleList[0]['CAP_LIS_INIT'];
			foreach ($array as $key => $value) {
				foreach ($value as $key2 => $value2) {
				$capsuleList = str_replace("\"{" . strtolower($key2) . "}\"","\"$value2\"",$capsuleList);
				}
			}
		return $capsuleList;
		}
		
		public function getCapsuleOption($id) {
		$capsuleList = capsule::getCapsuleListWhereClause($id); 
		$capsuleList = array("name" => $capsuleList[0]['CAP_LIS_NAME'], "option" => encryption::base64Decoding($capsuleList[0]['CAP_LIS_OPTION']));
		return $capsuleList;
		}
		
		public function savePageLayout($id) {
		
		$select = new select();
		
		$data   = $id;
		
		  if (!empty($data)) {
    		
    		  foreach ($data['containerInfo'] as $key => $value) {
        		  
        		  $select->column      = '*';
        		  $select->tableName   = 'CAP_LIST';
        		  $select->whereClause = [['CAP_LIS_ID','=',$value['capsuleID']]];
        		  $select->execute();
        		  
        		  if (!empty($select->arrayResult)) {
                    
            		$id['containerInfo'][$key]['capsuleName'] = $select->arrayResult[0]['CAP_LIS_NAME'];
            		
                  }
              
              }
              
          }

        $container = encryption::base64Encoding($id['containerInfo']); 
		$column	= array("CAP_PAG_CONTAINER" => $container); 
		$tableName = "CAP_PAGES"; 
		$whereClause = array(array("CAP_PAG_ID","=",$id['pageID']));
		$data = new update($column,$tableName,$whereClause,$whereID,$orderClause); $last = $data->execute();
    		
		}

		public function getContentToEdit($id) {
		$select = new select("*","","","",""); $lang = $select->language;
		$select->tableName = "CAP_CONTENT LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
		 WHERE CAP_CON_ID = $id AND CAP_LAN_COM_LAN_ID = '$lang' ORDER BY CAP_LAN_COM_COLUMN ASC";
		$select->execute(); 
		
			if (empty($select->arrayResult)) {
				$select->tableName = "CAP_CONTENT LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
		 WHERE CAP_CON_ID = $id ORDER BY CAP_LAN_COM_COLUMN ASC";
		$select->execute();
			}
		
		return $select->arrayResult;
		}
		
		public function getContentToEditAjax($id,$lang) {
		$select = new select("*","","","","");
		$select->tableName = "CAP_CONTENT LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
		 WHERE CAP_CON_ID = $id AND CAP_LAN_COM_LAN_ID = '".strtolower($lang)."' ORDER BY CAP_LAN_COM_COLUMN ASC";
		$select->execute();
		return $select->arrayResult;
		}
		
		public function getFileToEdit($id,$type) {
		$select = new select("*","","","","");
		$select->tableName = "CAP_CONTENT WHERE CAP_CON_ID = $id ";
		//echo $select->query;
		$select->execute(); $path = $select->arrayResult[0][CAP_CON_CONTENT];
		$content = scandir(ROOT_PATH.$path);

			foreach ($content as $key => $value) {
				
				if ($value != '.' && $value != '..') {
				
				$array [] = array(
				
				"id"		=> $select->arrayResult[0][CAP_CON_ID],
				"name"		=> $select->arrayResult[0][CAP_CON_HEADER],
				"category"	=> $select->arrayResult[0][FK_CAP_CONTENT_CATEGORY],
				"published"	=> $select->arrayResult[0][CAP_CON_PUBLISHED],
				"pages"		=> $select->arrayResult[0][CAP_CON_PAGES],
				"type"		=> $select->arrayResult[0][FK_CAP_CONTENT_TYPE],
				"path" 		=> "library/content/$type/".$select->arrayResult[0][CAP_CON_HEADER]."/".$value
				
				);
				
				}
				
			}
		
		return $array;
		}
		
		public function deleteContent($id) {
		
		$response;
		
		$whiteList = array("library","content");
		
		$id = explode(",",$id);
		
			foreach ($id as $value) {
			
			$value = explode("/",$value);

			if ($value[1] != 'content') {
			
			$select   = new select("*","CAP_CONTENT","CAP_CON_ID","$value[0]",""); $select->executeWhereClause();
			$location = $select->arrayResult[0][CAP_CON_CONTENT]; $locationValidator = explode("/",$location);
			
				if ($locationValidator[0] != 'library') {
				
				$response .= "Delete failed. Forbidden Directory";
				
				continue;
				
					if ($locationValidator[1] != 'content') {
					
					$response .= "Delete failed. Forbidden Directory";
					
					continue;
					
					}
					
				}
				
			$check = new file(ROOT_PATH.$location); 
			
			if ($check->isDirectory()) {$check->deleteDirectory();} else {$response .= "Directory not exist";}
			
			}
			
			$deleteContent  = new delete("","CAP_CONTENT","CAP_CON_ID","$value[0]",""); $deleteContent->deleteRow();
			
			$deleteLanguage = new delete(
			"",
			"CAP_LANGUAGE_COMBINE","CAP_LAN_COM_FKID = '$value[0]' AND CAP_LAN_COM_TYPE = '$value[1]'",
			"",
			""); 
			$deleteLanguage->deleteRowMultipleWhere();
			
			unset($deleteContent); unset($deleteLanguage);
			
			}
			
		echo $response;
			
		}
		
		public function deleteFile($id) {
		
		$response;
		
		$whiteList = array("library","content");
		
		$id = explode(",",$id);
		
			foreach ($id as $value) {
			
			$checker = explode("/",$value);

				if ($checker[0] == 'library' && $checker[1] == 'content') {
				
					if (strtolower($checker[2]) == 'video') {
					
					$ext  = pathinfo($value, PATHINFO_DIRNAME)."/".pathinfo($value, PATHINFO_FILENAME)."."."jpg";
					
					$file = new file(ROOT_PATH.$value); $jpg = new file(ROOT_PATH.$ext);
					
					if ($file->isFile() && $jpg->isFile()) {$file->deleteFile(); $jpg->deleteFile();} else {$response .= "Directory not exist";}
					
					}
					
					else {
				
					$file = new file(ROOT_PATH.$value); 
			
					if ($file->isFile()) {$file->deleteFile();} else {$response .= "Directory not exist";}
					
					}
			
				}
			
			unset($file);
			
			}
			
		echo $response;
			
		}
				
		public function uploadItem($folder,$type,$files) {
		$targetFolder = ROOT_PATH.'library/content/'.strtolower($type).'/'.$folder.'/';

			if (!empty($files)) {
			$tempFile = $files['Filedata']['tmp_name'];
			$targetFile = str_replace('//','/',$targetFolder) . $files['Filedata']['name'];
			
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png','pdf','mov','3gp','flv','avi','mp4','m4v','mp3','doc','xls','rar','txt','exe');
			$fileParts = pathinfo($files['Filedata']['name']);
	
				if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				
					if (strtolower($type) == 'video') {
					$video = new video('ffmpeg',$targetFile,'640x480','jpg'); $video->thumbnail();
					}
				
				echo $files[Filedata][name] . " inserted";
				} 
				else {
				echo 'Invalid file type.';
				}
		
			}
			
		}
		
		public function uploadFile($folder,$type,$category,$pages,$published) {
		
		header('Content-Type: application/json');
		
		$fileWhiteList = array('file','video','image','audio');
		$type = strtolower($type);
		
		$file = new file(ROOT_PATH.'library/content/'.$type.'/'.$folder);
		
		if (!in_array($type,$fileWhiteList)) {
		echo json_encode(array("message" => "Request is not in our filesystem", "lastID" => ""));
		die;
		}
		
		if (empty($category) || empty($pages) || empty($folder) || empty($published)) {
		echo json_encode(array("message" => "Upload failed, please complete the form", "lastID" => ""));
		die;
		}
		
		$select = new select("*",
		"CAP_CONTENT LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID WHERE CAP_CON_HEADER = '$folder' 
		 AND CAP_CON_TYP_TYPE = '$type'","","",""); 
		 
		$select->execute(); if (!empty($select->arrayResult)) {
		$message ['message'] = 'Folder Name taken please choose another name.'; $message ['lastID']	 = '';
		echo json_encode($message); die;
		}
		
		$select = new select("*","CAP_CONTENT_TYPE WHERE CAP_CON_TYP_TYPE = '$type'","","",""); 
		$select->execute(); $typeID = $select->arrayResult[0][CAP_CON_TYP_ID];
		
		$insert   = new insert(
		array(
		"CAP_USER_CAP_USE_ID" 		=> 1,
		"FK_CAP_CONTENT_CATEGORY" 	=> $category, 
		"CAP_CON_PUBLISHED" 		=> $published,
		"FK_CAP_CONTENT_TYPE" 		=> $typeID,
		"CAP_CON_PAGES"				=> $pages,
		"CAP_CON_HEADER"			=> $folder,
		"CAP_CON_CONTENT"			=> 'library/content/'.$type.'/'.$folder),
		"CAP_CONTENT","","","");
		
		$insert->insertRowToTable(); $insert->columnMaxID = "CAP_CON_ID"; $lastID = $insert->returnMaxIDFromTable();
		if ($file->checkFolderExistence() != 1) {$file->deleteDirectory();}
		
			if ($file->createDirectory()) {
			echo json_encode(array("message" => "Upload Succeed", "lastID" => $lastID));
			} 
			else {
			$delete = new delete("","CAP_CONTENT","CAP_CON_ID",$lastID,"");  $delete->deleteRow();
			echo json_encode(array("message" => "Cannot create directory $type", "lastID" => ""));
			}
		
		}

		public function uploadEditFile($id,$oldName,$folder,$type,$category,$pages,$published) {
		
		header('Content-Type: application/json');
		
		$fileWhiteList = array('file','video','image','audio');
		$type = strtolower($type);
		
		$file = new file(ROOT_PATH.'library/content/'.$type.'/'.$folder);
				
		if (!in_array($type,$fileWhiteList)) {
		echo json_encode(array("message" => "Request is not in our filesystem", "lastID" => ""));
		die;
		}
		
		if (empty($category) || empty($pages) || empty($folder) || empty($published)) {
		echo json_encode(array("message" => "Upload failed, please complete the form", "lastID" => ""));
		die;
		}
		
		$select = new select("*",
		"CAP_CONTENT LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID WHERE CAP_CON_HEADER = '$folder' 
		 AND CAP_CON_TYP_TYPE = '$type'","","",""); 
		
		$select->execute(); 

		if (!empty($select->arrayResult)) {
		
			if ($select->arrayResult[0][CAP_CON_CONTENT] == "library/content/$type/".$folder) {
			
				if ("library/content/$type/".$folder != "library/content/$type/".$oldName) {
			
				$message ['message'] = 'Folder Name taken please choose another name.'; $message ['lastID']	 = '';
				echo json_encode($message); die;
				
				}
				
				else {
				
					if ($file->renameDirectory(ROOT_PATH."library/content/$type/".$oldName)) {
					$lastID = 1;
					//echo json_encode(array("message" => "Rename Succeed", "lastID" => '1'));
					}
								
				}
			
			}
			else {
			
				if ($file->renameDirectory(ROOT_PATH."library/content/$type/".$oldName)) {
				$lastID = 1;
				//echo json_encode(array("message" => "Rename Succeed", "lastID" => '1'));
				}
							
			}
			
		}
		
		else {
			
			if ($file->renameDirectory(ROOT_PATH."library/content/$type/".$oldName)) {
			$lastID = 1;
			//echo json_encode(array("message" => "Rename Succeed", "lastID" => '1'));
			}
					
		}
		
		
		$update   = new update(
		array(
		"FK_CAP_CONTENT_CATEGORY" 	=> $category, 
		"CAP_CON_CONTENT"		 	=> 'library/content/'.$type.'/'.$folder, 
		"CAP_CON_PUBLISHED" 		=> $published,
		"CAP_CON_PAGES"				=> $pages,
		"CAP_CON_HEADER"			=> $folder),
		"CAP_CONTENT","CAP_CON_ID","$id","");
		
			if ($update->updateMultipleRowWhereID()) {
			echo json_encode(array("message" => "Upload Succeed", "lastID" => $lastID));
			}
			else {
			echo json_encode(array("message" => "Upload Succeed", "lastID" => $lastID));
			}

		}
		
		public function getCompleteLanguageList() {
		
		$select = new select("*","CAP_LANGUAGE","","","");

		$select->execute();

		return $select->arrayResult;
		
		}
		
		public function saveNewMenuStructure($id,$delMenuList,$delMenuSet,$lang) {
		//print_r($id);
		$selectSystemLanguage = new select("*","CAP_LANGUAGE","","",""); $selectSystemLanguage->execute();
		
		$systemLanguage = $selectSystemLanguage->arrayResult;
						//print_r($id);
			//Looping the menu set structure
			if (!empty($id)) {
			
				foreach ($id as $value) {
				
				$i = 0;
				
				$mainID = self::getDomainID($value[domain]);
				
				/*$getMainID = new select("*","CAP_MAIN",[["CAP_MAI_DOMAIN","=","$value[domain]"]]);$getMainID->execute();
				$mainID = $getMainID->arrayResult[0]['CAP_MAI_ID'];*/
							
				$select   = new select("*","CAP_MENU_TYPE",array(array("CAP_MEN_TYP_ID","=",$value['id'])),"",""); 
				
				$select->execute();
				
				$update   = new update(array("CAP_MEN_TYP_TYPE" => $value['name']),"CAP_MENU_TYPE",array(array("CAP_MEN_TYP_ID","=",$value['id'])),"",""); 
				$insert   = new insert(array("CAP_MEN_TYP_TYPE" => $value['name'],"FK_CAP_MAI_ID" => $mainID),"CAP_MENU_TYPE","CAP_MEN_ID","",""); 
				
				$updateMp = new update("","CAP_MENU_PAGES","","",""); 
				$insertMp = new insert("","CAP_MENU_PAGES","","",""); 
				
				$updateLa = new update("","CAP_LANGUAGE_COMBINE","","",""); 
				$insertLa = new insert("","CAP_LANGUAGE_COMBINE","","",""); 
				
					if (empty($select->arrayResult)) {
					$insert->whereClause = "CAP_MEN_TYP_ID";
					$laster = $insert->execute();
					}
					else {
					$update->execute();
					$laster = $select->arrayResult[0]['CAP_MEN_TYP_ID'];
					}
					
					if (empty($value['child'])) {continue;}
					
					//Looping inside of the menu set structure
					foreach ($value['child'] as $child) {
					
						if (empty($child[8])):
						
						$parentKey = NULL;
						
						else:
						
						$parentKey = $child[8];
						
						endif;
					
					if (preg_match("![A-Za-z]!",$child[0])):
							
					$child[0] = null;
							
					endif;
					
					$select->tableName 	 = "CAP_MENU";
					$select->whereClause = array(array("CAP_MEN_ID","=",$child[0]));
					
					$insert->tableName 	 = "CAP_MENU";
						
						if (!empty($parentKey)) {
							
							foreach ($array as $arrayKey => $arrayValue) {
	
								if ($arrayValue['id'] == $parentKey) {
	
									$searchParent = $arrayValue['insertID'];
									
									break;
										
								}
								
							}
							
						}
					
					$column = array(
					"CAP_MEN_NAME" 	 	=> ltrim(rtrim($child[1])),
					"CAP_MEN_IMG" 		=> $child[3],
					"CAP_MEN_OTHERURL" 	=> $child[4],
					"CAP_MEN_ACCESS" 	=> $child[5],
					"CAP_MEN_STATUS" 	=> $child[6],
					"CAP_MENU_TYPE_CAP_MEN_TYP_ID" => $laster,
					"CAP_MEN_PARENT" 	=> $searchParent,
					"CAP_MEN_POSITION" 	=> $child[10],
					"CAP_MEN_POSITION2"	=> $i++);
	
					$select->execute();

						if (empty($select->arrayResult)) {

							$insert->column = $column;

							$lastID = $insert->execute();
							
							if (empty($child[9])) {$child[9] = null;}
							
							$insertMp->column = array("CAP_MENU_CAP_MEN_ID" => $lastID, "CAP_PAGES_CAP_PAG_ID" => $child[9]);

							$insertMp->execute();
							
								foreach ($systemLanguage as $keyLanguage => $valueLanguage) {
									
									$insertLa->column = array(
									"CAP_LAN_COM_COLUMN" 	  => "CAP_MEN_NAME",
									"CAP_LAN_COM_VALUE" 	  => ltrim(rtrim($child[1])),
									"CAP_LAN_COM_DESCRIPTION" => ltrim(rtrim($child[2])),
									"CAP_LAN_COM_FKID" 		  => $lastID, 
									"CAP_LAN_COM_LAN_ID"	  => $valueLanguage['CAP_LAN_ID'],
									"CAP_LAN_COM_TYPE" 		  => "menu"
									);

								$insertLa->execute();
										
								}
							
						$array [] =  array("id" => $child[0], "insertID" => $lastID, "menuName" => ltrim(rtrim($child[1])));
							
						}
						else {
							
							$lastID = $child[0];
							
							if (empty($child[9])) {$child[9] = null;}
							
							$column = array(
							"CAP_MEN_NAME" 	 	=> ltrim(rtrim($child[1])),
							"CAP_MEN_IMG" 		=> $child[3],
							"CAP_MEN_OTHERURL" 	=> $child[4],
							"CAP_MEN_ACCESS" 	=> $child[5],
							"CAP_MEN_STATUS" 	=> $child[6],
							"CAP_MENU_TYPE_CAP_MEN_TYP_ID" => $laster,
							"CAP_MEN_PARENT" 	=> $searchParent,
							"CAP_MEN_POSITION" 	=> $child[10],
							"CAP_MEN_POSITION2"	=> $i++);
													
							$update->tableName 		= "CAP_MENU";
							$update->whereClause 	= array(array("CAP_MEN_ID","=",$lastID));
							$update->column 	 	= $column;
														
							$updateMp->whereClause	= array(array("CAP_MENU_CAP_MEN_ID","=",$lastID));
							$updateMp->column 	 	= array("CAP_MENU_CAP_MEN_ID" => $lastID, "CAP_PAGES_CAP_PAG_ID" => $child[9]);
							$updateLa->whereClause	= array(
														array("CAP_LAN_COM_FKID","=",$lastID),
														array("CAP_LAN_COM_LAN_ID","=",$lang),
														array("CAP_LAN_COM_TYPE","=","menu")
													  );	
							$updateLa->column  		= array("CAP_LAN_COM_VALUE" => ltrim(rtrim($child[1])),"CAP_LAN_COM_DESCRIPTION" => ltrim(rtrim($child[2])));
							//print_r($updateMp->column); echo $lastID."asasas";
							
							$update->execute();
																					
							$selectCheckPages = new select("*","CAP_MENU_PAGES",array(array("CAP_MENU_CAP_MEN_ID","=",$lastID)),"","");
							//print_r($selectCheckPages->whereClause);
							$selectCheckPages->execute();
								
								if (!empty($selectCheckPages->arrayResult)) {
							
									$updateMp->execute();
									
								}
								else {
									
									$insertMp->column = array("CAP_MENU_CAP_MEN_ID" => $lastID, "CAP_PAGES_CAP_PAG_ID" => $child[9]);
																			
									$insertMp->execute();
								
								}
							
							$updateLa->execute();
						
						$array [] =  array("id" => $lastID, "insertID" => $lastID, "menuName" => ltrim(rtrim($child[1])));
						
						}
											
					unset($lastID); unset($searchParent);
					
					}
				
				}
					
			}
			
				if (!empty($delMenuList)) {
			
				$delMenuListExplode = substr($delMenuList, 0, -1); $delMenuListExplode = explode(",",$delMenuListExplode);			
					foreach ($delMenuListExplode as $value) {
			
					$delete = new delete("","CAP_MENU","CAP_MEN_ID",$value,"");  $delete->deleteRow();
					
					$delete = new delete(
							  "",
							  "CAP_LANGUAGE_COMBINE",
							  "CAP_LAN_COM_FKID = '$value' AND CAP_LAN_COM_TYPE = 'menu'",
							  "",
							  "");  
					$delete->deleteRowMultipleWhere();
			
					}
				
				unset($delete);
				
				}
				
				if (!empty($delMenuSet)) {

				$delMenuSetExplode = substr($delMenuSet, 0, -1); $delMenuSetExplode = explode(",",$delMenuSetExplode);

					foreach ($delMenuSetExplode as $value) {
					
					$selectLanguage = new select("CAP_MEN_ID","CAP_MENU",array(array("CAP_MENU_TYPE_CAP_MEN_TYP_ID","=",$value)),"","");
					
					$selectLanguage->execute();
						  
						  if (!empty($selectLanguage->arrayResult)) {
						  
						  	foreach ($selectLanguage->arrayResult as $deleteLang) {
						  	
						  	$delete  = new delete("",
						  	"CAP_LANGUAGE_COMBINE",
						  	"CAP_LAN_COM_FKID = $deleteLang[CAP_MEN_ID] AND CAP_LAN_COM_TYPE = 'menu'","","");  $delete->deleteRowMultipleWhere();
						  	
						  	}
						  
						  }
					
					$delete  = new delete("","CAP_MENU_TYPE","CAP_MEN_TYP_ID",$value,"");  $delete->deleteRow();
			
					}
				
				unset($delete);
				
				}
				
		
		}
		
		public function getDomainID($domainName){
					
			if(empty($domainName)){
				$domainName = $_SERVER['HTTP_HOST'];
			}
			
				
	   $domainName = explode('.',$domainName);
	   
	   if($domainName[0]=='www'){
		   $domainName[0] = "";
	   }
	   
	   $countArr = count($domainName);
	   $i = 1;
	   foreach($domainName as $key => $value){
		   $buildDomain .= $value;
		   if(!empty($value) && $i < $countArr ){
			   $buildDomain .= '.';
		   }
		   $i++;
	   }
	   $domainName = $buildDomain;
	   			   
	   		$domain		= new select("","","");
	   		
	   		$domain->column = "CAP_MAI_ID";
	   		$domain->tableName = "CAP_MAIN";
	   		$domain->whereClause = [["CAP_MAI_DOMAIN","=",$domainName]];
	   		$domain->execute();
	   		$mainID = $domain->arrayResult[0]['CAP_MAI_ID'];
	   		if(empty($mainID)){
	   
	   		$domain->column = "a.CAP_MAI_ID";
	   		$domain->tableName = "CAP_MAIN a, ".str_replace('/','',APP).".CAP_MAIN b WHERE a.CAP_MAI_PARENT = b.CAP_MAI_ID AND a.CAP_MAI_DOMAIN  || '.' ||  b.CAP_MAI_DOMAIN ='$domainName'";
	   		$domain->whereClause = "";
			$domain->execute();
			$mainID = $domain->arrayResult[0]["CAP_MAI_ID"];
			}    
        return $mainID;
	        
			
		}
		
		public function getDomainTemplate($domainName){
		
			
			if(empty($domainName)){
				$domainName = $_SERVER['HTTP_HOST'];
			}
			
			
				$domain 	= new select("*","CAP_MAIN","","","");$domain->execute();
				foreach($domain->arrayResult as $key=>$value){
					$makeDomain = $value['CAP_MAI_DOMAIN'] ;
					if(!empty($value['CAP_MAI_PARENT'])){
						$subdomain 	= new select("*","CAP_MAIN",[["CAP_MAI_ID","=",$value['CAP_MAI_PARENT']]],"","");$subdomain->execute();
						$makeDomain .= '.'  . $subdomain->arrayResult[0]['CAP_MAI_DOMAIN'];
						
					}
					if($domainName == $makeDomain){
						$mainID = $value['CAP_MAI_TEMPLATE'];
						break;
					}
					 
				}
			
			
			return $mainID;
			
		}
					
		public function getMenuList($id=null, $mainDomain=null,$withDisableMenu = null, $page = null, $limit = null) {
			
			$misc = new misc();
					
			$mainID = self::getDomainID($mainDomain);
				
			(empty($withDisableMenu))?
								$data = new select("*","CAP_MENU_TYPE",[["FK_CAP_MAI_ID","=","$mainID"]],"","CAP_MEN_TYP_ID ASC"):
								$data = new select("*","CAP_MENU_TYPE",[["FK_CAP_MAI_ID","=","$mainID"],["","OR",""],["CAP_MEN_SET_TO_INVISIBLE","=","1"]],"","CAP_MEN_TYP_ID ASC");
			
			if($page!=null && $limit != null){
				$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);
		
				$data->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
			}
			
			$data->execute();
		
			if (empty($id)) {$language = self::defaultLanguage();} else {$language = $id;}

			if (!empty($data->arrayResult)) {
			
				foreach($data->arrayResult as $value) {
				
				$subData = new select(
						   "*",
						   "CAP_MENU 
						    LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
						    LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID",
						   array(
						   		array("CAP_MENU_TYPE_CAP_MEN_TYP_ID","=",$value['CAP_MEN_TYP_ID'])
						   	),
						   "",
						   "CAP_MEN_ID ASC"); 
					
				$subData->execute();

					if (is_array($subData->arrayResult)) {
	
						foreach ($subData->arrayResult as $checker) {
					
						$checkLanguage = 
						
						new select("*",
							
							"CAP_MENU 
							LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
							LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID 
							LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID",
							array(
								array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID","=",$checker['CAP_MEN_ID']),
								array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_LAN_ID","=",$language),
								array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_TYPE","=","menu")
							),"","CAP_MEN_POSITION ASC"); 
						
						$checkLanguage->execute();
							
							if (empty($checkLanguage->arrayResult)) {
		
							$checkLanguage =
							
							new select("*",
							
							"CAP_MENU 
							LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
							LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID 
							LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID",
							array(
								array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID","=",$checker['CAP_MEN_ID']),
								array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_LAN_ID","=",$data->language),
								array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_TYPE","=","menu")
							),"","CAP_MEN_POSITION ASC");
						
							$checkLanguage->execute();
							
							$language = self::defaultLanguage();
							
							}
						
						$subData->arrayResult = $checkLanguage->arrayResult;
						
							if (!empty($subData->arrayResult)) {
							
							$flag = false;
							
								foreach ($subData->arrayResult as $valueSub) {
								
									if (!empty($processed)) {
																				
										foreach ($processed as $recheck) { 
											
											if ($valueSub['CAP_MEN_ID'] == $recheck) {$flag = true; break;}
											
										}
										
										if ($flag) {continue;}
										
									}
																	
								$theChild = self::getRecursiveMenuList($valueSub['CAP_MEN_ID'],$theChild,$language,$processed);
								
								$processed [] = $valueSub['CAP_MEN_ID'];
								
									if (empty($theChild)) {
									$theMenuTree [] = array("parent" => $valueSub);
									}
									else {
									$theMenuTree [] = array("parent" => $valueSub, "child" => $theChild);
									}
	
								unset($theChild); 
															
								}
							
							}
						
						}
										
					}
				
				$completeMenuList [] = array(
								  	   "menuSetID" => $value['CAP_MEN_TYP_ID'], 
								  	   "menuSetName" => $value['CAP_MEN_TYP_TYPE'], 
									   "parentMenuSet" => $theMenuTree,
									   "paging"=>$pagging);
	
				unset($subData);
				unset($theMenuTree);
				
				}
			
			}
		return $completeMenuList;
		
		}
		
		public function getRecursiveMenuList($id,&$menuTree,$language,&$processed) {
				
		$subDataRecursive = new select(
					   		"*",
					   		"CAP_MENU 
					   		LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
					    	LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID
					    	LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID",
					   		array(
					   			array("CAP_MENU.CAP_MEN_PARENT","=",$id),
					   			array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_LAN_ID","=",$language),
					   			array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_TYPE","=","menu")
					   		),"","CAP_MEN_POSITION ASC"); 
			
		$subDataRecursive->execute();
		
		if (!empty($subDataRecursive->arrayResult)) {

				foreach ($subDataRecursive->arrayResult as $key => $value) {

				$newID	   = $value['CAP_MEN_ID'];
				$processed[] = $value['CAP_MEN_ID'];
				$array  [] = $value;
				$name      = $value;
				$theChild  = self::getRecursiveMenuList($newID,$array[],$language,$processed);
								
				if (empty($theChild)) {
				$menuTree  [] = array("parent" => $name);
				}
				else {
				$menuTree  [] = array("parent" => $name, "child" => $theChild);
				}
				
            	unset($array);
				}
			
            }	

		return $menuTree;
		
		}
		
		public function getContentList() {
		
		$lang = self::defaultLanguage();
		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID
		 ORDER BY CAP_CON_CREATED DESC",
		"","",""); $data->execute();
			
		return $data->arrayResult;
		
		}

		public function getSitesListUser() {
				
		$data = new select('*','CAP_MAIN','','','CAP_MAI_ID ASC'); 

		$data->execute();

		return $data->arrayResult;
		
		}
		
		public function getSitesList($page, $limit, $search = false) {
		
		$update 	= new update();
		$misc 		= new misc();
		
		$data 		= new select("*","CAP_MAIN",[["CAP_MAI_PARENT","","IS NULL"]],"","CAP_MAI_ID ASC",""); 
		if($page!=null && $limit != null){
		$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);

		$data->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
		}
		$data->execute();

			if (!empty($data->arrayResult)):

			$i = 0;

			$update->transactionStart();

				foreach ($data->arrayResult as $key => $value):

					if (!empty($value['CAP_MAI_TEMPLATE'])):

						if (!is_dir(ROOT_PATH."view/pages/".$value['CAP_MAI_TEMPLATE'])):

							$update->column = ["CAP_MAI_TEMPLATE" => null];

							$update->tableName = "CAP_MAIN";

							$update->whereClause = [["CAP_MAI_ID","=",$value['CAP_MAI_ID']]];

							$result = $update->execute();

							$i = (!$result) ? $i + 1 : $i;

							$value['CAP_MAI_TEMPLATE'] = null;

							$array [] = $value;

						else:

						$array [] = $value;

						endif;

					else:

					$array [] = $value;	

					endif;

				endforeach;

			endif;
		
		if ($i == 0): $update->transactionSuccess(); else: $update->transactionFailed(); endif;
			if($page!=null && $limit != null){
			$newArray= ["data"=>$array,"paging"=>$pagging];
			return $newArray;
			}else{
				return $array;
			}
		
		}
		
		public function getSitesAllSites(){
		
			$userid = user::getID();

			$getDomain = admin::getSubSitesList();
			
			foreach($getDomain as $key => $value){
				
				$getSubDomain = admin::getSubSitesList($value['CAP_MAI_ID']);
								
				if(!empty($getSubDomain)){
					foreach($getSubDomain as $keys => $values){
						$subDomain []= $values['CAP_MAI_DOMAIN'];
					}
					$buildNewArray []= ["domain"=>$value['CAP_MAI_DOMAIN'],"subdomain"=>$subDomain];
				}else{
					$buildNewArray []= ["domain"=>$value['CAP_MAI_DOMAIN']];
				}
				unset($subDomain);
			}
			
			return $buildNewArray;
			
		}
		
		public function getSubSitesList($id = null,$page=null, $limit=null) {
		
			$misc = new misc();
			
			$update = new update();
			
			
	
			$data = new select("*","CAP_MAIN","","","CAP_MAI_ID ASC"); 
			
								if(!empty($id) && $id != 'allsites' ){
									
									$data->whereClause = [["CAP_MAI_PARENT","=",$id]];
									
								}else{
								
									$data->whereClause = [["CAP_MAI_PARENT","","IS NULL"]];
									
								}
			if($page!=null && $limit != null){
				$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);
		
				$data->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
			}
			$data->execute();
	
				if (!empty($data->arrayResult)):
	
				$i = 0;
	
				$update->transactionStart();
	
					foreach ($data->arrayResult as $key => $value):
	
						if (!empty($value['CAP_MAI_TEMPLATE'])):
	
							if (!is_dir(ROOT_PATH."view/pages/".$value['CAP_MAI_TEMPLATE'])):
	
								$update->column = ["CAP_MAI_TEMPLATE" => null];
	
								$update->tableName = "CAP_MAIN";
															
									$update->whereClause = [["CAP_MAI_ID","=",$value['CAP_MAI_ID']]];
								
								$result = $update->execute();
	
								$i = (!is_resource($result)) ? $i + 1 : $i;
	
								$value['CAP_MAI_TEMPLATE'] = null;
	
								$array [] = $value;
	
							else:
	
							$array [] = $value;
	
							endif;
	
						else:
	
						$array [] = $value;	
	
						endif;
	
					endforeach;
	
				endif;
			
			if ($i == 0): $update->transactionSuccess(); else: $update->transactionFailed(); endif;
			if($page!=null && $limit != null){
				$newArray= ["data"=>$array,"paging"=>$pagging];
				return $newArray;
			}else{
				return $array;
			}

		
		}


		public function getTagonomyList($mainID,$page,$limit) {
		
			$lang = self::defaultLanguage();
			
			$misc = new misc();
			
			$mainID = (empty($mainID))?self::getDomainID($_SERVER['HTTP_HOST']) : self::getDomainID($mainID);
						
			$data = new select("*","CAP_CONTENT_CATEGORY",[["FK_CAP_MAI_ID","=","$mainID"]],"","CAP_CON_CAT_NAME ASC"); 
			
			if($page!=null && $limit != null){
				$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);
		
				$data->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
			}
			
			$data->execute();
			
			$array = $data->arrayResult;
			
			if($page!=null && $limit != null){
				$newArray= ["data"=>$array,"paging"=>$pagging];
				return $newArray;
			}else{
				return $array;
			}
		
		}
		
		public function getUserList($mainID = null,$page=null, $limit=null) {
		$sessionRole = $_SESSION['role'];
		$misc	= new misc();
		$lang   = self::defaultLanguage();
		$mainID = (!is_numeric($mainID))?null:$mainID;
				
		if(empty($mainID) && $sessionRole != 2){
			$data = new select('*','CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.CAP_USE_ID = CAP_MAIN.FK_CAP_USE_ID',[['CAP_USE_GLOBAL','=',1]],'','CAP_USE_FIRSTNAME ASC'); 
		}
		elseif ($sessionRole == 2) {
			$mainID   = $GLOBALS['_neyClass']['sites']->domain();
			$data = new select('*','CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.CAP_USE_ID = CAP_MAIN.FK_CAP_USE_ID',[['FK_CAP_MAI_ID','=',$mainID],['','OR',''],['FK_CAP_MAI_ID_LOCATION','=',$mainID]],'','CAP_USE_FIRSTNAME ASC');
			
		}
		else{
			$data = new select('*','CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.CAP_USE_ID = CAP_MAIN.FK_CAP_USE_ID',[['FK_CAP_MAI_ID','=',$mainID],['','OR',''],['FK_CAP_MAI_ID_LOCATION','=',$mainID]],'','CAP_USE_FIRSTNAME ASC'); 
		}
		
		if($page!=null && $limit != null){
		$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);

		$data->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
		}
		
		
		$data->execute();
		
			if (!empty($data->arrayResult)):

			$array = $data->arrayResult;

				foreach ($array as $key => $value):

					unset($userRoles);

					$data->column = "*";

					$data->tableName = "CAP_USER_ROLE_COMBINE";

					$data->whereClause = [["FK_CAP_USE_ID","=",$value['CAP_USE_ID']]];

					$data->orderClause = null;
					
					$data->limitClause = null;

					$data->execute();
					
					if (!empty($data->arrayResult)):

						foreach ($data->arrayResult as $roles):

							$userRoles [] = $roles['FK_CAP_USE_ROL_ID'];
							
							
							//print_r($userRoles);

						endforeach;

						$array [$key]['ROLES'] = $userRoles;

					endif;

				endforeach;

			endif;

			if($page!=null && $limit != null){
				$newArray= ["data"=>$array,"paging"=>$pagging];
				return $newArray;
			}
			else {
				return $array;
			}
		
		}
		
		public function searchUserSet($mainID = null,$page=null, $limit=null) {

		$misc	= new misc();
		
		$lang   = self::defaultLanguage();
		
		$text   = strtolower(ltrim(rtrim($mainID[0])));
		
		$page   = $mainID[1];
			
		$length = strlen($text);
		
		$mainID = (!is_numeric($page))?null:$page;
		
		$sessionRole = $_SESSION['role'];
				
		if ($sessionRole == 2) {
			
			$mainID   = $GLOBALS['_neyClass']['sites']->domain();
			
			$data = new select("*, (CAP_USE_FIRSTNAME || ' ' || CAP_USE_LASTNAME) AS FULLNAME","CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.FK_CAP_MAI_ID = CAP_MAIN.CAP_MAI_ID",
			[["(LOWER(CAP_USE_FIRSTNAME) || ' ' || LOWER(CAP_USE_LASTNAME))","LIKE","%".$text."%"],
			["FK_CAP_MAI_ID","=",$mainID],
			["","OR",""],
			["(LOWER(CAP_USE_FIRSTNAME) || ' ' || LOWER(CAP_USE_LASTNAME))","LIKE","%".$text."%"],
			["FK_CAP_MAI_ID_LOCATION","=",$mainID]],"","CAP_USE_FIRSTNAME ASC");
			
		}
		else {
		
			if (empty($mainID)) {
			
				$data = new select("*, (CAP_USE_FIRSTNAME || ' ' || CAP_USE_LASTNAME) AS FULLNAME","CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.FK_CAP_MAI_ID = CAP_MAIN.CAP_MAI_ID",
				[["(LOWER(CAP_USE_FIRSTNAME) || ' ' || LOWER(CAP_USE_LASTNAME))","LIKE","%".$text."%"],
				["CAP_USE_GLOBAL","=",1]],"","CAP_USE_FIRSTNAME ASC"); 
				
			}
			else {
			
				$data = new select("*, (CAP_USE_FIRSTNAME || ' ' || CAP_USE_LASTNAME) AS FULLNAME","CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.FK_CAP_MAI_ID = CAP_MAIN.CAP_MAI_ID",
				[["(LOWER(CAP_USE_FIRSTNAME) || ' ' || LOWER(CAP_USE_LASTNAME))","LIKE","%".$text."%"],
				["FK_CAP_MAI_ID","=",$mainID],
				["","OR",""],
				["(LOWER(CAP_USE_FIRSTNAME) || ' ' || LOWER(CAP_USE_LASTNAME))","LIKE","%".$text."%"],
				["FK_CAP_MAI_ID_LOCATION","=",$mainID]],"","CAP_USE_FIRSTNAME ASC");
				 
			}
			
		}
			
			if (!empty($text) && $length <= 5):
				
				$data->limitClause = 200;				
			
			elseif (!empty($text) && $length >= 5):
			
				$data->limitClause = 200;
			
			else:
											
				$data->limitClause = 20;
							
			endif;
					
		$data->execute();

			if (!empty($data->arrayResult)):

			$array = $data->arrayResult;

				foreach ($array as $key => $value):

					unset($userRoles);

					$data->column = "*";

					$data->tableName = "CAP_USER_ROLE_COMBINE";

					$data->whereClause = [["FK_CAP_USE_ID","=",$value['CAP_USE_ID']]];

					$data->orderClause = null;
					
					$data->limitClause = null;

					$data->execute();
					
					if (!empty($data->arrayResult)):

						foreach ($data->arrayResult as $roles):

							$userRoles [] = $roles['FK_CAP_USE_ROL_ID'];

						endforeach;

						$array [$key]['ROLES'] = $userRoles;

					endif;

				endforeach;

			endif;

			if($page!=null && $limit != null){
			
				$newArray= ["data"=>$array,"paging"=>$pagging];
				
				return $newArray;
				
			}
			
			else {
			
				return $array;
				
			}
		
		}

		public function getUserToEdit($id) {
		
		$lang = self::defaultLanguage();
		
		$data = new select("*","CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.FK_CAP_MAI_ID_LOCATION = CAP_MAIN.CAP_MAI_ID",[["CAP_USE_ID","=",$id]],"","CAP_USE_FIRSTNAME ASC"); $data->execute();
		
			if (!empty($data->arrayResult)):

			$array = $data->arrayResult;
			
				foreach ($array as $key => $value):

					unset($userRoles);

					$data->column = "*";

					$data->tableName = "CAP_USER_ROLE_COMBINE";

					$data->whereClause = [["FK_CAP_USE_ID","=",$value['CAP_USE_ID']]];

					$data->orderClause = null;

					$data->execute();

					if (!empty($data->arrayResult)):

						foreach ($data->arrayResult as $roles):

							$userRoles [] = $roles['FK_CAP_USE_ROL_ID'];

						endforeach;

						$array [$key]['ROLES'] = $userRoles;

					endif;

				endforeach;

			endif;

			if (!empty($array[0]['CAP_MAI_PARENT'])):
			
			$data = new select("*","CAP_MAIN",[["CAP_MAI_ID","=",$array[0]['CAP_MAI_PARENT']]]); $data->execute();
			
				if (!empty($data->arrayResult[0]['CAP_MAI_DOMAIN'])):
				
					$array[0]['PARENT_DOMAIN'] = $data->arrayResult[0]['CAP_MAI_DOMAIN'];
				
				endif;
			
			endif;

		return $array[0];
		
		}
		


		
		public function getRoleList($mainID = null,$page = null,$limit = null) {
				$misc = new misc();
				if(!empty($mainID)):
				$mainID = self::getDomainID($mainID);
				$data = new select("*","CAP_USER_ROLE",[["FK_CAP_MAI_ID","=","$mainID"],['CAP_USE_ROL_ID',"!=",1],['CAP_USE_ROL_ID',"!=",2],['CAP_USE_ROL_ID',"!=",3],['CAP_USE_ROL_ID',"!=",4]],"","CAP_USE_ROL_NAME ASC"); 
			
				else:
				$currentDomain =  self::getDomainID($mainID);
				$data = new select("*","CAP_USER_ROLE",[["FK_CAP_MAI_ID","=","$currentDomain"],["","OR",""],["FK_CAP_MAI_ID","","IS NULL"]],"","CAP_USE_ROL_NAME ASC"); 
				endif;
				if($page!=null && $limit != null){
					$pagging 	= $misc->getPagging($limit,$page,$data->column,$data->tableName,$data->whereClause);
			
					$data->limitClause = $pagging[0]['limit']." OFFSET ".$pagging[0]['offset'];
				}
				$data->execute();
				$array = $data->arrayResult;
				if($page !=null && $limit != null){
					$newArray= ["data"=>$array,"paging"=>$pagging];
					return $newArray;
				}else{
					return $array;
				}
		
		}
				
		public function defaultLanguage() {
		$select = new select("*","CAP_MAIN","","",""); $select->execute();
		return $select->arrayResult[0]['CAP_MAI_LANGUAGE'];
		}
		
		public function updateContentGlobal($id) {
		
			if (is_array($id)):
			
				foreach ($id as $value):
				
				$array = array("FK_CAP_CONTENT_CATEGORY" => $value[1], "CAP_CON_PAGES" => $value[2]);
				
				$update = new update($array,"CAP_CONTENT",array(array("CAP_CON_ID","=",$value[0])),"",""); 
				
				$update->execute();
				
				unset($update);
				
				endforeach;
			
			endif;
		
		}
		
		public function getAllTemplate() {
			
			$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");

			$list = @scandir(ROOT_PATH."view/pages/");
	
			if (!empty($list)):
	
				foreach ($list as $key => $value):
	
					if ($value == '.' || $value == '..'): continue; endif;
				
					if (in_array($value,$whiteList)): continue; endif;
	
					$option [] = $value;
	
				endforeach;
	
			endif;
			
		return $option;
			
		}
		
		public function saveNewSites($id,$delMenuList) {
		
			if (!empty($delMenuList)):
			
			$list = explode(",",$delMenuList);

			$delete = new delete();

				foreach ($list as $key => $value):
					
					if (!empty($value)):

					$delete->tableName = "CAP_MAIN";

					$delete->whereClause = [["CAP_MAI_ID","=",$value]];

					$result = $delete->execute();

					$i = (!result) ? $i + 1 : $i;

					endif;
					
				endforeach;
			
			endif;
			
			$insert = new insert();

			$update = new update();

			$insert->transactionStart();

			$update->transactionStart();

			if (!empty($id)):

			$i = 0;

				foreach ($id as $key => $value):
					$value[6] = ($value[6] == 'allsites' || empty($value[6]))?null:$value[6];
					if (empty($value[0])):

						$insert->column = [
										   "CAP_MAI_DOMAIN" 	 => $value[1],
										   "CAP_MAI_NAME"		 => $value[2],
										   "CAP_MAI_TEMPLATE" 	 => $value[3],
										   "CAP_MAI_LANGUAGE" 	 => $value[4],
										   "CAP_MAI_SITE_ACTIVE" => $value[5],
										   "CAP_MAI_PARENT"		 => $value[6]
										  ];

						$insert->tableName = "CAP_MAIN";

						$insert->whereClause = "CAP_MAI_ID";

						$lastID = $insert->execute();

						$i = (!is_numeric($lastID) || empty($lastID)) ? $i + 1 : $i;

					else:
						$update->column = [
										   "CAP_MAI_DOMAIN" 	 => $value[1],
										   "CAP_MAI_NAME"		 => $value[2],
										   "CAP_MAI_TEMPLATE" 	 => $value[3],
										   "CAP_MAI_LANGUAGE" 	 => $value[4],
										   "CAP_MAI_SITE_ACTIVE" => $value[5],
										   "CAP_MAI_PARENT"		 => $value[6]
										  ];

						$update->tableName = "CAP_MAIN";

						$update->whereClause = [["CAP_MAI_ID","=",$value[0]]];

						$lastID = $update->execute();

						$i = (!is_resource($lastID) || empty($lastID)) ? $i + 1 : $i;

					endif;
					
				endforeach;

			endif;

			if ($i == 0):

				$insert->transactionSuccess();

				$update->transactionSuccess();

			else:

				$insert->transactionFailed();

				$update->transactionFailed();

			endif;
					
		}

		public function saveNewTagonomy($id,$delMenuList) {
			
			$primer = $GLOBALS['_neyClass']['sites']->domain();

			if (!empty($delMenuList)) {
			
			$list = explode(",",$delMenuList);

				foreach ($list as $key => $value) {
					
					if (!empty($value)) {
					$delete = new delete("","CAP_CONTENT_CATEGORY","CAP_CON_CAT_ID","$value",""); $delete->deleteRow();
					}
					
				}
			
			}
			
			if (!empty($id)):

				foreach ($id as $key => $value) {
					
					$mainID = (empty($value[2])) ? $primer : self::getDomainID($value[2]);

					if (empty($value[0])) {
					$insert = new insert(array("CAP_CON_CAT_NAME" => $value[1],"FK_CAP_MAI_ID" => $mainID),"CAP_CONTENT_CATEGORY","","",""); $insert->execute();
					}
					else {
					$update = new update(array("CAP_CON_CAT_NAME" => $value[1]),"CAP_CONTENT_CATEGORY",array(array("CAP_CON_CAT_ID","=",$value[0])),"",""); $update->execute();
					}
					
				}
			
			endif;
		
		}
		
	public function saveNewUser($id,$delMenuList) {
		
	$i = 0;

	$select = new select(); $insert = new insert(); $update = new update(); $delete = new delete();

	$insert->transactionStart(); $update->transactionStart(); $delete->transactionStart();
		
		if (!empty($delMenuList)):
			
		$list = explode(",",$delMenuList);

			foreach ($list as $key => $value):
					
				if (!empty($value)):

				$delete->tableName = "CAP_USER";

				$delete->whereClause = [["CAP_USE_ID","=",$value]];

				$lastIDRole = $delete->execute();

				$i = (!$lastIDRole) ? $i + 1 : $i;

				endif;
					
			endforeach;
			
		endif;

	if ($i == 0):

		$delete->transactionSuccess();

	else:

		$delete->transactionFailed();

	endif;
		
	}
	
	public function editUser($id) {
	//print_r($id);
	$value = $id;
	
	$select = new select(); $insert = new insert(); $update = new update(); $delete = new delete();

	$insert->transactionStart(); $update->transactionStart(); $delete->transactionStart();
	
		if (!empty($value)):
		
		$firstName = reset(explode(' ',trim($value['name'])));
				
		$lastName  = explode(' ',trim($value['name'])); unset($lastName[0]); $lastName = implode(' ',$lastName);
		
			if (empty($value['id'])):

			$insert->tableName = "CAP_USER";
							
			$insert->column = [
			"CAP_USE_FIRSTNAME"   => $firstName,
			"CAP_USE_LASTNAME"    => $lastName,
			"CAP_USE_EMAIL" 	  => $value['email'],
			"CAP_USE_USERNAME" 	  => $value['username'],
			"CAP_USE_PASSWORD" 	  => hash('sha512', trim($value['password'])),
			"CAP_USE_STATUS" 	  => $value['status'],
			"CAP_USE_GLOBAL" 	  => $value['global'],
			"FK_CAP_MAI_ID" 	  => $value['location'],
			"CAP_USE_DATECREATED" => date("Y-m-d h:i:s")];
			
			$insert->dateColumn  = ['CAP_USE_DATECREATED'];

			$insert->whereClause = "CAP_USE_ID";
			
			$lastID = $insert->execute();
			
			$i = (!is_numeric($lastID) && empty($lastID)) ? $i + 1 : $i;

				if (is_numeric($lastID) && !empty($lastID) && !empty($value['role'])):

					foreach ($value['role'] as $user => $role):

						$insert->tableName = "CAP_USER_ROLE_COMBINE";

						$insert->column = [
						"FK_CAP_USE_ID" 	=> $lastID,
						"FK_CAP_USE_ROL_ID" => $role];

						$insert->dateColumn = [];

						$insert->whereClause = "CAP_USE_ROL_COM_ID";
						
						$lastIDRole = $insert->execute();

						$i = (!is_numeric($lastIDRole) && empty($lastIDRole)) ? $i + 1 : $i;

					endforeach;

				endif;				
			
			else:

				if (empty($value['password'])):

				$update->column = [
				"CAP_USE_FIRSTNAME"   => $firstName,
				"CAP_USE_LASTNAME"    => $lastName,
				"CAP_USE_EMAIL" 	  => $value['email'],
				"CAP_USE_USERNAME" 	  => $value['username'],
				"CAP_USE_STATUS" 	  => $value['status'],
				"CAP_USE_GLOBAL" 	  => $value['global'],
				"FK_CAP_MAI_ID" 	  => $value['location'],
				"CAP_USE_DATEUPDATED" => date("Y-m-d H:i:s")];

				else:

				$update->column = [
				"CAP_USE_FIRSTNAME"   => $firstName,
				"CAP_USE_LASTNAME"    => $lastName,
				"CAP_USE_EMAIL" 	  => $value['email'],
				"CAP_USE_USERNAME" 	  => $value['username'],
				"CAP_USE_PASSWORD" 	  => hash('sha512', trim($value['password'])),
				"CAP_USE_STATUS" 	  => $value['status'],
				"CAP_USE_GLOBAL" 	  => $value['global'],
				"FK_CAP_MAI_ID" 	  => $value['location'],
				"CAP_USE_DATEUPDATED" => date("Y-m-d H:i:s")];

				endif;

				$update->tableName   = "CAP_USER";

				$update->whereClause = [["CAP_USE_ID","=",$value['id']]];

				$update->dateColumn  = ['CAP_USE_DATEUPDATED'];
				
				$lastID = $update->execute();

				$i = (!is_resource($lastID) && empty($lastID)) ? $i + 1 : $i;

				if (is_resource($lastID) && !empty($lastID) && !empty($value['role'])):

					foreach ($value['role'] as $user => $role):

						$select->column      = "*";

						$select->tableName   = "CAP_USER_ROLE_COMBINE";

						$select->whereClause = [["FK_CAP_USE_ID","=",$value['id']],["FK_CAP_USE_ROL_ID","=",$role]];

						$select->execute();

						if (empty($select->arrayResult)):

							$insert->tableName = "CAP_USER_ROLE_COMBINE";

							$insert->column = [
							"FK_CAP_USE_ID" 	=> $value['id'],
							"FK_CAP_USE_ROL_ID" => $role];

							$insert->dateColumn  = [];

							$insert->whereClause = "CAP_USE_ROL_COM_ID";
							
							$lastIDRole = $insert->execute();

							$i = (!is_numeric($lastIDRole) && empty($lastIDRole)) ? $i + 1 : $i;

						endif;

					endforeach;

					$select->tableName   = "CAP_USER_ROLE_COMBINE";

					$select->whereClause = [["FK_CAP_USE_ID","=",$value['id']]];

					$select->execute();

					if (!empty($select->arrayResult)):

						foreach ($select->arrayResult as $del):

							if (!in_array($del['FK_CAP_USE_ROL_ID'], $value['role'])):

								$delete->tableName = "CAP_USER_ROLE_COMBINE";

								$delete->whereClause = [["CAP_USE_ROL_COM_ID","=",$del['CAP_USE_ROL_COM_ID']]];

								$lastIDRole = $delete->execute();

								$i = (!$lastIDRole) ? $i + 1 : $i;

							endif;

						endforeach;

					endif;

				endif;
			
			endif;
			
			if (!empty($value['location'])):
				
				$select->column = "*";
			
				$select->tableName = "CAP_MAIN";
				
				$select->whereClause = [["CAP_MAI_ID","=",$value['location']]];
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
					
					$mainID = $select->arrayResult[0]['CAP_MAI_ID'];
					
					$domain = $select->arrayResult[0]['CAP_MAI_DOMAIN'];
					
					$langs  = $select->arrayResult[0]['CAP_MAI_LANGUAGE'];
					
					$userID = (!empty($value['id'])) ? $value['id'] : $lastID;
				
					$select->column = "*";
				
					$select->tableName = "CAP_USER";
					
					$select->whereClause = [["CAP_USE_ID","=",$userID]];
					
					$select->execute();
					
					if (!empty($select->arrayResult)):
					
						$userLastSubDomain = $select->arrayResult[0]['FK_CAP_MAI_ID_LOCATION'];
						
						if (!empty($value['siteuser'])):
						
							if (empty($userLastSubDomain)):
							
							$insert->tableName = "CAP_MAIN";
							
							$insert->column = [
							"CAP_MAI_NAME"   		=> $select->arrayResult[0]['CAP_USE_FIRSTNAME'] . ' ' . $select->arrayResult[0]['CAP_USE_LASTNAME'],
							"CAP_MAI_LANGUAGE"    	=> $langs,
							"CAP_MAI_TEMPLATE" 	  	=> $value['template'],
							"CAP_MAI_DOMAIN" 	  	=> $value['domain'],
							"CAP_MAI_SITE_ACTIVE" 	=> 1,
							"CAP_MAI_TYPE" 	  		=> 'SUB DOMAIN',
							"CAP_MAI_PARENT" 	  	=> $value['location'],
							"CAP_MAI_DATECREATED" 	=> date("Y-m-d H:i:s"),
							"FK_CAP_USE_ID"			=> $userID];
							
							$insert->dateColumn  = ['CAP_MAI_DATECREATED'];
				
							$insert->whereClause = "CAP_MAI_ID";
							
							$lastDomainID = $insert->execute();
							
							$i = (!is_numeric($lastDomainID) && empty($lastDomainID)) ? $i + 1 : $i;
							
							else:
							
							$update->column = [
							"CAP_MAI_NAME"   		=> $select->arrayResult[0]['CAP_USE_FIRSTNAME'] . ' ' . $select->arrayResult[0]['CAP_USE_LASTNAME'],
							"CAP_MAI_LANGUAGE"    	=> $langs,
							"CAP_MAI_TEMPLATE" 	  	=> $value['template'],
							"CAP_MAI_DOMAIN" 	  	=> $value['domain'],
							"CAP_MAI_PARENT" 	  	=> $value['location'],
							"CAP_MAI_DATEUPDATED" 	=> date("Y-m-d H:i:s"),
							"FK_CAP_USE_ID"			=> $userID];
				
							$update->tableName   = "CAP_MAIN";
			
							$update->whereClause = [["CAP_MAI_ID","=",$userLastSubDomain]];
			
							$update->dateColumn  = ['CAP_MAI_DATEUPDATED'];
							
							$lastIDTotal = $update->execute();
							
							$lastDomainID=$userLastSubDomain;
							
							$i = (!is_resource($lastIDTotal) && empty($lastIDTotal)) ? $i + 1 : $i;
								
							endif;
							
						$update->column = ["FK_CAP_MAI_ID_LOCATION" => $lastDomainID];
				
						$update->tableName   = "CAP_USER";
		
						$update->whereClause = [["CAP_USE_ID","=",$userID]];
		
						$update->dateColumn  = [];
						
						$lastIDTotal = $update->execute();
						
						$i = (!is_resource($lastIDTotal) && empty($lastIDTotal)) ? $i + 1 : $i;
						
						else:
						
						$delete->tableName = "CAP_MAIN";

						$delete->whereClause = [["FK_CAP_USE_ID","=",$userID]];

						$lastIDRole = $delete->execute();

						$i = (!$lastIDRole) ? $i + 1 : $i;
						
						endif;
						
					endif;
				
				endif;
			
			endif;
					
		endif;
		
	if ($i == 0):

		$insert->transactionSuccess();

		$update->transactionSuccess();

		$delete->transactionSuccess();

	else:

		$insert->transactionFailed();

		$update->transactionFailed();

		$delete->transactionFailed();

	endif;
		
	}
				
	public function saveRoles($id,$delMenuList) {
	//print_r($id);
	
		if (!empty($delMenuList)) {
				
			$list = explode(",",$delMenuList);
	
			foreach ($list as $key => $value) {
						
				if (!empty($value)) {
				$delete = new delete("","CAP_USER_ROLE","CAP_USE_ROL_ID","$value",""); $delete->deleteRow();
				}
						
			}
				
		}
			
		foreach ($id as $key => $value) {
			
			if ($value[5] == 'Select Page') {$pageID = NULL;} else {$pageID = $value[5];}
			
			if (empty($value[0])) {
			$mainID = self::getDomainID($value[7]);
			$insert = new insert(array("CAP_USE_ROL_NAME" => $value[1],"CAP_USE_ROL_DESC"=>$value[2],"CAP_USE_ROL_STATUS" => $value[3],"FK_CAP_MEN_ID" => $pageID,"FK_CAP_MAI_ID" => $mainID),"CAP_USER_ROLE","","",""); $insert->execute();
			}
			else {
			$update = new update(array("CAP_USE_ROL_NAME" => $value[1],"CAP_USE_ROL_DESC"=>$value[2],"CAP_USE_ROL_STATUS" => $value[3],"FK_CAP_MEN_ID" => $pageID),"CAP_USER_ROLE",array(array("CAP_USE_ROL_ID","=",$value[0])),"",""); $update->execute();
			}
					
		}
	
	}
	
	public static function saveMetadata($id,$del) {
	
	if (!empty($del)) {
	
		foreach ($del as $key => $value) {
				
			if (!empty($value)) {
			$delete = new delete("","CAP_CONTENT_METADATA","CAP_CON_MET_ID","$value",""); $delete->deleteRow();
			}
				
		}
		
	}
	
	$insert = new insert("","","","","");
	
	$update = new update("","","","","");
	
	if (!empty($id)) {
	
		foreach ($id as $key => $value) {
			
			if ($value[0] == 'on') {
			
			$insert->tableName = "CAP_CONTENT_METADATA";
			
			$insert->columnMaxID = "CAP_CON_MET_ID"; $lastID = $insert->returnMaxIDFromTable()+1;
											
			$insert->column = (array(
								 "CAP_CON_MET_ID" => $lastID,
								 "FK_CAP_CON_ID" => $value[1],
								 "CAP_CON_MET_HEADER" => $value[2],
								 "CAP_CON_MET_CONTENT" => $value[3],
								 "CAP_CON_MET_PATH" => $value[4])); 
			
			$insert->insertRowToTable();
			
			}
			else {
											
			$update->tableName = "CAP_CONTENT_METADATA";
			
			$update->whereClause = "CAP_CON_MET_ID";
			
			$update->whereID = $value[0];
			
			$update->column = (array(
								 "CAP_CON_MET_HEADER" => $value[2],
								 "CAP_CON_MET_CONTENT" => $value[3])); 
			
			$update->updateMultipleRowWhereID();
			
			}
			
		}
		
	}
	
	}

}

class adminJavascript {

public $site;

		public function getScript() {
		
		
		$adminJavascript = self::variableCapsulePopUp() .PHP_EOL . self::adminMenuList() . PHP_EOL . self::getPagesList() . PHP_EOL . self::getRoleList();
		
		//print_r($adminJavascript);
		
		return $adminJavascript;
        }
        
        public function adminMenuList() {
        $list = array("Sites","Info","Menu","Content","Tagonomy","User","Role");
        
        	foreach ($list as $value) {
        	$var .= 'var ' . $value . ' = null;'; 
        	}
        	
        return $var;
        }
                
        public function variableCapsulePopUp() {
        
        $site = substr(APP, 0, -1);
        
        $capsuleList = capsule::getCapsuleListForAdmin();
                
        $var  = 'var Capsule = "';
        $var .= "<table class='adminTablePopUpCapsule'>";
        
        	foreach ($capsuleList as $key => $value) {
        	$var .= "<tr><td class='adminTablePopUpCapsuleImage'><img src='".$site."/library/capsule/admin/image/caplist.png'></td><td><span class='dragCapsule'><input type='hidden' name='capID' value='" . $value['CAP_LIS_ID'] . "'><input type='hidden' name='capInclude' value='" . $value['CAP_LIS_INCLUDE'] . "'>" . ucwords($value['CAP_LIS_NAME']) . "</span></td>";
        		if ($value['CAP_LIS_TYPE'] == 'application') {
        		
        		$locate = explode("\\",$value['CAP_LIS_INIT']);
        		
        			foreach ($locate as $location) {
        			$i++; if ($i == 1) {continue;} $path .= $location; if ($i == 4) {break;} else {$path .= "/";}
        			}
        		
        		$var .= '<td><img init="' . $path .'/' . $value['CAP_LIS_NAME']. ' .ajax.php" class="adminTablePopUpCapsuleApp" src="' . $site . '"/library/capsule/admin/image/app.png"></td><td><span class="dragCapsule"></td></tr>';
        		}
        		else {
        		$var .= "<td></td></tr>";
        		}
        		
        	$i = 0; $path = '';
        	}
        
        $var .= "</table>";
        $var .= '";';
                
        return $var;
        }
        
        public function getPagesList() {

        $data   = admin::getPagesList();
        
        $table  = "var PagesList = \"";
        
        $table .= "<select class='admin-menu-class'>";
	
		$table .= "<option selected='selected' value=''>Select Pages</option>";
		
		if (!empty($data)):

			foreach ($data as $key => $value):
				
				$template = explode("/",$value['CAP_PAG_PATH']);
				
				if ($template[2] == DEFAULT_TEMPLATE):
			
					if ($value['CAP_PAG_ID'] == $valueParent['parent']['CAP_PAG_ID']):

					$table .= "<option selected='selected' value='" . $value['CAP_PAG_ID'] . "'>" .$template[3]." - ". $value['CAP_PAG_NAME'] . "</option>";

					else:

					$table .= "<option value='" . $value['CAP_PAG_ID'] . "'>" . $template[3]." - ". $value['CAP_PAG_NAME'] . "</option>";

					endif;
			
				endif;

			endforeach;

		endif;
	
		$table .= "</select>";
	
		$table .= '";';
	
		return $table;
        
        }
        
        public function getRoleList() {
       
        $data   = admin::getRoleList();
           
        $table  = "var RoleList = \"";
           
        $table .= "<select class='admin-menu-class'>";
       
        //$table .= "<option selected='selected' value=''>Select Pages</option>";
        if(!empty($data)){
	        foreach ($data as $key => $value) {
	        $table .= "<option value='" . $value['CAP_USE_ROL_ID'] . "'>" . ucwords($value['CAP_USE_ROL_NAME']) . "</option>";		
	        }
        }
       
        $table .= "</select>";
       
        $table .= '";';
       
        return $table;
           
        }
        
        public static function newContent($dataContentCat,$dataContentType,$dataPages,$dataLanguage,$langDefault) {
        
        $tableSet .= "var newContent = \"<div class='newContentTable'>";
                
        $tableSet .= "<select id='contentCategorySelected'><option selected='selected' value=''>Select Category</option>";
			
				foreach ($dataContentCat as $category) {
				
					if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
					$tableSet .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . $category['CAP_CON_CAT_NAME'] . "</option>";
					
					}
					else {
					
					$tableSet .= "<option value='$category[CAP_CON_CAT_ID]'>" . $category['CAP_CON_CAT_NAME'] . "</option>";
					
					}
								
				}
			
		$tableSet .= "</select>&nbsp;&nbsp;";
						
		$tableSet .= "<select id='contentPagesSelected'><option selected='selected' value=''>Select Pages</option>";
	
				foreach ($dataPages as $pages) {
		
					if ($value[CAP_PAG_ID] == $pages[CAP_PAG_ID]) {
					$tableSet .= "<option selected='selected' value='" . $pages[CAP_PAG_ID] . "'>" . ucwords(strtolower($pages[CAP_PAG_NAME])) . "</option>";
					}
					else {
					$tableSet .= "<option value='" . $pages[CAP_PAG_ID] . "'>" . ucwords(strtolower($pages[CAP_PAG_NAME])) . "</option>";
					}
		
				}
	
		$tableSet .= "</select>&nbsp;&nbsp;";
		
		$tableSet .= "<select id='contentPublishedSelected'><option selected='selected' value=''>Select Published</option>";
		
		$tableSet .= "<option value='Y'>Yes</option>";
					
		$tableSet .= "<option value='N'>No</option></select>&nbsp;&nbsp;";
		
		$tableSet .= "<select id='contentLanguageSelected'><option selected='selected' value=''>Select Language</option>";
	
				foreach ($dataLanguage as $lang) {
					
					if ($lang[CAP_LAN_ID] == $langDefault) {
					$tableSet .= "<option selected='selected' value='" . $lang[CAP_LAN_ID] . "'>" . ucwords(strtolower($lang[CAP_LAN_NAME])) . "</option>";
					}
					else {
					$tableSet .= "<option value='" . $lang[CAP_LAN_ID] . "'>" . ucwords(strtolower($lang[CAP_LAN_NAME])) . "</option>";
					}
					
		
				}
	
		$tableSet .= "</select>&nbsp;&nbsp;";
		
		$tableSet .= "<hr/>";
		
		$tableSet .= "<input class='adminContentHeader' type='text' value=''>";
		
		$tableSet .= "<hr/></div>";
        
        $tableSet .= "<div class='contentChangeable'><div id='theNicPanel'></div><textarea id='textAreaContent'></textarea></div>\";";
        
        
        $tableSet .= "var editNotContent = \"<div class='newContentTable'>";
                    
        $tableSet .= "<input id='editNotContentID' type='hidden' value=''><input id='editNotContentOldName' type='hidden' value=''>";
            
        $tableSet .= "<select id='contentCategorySelected'><option selected='selected' value=''>Select Category</option>";
        		
        			foreach ($dataContentCat as $category) {
        			
        				if ($value[CAP_CON_CAT_ID] == $category[CAP_CON_CAT_ID]) {
        				
        				$tableSet .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . $category[CAP_CON_CAT_NAME] . "</option>";
        				
        				}
        				else {
        				
        				$tableSet .= "<option value='$category[CAP_CON_CAT_ID]'>" . $category[CAP_CON_CAT_NAME] . "</option>";
        				
        				}
        							
        			}
        		
        	$tableSet .= "</select>&nbsp;&nbsp;";
        					
        	$tableSet .= "<select id='contentPagesSelected'><option selected='selected' value=''>Select Pages</option>";
        
        			foreach ($dataPages as $pages) {
        	
        				if ($value[CAP_PAG_ID] == $pages[CAP_PAG_ID]) {
        				$tableSet .= "<option selected='selected' value='" . $pages[CAP_PAG_ID] . "'>" . ucwords(strtolower($pages[CAP_PAG_NAME])) . "</option>";
        				}
        				else {
        				$tableSet .= "<option value='" . $pages[CAP_PAG_ID] . "'>" . ucwords(strtolower($pages[CAP_PAG_NAME])) . "</option>";
        				}
        	
        			}
        
        	$tableSet .= "</select>&nbsp;&nbsp;";
        	
        	$tableSet .= "<select id='contentPublishedSelected'><option selected='selected' value=''>Select Published</option>";
        	
        	$tableSet .= "<option value='Y'>Yes</option>";
        				
        	$tableSet .= "<option value='N'>No</option></select>&nbsp;&nbsp;";
        	
        	$tableSet .= "<select id='contentLanguageSelected'><option selected='selected' value=''>Select Language</option>";
        
        			foreach ($dataLanguage as $lang) {
        				
        				if ($lang[CAP_LAN_ID] == $langDefault) {
        				$tableSet .= "<option selected='selected' value='" . $lang[CAP_LAN_ID] . "'>" . ucwords(strtolower($lang[CAP_LAN_NAME])) . "</option>";
        				}
        				else {
        				$tableSet .= "<option value='" . $lang[CAP_LAN_ID] . "'>" . ucwords(strtolower($lang[CAP_LAN_NAME])) . "</option>";
        				}
        				
        	
        			}
        
        	$tableSet .= "</select>&nbsp;&nbsp;";
        	
        	$tableSet .= "<hr/>";
        	
        	$tableSet .= "<input class='adminContentHeader' type='text' value=''>";
        	
        	$tableSet .= "<hr/></div>";
            
            $tableSet .= "<div class='contentChangeable'><div class='uploadAnything'><input id='file_upload' name='file_upload' type='file'></div><div class='contentNotContent'></div></div>\";";
        
        
        
        $tableSet .= "var newNotContent = \"<div class='contentChangeable'>";
        
        $tableSet .= "<div class='uploadAnything'><input id='file_upload' name='file_upload' type='file'></div>";
        
        $tableSet .= '</div>";';
        
        return $tableSet;
        
        }

}


?>