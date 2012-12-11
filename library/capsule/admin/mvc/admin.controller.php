<?php

namespace library\capsule\admin;

use \framework\encryption;
use \framework\cross;

class controller  {

public $id;
public $type;

	public function __construct($type) {
	if (!empty($type)) {parent::__construct();}
	}
	
	public function initContent($id,$type,$set,$menuID,$lang,$langSet) {
	self::contentDeterminator($id,$type,$set,$menuID,$lang,$langSet);
	}
	
	protected function contentDeterminator($id,$type,$set,$menuID,$lang,$langSet) {
	if (empty($id)){admin::insertContent($set,$menuID,$lang,$langSet);}else{admin::updateContent($set,$lang,$langSet);}
	}
	
	public function initCapsule($id) {
	eval(admin::loadCapsule($id));
	}
	
	public function initCapsuleWithOption($id,$array) {
	echo "<input type='hidden' name='initWithOption' value='" . encryption::base64Encoding($array) . "'>";
	eval(admin::loadCapsuleWithOption($id,$array));
	}
	
	public function getCapsuleOption($id) {
	$view = new view(admin::getCapsuleOption($id)); $view->displayCapsuleOption();
	}
	
	public function savePageLayout($id,$pageID) {
	$id = array("pageID" => $pageID, "containerInfo" => $id); admin::savePageLayout($id);
	}
	
	public function getSitesList($page=1, $limit=20, $search = false) {
	$data = new view(admin::getSitesList($page, $limit, $search)); $data->displaySitesList($page, $limit);
	}
	
	public function getSubSitesList($id,$page=1, $limit=20) {
	$id=='allsites'?$isSubDomain = false:$isSubDomain = true;
	$data = new view(admin::getSubSitesList($id,$page, $limit)); $data->displaySubSitesList($id,$isSubDomain,$page, $limit);
	}

	public function getMenuList($id,$mainID,$page=1, $limit=20) {
	$data = new view(admin::getMenuList($id,$mainID,null,$page, $limit)); $data->displayMenuList($mainID);
	}
	
	public function getContentList() {
	$data = new view(admin::getContentList()); $data->displayContentList();
	}
	
	public function getTagonomyList($mainID,$page=1, $limit=20) {
	$data = new view(admin::getTagonomyList($mainID,$page, $limit)); $data->displayTagonomyList($mainID);
	}
	
	public function getUserList($mainID,$page=1, $limit=20) {
	$data = new view(admin::getUserList($mainID,$page, $limit)); $data->displayUserList($mainID);
	}
	
	public function getRoleList($mainID = null,$page=1, $limit=20) {
	$data = new view(admin::getRoleList($mainID,$page, $limit)); $data->displayRoleList($mainID);
	}
	
	public function getPagesListFromTable() {
	$data = new view(admin::getPagesList()); $data->displaySelectPagesList();
	}
	
	public function saveNewMenuStructure($id,$delMenuList,$delMenuSet,$lang,$mainID) {
	admin::saveNewMenuStructure($id,$delMenuList,$delMenuSet,$lang); self::getMenuList(null,$mainID);
	}
	
	public function saveNewSites($id,$delMenuList) {
	admin::saveNewSites($id,$delMenuList); self::getSitesList();
	}

	public function saveNewTagonomy($id,$delMenuList,$mainID) {
	admin::saveNewTagonomy($id,$delMenuList); self::getTagonomyList($mainID);
	}
	
	public function saveNewUser($id,$delMenuList,$mainID) {
	admin::saveNewUser($id,$delMenuList); self::getUserList($mainID);
	}
	
	public function saveRoles($id,$delMenuList,$mainID) {
	admin::saveRoles($id,$delMenuList,$mainID); self::getRoleList($mainID);
	}
		
	public function uploadFile($folder,$type,$category,$pages,$published) {
	admin::uploadFile($folder,$type,$category,$pages,$published);
	}
	
	public function uploadEditFile($id,$oldName,$folder,$type,$category,$pages,$published) {
	admin::uploadEditFile($id,$oldName,$folder,$type,$category,$pages,$published);
	}
	
	public function uploadItem($folder,$type,$files) {
	admin::uploadItem($folder,$type,$files);
	}
	
	public function submitInternalContent($id,$lang,$content) {
	admin::insertInternalContent($id,$lang,$content);
	}
	
	public function editInternalContent($id,$lang,$content) {
	admin::editInternalContent($id,$lang,$content);
	}
	
	public function editUser($id,$mainID) {
	admin::editUser($id); self::getUserList($mainID);
	}
	
	public function getUserToEdit($id) {
	$data = new view(admin::getUserToEdit($id)); $data->getUserToEdit(); 
	}

	public function getContentToEdit($id) {
	$data = new view(admin::getContentToEdit($id)); $data->getContentToEdit(); 
	}
	
	public function getContentToEditAjax($id,$lang) {
	$data = new view(admin::getContentToEditAjax($id,$lang)); $data->getContentToEditAjax(); 
	}
	
	public function getFileToEdit($id,$type) {
	$data = new view(admin::getFileToEdit($id,$type)); $data->getFileToEdit();
	}
	
	public function deleteContent($id) {
	admin::deleteContent($id);
	}
	
	public function deleteFile($id) {
	admin::deleteFile($id);
	}
	
	public function crossDomainRequest($cross) {
	$site = new cross($cross); $site->getBodyWebContent();
	}
	
	public function updateContentGlobal($id) {
	admin::updateContentGlobal($id);
	}
	
	public function getLanguage($id) {
	$data = new view(admin::getLanguageList()); $data->displayLanguageList($id);
	}
	
	public function metadata($id,$idData) {
	$data = new view(admin::metadata($id)); $data->displayMetadata($id,$idData);
	}
	
	public function saveMetadata($id,$del) {
	admin::saveMetadata($id,$del);
	}
	
	public function searchsitesSet($id) {
	$data = new view(admin::searchsitesSet($id)); $data->displaySitesListSearched();
	}
	
	public function searchsubsitesSet($id) {
	$data = new view(admin::searchsubsitesSet($id)); $data->displaySubSitesListSearched();
	}
	
	public function searchuserSet($id) {
	$data = new view(admin::searchuserSet($id)); $data->displayUserListSearched();
	}

}

?>