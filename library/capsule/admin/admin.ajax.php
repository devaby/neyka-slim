<?php 

//Declaring namespace
namespace framework;

//All Use Goes Here If You're Using Class
use \library\capsule\admin\controller;

//Including Global Configuration
include_once('../../../config.php');

//Starting Capsule Framework
include_once ROOT_PATH.'framework/neyka.class.php';

//Gentlemen, Start Your Engine!
neyka::startAjax();

//Accepting basic data 
$id 		= $_POST['id'];
$include	= $_POST['incl'];
$control	= $_POST['control']; 


//Ajax time start
//$time = server::scriptTime();

//Event Handler 
switch ($control) {

	case "admin/submitContent":
	include_once ROOT_PATH.$include;
	controller::initContent($id,$type,array("column" => $_POST['pageArray'],"tableName" => $_POST['tableName'], "whereClause" => $_POST['whereColumn'], 
	"whereID" => $id), $_POST['menuID'], $_POST['language'], $_POST['languageSet']);
	break;
	
	case "admin/submitInternalContent":
	$content = array(
	"header"=>$_POST[header],"content"=>$_POST[content],"category"=>$_POST[category],
	"pages"=>$_POST[pages],"published"=>$_POST[published],"language"=>$_POST[language]);
	include_once ROOT_PATH.$include;
	controller::submitInternalContent($id,$lang,$content);
	break;
	
	case "admin/editInternalContent":
	$content = array(
	"header"=>$_POST[header],"content"=>$_POST[content],"category"=>$_POST[category],
	"pages"=>$_POST[pages],"published"=>$_POST[published],"language"=>$_POST[language]);
	include_once ROOT_PATH.$include;
	controller::editInternalContent($id,$lang,$content);
	break;
	
	case "admin/loadCapsule":
	include_once ROOT_PATH.$include;
	controller::initCapsule($_POST[idCapsule]);
	break;
	
	case "admin/loadCapsuleWithOption":
	include_once ROOT_PATH.$include;
	controller::initCapsuleWithOption($_POST[idCapsule],$_POST[arrayCon]);
	break;
	
	case "admin/capsuleOption":
	include_once ROOT_PATH.$include;
	controller::getCapsuleOption($id);
	break;
	
	case "admin/savePageLayout":
	include_once ROOT_PATH.$include;
	controller::savePageLayout($id,$_POST[pageID]);
	break;
	
	case "admin/getSitesList":
	include_once ROOT_PATH.$include;
	controller::getSitesList();
	break;
	
	case "admin/getSubSitesList":
	include_once ROOT_PATH.$include;
	if(isset($_POST['nextPage'])){
		$nextPage = $_POST['nextPage'];
	}else{
		$nextPage = 1;
	}
	controller::getSubSitesList($_POST['idSites'],$nextPage);
	break;

	case "admin/getMenuList":
		include_once ROOT_PATH.$include;
		if(isset($_POST['nextPage'])){
			$nextPage = $_POST['nextPage'];
		}else{
			$nextPage = 1;
		}
		controller::getMenuList($_POST['id'],$_POST['mainID'],$nextPage);
	break;
	
	case "admin/getContentList":
	include_once ROOT_PATH.$include;
	controller::getContentList();
	break;
	
	case "admin/getTagonomyList":
	include_once ROOT_PATH.$include;
	if(isset($_POST['nextPage'])){
		$nextPage = $_POST['nextPage'];
	}else{
		$nextPage = 1;
	}
	controller::getTagonomyList($_POST['mainID'],$nextPage);
	break;
	
	case "admin/getUserList":
	include_once ROOT_PATH.$include;
	if(isset($_POST['nextPage'])){
		$nextPage = $_POST['nextPage'];
	}else{
		$nextPage = 1;
	}
	controller::getUserList($_POST['mainID'],$nextPage);
	break;
	
	case "admin/getRoleList":
	include_once ROOT_PATH.$include;
	if(isset($_POST['nextPage'])){
		$nextPage = $_POST['nextPage'];
	}else{
		$nextPage = 1;
	}
	controller::getRoleList($_POST['mainID'],$nextPage);
	break;
		
	case "admin/uploadFile":
	include_once ROOT_PATH.$include;
	controller::uploadFile($_POST[folder],$_POST[type],$_POST[category],$_POST[pages],$_POST[published]);
	break;
	
	case "admin/uploadEditFile":
	include_once ROOT_PATH.$include;
	controller::uploadEditFile($_POST[id],$_POST[oldName],$_POST[folder],$_POST[type],$_POST[category],$_POST[pages],$_POST[published]);
	break;
	
	case "admin/uploadItem":
	include_once ROOT_PATH.$include;
	controller::uploadItem($_POST[myFolder],$_POST[type],$_FILES);
	break;
	
	case "admin/checkFile":
	include_once ROOT_PATH.$include;
	controller::uploadFile($_POST[folder],$_POST[type],$_POST[category],$_POST[pages],$_POST[published]);
	break;
	
	case "admin/getPagesList":
	include_once ROOT_PATH.$include;
	controller::getPagesListFromTable();
	break;
	
	case "admin/saveNewMenuStructure":
	include_once ROOT_PATH.$include;
	controller::saveNewMenuStructure($id,$_POST[delMenuList],$_POST[delMenuSet],$_POST[lang],$_POST[mainID]);
	break;
	
	case "admin/saveNewSites":
	include_once ROOT_PATH.$include;
	controller::saveNewSites($id,$_POST[delMenuList]);
	break;

	case "admin/saveNewTagonomy":
	include_once ROOT_PATH.$include;
	controller::saveNewTagonomy($id,$_POST[delMenuList],$_POST[mainID]);
	break;
	
	case "admin/saveNewUser":
	include_once ROOT_PATH.$include;
	controller::saveNewUser($id,$_POST[delMenuList],$_POST[mainID]);
	break;
	
	case "admin/saveRoles":
	include_once ROOT_PATH.$include;
	controller::saveRoles($id,$_POST[delMenuList],$_POST[mainID]);
	break;
	
	case "admin/getUserToEdit":
	include_once ROOT_PATH.$include;
	controller::getUserToEdit($id);
	break;
	
	case "admin/editUser":
	include_once ROOT_PATH.$include;
	controller::editUser($id,$_POST[mainID]);
	break;

	case "admin/getContentToEdit":
	include_once ROOT_PATH.$include;
	controller::getContentToEdit($id);
	break;
	
	case "admin/getContentToEditAjax":
	include_once ROOT_PATH.$include;
	controller::getContentToEditAjax($id,$_POST[lang]);
	break;
	
	case "admin/getFileToEdit":
	include_once ROOT_PATH.$include;
	controller::getFileToEdit($id,$_POST[type]);
	break;
	
	case "admin/deleteContent":
	include_once ROOT_PATH.$include;
	controller::deleteContent($id);
	break;
	
	case "admin/deleteFile":
	include_once ROOT_PATH.$include;
	controller::deleteFile($id);
	break;
	
	case "admin/crossDomainAjaxRequest":
	include_once ROOT_PATH.'library/admin/admin.main.php';
	controller::crossDomainRequest($_POST[site]);
	break;
	
	case "admin/updateContentGlobal":
	include_once ROOT_PATH.$include;
	controller::updateContentGlobal($id);
	break;
	
	case "admin/getLanguage":
	include_once ROOT_PATH.$include;
	controller::getLanguage($_POST[id]);
	break;
	
	case "admin/metadata":
	include_once ROOT_PATH.$include;
	controller::metadata($_POST[id],$_POST[idData]);
	break;
	
	case "admin/saveMetadata":
	include_once ROOT_PATH.$include;
	controller::saveMetadata($_POST[id],$_POST[del]);
	break;
	
	case "admin/searchadmin-sitesSet":
	include_once ROOT_PATH.$include;
	controller::searchsitesSet($_POST['id']);
	break;
	
	case "admin/searchadmin-subSitesSet":
	include_once ROOT_PATH.$include;
	controller::searchsubsitesSet($_POST['id']);
	break;
	
	case "admin/searchadmin-userSet":
	include_once ROOT_PATH.$include;
	controller::searchuserSet($_POST['id']);
	break;
	
	default:
	echo "No controller selected";
	break;


}

//If you want to see script time taken uncomment this parts
//echo "Time taken = ".number_format(($time - $Start),2)." secs";

?>