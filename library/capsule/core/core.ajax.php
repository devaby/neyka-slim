<?php

//Declaring namespace
namespace library\capsule\core;



//Including Global Configuration
include_once('../../../config.php');


//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

switch($_POST['control']) {

	case "getContentNotContent":
	core::getContentNotContent($_POST['id'],$_POST['type']);
	break;
	
	case "getContentNotContentAdmin":
	core::getContentNotContentAdmin($_POST['id'],$_POST['type']);
	break;
	
	case "getContent":
	core::getContentUser($_POST['id'],$_POST['type']);
	break;

	case "getContentAdmin":
	core::getContentAdmin($_POST['id'],$_POST['type']);
	break;
	
	case "getEventAdmin":
	core::getEventAdmin($_POST['id'],$_POST['type']);
	break;
	
	case "originalContent":
	core::originalContentUser($_POST['id'],$_POST['type']);
	break;
	
	case "originalContentAdmin":
	core::originalContentAdmin($_POST['id'],$_POST['type']);
	break;
	
	case "originalTextContent":
	core::originalTextContentUser($_POST['id'],$_POST['type']);
	break;
	
	case "originalTextContentAdmin":
	core::originalTextContentAdmin($_POST['id'],$_POST['type']);
	break;
	
	case "originalEventAdmin":
	core::originalEventAdmin($_POST['id'],$_POST['type']);
	break;
	
	case "getContentNotContentNew":
	core::getContentNotContentUserNew($_POST['id'],$_POST['type']);
	break;
	
	case "getContentNotContentPersonalNew":
	core::getContentNotContentPersonalNew($_POST['id'],$_POST['type']);
	break;
	
	case "getContentNotContentAdminNew":
	core::getContentNotContentAdminNew($_POST['id'],$_POST['type']);
	break;
	
	case "getContentNew":
	core::getContentUserNew($_POST['id'],$_POST['type']);
	break;
	
	case "getContentPersonalNew":
	core::getContentPersonalNew($_POST['id'],$_POST['type']);
	break;
	
	case "getContentAdminNew":
	core::getContentAdminNew($_POST['id'],$_POST['type']);
	break;
	
	case "getEventAdminNew":
	core::getEventAdminNew($_POST['id'],$_POST['type']);
	break;
	
	case "deleteContentNotContentUser":
	core::deleteContentNotContentUser($_POST['id'],$_POST['type'],$_POST['content'],$_POST['del'],$_POST['fkid'],$_POST['mainID']);
	break;
	
	case "deleteContentNotContent":
	core::deleteContentNotContent($_POST['id'],$_POST['type'],$_POST['content'],$_POST['del'],$_POST['fkid'],$_POST['mainID']);
	break;
	
	case "updateContentNotContent":
	core::updateContentNotContent($_POST['data'],$_POST['del']);
	break;
	
	case "updateEventNotEvent":
	core::updateEventNotEvent($_POST['data'],$_POST['del']);
	break;
	
	case "getMultipleLanguageContent":
	core::getMultipleLanguageContent($_POST['data']);
	break;
	
	case "getMultipleLanguageMenu":
	core::getMultipleLanguageMenu($_POST['data']);
	break;
	
	case "insertMainSubMenu":
	core::insertMainSubMenu($_POST['data']);
	break;
	
	case "insertSubMenu":
	core::insertSubMenu($_POST['data'],$_POST['del']);
	break;
	
	case "createDirectory":
	core::createDirectory($_POST['type'],$_POST['content'],$_POST['mainID']);
	break;
	
	case "uploadItem":
	core::uploadItem($_POST['myFolder'],$_POST['type'],$_FILES,$_POST['myID'],$_POST['conId'],$_POST['myMainID']);
	break;
	
	case "uploadPhotoProfil":
	core::uploadPhotoProfil($_POST['myFolder'],$_POST['type'],$_FILES,$_POST['myID'],$_POST['conId']);
	break;
	
	case "getImageUploaded":
	core::getImageUploaded($_POST['userID']);
	break;
	
	case "updateContent":
	core::updateContent($_POST['data']);
	break;
	
	case "updateEvent":
	core::updateEvent($_POST['data']);
	break;
	
	case "metadata":
	core::metadata($_POST['id'],$_POST['idData']);
	break;
	
	case "saveMetadata":
	core::saveMetadata($_POST['id'],$_POST['del']);
	break;
	
	case "classification":
	core::classification($_POST['id']);
	break;
	
	case "saveClassification":
	core::saveClassification($_POST['id']);
	break;
	
	case "tagging":
	core::tagging($_POST['id']);
	break;
	
	case "editUser":
	core::editUser($_POST['id']);
	break;
	
	case "saveTagging":
	core::saveTagging($_POST['id']);
	break;

	case "showTagging":
	core::showTagging($_POST['id']);
	break;
	
	case "searchOnTheFly":
	core::searchOnTheFly($_POST['data']);
	break;
	
	case "insertSubKlasifikasi":
	core::insertSubKlasifikasi($_POST['data'],$_POST['del']);
	break;
	
	case "insertSubPublisher":
	core::insertSubPublisher($_POST['data'],$_POST['del']);
	break;
	
	case "insertSubGrouping":
	core::insertSubGrouping($_POST['data'],$_POST['del']);
	break;
	
	case"checkDirectory":
	core::checkDirectory($_POST['data'],$_POST['mainID'],$_POST['type']);
	break;

	case"nextPage":
	core::nextPage($_POST['id'],$_POST['type']);
	break;
	
	case"nextPageText":
	core::nextPageText($_POST['id'],$_POST['type']);
	break;
	
	case "getSearchResult":
	core::getSearchResult($_POST[text]);
	break;
	case "getSearchResultUser":
	core::getSearchResultUser($_POST[text]);
	break;

	case 'getDadoDashboardUser':
	core::getDadoDashboardUser($_POST['from'],$_POST['to'],$_POST['typeOfdate']);	
	break;
	
	case 'getDadoDashboard':
	core::getDadoDashboard($_POST['from'],$_POST['to'],$_POST['typeOfdate']);	
	break;
	
	case 'getDadoDashboardYear':
	core::getDadoDashboardYear($_POST['year']);	
	break;
	
	case 'getDadoDashboardUserYear':
	core::getDadoDashboardUserYear($_POST['year']);	
	break;

	case 'setDefaultMetadata':
	core::setDefaultMetadata($_POST[data],$_POST[del]);
	break;

	case 'setRetensiWaktu':
	core::setRetensiWaktu($_POST['id']);
	break;

	case 'setRetensiWaktuContent':
	core::setRetensiWaktuContent($_POST['id']);
	break;
	
	case 'saveRetensiWaktu':
	core::saveRetensiWaktu($_POST['id'],$_POST['data']);
	break;
	
	case 'saveRetensiWaktuContent':
	core::saveRetensiWaktuContent($_POST['id'],$_POST['data']);
	break;
	
	case 'setShow':
	core::setShow($_POST['id']);
	break;
	
	case 'saveSetShow':
	core::saveSetShow($_POST['id'],$_POST['data']);
	break;
	
	case 'setShowContent':
	core::setShowContent($_POST['id']);
	break;
	
	case 'saveSetShowContent':
	core::saveSetShowContent($_POST['id'],$_POST['data']);
	break;
	
	case "getLibraryContent":
	core::getLibraryContent($_POST['data']);
	break;
	
	case "commentManagement":
	core::commentManagement($_POST['data']);
	break;

	default:
	echo "no available controller";
	break;

}

?>