<?php

namespace library\capsule\core\mvc;

use \framework\capsule;
use \framework\encryption;
use \framework\file;
use \framework\user;
use \framework\misc;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;
use \framework\database\oracle\update;
use \framework\simple_html_dom;
use \framework\time;
use \framework\connection;
use \Imagick;


class model extends capsule {

public $dataModel;

    public function __construct ($data = null) {
	$this->dataModel = $data;
    }
    
   public function pages($mainID) {
      
   $select = new select("*","CAP_PAGES",[["CAP_PAG_SITES","=","$mainID"],['CAP_PAG_PATH','LIKE','%/content/%']],"","");
   
   $select->execute();
         
   return $select->arrayResult;
   
   }
   
   public function language() {
   
   $select = new select("*","CAP_LANGUAGE","","","");
   
   $select->execute();
   
   return $select->arrayResult;
   
   }
   
   public function getContentListContentPersonalSites($page = null, $perPage = null) {
	$mainID = $this->getPersonalSiteID();
		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content' AND 
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
		$misc = new misc();
		$count = $this->countTotalOfContent("AND CAP_CONTENT.FK_CAP_MAI_ID = $mainID");
		
		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","content"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CONTENT.CAP_CON_CREATED DESC"); 
		$newArray  = $misc->getPagging(		$perPage,
											$page,
											$data->column,
											$data->tableName,
											$data->whereClause,
											$count[0][COUNT]
									  );
									  
		$limitClause = $newArray[0]["limit"]." OFFSET ".$newArray[0]['offset'];
		
		$data->execute();
		return $data->arrayResult;
		
	}
   
  /* public function getContentListContent() {
   
   $userID = $this->getUserID();
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content'
		 ORDER BY CAP_CON_CREATED DESC",
		"","",""); $data->execute();
			
		return $data->arrayResult;
		
	}
   */
 public function getContentListImagePersonalSitesTotal($start = null, $perPage = null) {
   
   $mainID = $this->getPersonalSiteID();
   
   /*$data = new select("COUNT(*) as COUNT","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'image' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		
		$data->execute();
		//echo($data->query);
		return $data -> arrayResult;*/
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","image"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	} 
    public function getContentListImagePersonalSites($start = null, $perPage = null) {
   
   $mainID = $this->getPersonalSiteID();
   
   /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'image' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		
		$data->selectDataPagging($start, $perPage);
		//echo($data->query);
		return $data -> arrayResult;
   */
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","image"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
  

 public function getContentListFilePersonalSites($start = null, $perPage = null) {
   
   $mainID = $this->getPersonalSiteID();
   		
   		 /*$data = new select("*, CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'file' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;
   		//echo $data -> query;*/
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","file"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
  /* public function getContentListFileUser() {
   
   $userID = $this->getUserID();
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'file'
		 ORDER BY CAP_CON_CREATED DESC",
		"","",""); $data->execute();
			
		return $data->arrayResult;
		
	} */
   public function getContentListAudioPersonalSites($start = null, $perPage = null) {
   
   $mainID = $this->getPersonalSiteID();
   		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'audio' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","audio"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
   public function getContentListVideoPersonalSites($start = null, $perPage = null) {
   
   $mainID = $this->getPersonalSiteID();
   		
   		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'video' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","video"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
   
   public function getContentListContentUser($page = null, $perPage = null) {
	$mainID = $this->getUserSiteID();
		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content' AND 
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
		$misc = new misc();
		$count = $this->countTotalOfContent("AND CAP_CONTENT.FK_CAP_MAI_ID = $mainID");
		
		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","content"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CONTENT.CAP_CON_CREATED DESC"); 
		$newArray  = $misc->getPagging(		$perPage,
											$page,
											$data->column,
											$data->tableName,
											$data->whereClause,
											$count[0][COUNT]
									  );
									  
		$limitClause = $newArray[0]["limit"]." OFFSET ".$newArray[0]['offset'];
		
		$data->execute();
		return $data->arrayResult;
		
	}
   
  /* public function getContentListContent() {
   
   $userID = $this->getUserID();
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content'
		 ORDER BY CAP_CON_CREATED DESC",
		"","",""); $data->execute();
			
		return $data->arrayResult;
		
	}
   */
 public function getContentListImageUserTotal($start = null, $perPage = null) {
   
   $mainID = $this->getUserSiteID();
   
   /*$data = new select("COUNT(*) as COUNT","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'image' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		
		$data->execute();
		//echo($data->query);
		return $data -> arrayResult;*/
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","image"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	} 
    public function getContentListImageUser($start = null, $perPage = null) {
   
   $mainID = $this->getUserSiteID();
   
   /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'image' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		
		$data->selectDataPagging($start, $perPage);
		//echo($data->query);
		return $data -> arrayResult;
   */
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","image"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
  

 public function getContentListFileUser($start = null, $perPage = null) {
   
   $mainID = $this->getUserSiteID();
   		
   		 /*$data = new select("*, CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'file' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;
   		//echo $data -> query;*/
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","file"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
  /* public function getContentListFileUser() {
   
   $userID = $this->getUserID();
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'file'
		 ORDER BY CAP_CON_CREATED DESC",
		"","",""); $data->execute();
			
		return $data->arrayResult;
		
	} */
   public function getContentListAudioUser($start = null, $perPage = null) {
   
   $mainID = $this->getUserSiteID();
   		
   		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'audio' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","audio"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
   public function getContentListVideoUser($start = null, $perPage = null) {
   
   $mainID = $this->getUserSiteID();
   		
   		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'video' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","video"),array("CAP_CONTENT.FK_CAP_MAI_ID","=","$mainID")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}	
	
	public function getContentListContentAdmin($page = null, $perPage = null) {
	
		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*,CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID = CAP_CONTENT.CAP_CON_ID
		 WHERE CAP_LAN_COM_COLUMN = 'header' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content' AND 
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
		$misc = new misc();
		$count = $this->countTotalOfContent();
		$newArray  = $misc->getPagging(		$perPage,
											$page,
											"",
											"",
											"",
											$count[0][COUNT]
									  );

		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","content")),"","CAP_CONTENT.CAP_CON_CREATED DESC",$newArray[0]["limit"]." OFFSET ".$newArray[0]['offset']); $data->execute();
			
		return $data->arrayResult;
		
	}
	
	public function getContentListEventAdmin($start = null, $perPage = null) {
	
		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*,CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID = CAP_CONTENT.CAP_CON_ID
		 WHERE CAP_LAN_COM_COLUMN = 'header' AND CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content' AND 
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","event")),"","CAP_CONTENT.CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
   
   public function getContentListImageAdmin($start = null, $perPage = null) {
   
   $userID = $this->getUserID();
   
   /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'image' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		
		$data->selectDataPagging($start, $perPage);
		//echo($data->query);
		return $data -> arrayResult;*/
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","image")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}

	 public function getContentListImageAdminTotal($start = null, $perPage = null) {
   
   $userID = $this->getUserID();
   
   /*$data = new select("COUNT(*) as COUNT","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'image' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		
		$data->execute();
		//echo($data->query);
		return $data -> arrayResult;*/
   
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","image")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
   public function getContentListFileAdmin($start = null, $perPage = null) {
   
   $userID = $this->getUserID();
   		
   		/* $data = new select("*, CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'file' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		//echo $data -> query;
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","file")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
   public function getContentListAudioAdmin($start = null, $perPage = null) {
   
   $userID = $this->getUserID();
   		
   		 /*$data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'audio' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","audio")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
   public function getContentListVideoAdmin($start = null, $perPage = null) {
   
   $userID = $this->getUserID();
   		
   		/* $data = new select("*,CAP_USER.*,CAP_CONTENT_TYPE.*,CAP_CONTENT_CATEGORY.*,CAP_PAGES.*","CAP_CONTENT","LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'video' AND
		",""," ORDER BY CAP_CON_CREATED DESC");
		
		$data->selectDataPagging($start, $perPage);
		
		return $data -> arrayResult;*/
   		
		$data = new select(
		"*",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 LEFT JOIN CAP_MAIN ON CAP_MAIN.CAP_MAI_ID = CAP_CONTENT.FK_CAP_MAI_ID",
		array(array("CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE","=","video")),"","CAP_CON_CREATED DESC"); $data->execute();
			
		return $data->arrayResult;
		
	}
	
	public static function getContentCategoryList() {
	$select = new select("*","CAP_CONTENT_CATEGORY","","",""); $select->execute();
	return $select->arrayResult;
	}
	
	public function publish($id){
		$select = new select("CAP_CON_PUBLISHED","CAP_CONTENT",array(array("CAP_CON_ID","=",$id)),"",""); $select->execute();
		return $select->arrayResult;
	}
	
	public static function getPagesList() {
	$select = new select("DISTINCT *","CAP_PAGES",array(array("CAP_PAG_PATH","LIKE","%/content/%")),"",""); $select->execute();
	return $select->arrayResult;
	}
	
	public function getUserID() {
	$user 	= unserialize($_SESSION['user']); 
	return $user->getID();
	echo $user->getID();
	}
	
	public function getUserSiteID() {
	$user 	= unserialize($_SESSION['user']); 
	return $user->getSiteID();
	}
	
	public function getPersonalSiteID() {
	$user 	= unserialize($_SESSION['user']); 
	return $user->getPersonalSiteID();
	}
	
	public function getUserName() {
	$user 	= unserialize($_SESSION['user']); 
	return $user->getName();
	echo $user->getName();
	}
	
	
	public function getAllDocumentTagging() {
		
		$select = new select("*","CAP_TAG","","","");
		
		$select->execute();
		
		return $select->arrayResult;
		
		
	}
		
	public function getAllMetadataType() {
		
		$select1 = new select("DISTINCT CAP_CON_MET_HEADER","CAP_CONTENT_METADATA","","","");
		
		$select1->execute();
		
		$select2 = new select("CAP_MET_DEF_NAME","CAP_METADATA_DEFAULT","","","");
		
		$select2->execute();
		
			if (!empty($select1->arrayResult)) {
		
				$metaArray = array_merge($select1->arrayResult,$select2->arrayResult);
				
			}
		
		if (!empty($metaArray)) {
			foreach ($metaArray as $value) {
				if (!empty($value['CAP_CON_MET_HEADER'])) {
					$newMetaArray [] = $value['CAP_CON_MET_HEADER'];
				}
				else {
					$newMetaArray [] = $value['CAP_MET_DEF_NAME'];
				}
			}
		}
		
		if (!empty($newMetaArray)) {
		
		$newMetaArray = array_unique($newMetaArray);
		
		}
		
		return $newMetaArray;
		
		
	}

	
	

	public static function getFileToEdit($id,$type) {
		$select = new select("*","","","","");
		$select->column = "(CAP_CONTENT.FK_CAP_MAI_ID) as FK_MAI_ID ,*";
		$select->tableName = "CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID";
		$select->whereClause=array(array("CAP_CON_ID","=",$id));
		$select->execute(); //print_r($select->arrayResult);
		$cap_content = $select->arrayResult[0];
		$path = $cap_content['CAP_CON_CONTENT'];
		
		$select->column		= "*";
		$select->tableName = "CAP_LANGUAGE_COMBINE";
		$select->whereClause = [["CAP_LAN_COM_FKID","=",$cap_content['CAP_CON_ID']]];
		$select->execute(); 
		$content = $select->arrayResult; 
		
		if (!empty($content) && $value != '.' && $value != '..') {
		
			foreach ($content as $key => $value) {
				
				if(!empty($value['CAP_LAN_COM_VALUE'])){
				$array [] = array(
				
				"id"		=> $cap_content['CAP_CON_ID'],
				"name"		=> $cap_content['CAP_CON_HEADER'],
				"category"	=> $cap_content['FK_CAP_CONTENT_CATEGORY'],
				"categoryn"	=> $cap_content['CAP_CON_CAT_NAME'],
				"published"	=> $cap_content['CAP_CON_PUBLISHED'],
				"pages"		=> $cap_content['CAP_CON_PAGES'],
				"type"		=> $cap_content['FK_CAP_CONTENT_TYPE'],
				"path" 		=> ROOT_PATH.$value['CAP_LAN_COM_VALUE'],
				"siteid"	=> $cap_content['FK_MAI_ID'],
				);
				
				}
				
			}
			
		}
		
		if (empty($array)) {
		
			$array [] = array(
				
			"id"		=> $cap_content['CAP_CON_ID'],
			"name"		=> $cap_content['CAP_CON_HEADER'],
			"category"	=> $cap_content['FK_CAP_CONTENT_CATEGORY'],
			"categoryn"	=> $cap_content['CAP_CON_CAT_NAME'],
			"published"	=> $cap_content['CAP_CON_PUBLISHED'],
			"pages"		=> $cap_content['CAP_CON_PAGES'],
			"type"		=> $cap_content['FK_CAP_CONTENT_TYPE'],
			"path" 		=> ROOT_PATH.$value['CAP_LAN_COM_VALUE'],
			"siteid"	=> $cap_content['FK_MAI_ID']
				
			);
		
		}
		
				
	return $array;
	
	}
	
	public static function getItemToEdit($fkid){
	
		$select = new select("*","","","","");
		$select->tableName = "CAP_LANGUAGE_COMBINE";
		$select->whereClause= array(array("CAP_LAN_COM_FKID","=",$fkid));
		$select->execute();
		return $select->arrayResult;
		//print_r($select->query);
	}

	public static function getFileNameFromMetadata($lancomid){
		$select = new select("*","","","","");
		$select->tableName = "CAP_CONTENT_METADATA";
		$select->whereClause = array(array("LOWER(CAP_CON_MET_HEADER)","=","LOWER('Judul Dokumen')"),array("FK_CAP_LAN_COM_ID","=",$lancomid));
		$select->execute();
		return $select->arrayResult;
		//print_r($select->query);
	}
	
	public static function getContentToEdit($id,$type) {
		$select = new select("*","","","","");
		$select->column = "*";
		$select->tableName = "CAP_MAIN";
		$select->execute();
		$defaultLanguage = $select->arrayResult[0]['CAP_MAI_LANGUAGE'];
		$select->column = "*,CAP_CONTENT.FK_CAP_MAI_ID as FK_MAI_ID";
		$select->tableName = "
		CAP_CONTENT 
		LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID 
		LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID ";
		$select->whereClause = array(array("CAP_CON_ID","=",$id),array("CAP_LAN_COM_LAN_ID","=",$defaultLanguage),array("CAP_LAN_COM_TYPE","=","content"));
		$select->execute();
		
		if (!empty($select->arrayResult)) {
		
			foreach ($select->arrayResult as $key => $value) {
								
			$array [] = array(
				
			"id"		=> $value['CAP_CON_ID'],
			"name"		=> $value['CAP_CON_HEADER'],
			"category"	=> $value['FK_CAP_CONTENT_CATEGORY'],
			"categoryn"	=> $value['CAP_CON_CAT_NAME'],
			"published"	=> $value['CAP_CON_PUBLISHED'],
			"pages"		=> $value['CAP_CON_PAGES'],
			"type"		=> $value['FK_CAP_CONTENT_TYPE'],
			"whoami"	=> $value['CAP_LAN_COM_COLUMN'],
			"content"	=> $value['CAP_LAN_COM_VALUE'],
			"desc"		=> $value['CAP_LAN_COM_DESCRIPTION'],
			"datepublished" => $value['CAP_CON_DATEPUBLISHED'],
			"siteid"	=> $value['FK_MAI_ID']				
			);
								
			}
		
		}
							
	return $array;
	
	}
	
	public static function getFileToEditEmpty($id,$type) {
		$select = new select("*","","","","");
		$select->tableName = "CAP_CONTENT LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID";
		$select->whereClause = array(array("CAP_CON_ID","=",$id));
		$select->execute(); $path = $select->arrayResult[0]['CAP_CON_CONTENT'];
				
			$array [] = array(
				
			"id"		=> $select->arrayResult[0]['CAP_CON_ID'],
			"name"		=> $select->arrayResult[0]['CAP_CON_HEADER'],
			"category"	=> $select->arrayResult[0]['FK_CAP_CONTENT_CATEGORY'],
			"categoryn"	=> $select->arrayResult[0]['CAP_CON_CAT_NAME'],
			"published"	=> $select->arrayResult[0]['CAP_CON_PUBLISHED'],
			"pages"		=> $select->arrayResult[0]['CAP_CON_PAGES'],
			"type"		=> $select->arrayResult[0]['FK_CAP_CONTENT_TYPE'],
			"path" 		=> $select->arrayResult[0]['CAP_CON_CONTENT']."/".$value
				
			);
						
	return $array;
	
	}

	
	public static function deleteContent($id,$fkid) {
	
	$file = new file("");
		
		 //print_r($fkid);
	$i=0;
		if(!empty($fkid)){
		 foreach($fkid as $key => $values){
			
			$user = new select("*","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT_METADATA ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_CONTENT_METADATA.FK_CAP_LAN_COM_ID LEFT JOIN CAP_CONTENT ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID = CAP_CONTENT.CAP_CON_ID
LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID",array(array("CAP_LAN_COM_ID","=","$values"),array("LOWER(CAP_CON_MET_HEADER)","=","LOWER('Judul Dokumen')")),"","");

			$user->execute();
			
			//echo $user->query;

			$userName = $user->arrayResult;
			
			//print_r($user->arrayResult);

			$folder = explode("-",pathinfo($id[$i],PATHINFO_DIRNAME));

			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName[0][CAP_USE_FIRSTNAME]." Menghapus ". $userName[0][cap_con_met_content] ." DARI FOLDER ".$folder[1],"FK_USE_ID"=>$userName[0][CAP_USE_ID],"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
						
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");
			
			//print_r($insertHis);

			$insertHis->execute();

			$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_ID","=","$values")),"","");

			$delete->execute();

			if(file_exists(ROOT_PATH."library/content/thumb/".$values.".png")){
				$status = $file->setFile(ROOT_PATH."library/content/thumb/".$values.".png")->deleteFile();
			}

			$i++;
			
			}
		}
		 if(!empty($id)){
			foreach ($id as $key => $value) {
			
			$checker = explode("/",$value);
			
				if ($checker[0] == 'library' && $checker[1] == 'content') {
				
				//echo ROOT_PATH.$value;
				//print_r($fkid);
													
					if(!empty($value) && $value != ""){
						if(file_exists(ROOT_PATH.$value)){
	
						
							$status = $file->setFile(ROOT_PATH.$value)->deleteFile();
							if(empty($status)){
	
								
								
								//$delete = new delete("","CAP_LANGUAGE_COMBINE","CAP_LAN_COM_ID",$value,"");
	
								//$delete->execute();
	
							}else{
	
								return false;
	
								die('An error occured on delete File');
	
							}
						}
					}
				}
			
			}
		}
	
	}
	
	public static function saveContent($id,$content,$type,$mainID) {

	$user 	= unserialize($_SESSION['user']); 
	
	$userID = $user->getID();
	
	$siteID = $user->getSiteID();
	
	$idUserForFolder = rtrim($content[1]);
	
	if($userID != $idUserForFolder && !empty($idUserForFolder)){
		
		$userID = $idUserForFolder;
		
	}
	$mainID = rtrim($content[2]);
	if(empty($mainID)){
		$mainID = self::getDomainID();
	}
	
		if (!empty($id)) {
		
		$select = new select("*","CAP_CONTENT",array(array("CAP_CON_ID","=","$id")),"","");
		
		$select->execute();
				
		$file = new file(""); $file->setFile(ROOT_PATH."library/content/".$type."/".$mainID."-".rtrim($content[0]));
			
			if ($file->renameDirectory(ROOT_PATH."library/content/".$type."/".$mainID."-".$select->arrayResult[0]['CAP_CON_HEADER'])) {
		
			$update = new update(array("FK_CAP_CONTENT_CATEGORY" => $content[2], "CAP_CON_CONTENT" => "library/content/".$type."/".$mainID."-".rtrim($content[0]), "CAP_CON_HEADER" => rtrim($content[0])),"CAP_CONTENT",array(array("CAP_CON_ID","=","$id")),"","");
			$update->execute();
			
			return 'success';
			
			}
			else {
			
			return 'failed';
			
			}
		
		}
		else {
			
			$select = new select("*","CAP_CONTENT_TYPE",array(array("CAP_CON_TYP_TYPE","=","$type")),"","");
			
			$select->execute(); $contentType = $select->arrayResult[0]['CAP_CON_TYP_ID'];
			
			$data = array(
				"CAP_USER_CAP_USE_ID" 		=> $userID,
				"CAP_CON_CREATED" 			=> date("Y-m-d H:i:s"),
				"FK_CAP_CONTENT_CATEGORY"	=> $content[2],
				"CAP_CON_CONTENT"			=> "library/content/".$type."/$mainID-".rtrim($content[0]),
				"CAP_CON_PUBLISHED"			=> "N",
				"CAP_CON_HEADER"			=> $content[0],
				"FK_CAP_CONTENT_TYPE"		=> $contentType,
				"FK_CAP_MAI_ID"				=> $mainID
			);
			$insert = new insert($data,"CAP_CONTENT","CAP_CON_ID","","");
			$insert->dateColumn  = array("CAP_CON_CREATED");
					
			
			
			$lastID = $insert->execute();
			
			return $lastID;
		
		}
		
	}
	
	public static function createDirectory($type,$content,$mainID){
	
		$user 	= unserialize($_SESSION['user']); 
		
		$userID = $user->getID();

		$userName = $user->getName();
			
		
		
		if(empty($mainID)){
		
			$mainID = self::getDomainID();
			
		}
		
		

		$dirName = "library/content/".$type."/".$mainID."-".rtrim($content[0]);
		if (!is_dir(ROOT_PATH.$dirName)) {
			
			$file = new file(ROOT_PATH.$dirName); 
		
			if (!$file->createDirectory()){

				echo 0;

			}else{

				echo 1;

				$folder = $dirName;

				$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName."MEMBUAT FOLDER ".rtrim($content[0])." DENGAN TIPE DOKUMEN ".$type,"FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
				$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

				$insertHis->execute();

			}
		}else{
			echo 1;
		}
	
	}

	public function checkDirectory($data,$mainID,$type){
		if(!empty($data)){

			if(empty($mainID)){
				$mainID = self::getDomainID();
			}
			
			 $dirName = 'library/content/'.$type.'/'.$mainID.'-'.$data.'';
			

			if(is_dir(ROOT_PATH.$dirName) && file_exists(ROOT_PATH.$dirName)){
				echo 0;
			}else{
				echo 1;
			}
		}
	}
	
/*public static function saveDeleteContent($data,$del) {

	$file = new file("");
	
	$select = new select("*","","","","");
	$selects = new select("*","","","","");
	$update = new update("","CAP_CONTENT","","","");
	
	$userName = $user->getName();

	$userID = model::getUserID();

	if (!empty($del)) {
		print_r($del);
		foreach ($del as $key => $value) {

		$select = new select("*","CAP_CONTENT LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID","CAP_CON_ID",$values,"");

			$select->execute();
		$path = $select->arrayResult[0]['CAP_CON_CONTENT'];
		$type = $select->arrayResult[0]['CAP_LAN_COM_TYPE'];
		$file->setFile(ROOT_PATH.$path);
		//echo $file->checkFolderExistence();

			if (!empty($path) && $file->checkFolderExistence() == 0 ) {
				
				$status = $file->deleteDirectory();
				

					$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS FOLDER ".$path." DENGAN TIPE DOKUMEN ".$type,"FK_USE_ID"=>$select->arrayResult[0]['CAP_USER_CAP_USE_ID'],"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
									
					$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

					$insertHis->execute();

					$delete = new delete("","CAP_CONTENT","CAP_CON_ID",$value,"");
					
					$delete->execute();


					$selects->tableName = "CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = '".$value."'";
			
					$selects->execute();
					
					foreach ($selects->arrayResult as $keys => $values) {
						if(file_exists(ROOT_PATH."library/content/thumb/".$values[CAP_LAN_COM_ID].".png")){
							$status = $file->setFile(ROOT_PATH."library/content/thumb/".$values[CAP_LAN_COM_ID].".png")->deleteFile();
							}
					}


					$delete = new delete("","CAP_LANGUAGE_COMBINE","CAP_LAN_COM_FKID = '".$value."'","","");
			
					$delete->deleteRowMultipleWhere();



				
						
			}
			else {
			
			$delete = new delete("","CAP_CONTENT","CAP_CON_ID",$value,"");
			
			$delete->execute();
			
			$select->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID = CAP_CONTENT.CAP_CON_ID WHERE CAP_LAN_COM_FKID = '".$value."' AND CAP_LAN_COM_TYPE = 'content'";
			
			$select->execute();
			
												
				if (!empty($select->arrayResult)) {
												
				$delete = new delete("","CAP_LANGUAGE_COMBINE","CAP_LAN_COM_FKID = '".$value."' AND CAP_LAN_COM_TYPE = 'content'","","");
			
				$delete->deleteRowMultipleWhere();
				
				

				$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS CONTENT DENGAN JUDUL ".ucwords(strtolower($select->arrayResult[0][CAP_CON_HEADER]))."","FK_USE_ID"=>$select->arrayResult[0]['CAP_USER_CAP_USE_ID'],"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
				$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

				$insertHis->execute();
						
				}
			
			}
		
		}
		
	}
	
	if (!empty($data)) {
	
		foreach ($data as $key => $value) {
		$select = new select("*","CAP_CONTENT","CAP_CON_ID",$value[0],"");
		$select->execute();
		$update->column = array("FK_CAP_CONTENT_CATEGORY" => $value[1], "CAP_CON_PAGES" => $value[2]);
		$update->whereClause = "CAP_CON_ID";
		$update->whereID = $value[0];
		$update->execute();
		
			if($select->arrayResult[0][CAP_CON_PAGES] != $value[2] || $select->arrayResult[0][FK_CAP_CONTENT_CATEGORY] != $value[1] ){
			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MELAKUKAN PERUBAHAN TERHADAP CONTENT DENGAN JUDUL ".ucwords(strtolower($select->arrayResult[0][CAP_CON_HEADER]))."" ,"FK_USE_ID"=>$select->arrayResult[0]['CAP_USER_CAP_USE_ID'],"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();
		
			}
		}
		
	}
			
	}
*/

public static function saveDeleteContent($data,$del) {

	$file = new file("");
	
	$select = new select("*","","","","");
	$selects = new select("*","","","","");
	
	$update = new update("","CAP_CONTENT","","","");
	
	$userName = model::getUserName();

	$userID = model::getUserID();

	if (!empty($del)) {
		//print_r($del);
		
		$user = unserialize($_SESSION['user']);
		
		$id = $user->getID();
		
		foreach ($del as $key => $value) {

		$select->tableName = "CAP_CONTENT";
		$select->whereClause = array(array("CAP_CON_ID","=","$value"));
		$select->execute();
		$path = $select->arrayResult[0]['CAP_CON_CONTENT'];
		$file->setFile(ROOT_PATH.$path);
		//echo $file->checkFolderExistence();
		
		

			if (!empty($path) && $file->checkFolderExistence() == 0 ) {
				
				$status = $file->deleteDirectory();
					
					$explode = explode("/", $path);
					
					$type = $explode[2];
					$doc  = explode("-", $explode[3]);
					$doc  = $doc[1];
					$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS FOLDER ".$doc." DENGAN TIPE DOKUMEN ".$type,"FK_USE_ID"=>$id,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
									
					$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

					$insertHis->execute();

					$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=","$value")),"","");
					
					$delete->execute();
					
					$selects->tableName = "CAP_LANGUAGE_COMBINE";
					$select->whereClause = array(array("CAP_LAN_COM_FKID","=","$value"));
					$selects->execute();
					if(!empty($selects->arrayResult)){
						foreach ($selects->arrayResult as $keys => $values) {
							if(file_exists(ROOT_PATH."library/content/thumb/".$values[CAP_LAN_COM_ID].".jpg")){
								$status = $file->setFile(ROOT_PATH."library/content/thumb/".$values[CAP_LAN_COM_ID].".jpg")->deleteFile();
								}
						}
					}


					$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=","$value")),"","");
			
					$delete->execute();

					
						
			}
			else {
			$datas = new select("*","CAP_CONTENT",array(array("CAP_CON_ID","=","$value")),"");
			$datas->execute();
			$header = $datas->arrayResult[0]['CAP_CON_HEADER'];
			
			$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=","$value")),"","");
			
			$delete->execute();
			
			//$selectz->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID = CAP_CONTENT.CAP_CON_ID WHERE CAP_LAN_COM_FKID = '$value' AND CAP_LAN_COM_TYPE = 'content'";
			
			
												
				if (!empty($select->arrayResult)) {
												
				$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID", "=",$value),array( "CAP_LAN_COM_TYPE","=","content")),"","");
			
				$delete->execute();									
				
				$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS CONTENT DENGAN JUDUL ".$header,"FK_USE_ID"=>$id,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
				$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

				$insertHis->execute();
						
				}
			
			}
		
		}
		
	}
	
	if (!empty($data)) {
	
		foreach ($data as $key => $value) {
		$select = new select("*","CAP_CONTENT",array(array("CAP_CON_ID","=","$value[0]")),"","");
		$select->execute();
		$update->column = array("FK_CAP_CONTENT_CATEGORY" => $value[1], "CAP_CON_PAGES" => $value[2]);
		$update->whereClause = array(array("CAP_CON_ID","=","$value[0]"));
		$update->whereID = "";
		$update->execute();
		
			if($select->arrayResult[0][CAP_CON_PAGES] != $value[2] || $select->arrayResult[0][FK_CAP_CONTENT_CATEGORY] != $value[1] ){
			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MELAKUKAN PERUBAHAN TERHADAP CONTENT DENGAN JUDUL \"".$select->arrayResult[0][CAP_CON_HEADER]."\"" ,"FK_USE_ID"=>$id,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();
		
			}
		}
		
	}
			
	}
	public static function saveDeleteEvent($data,$del) {

	$file = new file("");
	
	$select = new select("*","","","","");
	$selects = new select("*","","","","");
	
	$update = new update("","CAP_CONTENT","","","");
	
	$userName = model::getUserName();

	$userID = model::getUserID();

	if (!empty($del)) {
		//print_r($del);
		
		$user = unserialize($_SESSION['user']);
		
		$id = $user->getID();
		
		foreach ($del as $key => $value) {

		$select->tableName = "CAP_CONTENT";
		$select->whereClause = array(array("CAP_CON_ID","=","$value"));
		$select->execute();
		$path = $select->arrayResult[0]['CAP_CON_CONTENT'];
		$file->setFile(ROOT_PATH.$path);
		//echo $file->checkFolderExistence();
		
		

			if (!empty($path) && $file->checkFolderExistence() == 0 ) {
				
				$status = $file->deleteDirectory();
					
					$explode = explode("/", $path);
					
					$type = $explode[2];
					$doc  = explode("-", $explode[3]);
					$doc  = $doc[1];
					$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS FOLDER ".$doc." DENGAN TIPE DOKUMEN ".$type,"FK_USE_ID"=>$id,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
									
					$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

					$insertHis->execute();

					$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=","$value")),"","");
					
					$delete->execute();
					
					$selects->tableName = "CAP_LANGUAGE_COMBINE";
					$select->whereClause = array(array("CAP_LAN_COM_FKID","=","$value"));
					$selects->execute();
					if(!empty($selects->arrayResult)){
						foreach ($selects->arrayResult as $keys => $values) {
							if(file_exists(ROOT_PATH."library/content/thumb/".$values[CAP_LAN_COM_ID].".jpg")){
								$status = $file->setFile(ROOT_PATH."library/content/thumb/".$values[CAP_LAN_COM_ID].".jpg")->deleteFile();
								}
						}
					}


					$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=","$value")),"","");
			
					$delete->execute();

					
						
			}
			else {
			$datas = new select("*","CAP_CONTENT",array(array("CAP_CON_ID","=","$value")),"");
			$datas->execute();
			$header = $datas->arrayResult[0]['CAP_CON_HEADER'];
			
			$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=","$value")),"","");
			
			$delete->execute();
			
			//$selectz->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID = CAP_CONTENT.CAP_CON_ID WHERE CAP_LAN_COM_FKID = '$value' AND CAP_LAN_COM_TYPE = 'content'";
			
			
												
				if (!empty($select->arrayResult)) {
												
				$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID", "=",$value),array( "CAP_LAN_COM_TYPE","=","content")),"","");
			
				$delete->execute();									
				
				$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS CONTENT DENGAN JUDUL ".$header,"FK_USE_ID"=>$id,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
				$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

				$insertHis->execute();
						
				}
			
			}
		
		}
		
	}
	
	if (!empty($data)) {
	
		foreach ($data as $key => $value) {
		$select = new select("*","CAP_CONTENT",array(array("CAP_CON_ID","=","$value[0]")),"","");
		$select->execute();
		$update->column = array("CAP_CON_PAGES" => $value[1]);
		$update->whereClause = array(array("CAP_CON_ID","=","$value[0]"));
		$update->whereID = "";
		$update->execute();
		
			if($select->arrayResult[0][CAP_CON_PAGES] != $value[2] || $select->arrayResult[0][FK_CAP_CONTENT_CATEGORY] != $value[1] ){
			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MELAKUKAN PERUBAHAN TERHADAP CONTENT DENGAN JUDUL \"".$select->arrayResult[0][CAP_CON_HEADER]."\"" ,"FK_USE_ID"=>$id,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();
		
			}
		}
		
	}
			
	}

	public static function getSetableMetadata(){
		$select = new select("*","CAP_METADATA_DEFAULT",array(array("CAP_MET_DEF_SHOW","!=","1")),"","");

		$select->execute();

		return $select->arrayResult;

	}
	
	public function uploadItem($folder,$type,$files,$userID,$conID,$mainID) {
				if(!empty($folder)){
				$explodeFolder = explode("-",$folder);
				
				

					if($explodeFolder[0]==$mainID){
					
						$combineFolder = $folder;
						
					}else{
						
						$combineFolder = $mainID.'-'.$folder;
						
					}
				
				
				
				$fileName = 'library/content/'.strtolower($type).'/'.$combineFolder.'/';

		$targetFolder = ROOT_PATH.$fileName;
		
			if (!empty($files)) {
			$tempFile = $files['Filedata']['tmp_name'];
			
			
			$fileTypes = array('JPG','jpg','jpeg','gif','png','pdf','mov','3gp','flv','avi','mp4','m4v','m4a','mp3','doc','docx','xls','xlsx','rar','txt','exe','zip');
			$fileParts = pathinfo($files['Filedata']['name']);
			$fileBaseName = $fileParts['filename'];
			
			$randomName = md5($files['Filedata']['name']).date('Y-m-d-H-i-s').".".$fileParts['extension'];
			//echo $randomName;
			
				if (in_array($fileParts['extension'],$fileTypes)) {
					//$randomName = md5($files['Filedata']['name']).date('Y-m-d H:i:s').".".$fileParts['extension'];
				$targetFile = str_replace('//','/',$targetFolder) . $randomName;
				$moveFile = move_uploaded_file($tempFile,$targetFile);
				
						


						$fileName .= $randomName;


						
						$insert = new insert(array(
							"CAP_LAN_COM_VALUE"   => $fileName,
							"CAP_LAN_COM_FKID"	  => $conID,
							"CAP_LAN_COM_COLUMN"  => $type,
							"CAP_LAN_COM_TYPE"    => $type,
							"CAP_LAN_COM_DATECREATED" => date("Y-m-d H:i:s")
						),"CAP_LANGUAGE_COMBINE","CAP_LAN_COM_ID","","");
						$insert->dateColumn = array("CAP_LAN_COM_DATECREATED");
						$itemId = $insert->execute();	
						$im = new imagick();
						if($moveFile){
						if( $fileParts['extension'] == 'pdf' ||  
							$fileParts['extension'] == 'mov' || 
							$fileParts['extension'] == 'jpg' ||
							$fileParts['extension'] == 'JPG' ||
							$fileParts['extension'] == 'jpeg'||
							$fileParts['extension'] == 'pdf' ||
							$fileParts['extension'] == 'png' ||
							$fileParts['extension'] == 'gif' ){

							
							$im->readImage($targetFile."[0]");
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
						}elseif($fileParts['extension'] == 'doc'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/DOC.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'docx'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/DOCX.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'xls'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/xls.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'xlsx'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/XLSX.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'm4a'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/M4A.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'mov'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/MOV.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'rar'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/RAR.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'zip'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/ZIP.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'txt'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/TXT.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'mp4' || $fileParts['extension'] == 'm4v'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/MP4.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}elseif($fileParts['extension'] == 'avi'){
						
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/AVI.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
							
						}else{
							$im = new imagick();
							
							$im->readImage(ROOT_PATH.'library/capsule/core/images/icon/Default.png');
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
							$im->setImageFormat( "png" );
							$im->writeImage(ROOT_PATH.'library/content/thumb/'.$itemId.".png");
						}
						
						
						$user = new select("CAP_USE_FIRSTNAME","CAP_USER",array(array("CAP_USE_ID","=","$userID")),"","");

						$user->execute();

						$userName = $user->arrayResult;

						$selectDefMet = new select("CAP_MET_DEF_NAME, CAP_MET_DEF_VALUE","CAP_METADATA_DEFAULT","","","");

						$selectDefMet -> execute();

						$neededMetaDataTab = $selectDefMet->arrayResult;
						
						foreach ($neededMetaDataTab as $key => $value) {
							if(strtolower($value[CAP_MET_DEF_NAME]) == "judul dokumen"){
								$neededMetaData [] = array($value[CAP_MET_DEF_NAME],$fileBaseName);
								
							}elseif(strtolower($value[CAP_MET_DEF_NAME]) == "nomor dokumen"){
								$neededMetaData [] = array($value[CAP_MET_DEF_NAME],$itemID);
							}elseif(strtolower($value[CAP_MET_DEF_NAME]) == "penerbit dokumen" || strtolower($value[CAP_MET_DEF_NAME]) == "tanggal diterbitkan"){
								$neededMetaData [] = array($value[CAP_MET_DEF_NAME],'[Belum Ditentukan]');
							}else{
								$neededMetaData [] = array($value[CAP_MET_DEF_NAME],$value[CAP_MET_DEF_VALUE]);
							}
							

						}
						
						if($fileParts['extension'] == 'pdf'){
																
								$neededMetaData [] = array($pagesOfPdfHeader,$pagesOfPdfContent);
								
						}
						
								$neededMetaData [] = array("Tipe File",mime_content_type($targetFile));
								
								$neededMetaData [] = array("Tanggal Upload Dokumen",date('d F Y'));
							
						

						/*$neededMetaData = array(
								array(
											"Judul Dokumen", "[Belum Di tentukan]"																				
									),
								array(
										"Penerbit Dokumen" , $userName[0][CAP_USE_FIRSTNAME]
									),
								array(
										"Tangal di terbitkan" ,"[Belum Di tentukan]"
									)
							);*/

						foreach ($neededMetaData as $keyMtd => $valueMtd) {
							
							$insertMtd = new insert(array(
									"FK_CAP_CON_ID" => $conID,
									"CAP_CON_MET_HEADER" => $valueMtd[0],
									"CAP_CON_MET_CONTENT" => $valueMtd[1],
									"CAP_CON_MET_PATH" => $fileName,
									"FK_CAP_LAN_COM_ID" => $itemId
								),"CAP_CONTENT_METADATA","","","");

							$insertMtd->execute();

						}

						$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName[0][CAP_USE_FIRSTNAME]." MENGUPLOAD ".$fileBaseName." KE DALAM FOLDER ".$folder,"FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
						
						$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

						$insertHis->execute();
						//if (strtolower($type) == 'video') {
						//	$video = new video('ffmpeg',$targetFile,'640x480','jpg'); $video->thumbnail();
						//}

						
						echo $files[Filedata][name] . " inserted";

						
					
					}else{
						
						echo "Error! there is an error occurred at uploading file";
						
					}
				
					
				
				
				} 
				else {
				echo 'Invalid file type.';
				}
		
		}
			}
	}
	
	public function uploadPhotoProfil($folder,$type,$files,$userID,$conID) {
		if(!empty($folder)){
			$explodeFolder = explode("-",$folder);
									
			
			$fileName = 'library/capsule/core/images/profile/';
			
			$targetFolder = ROOT_PATH.$fileName;
		
			if (!empty($files)) {
				$tempFile = $files['Filedata']['tmp_name'];
				
				
				$fileTypes = array('JPG','jpg','jpeg','gif','png');
				$fileParts = pathinfo($files['Filedata']['name']);
				$fileBaseName = $fileParts['filename'];
				$randomName = $userID.".".$fileParts['extension'];
				if($files['Filedata']['size'] <= 2000000 ):
					if (in_array($fileParts['extension'],$fileTypes)) {
						//$randomName = md5($files['Filedata']['name']).date('Y-m-d H:i:s').".".$fileParts['extension'];
						$targetFile = str_replace('//','/',$targetFolder) . $randomName;
						$moveFile = move_uploaded_file($tempFile,$targetFile);
						if($fileParts['extension'] != 'png' && $moveFile && $targetFile != str_replace('//','/',$targetFolder) ){
							$randomName = $userID.".png";
							imagepng(imagecreatefromstring(file_get_contents($targetFile)), str_replace('//','/',$targetFolder) .$randomName);
							unlink($targetFile);
						}
					
						if($moveFile){
																	
							$insertHis = new insert(array("CAP_PER_HIS_EVENT" =>"PHOTO PROFIL TELAH DIUBAH.","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
							
							$insertHis->dateColumn = array("CAP_PER_HIS_DATE");
	
							$insertHis->execute();
													
							echo $files[Filedata][name] . " inserted";
	
						}else{
							
							echo "Error! there is an error occurred at uploading photo.";
							return 0;
						}
					
					} 
					else {
						echo 'Only jpg, gif and png that allowed.';
						return 0;
					}
				else:
					echo 'Only file under 2mb that allowed.';
					return 0;
				endif;
		
			}
		}
			
	}
	
	
	public function updateContent($data) {
		$userID = model::getUserID();
		if(isset($data[8])){
			if(!empty($data[8])){
				$siteID = $data[8];
			}else{
				$siteID = model::getPersonalSiteID();
			}
		}else{
		
		$siteID = model::getUserSiteID();
		
		}
		//print_r($userID);

		//return false;

		$userName = model::getUserName();
		if (empty($data[0])) {
		
	
		
		$select = new select("*","CAP_CONTENT_TYPE WHERE CAP_CON_TYP_TYPE = 'content'","","","");
		
		$select->execute();
		
		//print_r($select);
		
		$type = $select->arrayResult[0]['CAP_CON_TYP_ID'];
		
			if (empty($data[1]) || empty($data[2]) ) {echo json_encode(array("error" => 1, "response" => null)); return false;}
			if($data[4] == "Y"){

				$publishDate = date("Y-m-d H:i:s");

				$first  = array(
				"CAP_USER_CAP_USE_ID" 		=> $userID, 
				"CAP_CON_CREATED" 			=> date("Y-m-d H:i:s"), 
				"CAP_CON_PUBLISHED" 		=> "Y", 
				"FK_CAP_CONTENT_CATEGORY" 	=> $data[1], 
				"CAP_CON_PAGES" 			=> $data[2], 
				"CAP_CON_CONTENT" 			=> $data[7], 
				"CAP_CON_HEADER" 			=> $data[5], 
				"FK_CAP_CONTENT_TYPE" 		=> $type,
				"CAP_CON_DATEPUBLISHED" 	=> $publishDate,
				"FK_CAP_MAI_ID"				=> $siteID);

			}else{
				$first  = array(
				"CAP_USER_CAP_USE_ID" 		=> $userID, 
				"CAP_CON_CREATED" 			=> date("Y-m-d H:i:s"), 
				"CAP_CON_PUBLISHED" 		=> "N", 
				"FK_CAP_CONTENT_CATEGORY" 	=> $data[1], 
				"CAP_CON_PAGES" 			=> $data[2], 
				"CAP_CON_CONTENT" 			=> $data[7], 
				"CAP_CON_HEADER" 			=> $data[5], 
				"FK_CAP_CONTENT_TYPE" 		=> $type,
				"CAP_CON_DATEPUBLISHED" 	=> "",
				"FK_CAP_MAI_ID"				=> $siteID);
			}
		
		$insert = new insert($first,"CAP_CONTENT","CAP_CON_ID","","");
		
		$insert->dateColumn = array("CAP_CON_CREATED","CAP_CON_DATEPUBLISHED");
		
		$insert->clob = array("CAP_CON_CONTENT");
		
		$lastID = $insert->execute();
	
			if (empty($lastID) || !is_numeric($lastID)) {echo json_encode(array("error" => 1, "response" => "Insert Failed!")); return false;}

		$secon  = array(
		"CAP_LAN_COM_COLUMN" 		=> "header", 
		"CAP_LAN_COM_VALUE" 		=> $data[5], 
		"CAP_LAN_COM_FKID"	 		=> $lastID, 
		"CAP_LAN_COM_LAN_ID"	 	=> $data[3], 
		"CAP_LAN_COM_TYPE" 			=> "content",
		"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
		);
		
		unset($insert->dateColumn);
		
		$insert->tableName = "CAP_LANGUAGE_COMBINE";
		
		$insert->whereClause = "CAP_LAN_COM_ID";
		
		$insert->column = $secon;
		
		$insert->clob   = array("CAP_LAN_COM_VALUE");
		
		$lastID2nd = $insert->execute();

			if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
			echo json_encode(array("error" => 2, "response" => null)); 
			$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=",$lastID)),""); $delete->deleteRow();
			$delete = new delete("","CAP_LANGUAGE_COMBINE","CAP_LAN_COM_FKID = '$lastID' AND CAP_LAN_COM_LAN_ID = '".$data[3]."' AND CAP_LAN_COM_TYPE = 'content'","",""); $delete->execute(); 
			return false;
			}
		
		$third  = array(
		"CAP_LAN_COM_COLUMN" 		=> "content", 
		"CAP_LAN_COM_VALUE" 		=> $data[7], 
		"CAP_LAN_COM_FKID"	 		=> $lastID, 
		"CAP_LAN_COM_LAN_ID"	 	=> $data[3], 
		"CAP_LAN_COM_TYPE" 			=> "content",
		"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
		);
		
		$insert->column = $third;
		
		$lastID2nd 		= $insert->execute();

			if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
			echo json_encode(array("error" => 3, "response" => null)); 
			$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=",$lastID)),""); $delete->execute();
			$delete = new delete("","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = '$lastID' AND CAP_LAN_COM_LAN_ID = '".$data[3]."' AND CAP_LAN_COM_TYPE = 'content'","",""); $delete->execute(); 
			return false;
			}
			else {
			echo json_encode(array("error" => 0, "response" => "success", "id" => $lastID));
			}

			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MEMBUAT CONTENT BARU DENGAN JUDUL ".$data[5]."","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();

		
		}
		else {

			if($data[4] == "Y"){
				$first  = array("FK_CAP_CONTENT_CATEGORY" => $data[1], "CAP_CON_PUBLISHED" 	=> "Y",  "CAP_CON_PAGES" => $data[2], "CAP_CON_CONTENT" => $data[6], "CAP_CON_HEADER" => $data[5], "CAP_CON_DATEPUBLISHED" => date("Y-m-d H:i:s"));
			}else{
				$first  = array("FK_CAP_CONTENT_CATEGORY" => $data[1], "CAP_CON_PUBLISHED" 	=> "N", "CAP_CON_PAGES" => $data[2], "CAP_CON_CONTENT" => $data[6], "CAP_CON_HEADER" => $data[5], "CAP_CON_DATEPUBLISHED" => "");
			}
		
		
		
		$secon  = array("CAP_LAN_COM_VALUE" => $data[5], "CAP_LAN_COM_DESCRIPTION" 	=> $data[6]);
		
		$third  = array("CAP_LAN_COM_VALUE" => $data[7], "CAP_LAN_COM_DESCRIPTION" 	=> $data[6]);
		
		$update = new update($first,"CAP_CONTENT",array(array("CAP_CON_ID","=",$data[0])),"");

		$update->dateColumn = array("CAP_CON_DATEPUBLISHED");
		
		$update->clob = array("CAP_CON_CONTENT");
		
		$update->execute();
		
				
		$select = new select("*","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = ".$data[0]." AND CAP_LAN_COM_LAN_ID = '".$data[3]."' AND CAP_LAN_COM_TYPE = 'content'","","","");
		
		$select->execute();
		
			if (!empty($select->arrayResult)) {
		
			$update = new update($secon,"CAP_LANGUAGE_COMBINE",array(array(" CAP_LAN_COM_FKID","=",$data[0]),array("CAP_LAN_COM_LAN_ID"," = ",$data[3]),array(" CAP_LAN_COM_COLUMN","=","header"),array(" CAP_LAN_COM_TYPE","=","content")),"","");
		
			$update->clob = array("CAP_LAN_COM_VALUE");
		
			$update->execute();
		
			$update = new update($third,"CAP_LANGUAGE_COMBINE",array(array(" CAP_LAN_COM_FKID","=",$data[0]),array("CAP_LAN_COM_LAN_ID"," = ",$data[3]),array(" CAP_LAN_COM_COLUMN","=","content"),array(" CAP_LAN_COM_TYPE","=","content")),"","");
		
			$update->clob = array("CAP_LAN_COM_VALUE");
		
			$update->execute();
			
			}
			else {
			
			$insert = new insert("","","","","");
			
			$secon  = array(
			"CAP_LAN_COM_COLUMN" => "header", 
			"CAP_LAN_COM_VALUE"  => $data[5], 
			"CAP_LAN_COM_FKID"	 => $data[0], 
			"CAP_LAN_COM_LAN_ID" => $data[3], 
			"CAP_LAN_COM_TYPE" 	 => "content",
			"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
			);
			
			$insert->tableName 	 = "CAP_LANGUAGE_COMBINE";
			
			$insert->whereClause = "CAP_LAN_COM_ID";
			
			$insert->column = $secon;
			
			$insert->clob   = array("CAP_LAN_COM_VALUE");
			
			$lastID2nd = $insert->execute();
			
				if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
				$delete = new delete("","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_ID = '$lastID2nd'","",""); $delete->execute();
				return false;
				}
			
			$third  = array(
			"CAP_LAN_COM_COLUMN" => "content", 
			"CAP_LAN_COM_VALUE"  => $data[7], 
			"CAP_LAN_COM_FKID"	 => $data[0], 
			"CAP_LAN_COM_LAN_ID" => $data[3], 
			"CAP_LAN_COM_TYPE" 	 => "content",
			"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
			);
		
			$insert->column = $third;
			
			$lastID2nd 		= $insert->execute();
			
				if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
				$delete = new delete("","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_ID = '$lastID2nd'","",""); $delete->execute();
				return false;
				}
			
			
			}

			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGUBAH CONTENT DENGAN JUDUL ".$data[5]."","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();

		
		}
		
	}
	
	public function updateEvent($data) {
		$categoryID = 6;
	
		$userID = model::getUserID();

		//print_r($userID);

		//return false;

		$userName = model::getUserName();
		if (empty($data[0])) {
		
	
		
		$select = new select("*","CAP_CONTENT_TYPE WHERE CAP_CON_TYP_TYPE = 'event'","","","");
		
		$select->execute();
		
		//print_r($select);
		
		$type = $select->arrayResult[0]['CAP_CON_TYP_ID'];
			
			if (empty($data[1]) || empty($data[2]) ) {echo json_encode(array("error" => 1, "response" => null)); return false;}
			if($data[3] == "Y"){


				$first  = array(
				"CAP_USER_CAP_USE_ID" 		=> $userID, 
				"CAP_CON_CREATED" 			=> date("Y-m-d H:i:s"), 
				"CAP_CON_PUBLISHED" 		=> "Y", 
				"FK_CAP_CONTENT_CATEGORY" 	=> $categoryID, 
				"CAP_CON_PAGES" 			=> $data[1], 
				"CAP_CON_CONTENT" 			=> $data[7], 
				"CAP_CON_HEADER" 			=> $data[4], 
				"FK_CAP_CONTENT_TYPE" 		=> $type,
				"CAP_CON_DATEPUBLISHED" 	=> date('Y-m-d H:i:s', strtotime($data[5])));

			}else{
				$first  = array(
				"CAP_USER_CAP_USE_ID" 		=> $userID, 
				"CAP_CON_CREATED" 			=> date("Y-m-d H:i:s"), 
				"CAP_CON_PUBLISHED" 		=> "N", 
				"FK_CAP_CONTENT_CATEGORY" 	=> $categoryID, 
				"CAP_CON_PAGES" 			=> $data[1], 
				"CAP_CON_CONTENT" 			=> $data[7], 
				"CAP_CON_HEADER" 			=> $data[4], 
				"FK_CAP_CONTENT_TYPE" 		=> $type,
				"CAP_CON_DATEPUBLISHED" 	=> date('Y-m-d H:i:s', strtotime($data[5])));
			}
		
		$insert = new insert($first,"CAP_CONTENT","CAP_CON_ID","","");
		
		$insert->dateColumn = array("CAP_CON_CREATED","CAP_CON_DATEPUBLISHED");
		
		$insert->clob = array("CAP_CON_CONTENT");
		
		$lastID = $insert->execute();
	
			if (empty($lastID) || !is_numeric($lastID)) {echo json_encode(array("error" => 1, "response" => null)); return false;}

		$secon  = array(
		"CAP_LAN_COM_COLUMN" 		=> "header", 
		"CAP_LAN_COM_VALUE" 		=> $data[4], 
		"CAP_LAN_COM_FKID"	 		=> $lastID, 
		"CAP_LAN_COM_LAN_ID"	 	=> $data[2], 
		"CAP_LAN_COM_TYPE" 			=> "content",
		"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
		);
		
		unset($insert->dateColumn);
		
		$insert->tableName = "CAP_LANGUAGE_COMBINE";
		
		$insert->whereClause = "CAP_LAN_COM_ID";
		
		$insert->column = $secon;
		
		$insert->clob   = array("CAP_LAN_COM_VALUE");
		
		$lastID2nd = $insert->execute();

			if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
			echo json_encode(array("error" => 2, "response" => null)); 
			$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=",$lastID)),""); $delete->deleteRow();
			$delete = new delete("","CAP_LANGUAGE_COMBINE","CAP_LAN_COM_FKID = '$lastID' AND CAP_LAN_COM_LAN_ID = '".$data[2]."' AND CAP_LAN_COM_TYPE = 'content'","",""); $delete->execute(); 
			return false;
			}
		
		$third  = array(
		"CAP_LAN_COM_COLUMN" 		=> "content", 
		"CAP_LAN_COM_VALUE" 		=> $data[7], 
		"CAP_LAN_COM_FKID"	 		=> $lastID, 
		"CAP_LAN_COM_LAN_ID"	 	=> $data[2], 
		"CAP_LAN_COM_TYPE" 			=> "content",
		"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
		);
		
		$insert->column = $third;
		
		$lastID2nd 		= $insert->execute();

			if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
			echo json_encode(array("error" => 3, "response" => null)); 
			$delete = new delete("","CAP_CONTENT",array(array("CAP_CON_ID","=",$lastID)),""); $delete->execute();
			$delete = new delete("","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = '$lastID' AND CAP_LAN_COM_LAN_ID = '".$data[2]."' AND CAP_LAN_COM_TYPE = 'content'","",""); $delete->execute(); 
			return false;
			}
			else {
			echo json_encode(array("error" => 0, "response" => "success", "id" => $lastID));
			}

			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MEMBUAT CONTENT BARU DENGAN JUDUL ".$data[4]."","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();

		
		}
		else {

			if($data[3] == "Y"){
				$first  = array("FK_CAP_CONTENT_CATEGORY" => $categoryID, "CAP_CON_PUBLISHED" 	=> "Y",  "CAP_CON_PAGES" => $data[1], "CAP_CON_CONTENT" => $data[7], "CAP_CON_HEADER" => $data[4], "CAP_CON_DATEPUBLISHED" =>  date('Y-m-d H:i:s', strtotime($data[5])));
			}else{
				$first  = array("FK_CAP_CONTENT_CATEGORY" => $categoryID, "CAP_CON_PUBLISHED" 	=> "N", "CAP_CON_PAGES" => $data[1], "CAP_CON_CONTENT" => $data[7], "CAP_CON_HEADER" => $data[4], "CAP_CON_DATEPUBLISHED" =>  date('Y-m-d H:i:s', strtotime($data[5])));
			}
		
		
		
		$secon  = array("CAP_LAN_COM_VALUE" => $data[4], "CAP_LAN_COM_DESCRIPTION" 	=> $data[6]);
		
		$third  = array("CAP_LAN_COM_VALUE" => $data[7], "CAP_LAN_COM_DESCRIPTION" 	=> $data[6]);
		
		$update = new update($first,"CAP_CONTENT",array(array("CAP_CON_ID","=",$data[0])),"");

		$update->dateColumn = array("CAP_CON_DATEPUBLISHED");
		
		$update->clob = array("CAP_CON_CONTENT");
		
		$update->execute();
		
				
		$select = new select("*","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = ".$data[0]." AND CAP_LAN_COM_LAN_ID = '".$data[2]."' AND CAP_LAN_COM_TYPE = 'content'","","","");
		
		$select->execute();
		
			if (!empty($select->arrayResult)) {
		
			$update = new update($secon,"CAP_LANGUAGE_COMBINE",array(array(" CAP_LAN_COM_FKID","=",$data[0]),array("CAP_LAN_COM_LAN_ID"," = ",$data[2]),array(" CAP_LAN_COM_COLUMN","=","header"),array(" CAP_LAN_COM_TYPE","=","content")),"","");
		
			$update->clob = array("CAP_LAN_COM_VALUE");
		
			$update->execute();
		
			$update = new update($third,"CAP_LANGUAGE_COMBINE",array(array(" CAP_LAN_COM_FKID","=",$data[0]),array("CAP_LAN_COM_LAN_ID"," = ",$data[2]),array(" CAP_LAN_COM_COLUMN","=","content"),array(" CAP_LAN_COM_TYPE","=","content")),"","");
		
			$update->clob = array("CAP_LAN_COM_VALUE");
		
			$update->execute();
			
			}
			else {
			
			$insert = new insert("","","","","");
			
			$secon  = array(
			"CAP_LAN_COM_COLUMN" => "header", 
			"CAP_LAN_COM_VALUE"  => $data[4], 
			"CAP_LAN_COM_FKID"	 => $data[0], 
			"CAP_LAN_COM_LAN_ID" => $data[2], 
			"CAP_LAN_COM_TYPE" 	 => "content",
			"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
			);
			
			$insert->tableName 	 = "CAP_LANGUAGE_COMBINE";
			
			$insert->whereClause = "CAP_LAN_COM_ID";
			
			$insert->column = $secon;
			
			$insert->clob   = array("CAP_LAN_COM_VALUE");
			
			$lastID2nd = $insert->execute();
			
				if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
				$delete = new delete("","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_ID = '$lastID2nd'","",""); $delete->execute();
				return false;
				}
			
			$third  = array(
			"CAP_LAN_COM_COLUMN" => "content", 
			"CAP_LAN_COM_VALUE"  => $data[7], 
			"CAP_LAN_COM_FKID"	 => $data[0], 
			"CAP_LAN_COM_LAN_ID" => $data[2], 
			"CAP_LAN_COM_TYPE" 	 => "content",
			"CAP_LAN_COM_DESCRIPTION" 	=> $data[6]
			);
		
			$insert->column = $third;
			
			$lastID2nd 		= $insert->execute();
			
				if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
				$delete = new delete("","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_ID = '$lastID2nd'","",""); $delete->execute();
				return false;
				}
			
			
			}

			$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGUBAH CONTENT DENGAN JUDUL ".$data[4]."","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
			$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

			$insertHis->execute();

		
		}
		
	}

	
	public function getMultipleLanguageContent($data) {
	
	$select = new select("*","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=","$data[0]"), array("CAP_LAN_COM_LAN_ID","=","$data[1]"), array("CAP_LAN_COM_TYPE","=","content")),"","");
		
	$select->execute();
	
		if (!empty($select->arrayResult)) {
		
			foreach ($select->arrayResult as $key => $value) {
			
				if ($value['CAP_LAN_COM_COLUMN'] == 'header') {
					$header  = $value['CAP_LAN_COM_VALUE'];
					$desc  	 = $value['CAP_LAN_COM_DESCRIPTION'];
				}
				else {
					$content = $value['CAP_LAN_COM_VALUE'];
					$desc  	 = $value['CAP_LAN_COM_DESCRIPTION'];
				}
			
			}
		
		echo json_encode(array('header' => $header, 'content' => $content, 'desc' => $desc));
		
		}
		else {
		
		echo json_encode(array('header' => $header, 'content' => $content, 'desc' => $desc));
		
		}
	
	}
	
	public function getMultipleLanguageMenu($data) {
	
	$select = new select("*","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=","$data[0]"), array("CAP_LAN_COM_LAN_ID","=","$data[1]"), array("CAP_LAN_COM_TYPE","=","menu")),"","");
		
	$select->execute();
	
		if (!empty($select->arrayResult)) {
		
			foreach ($select->arrayResult as $key => $value) {
			
				if ($value['CAP_LAN_COM_COLUMN'] == 'header') {
					$header  = $value['CAP_LAN_COM_VALUE'];
				}
				else {
					$content = $value['CAP_LAN_COM_VALUE'];
				}
			
			}
		
		echo json_encode(array('header' => $header, 'content' => $content));
		
		}
		else {
		
		echo json_encode(array('header' => $header, 'content' => $content));
		
		}
	
	}
	
	public function insertMainSubMenu($data) {
		
	$userID = model::getUserID();
	
	$selectParMen = new select("*","CAP_MENU",array( array("CAP_MEN_ID","=","3920")),"","");
	
	$selectParMen->execute();
	
	$pos1 = ($selectParMen->arrayResult[0]['CAP_MEN_POSITION']) + 1;
	$pos2 = ($selectParMen->arrayResult[0]['CAP_MEN_POSITION2']) + 1;
		
	$select = new select("*","CAP_MENU",array(array("FK_CAP_USE_ID","=","$userID"), array("CAP_MEN_PARENT","=","3920")),"","");
	
	$select->execute();
	
		if (empty($select->arrayResult)) {
		
		$array  = array(
				  "CAP_MENU_TYPE_CAP_MEN_TYP_ID" => 1083,
				  "CAP_MEN_NAME" => $data[1],
				  "CAP_MEN_PARENT" => 3920,
				  "CAP_MEN_ACCESS" => 4,
				  "CAP_MEN_STATUS" => "Active",
				  "FK_CAP_USE_ID" => $userID,
				  "CAP_MEN_POSITION" => $pos1,
				  "CAP_MEN_POSITION2" => $pos2
				  );
		
		$insert = new insert($array,"CAP_MENU","CAP_MEN_ID","","");
		
		$lastID = $insert->execute();
		
		$insert = new insert("","","","","");
		
		$secon  = array(
		"CAP_LAN_COM_COLUMN" => "CAP_MEN_NAME", 
		"CAP_LAN_COM_VALUE"  => $data[1], 
		"CAP_LAN_COM_FKID"	 => $lastID, 
		"CAP_LAN_COM_LAN_ID" => $data[2], 
		"CAP_LAN_COM_TYPE" 	 => "menu");
		
		$insert->tableName 	 = "CAP_LANGUAGE_COMBINE";
		
		$insert->whereClause = "CAP_LAN_COM_ID";
		
		$insert->column = $secon;
		
		$lastID2nd = $insert->execute();
			
			if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
			$delete = new delete("","CAP_MENU","CAP_MEN_ID",$lastID,""); $delete->execute();
			$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_ID","=", "$lastID2nd")),"",""); $delete->execute();
			return false;
			}
			
		echo $lastID;
		
		}
		else {
		
		$array  = array("CAP_MEN_NAME" => $data[1]);
		
		$update = new update($array,"CAP_MENU",array(array("CAP_MEN_ID","=","$data[0]")),"","");
		
		$update->execute();
		
		$select = new select("*","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=","$data[0]"), array("CAP_LAN_COM_LAN_ID","=","$data[2]"), array("CAP_LAN_COM_TYPE","=","menu")),"","");
		
		$select->execute();
		
			if (empty($select->arrayResult)) {
			
			$insert = new insert("","","","","");
			
			$secon  = array(
			"CAP_LAN_COM_COLUMN" => "CAP_MEN_NAME", 
			"CAP_LAN_COM_VALUE"  => $data[1], 
			"CAP_LAN_COM_FKID"	 => $data[0], 
			"CAP_LAN_COM_LAN_ID" => $data[8], 
			"CAP_LAN_COM_TYPE" 	 => "menu");
			
			$insert->tableName 	 = "CAP_LANGUAGE_COMBINE";
			
			$insert->whereClause = "CAP_LAN_COM_ID";
			
			$insert->column = $secon;
			
			
			$lastID2nd = $insert->execute();
			
				if (empty($lastID2nd) || !is_numeric($lastID2nd)) {
				$delete = new delete("","CAP_MENU","CAP_MEN_ID",$lastID,""); $delete->execute();
				$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_ID" ,"=" ,"$lastID2nd")),"",""); $delete->execute();
				return false;
				}
			
			}
			else {
			
			$secon  = array("CAP_LAN_COM_VALUE"  => $data[1]);
			
			$update = new update($secon,"CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=",$data[0]), array("CAP_LAN_COM_LAN_ID","=","$data[8]"),array("CAP_LAN_COM_COLUMN","=","CAP_MEN_NAME"), array("CAP_LAN_COM_TYPE","=","menu")),"","");
		
			$update->clob = array("CAP_LAN_COM_VALUE");
		
			$update->execute();
			
			echo $update->query;
			
			}
		
		}
	
	}
	
	public function insertSubMenu($data,$del) {
	
	//print_r($data);
	
	$userID = model::getUserID();
	
		if (!empty($del)) {
		
		$mainDeleter = new delete("","","","","");
		
			foreach ($del as $key => $value) {
			
				$mainDeleter->tableName   = "CAP_MENU";
				$mainDeleter->whereClause = array(array("CAP_MEN_ID", "=", "$value"),array("FK_CAP_USE_ID", "=","$userID"));
				$mainDeleter->execute();
				
				$mainDeleter->tableName   = "CAP_MENU_PAGES";
				$mainDeleter->whereClause = array(array("CAP_MENU_CAP_MEN_ID", "=", "$value"));
				$mainDeleter->execute();
				
				$mainDeleter->tableName   = "CAP_LANGUAGE_COMBINE";
				$mainDeleter->whereClause = array(array("CAP_LAN_COM_FKID", "=", "$value"));
				$mainDeleter->execute();
			
			}
		
		}
	
	$select = new select("*","CAP_MENU",array(array("CAP_MEN_PARENT", "=", 3920),array("FK_CAP_USE_ID", "=","$userID")),"","");
	
	$select->execute();
	
		if (empty($select->arrayResult)) {
		
		echo "Mohon isi profil terlebih dahulu";
		
		return false;
		
		}
		else {
		
			foreach ($data as $key => $value) {
			
			$select2 = new select("*","CAP_MENU",array(array("CAP_MEN_ID", "=", "$value[0]"),array("FK_CAP_USE_ID", "=","$userID")),"","");
			
			$select2->execute();
			
				if (empty($select2->arrayResult)) {
			
				$array  = array(
				"CAP_MENU_TYPE_CAP_MEN_TYP_ID" 	=> 1083,
				"CAP_MEN_NAME" 					=> $value[2],
				"CAP_MEN_PARENT" 				=> $select->arrayResult[0]['CAP_MEN_ID'],
				"CAP_MEN_ACCESS" 				=> 4,
				"CAP_MEN_STATUS" 				=> "Inactive",
				"CAP_MEN_POSITION" 				=> $value[4],
				"CAP_MEN_OTHERURL" 				=> $value[3],
				"FK_CAP_USE_ID" 				=> $userID
				);
		
				$insert = new insert($array,"CAP_MENU","CAP_MEN_ID","","");
			
				$lastID = $insert->execute();
			
				$insert->tableName 	 = "CAP_MENU_PAGES";
			
				$insert->whereClause = "CAP_MEN_PAG_ID";
			
				$insert->column 	 = array("CAP_MENU_CAP_MEN_ID" => $lastID, "CAP_PAGES_CAP_PAG_ID" => $value[5]);
			
				$lastID2nd = $insert->execute();
			
				$secon  = array(
				"CAP_LAN_COM_COLUMN" => "CAP_MEN_NAME", 
				"CAP_LAN_COM_VALUE"  => $value[2], 
				"CAP_LAN_COM_FKID"	 => $lastID, 
				"CAP_LAN_COM_LAN_ID" => $value[8], 
				"CAP_LAN_COM_TYPE" 	 => "menu");
						
				$insert->tableName 	 = "CAP_LANGUAGE_COMBINE";
			
				$insert->whereClause = "CAP_LAN_COM_ID";
			
				$insert->column 	 = $secon;
			
				$insert->clob   	 = array("CAP_LAN_COM_VALUE");
			
				$lastID3rd = $insert->execute();
			
					if (empty($lastID) || !is_numeric($lastID) || empty($lastID2nd) || !is_numeric($lastID2nd) || empty($lastID3rd) || !is_numeric($lastID3rd)) {
					$delete = new delete("","CAP_MENU",array(array("CAP_MEN_ID","=",$lastID)),"",""); $delete->execute();
					$delete = new delete("","CAP_MENU_PAGES",array(array("CAP_MEN_PAG_ID","'=",$lastID2nd)),"",""); $delete->execute();
					$delete = new delete("","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_ID","'=",$lastID3rd)),"",""); $delete->execute();
					return false;
					}
					
				}
				else {
				
				$array  = array(
				"CAP_MEN_NAME" 		=> $value[2],
				"CAP_MEN_POSITION" 	=> $value[4],
				"CAP_MEN_OTHERURL" 	=> $value[3]
				);
		
				$update = new update($array,"CAP_MENU",array(array("CAP_MEN_ID","=",$value[0])),"","");
		
				$update->execute();
				
				$select3 = new select("*","CAP_MENU_PAGES",array(array("CAP_MENU_CAP_MEN_ID","=",$value[0])),"","");
				
				$select3->execute();
				
					if (!empty($select3->arrayResult)) {
			
					$update->tableName 	 = "CAP_MENU_PAGES";
			
					$update->whereClause = array(array("CAP_MENU_CAP_MEN_ID","=",$value[0]));
					
					$update->whereID 	 = "";
			
					$update->column 	 = array("CAP_PAGES_CAP_PAG_ID" => $value[5]);
						
					$lastID2nd = $update->execute();
					
					}
					else {
					
					$insert = new insert("","","","","");
					
					$insert->tableName 	 = "CAP_MENU_PAGES";
					
					$insert->whereClause = "CAP_MEN_PAG_ID";
					
					$insert->column 	 = array("CAP_MENU_CAP_MEN_ID" => $value[0], "CAP_PAGES_CAP_PAG_ID" => $value[5]);
						
					$lastID2nd = $insert->execute();
					
					}
				
				$select3 = new select("*","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=",$value[0]), array("CAP_LAN_COM_LAN_ID","=",$value[8]), array("CAP_LAN_COM_TYPE","=","menu")),"","");
				
				$select3->execute();
				
					if (!empty($select3->arrayResult)) {
					
					$secon  = array(
					"CAP_LAN_COM_VALUE"  => $value[2],
					"CAP_LAN_COM_LAN_ID" => $value[8],
					"CAP_LAN_COM_TYPE" 	 => "menu");
					
					$update->tableName 	 = "CAP_LANGUAGE_COMBINE";
			
					$update->whereClause = "CAP_LAN_COM_FKID";
					
					$update->whereID 	 = $value[0] . " AND CAP_LAN_COM_LAN_ID = '".$value[8]."' AND CAP_LAN_COM_TYPE = 'menu'";
			
					$update->column 	 = $secon;
						
					$lastID3rd = $update->execute();
					
					}
					else {
										
					$insert = new insert("","","","","");
					
					$secon  = array(
					"CAP_LAN_COM_COLUMN" => "CAP_MEN_NAME", 
					"CAP_LAN_COM_VALUE"  => $value[2], 
					"CAP_LAN_COM_FKID"	 => $value[0], 
					"CAP_LAN_COM_LAN_ID" => $value[8], 
					"CAP_LAN_COM_TYPE" 	 => "menu");
										
					$insert->tableName 	 = "CAP_LANGUAGE_COMBINE";
					
					$insert->column 	 = $secon;
					
					$lastID3rd = $insert->execute();
					
					}
				
				}
			
			}
		
		}
	
	}
	
	public function getSubMainMenu() {
	
	$userID = model::getUserID();
	
	$select = new select("*","CAP_MENU",array(array("FK_CAP_USE_ID","=","$userID"), array("CAP_MEN_PARENT","=","3920")),"","");
	
	$select->execute();

	return $select->arrayResult;
	
	}
	
	public function getSubMenu() {
	
	$userID = model::getUserID();
	
	$select = new select("*","CAP_MAIN","","","");
	
	$select->execute();
	
	$defaultLanguage = $select->arrayResult[0]['CAP_MAI_LANGUAGE'];
	
	$select = new select("*","CAP_MENU LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID",array(array("FK_CAP_USE_ID","=","$userID"), array("CAP_MEN_PARENT","!=","3920"), array("CAP_LAN_COM_LAN_ID","=","$defaultLanguage"), array("CAP_LAN_COM_TYPE","=","menu")),"","");
	
	$select->execute();

	return $select->arrayResult;
	
	}
	
	public function getItemData($id){
	
		$select = new select("*","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=","$id")),"","","1");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	
	
	public static function metadata($path) {
		
		$select = new select("*","CAP_CONTENT_METADATA",array(array("CAP_CON_MET_PATH","=","$path")),"","CAP_CON_MET_ID ASC"); $select->execute();
		
		return $select->arrayResult;
		
		}
		
    public static function saveMetadata($id,$del) {
	
	if (!empty($del)) {
	
		foreach ($del as $key => $value) {
				
			if (!empty($value)) {
			$delete = new delete("","CAP_CONTENT_METADATA",array(array("CAP_CON_MET_ID","=","$value")),"",""); $delete->execute();
			}
				
		}
		
	}
	
	$select = new select("*","","","","","1");
	
	$insert = new insert("","","","","");
	
	$update = new update("","","","","");
	
	if (!empty($id)) {
	
		foreach ($id as $key => $value) {
			
			$select->tableName = "CAP_CONTENT_METADATA";
			
			$select->whereClause = array(array("FK_CAP_CON_ID","=",$value[1]),array("FK_CAP_LAN_COM_ID","","IS NOT NULL"));
			
			$select->execute();
			
				if (!empty($select->arrayResult)) {
					
					$lastPath = $select->arrayResult[0]['FK_CAP_LAN_COM_ID'];
					
				}
				
			//print_r($lastPath);
			
			if ($value[0] == 'on') {
			
			$insert->tableName = "CAP_CONTENT_METADATA";
			
			
											
			$insert->column = array(
								 "FK_CAP_CON_ID" => $value[1],
								 "CAP_CON_MET_HEADER" => $value[2],
								 "CAP_CON_MET_CONTENT" => $value[3],
								 "CAP_CON_MET_PATH" => $value[4],
								 "FK_CAP_LAN_COM_ID" => $lastPath); 
			
			$insert->execute();
			
			}
			else {
											
			$update->tableName = "CAP_CONTENT_METADATA";
			
			$update->whereClause = array(array("CAP_CON_MET_ID","=",$value[0]));
			
			$update->whereID = "";
			
			$update->column = array(
								 "CAP_CON_MET_HEADER" => $value[2],
								 "CAP_CON_MET_CONTENT" => $value[3],
								 "FK_CAP_LAN_COM_ID" => $lastPath); 
			
			$update->execute();
			
			}
			
		}
		
	}
	
	}
	
	public static function saveClassification($id) {
	
	
	$insert = new insert("","","","","");
	
	$update = new update("","","","","");
	
	if (!empty($id)) {
		
		$value = $id;
	
		
			//print_r($value);
			if($value[1]==$value[2]){
				
			echo "nothing";
			}
			else if($value[1]=="" || empty($value[1])){
				
				if(!empty($value[0])){
				
				$insert->tableName = "CAP_PER_MT_KLA_LAN_COM";
				
				$insert->column = (array(
					
					"FK_LAN_COM_ID" => $value[0],
					"FK_KLA_ID" => $value[2]
				
				));
				echo "new";
				$insert->execute();
				}
				
			}else{
			
				if(!empty($value[0])){
				$update->column = (array(
									"FK_KLA_ID" => $value[2]
				)); 
				
				$update->tableName = "CAP_PER_MT_KLA_LAN_COM";
				
				$update->whereClause = array(array("FK_LAN_COM_ID","=","$value[0]"));
				
				$update->whereID = "";
				echo "update";
				$update->execute();
				}
			}
			
			$check = new select("","","","","");
			
			$insert = new insert("","","","","");
			
			$check -> column = "*";
			
			$check -> tableName = "CAP_CONTENT_METADATA";
			
			$check -> whereClause = array(array("FK_CAP_LAN_COM_ID","=","$value[0]"),array("LOWER(CAP_CON_MET_HEADER)","=","LOWER('Klasifikasi')"));
			
			$check -> whereID = "";
			
			$check->execute();
			
			$select = new select("*","CAP_KLASIFIKASI",array(array("CAP_KLA_ID","=","$value[2]")),"","");
				
			$select->execute();
			
			$groName = $select->arrayResult[0]['CAP_KLA_NAME'];
			
			if(!empty($check->arrayResult[0]['CAP_CON_MET_ID'])){
			
				$updateMeta = new update(array("CAP_CON_MET_CONTENT" => $groName),"CAP_CONTENT_METADATA",array(array("CAP_CON_MET_ID","=","$check->arrayResult[0]['CAP_CON_MET_ID']")),"","");
								
				$status .= $updateMeta->execute();	
								
			}else{
				
				$check -> column = "*";
			
				$check -> tableName = "CAP_CONTENT_METADATA";
				
				$check -> whereClause = array(array("FK_CAP_LAN_COM_ID","=","$value[0]"));
				
				$check -> whereID = "" ;
				
				$check->execute();
				
				$insert->column = array(
									"FK_CAP_CON_ID" => $check->arrayResult[0]['FK_CAP_CON_ID'],
									"CAP_CON_MET_HEADER" => "Klasifikasi",
									"CAP_CON_MET_CONTENT" => $groName,
									"CAP_CON_MET_PATH" => $check->arrayResult[0]['CAP_CON_MET_PATH'],
									"FK_CAP_LAN_COM_ID" => $value[0]);
		
				$insert->tableName = "CAP_CONTENT_METADATA";
				
				$status .= $insert->execute();
				
				
			}
			
			
				if($value[4]==$value[5]){
				
			echo "nothing";
			}
			else if($value[4]=="" || empty($value[4])){
				
				if(!empty($value[0])){
				
				$insert->tableName = "CAP_PER_PUB_LAN_COM";
				
				$insert->column = (array(
					
					"FK_LAN_COM_ID" => $value[0],
					"FK_PER_PUB_ID" => $value[5]
				
				));
				echo "new";
				$insert->execute();
				}
				
			}else{
			
				if(!empty($value[0])){
				$update->column = (array(
									"FK_PER_PUB_ID" => $value[5]
				)); 
				
				$update->tableName = "CAP_PER_PUB_LAN_COM";
				
				$update->whereClause = array(array("FK_LAN_COM_ID","=","$value[0]"));
				
				$update->whereID = "";
				echo "update";
				$update->execute();
				}
			}
			
			$check = new select("","","","","");
			
			$insert = new insert("","","","","");
			
			$check -> column = "*";
			
			$check -> tableName = "CAP_CONTENT_METADATA";
			
			$check -> whereClause = array(array("FK_CAP_LAN_COM_ID","=","$value[0]"), array("LOWER(CAP_CON_MET_HEADER)","=","LOWER('Penerbit Dokumen')"));
			
			$check -> whereID = "" ;
			
			$check->execute();
			
			$select = new select("*","CAP_PER_PUBLISHER",array(array("CAP_PER_PUB_ID","=","$value[5]")),"","");
				
			$select->execute();
			
			$groName = $select->arrayResult[0]['CAP_PER_PUB_NAME'];
			
			if(!empty($check->arrayResult[0]['CAP_CON_MET_ID'])){
			
				$updateMeta = new update(array("CAP_CON_MET_CONTENT" => $groName),"CAP_CONTENT_METADATA",array(array("CAP_CON_MET_ID","=","$check->arrayResult[0]['CAP_CON_MET_ID']")),"","");
								
				$status .= $updateMeta->execute();	
								
			}else{
				
				$check -> column = "*";
			
				$check -> tableName = "CAP_CONTENT_METADATA";
				
				$check -> whereClause = array(array("FK_CAP_LAN_COM_ID","=","$value[0]"));
				
				$check -> whereID = "";
				
				$check->execute();
				
				$insert->column = array(
									"FK_CAP_CON_ID" => $check->arrayResult[0]['FK_CAP_CON_ID'],
									"CAP_CON_MET_HEADER" => "Penerbit Dokumen",
									"CAP_CON_MET_CONTENT" => $groName,
									"CAP_CON_MET_PATH" => $check->arrayResult[0]['CAP_CON_MET_PATH'],
									"FK_CAP_LAN_COM_ID" => $value[0]);
		
				$insert->tableName = "CAP_CONTENT_METADATA";
				
				$status .= $insert->execute();
				
				
			}
			
			
		
		
	}
	
	}
		
	public function classification($id){
		$select = new select("*","CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
",array(array("CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID","=","$id")),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function publisherID($id){
		$select = new select("*","CAP_PER_PUB_LAN_COM LEFT JOIN CAP_PER_PUBLISHER ON CAP_PER_PUBLISHER.CAP_PER_PUB_ID = CAP_PER_PUB_LAN_COM.FK_PER_PUB_ID",array(array("CAP_PER_PUB_LAN_COM.FK_LAN_COM_ID","=","$id")),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	
	public function getKlasifikasiRecursiveChild($id){
		
	
	$selectChild = new select("*","CAP_KLASIFIKASI",array(array("CAP_KLA_PARENT","=","$id")),"","");
	
	$selectChild->execute();
	
	if(!empty($selectChild->arrayResult)){
		foreach($selectChild->arrayResult as $key => $value){
			$array [] = $value['CAP_KLA_ID'];
			
			$child  = self::getKlasifikasiRecursiveChild($value['CAP_KLA_ID']);
			
			if(!empty($child)){
			
				if(is_array($child)){
					foreach($child as $keys => $values){
						$array [] =$values;
					}
				}else{
				$array [] = $child;
				}
			}
			
			
			unset($child);
		
		}
		
		return $array;
	}
	
	
	
	}
	
	
	
	
	
	
	public function klasifikasi_search() {
		
		if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null' || !empty($this->data[0]['text'])) {
			$searchQuery .= " WHERE ";
		}
		
		if (!empty($this->data[0]['klasifikasi'])) {
			$searchQuery .= " CAP_KLA_ID = ".$this->data[0]['klasifikasi']." ";
			$searchQuery .= " OR CAST(CAP_KLA_PARENT AS INTEGER) IN (".$this->data[0]['klasifikasi'];
			
			
			$array = self::getKlasifikasiRecursiveChild($this->data[0]['klasifikasi']);
			
			
			
			if(!empty($array)){
			
			$count = count($array);
			$i = 1;
			
			//print_r($array);
				foreach($array as $key => $value){
				
					if($i <= $count){
						
					$searchQuery .= ",";
						
					}
					$searchQuery .= $value;
					
				}
			}
			
			$searchQuery .= ")";
		}

		if (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') {
		
			if (!empty($this->data[0]['klasifikasi'])) {
				$searchQuery .= " AND ";
			}
			
		$i = 1;
		$c = count($this->data[0]['tag']);		
		
			foreach ($this->data[0]['tag'] as $value) {
				
			$tagID .= " FK_TAG_ID = ".str_replace("'","''",$value);
			
				if ($i < $c) {
					
					$tagID .= " OR ";
					
				}
				
			$i++;
			
			}		
		
		$searchQuery .=  "(".$tagID.")";
			
		}
		
		if (!empty($this->data[0]['text'])) {
		
			if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag'])  && $this->data[0]['tag'] != 'null') {
				$searchQuery .= " AND ";
			}
			
			
			
			
			$searchQuery .= " LOWER(CAP_CONTENT_METADATA.CAP_CON_MET_HEADER) = LOWER('".str_replace("'","''",$this->data[0]['metadata'])."') AND LOWER(CAP_CONTENT_METADATA.CAP_CON_MET_CONTENT) LIKE LOWER('%".str_replace("'","''",$this->data[0]['text'])."%')";
		}
		
		if (!empty($this->data[0]['klasifikasi']) || (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') || !empty($this->data[0]['text'])) {
		
		
		
		$select = new select(

		"DISTINCT CAP_LAN_COM_ID",
		"CAP_LANGUAGE_COMBINE
		LEFT JOIN CAP_TAG_KEY ON CAP_TAG_KEY.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
		LEFT JOIN CAP_CONTENT_METADATA ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_CONTENT_METADATA.FK_CAP_LAN_COM_ID $searchQuery",
		"",
		"",
		"","");
		
		}
		else {
				
		$select = new select("*","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID",
								array(array("CAP_LAN_COM_COLUMN","=","file"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","video"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","image"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","audio")),"","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED DESC","100");
		
		}
		
		$select->execute();
		//echo $select->query;
		//print_r($select->arrayResult);
		
		if (!empty($select->arrayResult)) {
			
			$selectComplete = new select("*","","","","");
			
			foreach ($select->arrayResult as $key => $value) {
				
				$selectComplete->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID WHERE CAP_LAN_COM_ID = $value[CAP_LAN_COM_ID] AND (CAP_LAN_COM_COLUMN = 'audio'
OR CAP_LAN_COM_COLUMN = 'video'
OR CAP_LAN_COM_COLUMN = 'image'
OR CAP_LAN_COM_COLUMN = 'file')";
				
				$selectComplete->whereClause = "";
				
				$selectComplete->orderClause = "CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED";
				
				$selectComplete->execute();
				
				$newArray [] = $selectComplete->arrayResult[0];
			    
			    //print_r( $selectComplete->arrayResult[0]);
			    
			}
			
		}
		//print_r( $newArray);
		$select->arrayResult = $newArray;
		
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","CAP_CONTENT_METADATA","","","");
		$array = $select->arrayResult;
		$i = 0;
		
			if (!empty($select->arrayResult)) {
		
				foreach ($select->arrayResult as $key => $value) {
					
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
					
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->whereID = "";
					
					$selectTag->execute();
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
			
			}
			//print_r($array);
			
			if (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') {
			
				if (!empty($array)) {
					
				$countTag = count($this->data[0]['tag']);
					
					foreach ($array as $key => $value) {
					
						$count = count($value['TAGGING']);						
							
						$i = 0;
						
						if (!empty($value['TAGGING'])) {
					
							foreach ($value['TAGGING'] as $value3) {
								
								
								if (in_array($value3['FK_TAG_ID'],$this->data[0]['tag'])) {
									
									$i++;
									
								}
								
							}
						
						}
						
						if ($i >= $countTag) {
						
						$newArrayian [] = $value;
						
						}
						
					}
					
				$array = $newArrayian;
				
				}
							
			}	
		
		return $array;
		//print_r($array);
		
	}
	
	public function klasifikasi_order_search() {
		
		$select = new select("","","","","");
		
		$select2 = new select("*","CAP_LANGUAGE_COMBINE","","","");
		
		if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
		
			foreach ($_SESSION['LAYAN-LIBRARY-ORDER'] as $value) {
				
				$select2->whereClause = array(array("CAP_LAN_COM_ID","=","$value"));
				
				$select2->execute();

				$select->arrayResult[] = $select2->arrayResult[0];
				
			}
		
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","CAP_CONTENT_METADATA","","","");
		$array = $select->arrayResult;
		$i = 0;
		
			if (!empty($select->arrayResult)) {
		
				foreach ($select->arrayResult as $key => $value) {
					
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
			
			}
			
		}
		
		return $array;
		
	}
	
	public function klasifikasi_lib() {
		
		$select = new select("*","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID",
								array(array("CAP_LAN_COM_COLUMN","=","file"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","video"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","image"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","audio")),"","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED DESC","100");
		
		$select->execute();
		
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","","","","");
		
		$array = $select->arrayResult;
		
		$i = 0;
		
			if (!empty($select->arrayResult)) {
		
				foreach ($select->arrayResult as $key => $value) {
					
					$selectTag->tableName	= "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->tableName = "CAP_CONTENT_METADATA";
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
				//print_r($selectTag);
					
			//print_r($selectTag->tableName);
			}
		
		return $array;
		
	}
	public function klasifikasi_lib_user() {
	$userID = $this->getUserID();
		
		$select = new select("*","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID",
		array(array("CAP_USER_CAP_USE_ID","=",$userID),array("CAP_LAN_COM_COLUMN","=","file"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","video"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","image"),array("","OR",""),array("CAP_LAN_COM_COLUMN","=","audio")),"","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED DESC","100");
		
		$select->execute();
		
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","CAP_CONTENT_METADATA","","","");
		
		$i = 0;
		
		$array = $select->arrayResult;
		
			if (!empty($select->arrayResult)) {
		
				foreach ($select->arrayResult as $key => $value) {
					
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
			
			}
		
		return $array;
		
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
	
	public function publisher(){
		
		$select = new select("*","CAP_PER_PUBLISHER",array(array("CAP_PER_PUB_PARENT","","IS NULL")),"","");
		
		$select->execute();
		
		$result = $select->arrayResult;
		
		if(!empty($result)){
		
			foreach($select->arrayResult as $value){
			
				$theChild = self::getPublisher($value['CAP_PER_PUB_ID'],$theChild);
				
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
		
								   "publisher" => $menuTree
								   
								   	);
								   	
		unset($menuTree);
		//print_r($completeMenuList);
		return $completeMenuList;		
		
	}
	public function getPublisher($parentID,&$menuTree){
		
		
		
		if(!empty($parentID)){
		
			$select = new select("*","CAP_PER_PUBLISHER",array(array("CAP_PER_PUB_PARENT","=","$parentID")),"","");
			
			$select->execute();
			
			if(!empty($select->arrayResult)){
				foreach($select->arrayResult as $keyItem=>$valueItem){
					$newID 		= $valueItem[CAP_PER_PUB_ID];
					$array []	= $valueItem;
					$name  		= $valueItem;
					$theChild 	= self::getPublisher($newID,$array[]);
					
					if(empty($theChild) && empty($theItem)){
					
						$menuTree [] = array("parent" => $valueItem);

						
					}else{

						$menuTree [] = array("parent" => $valueItem, "child" => $theChild);

					}
					unset($array);
					unset($theChild);
					unset($theItem);
				}
				
				
			}
			
		
		}
		return $menuTree;
		
		
	}

	public function grouping(){
		
		$select = new select("*","CAP_GROUPING",array(array("CAP_GRO_PARENT","","IS NULL")),"","");
		
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

			$select = new select("*","CAP_GROUPING LEFT JOIN CAP_GRO_LAN_COM
ON CAP_GROUPING.CAP_GRO_ID = CAP_GRO_LAN_COM.FK_GRO_ID
LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_GRO_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID",array(array("CAP_GROUPING.CAP_GRO_ID","=","$groupID")),"","");

			$select->execute();

			

				return $select->arrayResult;
				
				

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
					
					if(empty($theChild) && empty($theItem)){
					
						$menuTree [] = array("parent" => $valueItem);

						
					}else{

						$menuTree [] = array("parent" => $valueItem, "child" => $theChild);

					}
					unset($array);
					unset($theChild);
					unset($theItem);
				}
				
				
			}
			
		
		}
		return $menuTree;
		
		
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
	
	public function getKlas(){
		$select = new select("*","CAP_PER_KLAS","","","");
		$select->execute();
		
		return $select->arrayResult;
	}
	
	public function getKlaTipe($id){
		$select = new select("*","CAP_PER_KLA_TIPE",array(array("FK_PER_KLA_ID","=","$id")),"","");
		$select->execute();
		
		return $select->arrayResult;
	}
	
	public function getKlaName($id){
		$select = new select("*","CAP_PER_KLA_NAME",array(array("FK_PER_KLA_TIP_ID","=","$id")),"","");
		$select->execute();
		
		return $select->arrayResult;
	}
	
	public function insertSubKlasifikasi($data,$del){
	
		
			
		$delete = new delete("","","","","");
		
		$insert = new insert("","","","","");
		
		$update = new update("","","","","");
		
		$select = new select("","","","","");

		$userID = $this->getUserID();

		$userName = $this->getUserName();
		
		$deletedID = array();

		$klaNameArray = array();
		
		$whereArray = array();
		
		if(!empty($del) || $del != ""){
			$delete = new delete("","","","","");
			
				$delete->tableName = "CAP_KLASIFIKASI";
			
			foreach($del as $key => $value){
				
					$select->column = "CAP_KLA_NAME";

					$select->tableName = "CAP_KLASIFIKASI";

					$select->whereClause = array(array("CAP_KLA_ID","=","$value"));

					$select->whereID = "";

					$select->execute();

					$klaName = $select->arrayResult[0]['CAP_KLA_NAME'];

					array_push($klaNameArray, $klaName);


				$delete->whereClause .=  " CAP_KLA_ID = ".$value." OR";	
				


				array_push($deletedID,$value);								
			}
			
			$delete->whereClause=substr($delete->whereClause,0,-2);
			
			$status = $delete->deleteRowMultipleWhere();
			
			if($status == false){
				
			
				echo "Unexpected error was occured!! [on delete item] \n";
				
				
			}else{

				

				$i=0;

				foreach ($deletedID as $key => $value) {
					
					$klaName = $klaNameArray[$i];

					$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS KLASIFIKASI ".$klaName." DARI DAFTAR KLASIFIKASI","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
					$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

					$insertHis->execute();

					$i++;

				}
				
			}
			
			
			
		}
		
		if(!empty($data)){
		
			$getID = array();
			
			foreach($data as $key => $value){
												
				$id = explode('-',$value[0]);
				
				$id=strtolower($id[0]);
										
				if($id=='insert'){
					
					if(is_array($getID)){
						
						if(in_array($value[1],$getID)){
						
							$parentID = array_search($value[1],$getID);
							
						}else{
						
							$parentID = $value[1];
							
						}
					
					}else{
					
							$parentID = $value[1];
															
					}
													
					$insert -> tableName = "CAP_KLASIFIKASI";
					
					$insert -> column = array(
					
								"CAP_KLA_NAME" => $value[2],
								
								"CAP_KLA_NOTE" => $value[3],

								"CAP_KLA_CODE" => $value[4],
								
								"CAP_KLA_PARENT" => $parentID
								
						) ;
						
					$insert -> whereClause = "CAP_KLA_ID";
					
					$lastID    = $insert->execute();
															
					$getID[$lastID] = $value[0];
					
					if(empty($lastID)){
						echo "Unexpected error was occured!! [ at item with value \"".$value[2]."\"] \n";
					}else{
						

						$insertHis = new insert(array("CAP_PER_HIS_EVENT" => "".$userName." MENAMBAHKAN KLASIFIKASI ".$value[2]." DENGAN KODE ".$value[4]." KE DALAM DAFTAR KLASIFIKASINYA","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
						$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

						$insertHis->execute();

					}
					
				}else{
					
					$text=$value[2];
						
					$note=$value[3];

					$kode = $value[4];
					
					if(!empty($value[1])){
					
						$parent=intval($value[1]);
					
					}else{
						
						$parent="";
						
					}
					
					if(!empty($id)){
						
						if(in_array($parent,$deletedID)){
							$parent=null;
						}

						$select->column = "*";

						$select->tableName = "CAP_KLASIFIKASI";

						$select->whereClause = array(array("CAP_KLA_ID","=","$id"));

						$select->whereID = "";

						$select->execute();

						$klaName = $select->arrayResult[0]['CAP_KLA_NAME'];

						$klaNote = $select->arrayResult[0]['CAP_KLA_NOTE'];
						
						$klaKode = $select->arrayResult[0]['CAP_KLA_CODE'];
						
						if($klaName != $text || $note != $klaNote || $klaKode != $kode || $parent != null){

							$update->tableName = "CAP_KLASIFIKASI";
							
																												
							$update->column = array(
									
									"CAP_KLA_NAME"=>$text,
									
									"CAP_KLA_NOTE"=>$note,

									"CAP_KLA_CODE"=>$kode,
									
									"CAP_KLA_PARENT"=>$parent
									
							 	);
							
							$update	-> whereClause = array(array("CAP_KLA_ID","=","$id"));
							
							$update -> whereID = "";
							
							
								
							if($update -> execute() == false){
								
								echo "Unexpected error was occured!! [ at item with id \"".$id."\"] \n";
							
							}else{
								/*$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGUBAH KLASIFIKASI ".$klaName." DENGAN KODE ".$kode." MENJADI KLASIFIKASI ".$text." DENGAN KETERANGAN ".$note."","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
								$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

								$insertHis->execute();*/

							}
							
						}
					}
							
				}
					
			}
				
		}
				
	}
	
	
	public function insertSubPublisher($data,$del){
	
		
			
		$delete = new delete("","","","","");
		
		$insert = new insert("","","","","");
		
		$update = new update("","","","","");
		
		$select = new select("","","","","");

		$userID = $this->getUserID();

		$userName = $this->getUserName();
		
		$deletedID = array();

		$klaNameArray = array();
		
		$whereArray = array();
						
		if(!empty($del) || $del != ""){
			$delete = new delete("","","","","");
			
				$delete->tableName = "CAP_PER_PUBLISHER";
			
			foreach($del as $key => $value){
				
					$select->column = "CAP_PER_PUB_NAME";

					$select->tableName = "CAP_PER_PUBLISHER";

					$select->whereClause = array(array("CAP_PER_PUB_ID","=","$value"));

					$select->whereID = "";

					$select->execute();

					$klaName = $select->arrayResult[0]['CAP_PER_PUB_NAME'];

					array_push($klaNameArray, $klaName);


				$delete->whereClause .=  " CAP_PER_PUB_ID = ".$value." OR";	
				


				array_push($deletedID,$value);								
			}
			
			$delete->whereClause=substr($delete->whereClause,0,-2);
			
			$status = $delete->deleteRowMultipleWhere();
			
			if($status == false){
				
			
				echo "Unexpected error was occured!! [on delete item] \n";
				
				
			}else{

				

				$i=0;

				foreach ($deletedID as $key => $value) {
					
					$klaName = $klaNameArray[$i];

					$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS PUBLISHER ".$klaName." DARI DAFTAR PUBLISHER","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
					$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

					$insertHis->execute();

					$i++;

				}
				
			}
			
			
			
		}
		
		if(!empty($data)){
		
			$getID = array();
			
			foreach($data as $key => $value){
												
				$id = explode('-',$value[0]);
				
				$id=strtolower($id[0]);
										
				if($id=='insert'){
					
					if(is_array($getID)){
						
						if(in_array($value[1],$getID)){
						
							$parentID = array_search($value[1],$getID);
							
						}else{
						
							$parentID = $value[1];
							
						}
					
					}else{
					
							$parentID = $value[1];
															
					}
													
					$insert -> tableName = "CAP_PER_PUBLISHER";
					
					$insert -> column = array(
					
								"CAP_PER_PUB_NAME" => $value[2],

								"CAP_PER_PUB_CODE" => $value[3],
								
								"CAP_PER_PUB_PARENT" => $parentID
								
						) ;
						
					$insert -> whereClause = "CAP_PER_PUB_ID";
					
					$lastID    = $insert->execute();
															
					$getID[$lastID] = $value[0];
					
					if(empty($lastID)){
						echo "Unexpected error was occured!! [ at item with value \"".$value[2]."\"] \n";
					}else{
						

						$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENAMBAHKAN PUBLISHER ".$value[2]." DENGAN KODE ".$value[3]." KE DALAM DAFTAR PUBLISHERNYA","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
						$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

						$insertHis->execute();

					}
					
				}else{
					
					$text=$value[2];
						
					$kode = $value[3];
					
					if(!empty($value[1])){
					
						$parent=intval($value[1]);
					
					}else{
						
						$parent="";
						
					}
					
					if(!empty($id)){
						
						if(in_array($parent,$deletedID)){
							$parent=null;
						}

						$select->column = "*";

						$select->tableName = "CAP_PER_PUBLISHER";

						$select->whereClause = array(array("CAP_PER_PUB_ID","=","$id"));

						$select->whereID = "";

						$select->execute();

						$klaName = $select->arrayResult[0]['CAP_PER_PUB_NAME'];
						
						$klaKode = $select->arrayResult[0]['CAP_PER_PUB_CODE'];
						
						if($klaName != $text || $note != $klaNote || $klaKode != $kode || $parent != null){

							$update->tableName = "CAP_PER_PUBLISHER";
							
																												
							$update->column = array(
									
									"CAP_PER_PUB_NAME"=>$text,
									
									"CAP_PER_PUB_CODE"=>$kode,
									
									"CAP_PER_PUB_PARENT"=>$parent
									
							 	);
							
							$update	-> whereClause = array(array("CAP_PER_PUB_ID","=","$id"));
							
							$update -> whereID = "";
							
							
								
							if($update -> execute() == false){
								
								echo "Unexpected error was occured!! [ at item with id \"".$id."\"] \n";
							
							}else{
								$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGUBAH DATA PUBLISHER ".$klaName." DENGAN KODE ".$kode." ","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
								$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

								$insertHis->execute();

							}
							
						}
					}
							
				}
					
			}
				
		}
				
	}
	
	public function insertSubGrouping($data,$del){
	
		$delete = new delete("","","","","");
		
		$insert = new insert("","","","","");
		
		$update = new update("","","","","");
		
		$select = new select("","","","","");

		$userID = $this->getUserID();

		$userName = $this->getUserName();
		
		$deletedID = array();

		$klaNameArray = array();
		
		$whereArray = array();
						
		if(!empty($del) || $del != ""){
			
			$delete = new delete("","","","","");
			
				$delete->tableName = "CAP_GROUPING";
			
			foreach($del as $key => $value){
				
					$select->column = "CAP_GRO_NAME";

					$select->tableName = "CAP_GROUPING";

					$select->whereClause = array(array("CAP_GRO_ID","=","$value"));

					$select->whereID = "";

					$select->execute();

					$klaName = $select->arrayResult[0]['CAP_GRO_NAME'];

					array_push($klaNameArray, $klaName);

				$delete->whereClause .=  " CAP_GRO_ID = ".$value." OR";	
				
				array_push($deletedID,$value);								
			}
			
			$delete->whereClause=substr($delete->whereClause,0,-2);
			
			$status = $delete->deleteRowMultipleWhere();
									
			if($status == FALSE){
							
				echo "Unexpected error was occured!! [on delete item] \n";
								
			}else{

				

				$i=0;

				foreach ($deletedID as $key => $value) {
					
					$klaName = $klaNameArray[$i];

					$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGHAPUS GROUP ".$klaName." DARI DAFTAR GROUP","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
					$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

					$insertHis->execute();

					$i++;

				}
				
			}
			
			
			
		}
		
		if(!empty($data)){
		
			$getID = array();
			
			foreach($data as $key => $value){
												
				$id = explode('-',$value[0]);
				
				$id=strtolower($id[0]);
										
				if($id=='insert'){
					
					if(is_array($getID)){
						
						if(in_array($value[1],$getID)){
						
							$parentID = array_search($value[1],$getID);
							
						}else{
						
							$parentID = $value[1];
							
						}
					
					}else{
					
							$parentID = $value[1];
															
					}
													
					$insert -> tableName = "CAP_GROUPING";
					
					$insert -> column = array(
					
								"CAP_GRO_NAME" => $value[2],

								"CAP_GRO_NOTE" => $value[3],
								
								"CAP_GRO_PARENT" => $parentID
								
						) ;
						
					$insert -> whereClause = "CAP_GRO_ID";
					
					$lastID    = $insert->execute();
															
					$getID[$lastID] = $value[0];
					
					if(empty($lastID)){
						echo "Unexpected error was occured!! [ at item with value \"".$value[2]."\"] \n";
					}else{
						

						$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENAMBAHKAN GROUP ".$value[2]." KE DALAM DAFTAR GROUPNYA","FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
						$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

						$insertHis->execute();

					}
					
				}else{
					
					$text=$value[2];
						
					$kode = $value[3];
					
					if(!empty($value[1])){
					
						$parent=intval($value[1]);
					
					}else{
						
						$parent="";
						
					}
					
					if(!empty($id)){
						
						if(in_array($parent,$deletedID)){
							$parent=null;
						}

						$select->column = "*";

						$select->tableName = "CAP_GROUPING";

						$select->whereClause = array(array("CAP_GRO_ID","=","$id"));

						$select->whereID = "";

						$select->execute();

						$klaName = $select->arrayResult[0]['CAP_GRO_NAME'];
						
						$klaKode = $select->arrayResult[0]['CAP_GRO_NOTE'];
						
						if($klaName != $text || $note != $klaNote || $klaKode != $kode || $parent != null){

							$update->tableName = "CAP_GROUPING";
							
																												
							$update->column = array(
									
									"CAP_GRO_NAME"=>$text,
									
									"CAP_GRO_NOTE"=>$kode,
									
									"CAP_GRO_PARENT"=>$parent
									
							 	);
							
							$update	-> whereClause = array(array("CAP_GRO_ID","=","$id"));
							
							$update -> whereID = "";
							
							
								
							if($update -> execute() == false){
								
								echo "Unexpected error was occured!! [ at item with id \"".$id."\"] \n";
							
							}else{
								$insertHis = new insert(array("CAP_PER_HIS_EVENT" => $userName." MENGUBAH DATA GROUP ".$klaName,"FK_USE_ID"=>$userID,"CAP_PER_HIS_DATE" =>  date("Y-m-d H:i:s")),"CAP_PER_HISTORY","","","");
					
								$insertHis->dateColumn = array("CAP_PER_HIS_DATE");

								$insertHis->execute();

							}
							
						}
					}
							
				}
					
			}
				
		}
				
	}
	
	
	public static function saveTagging($id) {
	
		$fkid=$id[0][1];
		
		//print_r($fkid);
		
		$insert = new insert("","","","","");
		
		$update = new update("","","","","");
		
		$select = new select("","","","","");
		
		$delete = new delete("","","","","");
	
	
		if (!empty($id) && $id !== "" && !empty($fkid) && $fkid!=="") {
			//print_r($id);
			$id=explode(",",$id[0][0]);
			
			
			$delete->tableName="CAP_TAG_KEY";
				
			$delete->whereClause=array(array("FK_LAN_COM_ID","=","$fkid"));
				
			$delete->whereID="";
				
			$delete->execute();
			//print_r($id);
			
			foreach ($id as $key => $value) {
				
				
				
				$value=trim($value," ");
				
				$value=str_replace(" ","",$value);
				
				$value = strtolower($value);
				
				//$value = array_filter(array_map('trim', $value));
				
				if($value != " " || $value != ""){
				
					$select->column    = "COUNT(*) AS COUNT";
					
					$select->tableName = "CAP_TAG";
					
					$select->whereClause = array(array("CAP_TAG_VALUE","=","$value"));
					
					$select->whereID = "";
					
					$select->execute();
					
					$result = $select->arrayResult; 
					
					
					
					$count = $result[0]['COUNT'];
					
					$select->column    = "*";
					
					$select->tableName = "CAP_TAG";
					
					$select->whereClause = array(array("CAP_TAG_VALUE","=","$value"));
					
					$select->whereID = "";
					
					$select->limitClause = "1";
					
					$select->execute();
					
					//print_r( $select);
					
					$result = $select->arrayResult; 
					
					if($result != "" && !empty($result) && $count != 0){
			
						foreach($result as $key=>$values){
							//echo $value['CAP_TAG_ID'];
							$insert->tableName = "CAP_TAG_KEY";
							
							$insert->column = array("FK_LAN_COM_ID"=>$fkid, "FK_TAG_ID"=>$values['CAP_TAG_ID']);
							
							$insert->execute();
							
						}
					}
					
					else{
					
					$insert->tableName = "CAP_TAG";
					
					$insert->column = array(
					
							"CAP_TAG_VALUE" => $value

						);
						
					$insert->whereClause = "";
						
					$lastID = $insert->execute();
						
						if(!empty($lastID)){
					
							$insert->tableName = "CAP_TAG_KEY";
							
							$insert->column = array("FK_LAN_COM_ID"=>$fkid, "FK_TAG_ID"=>$lastID);
							
							$insert->whereClause = "";
							
							$insert->execute();
				
						}
				
				}
				
				}
			}
		
		}
		elseif(isset($id) && $id=="" && !empty($fkid) && $fkid!==""){
			$delete->tableName="CAP_TAG_KEY";
				
			$delete->whereClause= array(array("CAP_TAG_KEY.FK_LAN_COM_ID","=","$fkid"));
				
			$delete->whereID="";
				
			$delete->execute();
		}
	
	}
		
	public function tagging($id){
		$select = new select("*","CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG.CAP_TAG_ID = CAP_TAG_KEY.FK_TAG_ID ",array(array("CAP_TAG_KEY.FK_LAN_COM_ID","=","$id")),"","","");
		
		$select->execute();
		
		
		return $select->arrayResult;
	}
	
	public function getDataCountUser($table,$whereClause){
	
		if(!empty($whereClause)){
			$whereClause = " WHERE ".$whereClause;
		}
	$userID = $this->getUserID();
		
		$select = new select("COUNT(*) as total","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID".$whereClause." AND CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID'","","","");
		
		$select->execute();
		
		return $select->arrayResult[0]['TOTAL'];
	}
	
	public function getDataCount($table,$whereClause){
	
		if(!empty($whereClause)){
			$whereClause = " WHERE ".$whereClause;
		}
		
		$select = new select("COUNT(*) as total","CAP_LANGUAGE_COMBINE".$whereClause,"","","");
		
		$select->execute();
		
		return $select->arrayResult[0]['TOTAL'];
	}
	
	public function searchOnTheFly($data){
	
	if($data=="" || empty($data)){
		return null;	
	}else{
		
		$data=strtoupper($data);
		
		$explode = explode(":",$data);
	
	
	$explodeFirst=strtoupper($explode[0]);
	
	if(count($explode) > 1){
		$eexplode = explode(" ",$explode[1]);
	}else{
		$eexplode = explode(" ",$$data);
	}
	
	if($explodeFirst == "tagging" ){
	
	    if(count($eexplode) >= 1){
	    	foreach($eexplode as $value){
		    $loop .=" upper(CAP_TAG.CAP_TAG_VALUE) LIKE '%".$value."%' OR";
		    }
	    }
	    else{
		    $loop .="upper(CAP_TAG.CAP_TAG_VALUE) LIKE '%".$explode[1]."%' OR";
	    }
	    
		$loop = substr($loop,0,-2);
		$select = new select("*","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_TAG_KEY ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = FK_LAN_COM_ID
LEFT JOIN CAP_TAG ON CAP_TAG.CAP_TAG_ID = CAP_TAG_KEY.FK_TAG_ID

WHERE (CAP_LAN_COM_COLUMN = 'file' OR CAP_LAN_COM_COLUMN = 'image' OR CAP_LAN_COM_COLUMN = 'video' OR CAP_LAN_COM_COLUMN = 'audio') 
AND (".$loop.")","","","","200");
		
		$select->execute();
	}
	else{
	
	  if(count($eexplode) > 1){
	    	foreach($eexplode as $value){
		    $loop .=" upper(CAP_PER_KLA_NAME.CAP_PER_KLA_NAM_NAME) LIKE '%".$value."%' OR upper(CAP_CONTENT_METADATA.CAP_CON_MET_HEADER) LIKE '%".$value."%' OR upper(CAP_CONTENT_METADATA.CAP_CON_MET_CONTENT) LIKE '%".$value."%' OR";
		    }
	    }
	    else{
		    $loop .="upper(CAP_PER_KLA_NAME.CAP_PER_KLA_NAM_NAME) LIKE '%".$data."%' OR upper(CAP_CONTENT_METADATA.CAP_CON_MET_HEADER) LIKE '%".$data."%' OR upper(CAP_CONTENT_METADATA.CAP_CON_MET_CONTENT) LIKE '%".$data."%' OR";
	    }
	    
		$loop = substr($loop,0,-2);
	
		$select = new select("*","CAP_LANGUAGE_COMBINE FULL JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID
LEFT JOIN CAP_PER_KLA_NAME ON CAP_PER_KLA_NAME.CAP_PER_KLA_NAM_ID = CAP_PER_MT_KLA_LAN_COM.FK_PER_KLA_NAM_ID
LEFT JOIN CAP_PER_KLA_TIPE ON CAP_PER_KLA_TIPE.CAP_PER_KLA_TIP_ID = CAP_PER_KLA_NAME.FK_PER_KLA_TIP_ID
LEFT JOIN CAP_PER_KLAS ON CAP_PER_KLAS.CAP_PER_KLA_ID = CAP_PER_KLA_TIPE.FK_PER_KLA_ID
LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
LEFT JOIN CAP_CONTENT_METADATA ON CAP_CONTENT_METADATA.FK_CAP_CON_ID = CAP_CONTENT.CAP_CON_ID

WHERE (CAP_LAN_COM_COLUMN = 'file' OR CAP_LAN_COM_COLUMN = 'image' OR CAP_LAN_COM_COLUMN = 'video' OR CAP_LAN_COM_COLUMN = 'audio') 
AND (".$loop.")","","","","200");
		
		$select->execute();
		
	}
		//print_r($select->query);
		return $select->arrayResult;
		
	}
	}

	public function getCombineListIP($id){

		$select = new select("","","","","");

		$select->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_PER_MT_KLA_LAN_COM
								ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID
								LEFT JOIN CAP_KLASIFIKASI ON 
								CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
								WHERE CAP_LANGUAGE_COMBINE.CAP_LAN_COM_COLUMN ='image' OR
									CAP_LANGUAGE_COMBINE.CAP_LAN_COM_COLUMN = 'audio' OR
									CAP_LANGUAGE_COMBINE.CAP_LAN_COM_COLUMN = 'file' OR
									CAP_LANGUAGE_COMBINE.CAP_LAN_COM_COLUMN = 'video' AND
									CAP_KLASIFIKASI = '".$id."'
									";

		$select->column = "*";

		$select->execute();

	}

	public function getDadoHistory($user = false, $range = null, $from = null, $until = null){

		$selectDate = new select("","","","","");

		$selectHistory = new select("","","","","");

		if($user != false){

			$user = $this->getUserID();

			$user = "FK_USE_ID = '$user' AND ";
			

		}else{

			
			$user = "";

		}

		if($range != null){

			$range = "CAP_PER_HIS_DATE >= NOW()-'$range day'::INTERVAL";

		}else{

			$range = "CAP_PER_HIS_DATE >= NOW()-'7 day'::INTERVAL";

		}

		$selectDate->tableName = "CAP_PER_HISTORY WHERE ".$user.$range." GROUP BY TO_CHAR(CAP_PER_HIS_DATE, 'YYYY-MM-DD') ORDER BY TO_CHAR(CAP_PER_HIS_DATE, 'YYYY-MM-DD') DESC";

		$selectDate->column = "TO_CHAR(CAP_PER_HIS_DATE, 'YYYY-MM-DD') AS DATETIME,COUNT(*)";

		$selectDate->execute();

		$selectHistory->tableName = "CAP_PER_HISTORY WHERE  ".$user.$range." ORDER BY CAP_PER_HIS_DATE DESC";

		$selectHistory->column = "TO_CHAR(CAP_PER_HIS_DATE, 'YYYY-MM-DD HH24:MI:SS') AS DATETIME, TO_CHAR(CAP_PER_HIS_DATE, 'YYYY-MM-DD') AS GROUPING, CAP_PER_HIS_EVENT, FK_USE_ID";

		$selectHistory->execute();

		if (!empty($selectDate->arrayResult)) {

			foreach ($selectDate->arrayResult as $key => $value) {

				$dateGroup = $value['DATETIME'];

				foreach ($selectHistory->arrayResult as $key2 => $value2) {

					if ($value['DATETIME'] == $value2['GROUPING']) {

					$dateValue [] = array("DATETIME" => $value2['DATETIME'], "CAP_PER_HIS_EVENT" => $value2['CAP_PER_HIS_EVENT'], "FK_USE_ID" => $value2['FK_USE_ID']);

					}

				}

			$finalGroup [] = array("DATE" => $dateGroup, "VALUE" => $dateValue);

			unset($dateValue);

			}

		}

		return $finalGroup;

	}

	public function getDadoStats($timeFrom = null, $timeUntil = null, $typeOfDate = null, $yearY = null){

		$type = array('file','image','audio','video');
			
			if(!empty($timeFrom) && !empty($timeUntil) && empty($yearY)){
			
			$file = self::countDado('file',$timeFrom , $timeUntil , $typeOfDate );

			$gambar = self::countDado('image',$timeFrom , $timeUntil , $typeOfDate );

			$audio = self::countDado('audio',$timeFrom , $timeUntil , $typeOfDate );

			$video = self::countDado('video',$timeFrom , $timeUntil , $typeOfDate );

			$content = self::countDadoContent('content',$timeFrom , $timeUntil , $typeOfDate );
			}elseif(!empty($yearY)){
				
				$year = $timeFrom;
				
				$years = self::countInYear($year);
				
				$file = self::countDadoYear('file',$year );

				$gambar = self::countDadoYear('image',$year );
	
				$audio = self::countDadoYear('audio',$year );
	
				$video = self::countDadoYear('video',$year );
	
				$content = self::countDadoYearContent('content',$year );
			}
			$returnArray [] = array('year' => $years, 'file' => $file, 'image' => $gambar,'audio' => $audio,'video' => $video,'content' => $content);

		return $returnArray;

	}

	public function countDado($type, $timeFrom = null, $timeUntil = null,$typeOfDate = null){

			if(!empty($typeOfDate)){
				switch ($typeOfDate) {
					
					default:
						$dateParam = "YYYY-MM-DD";

						break;
				}
			}else{
				$dateParam = "YYYY-MM-DD";
			}

			if($timeFrom == null && $timeUntil == null){
				$timeFrom 	= strtotime(date('Y-m-d'))-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d');
			}elseif($timeFrom == null && $timeUntil != null){
				$timeFrom 	= strtotime($timeUntil)-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}elseif($timeFrom != null && $timeUntil == null){
				$timeUntil 	= strtotime($timeFrom)+604800;
				$timeUntil 	= date('Y-m-d', $timeUntil);
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
			}else{
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}

			$select = new select("TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LANGUAGE_COMBINE 
						WHERE CAP_LAN_COM_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAN_COM_DATECREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59'  AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();

			$result =  $select->arrayResult;
			//echo $select->query;
			return $result;

	}

	public function countDadoContent($type, $timeFrom = null, $timeUntil = null,$typeOfDate = null){

			if(!empty($typeOfDate)){
				switch ($typeOfDate) {
					case 'month':
						$dateParam = "MONTH YYYY";
						if(!empty($timeFrom) && !empty($timeUntil)){
							echo $timeFrom 	= date('Y-m-d H:i:s', strtotime('1 ' .$timeFrom . ' 00:00:00'));
							echo $timeUntil 	= date('Y-m-d H:i:s', strtotime('-1 second',strtotime('' .$timeUntil . ' 00:00:00')));

						}else{
							$timeFrom = null;
							$timeUntil = null;
						}
						break;

					case 'year':
						$dateParam = "YYYY";

						break;
					
					default:
						$dateParam = "YYYY-MM-DD";

						break;
				}
			}else{
				$dateParam = "YYYY-MM-DD";
			}

			if($timeFrom == null && $timeUntil == null){
				$timeFrom 	= strtotime(date('Y-m-d'))-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d');
			}elseif($timeFrom == null && $timeUntil != null){
				$timeFrom 	= strtotime($timeUntil)-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}elseif($timeFrom != null && $timeUntil == null){
				$timeUntil 	= strtotime($timeFrom)+604800;
				$timeUntil 	= date('Y-m-d', $timeUntil);
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
			}else{
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}

			$select = new select("TO_CHAR(CAP_CON_CREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						WHERE CAP_CON_CREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_CON_CREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59'  AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') DESC","","","");

			$select->execute();

			$result =  $select->arrayResult;
			//echo $select->query;
			return $result;

	}
	public function countInYear($timeFrom){
			
			for($i=1; $i<=12; $i++){
				if($i<10){
					$i = '0'.$i;
				}
				
				$bulitArray [] = $i.'/'.$timeFrom;
				
			}
			
			
			
			//echo $select->query;
			return $bulitArray;

	}
	public function countDadoYear($type, $timeFrom){
			
			$select = new select("","","","","");
			
			$year = $timeFrom;
			
			$dateRange = array(0,1,2,3,4,5,6,7,8,9,10,11);
			
			foreach ($dateRange as $key => $value) {
				
				$i = $value;
					
				$a = $i +1 ;	
				
				if($a < 10 ){
					$a = '0'.$a;
				}
				
				$dateTime = $year."-".$a;
				
				$dateParam = 'YYYY-MM';
				$timeFrom = date('Y-m-d', strtotime($year.'/'.$a.'/01' ));
				$timeUntil = date('Y-m-d', strtotime($timeFrom ." +1 month -1 days"))."";
				
				if($j<10){
					$j = '0'.$j;
				}
				
				$select->column = "TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(CAP_LAN_COM_ID) AS COUNT";
				
				$select->tableName = "CAP_LANGUAGE_COMBINE 
						WHERE CAP_LAN_COM_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAN_COM_DATECREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59'
						AND CAP_LAN_COM_COLUMN = '" . $type . "' 
						GROUP BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') DESC";

				$select->execute();

				$result =  $select->arrayResult;
				
				$bulitArray [] = array("MONTH"=>$dateTime, "COUNT"=>$result[0]['COUNT']);
				
			}
			//print_r($bulitArray);
			//echo $select->query;
			return $bulitArray;

	}

	public function countDadoYearContent($type, $timeFrom ){
			
			$select = new select("","","","","");
			
			$year = $timeFrom;
			
			$dateRange = array(0,1,2,3,4,5,6,7,8,9,10,11);
			
			foreach ($dateRange as $key => $value) {
				
				$i = $value;
					
				$a = $i +1 ;	
				
				if($a < 10 ){
					$a = '0'.$a;
				}
				
				$dateTime = $year."-".$a;
				
				$dateParam = 'YYYY-MM';
				$timeFrom = date('Y-m-d', strtotime($year.'/'.$a.'/01' ));
				$timeUntil = date('Y-m-d', strtotime($timeFrom ." +1 month -1 days"))."";
				
				if($j<10){
					$j = '0'.$j;
				}
				
				$select->column = "TO_CHAR(CAP_CON_CREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT";
				
				$select->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						WHERE CAP_CON_CREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_CON_CREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59'  AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') DESC";

				$select->execute();

				$result =  $select->arrayResult;
				
				$bulitArray [] = array("MONTH"=>$dateTime, "COUNT"=>$result[0]['COUNT']);
				
			}
			//print_r($bulitArray);
			//echo $select->query;
			return $bulitArray;
			
	}

	public function getDadoUserStats($timeFrom = null, $timeUntil = null, $typeOfDate = null, $yearY = null){

		$type = array('file','image','audio','video');
		
			if(!empty($timeFrom) && !empty($timeUntil) && empty($yearY)){
			
			$file = self::countDadoUser('file',$timeFrom , $timeUntil , $typeOfDate );

			$gambar = self::countDadoUser('image',$timeFrom , $timeUntil , $typeOfDate );

			$audio = self::countDadoUser('audio',$timeFrom , $timeUntil , $typeOfDate );

			$video = self::countDadoUser('video',$timeFrom , $timeUntil , $typeOfDate );

			$content = self::countDadoUserContent('content',$timeFrom , $timeUntil , $typeOfDate );
			
			}elseif(!empty($yearY)){

				$year = $timeFrom;

				$years = self::countInYear($year);

				$file = self::countDadoUserYear('file',$year );

				$gambar = self::countDadoUserYear('image',$year );

				$audio = self::countDadoUserYear('audio',$year );

				$video = self::countDadoUserYear('video',$year );

				$content = self::countDadoUserYearContent('content',$year );

			}


			$returnArray [] = array('year'=>$years,'file' => $file, 'image' => $gambar,'audio' => $audio,'video' => $video,'content' => $content);

		return $returnArray;

	}

	public function countDadoUser($type, $timeFrom = null, $timeUntil = null,$typeOfDate = null){

			
			if(!empty($typeOfDate)){
				switch ($typeOfDate) {
					
					default:
						$dateParam = "YYYY-MM-DD";

						break;
				}
			}else{
				$dateParam = "YYYY-MM-DD";
			}

			if($timeFrom == null && $timeUntil == null){
				$timeFrom 	= strtotime(date('Y-m-d'))-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d');
			}elseif($timeFrom == null && $timeUntil != null){
				$timeFrom 	= strtotime($timeUntil)-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}elseif($timeFrom != null && $timeUntil == null){
				$timeUntil 	= strtotime($timeFrom)+604800;
				$timeUntil 	= date('Y-m-d', $timeUntil);
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
			}else{
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}
			$userID = model::getUserID();
			$select = new select("TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						WHERE CAP_LAN_COM_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAN_COM_DATECREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59' AND CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();

			$result =  $select->arrayResult;
			//echo $select->query;
			return $result;

	}

	public function countDadoUserContent($type, $timeFrom = null, $timeUntil = null,$typeOfDate = null){

			if(!empty($typeOfDate)){
				switch ($typeOfDate) {
					case 'month':
						$dateParam = "MONTH YYYY";
						if(!empty($timeFrom) && !empty($timeUntil)){
							echo $timeFrom 	= date('Y-m-d H:i:s', strtotime('1 ' .$timeFrom . ' 00:00:00'));
							echo $timeUntil 	= date('Y-m-d H:i:s', strtotime('-1 second',strtotime('1 ' .$timeUntil . ' 00:00:00')));

						}else{
							$timeFrom = null;
							$timeUntil = null;
						}
						break;

					case 'year':
						$dateParam = "YYYY";

						break;
					
					default:
						$dateParam = "YYYY-MM-DD";

						break;
				}
			}else{
				$dateParam = "YYYY-MM-DD";
			}

			if($timeFrom == null && $timeUntil == null){
				$timeFrom 	= strtotime(date('Y-m-d'))-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d');
			}elseif($timeFrom == null && $timeUntil != null){
				$timeFrom 	= strtotime($timeUntil)-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}elseif($timeFrom != null && $timeUntil == null){
				$timeUntil 	= strtotime($timeFrom)+604800;
				$timeUntil 	= date('Y-m-d', $timeUntil);
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
			}else{
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}
$userID = model::getUserID();
			$select = new select("TO_CHAR(CAP_CON_CREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						WHERE CAP_CON_CREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_CON_CREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59' AND CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') DESC","","","");

			$select->execute();

			$result =  $select->arrayResult;
			//echo $select->query;
			return $result;

	}
	
	public function countDadoUserYear($type, $timeFrom){
			
			$select = new select("","","","","");
			
			$year = $timeFrom;
			
			$dateRange = array(0,1,2,3,4,5,6,7,8,9,10,11);
			
			foreach ($dateRange as $key => $value) {
				
				$i = $value;
					
				$a = $i +1 ;	
				
				if($a < 10 ){
					$a = '0'.$a;
				}
				
				$dateTime = $year."-".$a;
				
				$dateParam = 'YYYY-MM';
				$timeFrom = date('Y-m-d', strtotime($year.'/'.$a.'/01' ));
				$timeUntil = date('Y-m-d', strtotime($timeFrom ." +1 month -1 days"))."";
				
				if($j<10){
					$j = '0'.$j;
				}
				$userID = model::getUserID();
				$select->column 	= "TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(CAP_LAN_COM_ID) AS COUNT";

				$select->tableName 	= "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						WHERE CAP_LAN_COM_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAN_COM_DATECREATED::DATE::TIMESTAMP <='".$timeUntil." 23:59:59' AND CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAN_COM_DATECREATED, '".$dateParam."') DESC";

				$select->execute();

				$result =  $select->arrayResult;

				$bulitArray [] = array("MONTH"=>$dateTime, "COUNT"=>$result[0]['COUNT']);

			}
			//print_r($bulitArray);
			//echo $select->query;
			return $bulitArray;

	}

	public function countDadoUserYearContent($type, $timeFrom ){
			
			$select = new select("","","","","");
			
			$year = $timeFrom;
			
			$dateRange = array(0,1,2,3,4,5,6,7,8,9,10,11);
			
			foreach ($dateRange as $key => $value) {
				
				$i = $value;
					
				$a = $i +1 ;	
				
				if($a < 10 ){
					$a = '0'.$a;
				}
				
				$dateTime = $year."-".$a;
				
				$dateParam = 'YYYY-MM';
				$timeFrom = date('Y-m-d', strtotime($year.'/'.$a.'/01' ));
				$timeUntil = date('Y-m-d', strtotime($timeFrom ." +1 month -1 days"))."";
				
				if($j<10){
					$j = '0'.$j;
				}
				$userID = model::getUserID();
				$select->column = "TO_CHAR(CAP_CON_CREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT";
				
				$select->tableName = "CAP_LANGUAGE_COMBINE LEFT JOIN CAP_CONTENT ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
						WHERE CAP_CON_CREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_CON_CREATED ::DATE::TIMESTAMP <='".$timeUntil." 23:59:59' AND CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND CAP_LAN_COM_COLUMN = '".$type."' 
						GROUP BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_CON_CREATED, '".$dateParam."') DESC";

				$select->execute();

				$result =  $select->arrayResult;
				
				$bulitArray [] = array("MONTH"=>$dateTime, "COUNT"=>$result[0]['COUNT']);
				
			}
			//print_r($bulitArray);
			//echo $select->query;
			return $bulitArray;
			
	}

	public function getStatsDado(){

		$select = new select("","","","","");



	}

	public function getJudulDokumen($id){
		$select = new select("*","CAP_CONTENT_METADATA WHERE LOWER(CAP_CON_MET_HEADER) = LOWER('Judul Dokumen') AND FK_CAP_LAN_COM_ID =".$id,"","","");

        $select -> execute();

        return $select->arrayResult;
	}

	public function getSearchData($text) {

		$explode1 = explode(" ", $text);

		foreach ($explode1 as $key => $value) {

			$explode2 = explode(":", $value, 2);

			switch ($explode2[0]) {

			case 'tagging':
				$searchQuery .= " LOWER(CAP_CON_CONTENT) LIKE LOWER('%".$explode2[1]."%') OR LOWER(CAP_CON_HEADER) LIKE LOWER('%".$explode2[1]."%') AND";
				break;

			default:
				if(!empty($explode2[0])){
				$searchQuery .= " LOWER(CAP_LAN_COM_VALUE) LIKE LOWER('%".$explode2[0]."%') OR LOWER(CAP_CON_HEADER) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_TAG_VALUE) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_KLA_NAME) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_KLA_NOTE) LIKE LOWER('%".$explode2[0]."')
									OR LOWER(CAP_CON_MET_CONTENT) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_CON_MET_HEADER) LIKE LOWER('%".$explode2[0]."%')
				 AND";
				}
				break;

			}

		}
		if(!empty($searchQuery)){
		$searchQuery = substr($searchQuery, 0,-3);

		$select = new select(

		"DISTINCT CAP_LAN_COM_ID, CAP_CON_ID",
		"CAP_CONTENT
		LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
		LEFT JOIN CAP_TAG_KEY ON CAP_TAG_KEY.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID
		LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
		LEFT JOIN CAP_CONTENT_METADATA ON CAP_CONTENT.CAP_CON_ID = CAP_CONTENT_METADATA.FK_CAP_CON_ID
		WHERE 
		".$searchQuery,
		"",
		"",
		"","100"); 
		
		$select->execute(); 
		
		$html = new simple_html_dom();
		//echo $select->query;
		if (!empty($select->arrayResult)) {
		
			foreach ($select->arrayResult as $key => $value) {
					
				$selectHeader = new select(
				
				"*",
				"CAP_CONTENT
				LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
				WHERE
				(
				CAP_LAN_COM_COLUMN = 'file' OR
				CAP_LAN_COM_COLUMN = 'image' OR
				CAP_LAN_COM_COLUMN = 'video' OR
				CAP_LAN_COM_COLUMN = 'audio' OR
				CAP_LAN_COM_COLUMN = 'content' OR
				CAP_LAN_COM_COLUMN = 'header') AND
				CAP_CON_ID = '$value[CAP_CON_ID]'",
				"",
				"",
				"","100"
				); 
				
				$selectHeader->execute();

				$valueView = $selectHeader->arrayResult[0];

				//if(!empty($selectHeader->arrayResult)){

					//foreach ($selectHeader->arrayResult as $keyView => $valueView) {

						$content  = $html->load($valueView[CAP_LAN_COM_VALUE]);

						$header = $valueView[CAP_CON_HEADER];

						$type = $valueView[CAP_LAN_COM_COLUMN];

						$array [] =  array("id" => $value[CAP_CON_ID]."", "header" => $header,"content" => self::trimmingWords($html->plaintext),"type" => $type );

					//}

				//}

			}

		}
		
		return $array;
		
		}
	}
	public function getSearchDataUser($text) {

		$explode1 = explode(" ", $text);

		foreach ($explode1 as $key => $value) {

			$explode2 = explode(":", $value, 2);

			switch ($explode2[0]) {

			case 'tagging':
				$searchQuery .= " LOWER(CAP_CON_CONTENT) LIKE LOWER('%".$explode2[1]."%') OR LOWER(CAP_CON_HEADER) LIKE LOWER('%".$explode2[1]."%') AND";
				break;

			default:
				if(!empty($explode2[0])){
				$searchQuery .= " (LOWER(CAP_LAN_COM_VALUE) LIKE LOWER('%".$explode2[0]."%') OR LOWER(CAP_CON_HEADER) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_TAG_VALUE) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_KLA_NAME) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_KLA_NOTE) LIKE LOWER('%".$explode2[0]."')
									OR LOWER(CAP_CON_MET_CONTENT) LIKE LOWER('%".$explode2[0]."%')
									OR LOWER(CAP_CON_MET_HEADER) LIKE LOWER('%".$explode2[0]."%'))
				 AND";
				}
				break;

			}

		}
		if(!empty($searchQuery)){
		$searchQuery = substr($searchQuery, 0,-3);
		$userID = model::getUserID();
		$select = new select(

		"DISTINCT CAP_LAN_COM_ID, CAP_CON_ID",
		"CAP_CONTENT
		LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
		LEFT JOIN CAP_TAG_KEY ON CAP_TAG_KEY.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID
		LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
		LEFT JOIN CAP_CONTENT_METADATA ON CAP_CONTENT.CAP_CON_ID = CAP_CONTENT_METADATA.FK_CAP_CON_ID
		WHERE CAP_CONTENT.CAP_USER_CAP_USE_ID = '$userID' AND
		".$searchQuery,
		"",
		"",
		"","100"); 
		
		$select->execute(); 
		
		$html = new simple_html_dom();
		//echo $select->query;
		if (!empty($select->arrayResult)) {
		
			foreach ($select->arrayResult as $key => $value) {
					
				$selectHeader = new select(
				
				"*",
				"CAP_CONTENT
				LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_CONTENT.CAP_CON_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID 
				WHERE
				(
				CAP_LAN_COM_COLUMN = 'file' OR
				CAP_LAN_COM_COLUMN = 'image' OR
				CAP_LAN_COM_COLUMN = 'video' OR
				CAP_LAN_COM_COLUMN = 'audio' OR
				CAP_LAN_COM_COLUMN = 'content' OR
				CAP_LAN_COM_COLUMN = 'header') AND
				CAP_CON_ID = '$value[CAP_CON_ID]'",
				"",
				"",
				"","100"
				); 
				
				$selectHeader->execute();

				$valueView = $selectHeader->arrayResult[0];

				//if(!empty($selectHeader->arrayResult)){

					//foreach ($selectHeader->arrayResult as $keyView => $valueView) {

						$content  = $html->load($valueView[CAP_LAN_COM_VALUE]);

						$header = $valueView[CAP_CON_HEADER];

						$type = $valueView[CAP_LAN_COM_COLUMN];

						$array [] =  array("id" => $value[CAP_CON_ID]."", "header" => $header,"content" => self::trimmingWords($html->plaintext),"type" => $type );

					//}

				//}

			}

		}
		
		return $array;
		
		}
	}

	public function trimmingWords($words) {
	
	$words = explode("\n",wordwrap($words, 10));
	
		foreach ($words as $value) {
		$i++; $newWords .= $value . " "; if ($i == 15) {break;}
		}
	
	return $newWords;
	
	}

	public function setDefaultMetadata($data, $del){
		if(!empty($del) ){
			foreach ($del as $key => $value) {
				if(is_numeric($value)){
					$delete = new delete("","CAP_METADATA_DEFAULT",array(array("CAP_MET_DEF_ID","=","$value")),"","");
					$delete -> execute();
				}
			}
		}
		if(!empty($data)){

			foreach ($data as $key => $value) {
				if (preg_match("![A-Za-z]!",$value[0])):
							
					$value[0] = null;
							
					endif;
				if(empty($value[0])){


				$insert = new insert("","","","","");
				$insert -> column = array(
						"CAP_MET_DEF_VALUE" => $value[2],
						"CAP_MET_DEF_NAME" => $value[1],
					);
				$insert -> tableName = "CAP_METADATA_DEFAULT";

				$insert -> execute();

				}else{

					$update = new update("","","","","");
					$update -> column = array(
							"CAP_MET_DEF_VALUE" => $value[2],
							"CAP_MET_DEF_NAME" => $value[1],
						);
					$update -> tableName = "CAP_METADATA_DEFAULT";

					$update -> whereClause = array(array("CAP_MET_DEF_ID","=","$value[0]"));

					$update -> whereID = "";

					$update->execute();

				}
			}
		}
	}

	public function setRetensiWaktu($id){
		$select = new select("*","CAP_GROUPING",array(array("CAP_GRO_ID","=","$id")),"","");

		$select -> execute();

		return $select->arrayResult;
	}

	public function setRetensiWaktuContent($id){
	
		
		$select = new select("*","CAP_LANGUAGE_COMBINE LEFT JOIN CAP_GRO_LAN_COM ON CAP_GRO_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID",array(array("CAP_LAN_COM_ID","=","$id")),"","");

		$select -> execute();

		return $select->arrayResult;
	}
	
	public function saveRetensiWaktu($id,$data){
		
		$update = new update( array("CAP_GRO_TIME" => date('Y-m-d H:i:s',strtotime($data[0]))),"CAP_GROUPING",array(array("CAP_GRO_ID","=","$data[1]")),"","");
						
		$update -> dateColumn = array("CAP_GRO_TIME");
		
		$update -> execute();
		
		
	}
	
	public function saveRetensiWaktuContent($id,$data){
	
		if($data[0] == "" || empty($data)){
			
			$date = null;
			
		}else{
			$date = date('Y-m-d H:i:s',strtotime($data[0]));
			$update -> dateColumn = array("CAP_LAN_COM_TIME");
		}
		
		$update = new update( array("CAP_LAN_COM_TIME" => $date ),"CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_ID","=","$data[1]")),"","");
						
		$update -> dateColumn = array("CAP_LAN_COM_TIME");
		
		$update -> execute();
		
		
	}
	
	public function saveSetShow($id,$data){
		
		$update = new update( array("CAP_GRO_SHOW" => $data[0]),"CAP_GROUPING",array(array("CAP_GRO_ID","=","$data[1]")),"","");
								
		$update -> execute();
		
		
		
		
	}
	
	public function saveSetShowContent($id,$data){
	
		if($data[0]==0){
			$download=0;
		}else{
			$download = $data[3];
		}
		
		$status = null;
		
		$update = new update( array("CAP_LAN_COM_PUBLISH" => $data[0], "CAP_lAN_COM_DOWNLOADABLE" => $download),"CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_ID","=","$data[2]")),"","");
								
		$status .= $update -> execute();
		
		$insert = new insert("","","","","");
		
		$check = new select("*","CAP_GRO_LAN_COM",array(array("FK_LAN_COM_ID","=","$data[2]")),"","");
		
		$check->execute();
		
		if(!empty($check->arrayResult[0]['CAP_GRO_LAN_COM_ID'])){
						
		$update->column = array("FK_GRO_ID" => $data[5]);
		
		$update->tableName = "CAP_GRO_LAN_COM";
		
		$update -> whereClause = array(array("CAP_GRO_LAN_COM_ID","=",$check->arrayResult[0][CAP_GRO_LAN_COM_ID]));
		
		$update -> whereID = "";
		
		$status .= $update->execute();	
			
		}else{				
				$insert->column = array("FK_GRO_ID"=>$data[5], "FK_LAN_COM_ID" => $data[2]);
				
				$insert->tableName = "CAP_GRO_LAN_COM";
				
				$status .= $insert->execute();
			
		}
		
			$check -> column = "*";
			
			$check -> tableName = "CAP_CONTENT_METADATA";
			
			$check -> whereClause = array(array("FK_CAP_LAN_COM_ID","=","$data[2]"),array("LOWER(CAP_CON_MET_HEADER)","=","LOWER('Grouping')"));
			
			$check -> whereID = "" ;
			
			$check->execute();
			
			$select = new select("*","CAP_GROUPING",array(array("CAP_GRO_ID","=","$data[5]")),"","");
				
			$select->execute();
			
			$groName = $select->arrayResult[0]['CAP_GRO_NAME'];
			
			if(!empty($check->arrayResult[0]['CAP_CON_MET_ID'])){
			
				$updateMeta = new update(array("CAP_CON_MET_CONTENT" => $groName),"CAP_CONTENT_METADATA",array(array("CAP_CON_MET_ID","=","$check->arrayResult[0][CAP_CON_MET_ID]")),"","");
								
				$status .= $updateMeta->execute();	
								
			}else{
				
				$check -> column = "*";
			
				$check -> tableName = "CAP_CONTENT_METADATA";
				
				$check -> whereClause = array(array("FK_CAP_LAN_COM_ID","=","$data[2]"));
				
				$check -> whereID = "" ;
				
				$check->execute();
				
				$insert->column = array(
									"FK_CAP_CON_ID" => $check->arrayResult[0]['FK_CAP_CON_ID'],
									"CAP_CON_MET_HEADER" => "Grouping",
									"CAP_CON_MET_CONTENT" => $groName,
									"CAP_CON_MET_PATH" => $check->arrayResult[0]['CAP_CON_MET_PATH'],
									"FK_CAP_LAN_COM_ID" => $data[2]);
		
				$insert->tableName = "CAP_CONTENT_METADATA";
				
				$status .= $insert->execute();
				
				
			}
			
						
		
		
		
		return $status;
		
	}

	public function countTotalOfContent($additionalParameter=""){
		
		$data = new select(
		"COUNT(*) as COUNT",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = 'content' ".$additionalParameter,
		"","",""); $data->execute();
			
		return $data->arrayResult;
	}
	
	public function countTotalOfFile($type){
		$data = new select(
		"COUNT(*) as COUNT",
		"CAP_CONTENT 
		 LEFT JOIN CAP_CONTENT_TYPE ON CAP_CONTENT.FK_CAP_CONTENT_TYPE = CAP_CONTENT_TYPE.CAP_CON_TYP_ID 
		 LEFT JOIN CAP_CONTENT_CATEGORY ON CAP_CONTENT.FK_CAP_CONTENT_CATEGORY = CAP_CONTENT_CATEGORY.CAP_CON_CAT_ID
		 LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID 
		 LEFT JOIN CAP_USER ON CAP_USER.CAP_USE_ID = CAP_CONTENT.CAP_USER_CAP_USE_ID
		 WHERE CAP_CONTENT_TYPE.CAP_CON_TYP_TYPE = '$type'
		 ",
		"","",""); $data->execute();
			
		return $data->arrayResult;
	}
	
	public function commentManagement($data){
		
		
		
	}
	
	public function getRole() {
    	
    $select = new select("*","CAP_USER_ROLE ORDER BY CAP_USE_ROL_ID ASC","","",""); $select->execute();
	
		foreach ($select->arrayResult as $value) { 
		$array [$value['CAP_USE_ROL_ID']] = strtolower(str_replace(' ','-',$value['CAP_USE_ROL_NAME']));
		}
	
	return $array;	
    	
	}
	
	public function getRoleList($mainID = null,$currentDomain = null) {
				
				if(!empty($mainID)):
				$mainID = self::getDomainID($mainID);
				$data = new select("*","CAP_USER_ROLE",[["FK_CAP_MAI_ID","=","$mainID"]],"","CAP_USE_ROL_NAME ASC"); $data->execute();
				else:
				
				$currentDomain =  self::getDomainID($currentDomain);
				$data = new select("*","CAP_USER_ROLE",[["FK_CAP_MAI_ID","=","$currentDomain"],["","OR",""],["FK_CAP_MAI_ID","","IS NULL"]],"","CAP_USE_ROL_NAME ASC"); $data->execute();
				endif;
		return $data->arrayResult;
		
		}
	public function getSitesList($page, $limit) {
		
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
		
		public function getDomainID($domainName=null){
					
			if(empty($domainName)){
				$domainName = $_SERVER['HTTP_HOST'];
			}
			
				$app = APP;
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
	   		$domain->tableName = "CAP_MAIN a, ".str_replace('/', '', $app).".CAP_MAIN b WHERE a.CAP_MAI_PARENT = b.CAP_MAI_ID AND a.CAP_MAI_DOMAIN  || '.' ||  b.CAP_MAI_DOMAIN ='$domainName'";
	   		$domain->whereClause = "";
			$domain->execute();
			$mainID = $domain->arrayResult[0]["CAP_MAI_ID"];
			}    
        return $mainID;
	        
			
		}
		
		public function getDomainName($mainID){
			if(!empty($mainID)):
		   		$domain		= new select("","","");
		   		$connection = new connection();
		   		
		   		$domain->column = "(a.CAP_MAI_DOMAIN  || '.' ||  b.CAP_MAI_DOMAIN) as DOMAIN_";
		   		$domain->tableName = "CAP_MAIN a, ".$connection->schema.".CAP_MAIN b WHERE a.CAP_MAI_PARENT = b.CAP_MAI_ID AND a.CAP_MAI_ID ='$mainID'";
		   		$domain->whereClause = "";
				$domain->execute();
				$mainDomain = $domain->arrayResult[0]["DOMAIN_"];
				
				if(empty($mainDomain)):
					$domain->column = "(CAP_MAI_DOMAIN) as DOMAIN_";
			   		$domain->tableName = "CAP_MAIN WHERE CAP_MAI_ID ='$mainID'";
			   		$domain->whereClause = "";
					$domain->execute();
					$mainDomain = $domain->arrayResult[0]["DOMAIN_"];
				endif;
				return $mainDomain;
	       endif;
			
		}
		
				
		public function defaultLanguage() {
		$select = new select("*","CAP_MAIN","","",""); $select->execute();
		return $select->arrayResult[0]['CAP_MAI_LANGUAGE'];
		}
		
		public function getUserData($id) {
		
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
	
		public function editUser($id) {
	//print_r($id);
	$value = $id;
	
	$select = new select(); $insert = new insert(); $update = new update(); $delete = new delete();

	$insert->transactionStart(); $update->transactionStart(); $delete->transactionStart();
	
		if (!empty($value)):
		
		$firstName = reset(explode(' ',trim($value['name'])));
				
		$lastName  = explode(' ',trim($value['name'])); unset($lastName[0]); $lastName = implode(' ',$lastName);
		
				if (empty($value['password'])):

				$update->column = [
				"CAP_USE_FIRSTNAME"   => $firstName,
				"CAP_USE_LASTNAME"    => $lastName,
				"CAP_USE_EMAIL" 	  => $value['email'],
				"CAP_USE_USERNAME" 	  => $value['username'],
				"CAP_USE_DATEUPDATED" => date("Y-m-d H:i:s")];

				else:

				$update->column = [
				"CAP_USE_FIRSTNAME"   => $firstName,
				"CAP_USE_LASTNAME"    => $lastName,
				"CAP_USE_EMAIL" 	  => $value['email'],
				"CAP_USE_USERNAME" 	  => $value['username'],
				"CAP_USE_PASSWORD" 	  => hash('sha512', trim($value['password'])),
				"CAP_USE_DATEUPDATED" => date("Y-m-d H:i:s")];

				endif;

				$update->tableName   = "CAP_USER";

				$update->whereClause = [["CAP_USE_ID","=",$value['id']]];

				$update->dateColumn  = ['CAP_USE_DATEUPDATED'];
				
				$lastID = $update->execute();

				$i = (!is_resource($lastID) && empty($lastID)) ? $i + 1 : $i;
			
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

}
class webService{
	private $keyPrivate = "8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92";
	public  $oriData,$data,$dataReturned,$saneData;
	
	public $request = array(
						"sidadoSearch"
					);
	
	public  $response = array(
				   "False Key" 		 	=> "Bad Request",
				   "No Data Available" 	=> "Wrong Unique ID",
				   "Wrong Request"	 	=> "No Request Type",
				   "Zero Data"		 	=> "No Data Available",
				   "Failed To Insert"	=> "Failed"
				   );
				   
	public function __construct($data){
		
		$request = $data->request;
		
		if($this->keyPrivate != $data->key){
			echo json_encode($this->response['False Key']);
			return false;
		}
		
		if(!in_array($request, $this->request)){
			echo json_encode($this->response['Wrong Request']);
			return false;
		}
		
		$this->oriData = $data; $this->data = $data->submitted;
		
		$this->$request();
		
	}
	
	

	
	public function sidadoSearch(){
		
	}
		
}
?>
