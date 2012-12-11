<?php

//Declaring namespace
namespace library\capsule\layan;

//Including Global Configuration
include_once('../../../config.php');

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

//Starting Session
session_start();

switch($_POST[control]) {

	case "loading":
	layan::loading();
	break;
	
	case "permohonan":
	layan::permohonan($_POST['data']);
	break;
	
	case "dokumen":
	layan::dokumen($_POST['data']);
	break;

	case "printPemberitahuan":
	layan::printPemberitahuan($_POST['data']);
	break;
	
	case "printPenolakan":
	layan::printPenolakan($_POST['data']);
	break;

	case "printPerpanjangan":
	layan::printPerpanjangan($_POST['data']);
	break;
	
	case "printKeberatan":
	layan::printKeberatan($_POST['data']);
	break;

	case "getDokumen":
	layan::getDokumen($_POST['data']);
	break;
	
	case "getFormPemberitahuan":
	layan::getFormPemberitahuan($_POST['data']);
	break;
	
	case "getFormPenolakan":
	layan::getFormPenolakan($_POST['data']);
	break;
	
	case "getFormPerpanjangan":
	layan::getFormPerpanjangan($_POST['data']);
	break;

	case "getHoliday":
	layan::getHoliday($_POST['data']);
	break;
		
	case "saveDokumen":
	print_r($_POST['data']);
	//layan::saveDokumen($_POST['data']);
	break;

	case "deletePemberitahuanDokumen":
	layan::deletePemberitahuanDokumen($_POST['data']);
	break;

	case "deletePerpanjanganDokumen":
	layan::deletePerpanjanganDokumen($_POST['data']);
	break;

	case "deletePenolakanDokumen":
	layan::deletePenolakanDokumen($_POST['data']);
	break;

	case "deleteKeberatanDokumen":
	layan::deleteKeberatanDokumen($_POST['data']);
	break;

	case "deletePemberitahuanDokumenMaster":
	layan::deletePemberitahuanDokumenMaster($_POST['data']);
	break;

	case "deletePerpanjanganDokumenMaster":
	layan::deletePerpanjanganDokumenMaster($_POST['data']);
	break;

	case "deletePenolakanDokumenMaster":
	layan::deletePenolakanDokumenMaster($_POST['data']);
	break;

	case "deleteKeberatanDokumenMaster":
	layan::deleteKeberatanDokumenMaster($_POST['data']);
	break;

	case "upload":
	layan::uploadFile($_FILES,$_POST['rel'],$_POST['ref']);
	break;

	case "setDelivered":
	layan::setDelivered($_POST['data']);
	break;

	case "deleteAttachment":
	layan::deleteAttachment($_POST['data']);
	break;
	
	case "getLibraryContent":
	layan::getUserLibraryContent($_POST['data']);
	break;
	
	case "getGuestLibraryContent":
	layan::getGuestLibraryContent($_POST['data']);
	break;
	
	case "getUserLibraryContent":
	layan::getUserLibraryContent($_POST['data']);
	break;
	
	case "getOrderLibraryContent":
	layan::getOrderLibraryContent();
	break;
	
	case "storeOrder":
	layan::storeOrder($_POST['data']);
	break;
	
	case "cancelOrder":
	layan::cancelOrder($_POST['data']);
	break;
	
	case "printOrder":
	layan::printOrder();
	break;
	
	case "resetOrder":
	layan::resetOrder();
	break;
	
	case "checkOrderNumber":
	layan::checkOrderNumber($_POST['data']);
	break;
	
	case "layanSearchPermohonan":
	layan::layanSearchPermohonan($_POST['data']);
	break;
	
	case "layanSearchPermohonanAdmin":
	layan::layanSearchPermohonanAdmin($_POST['data']);
	break;

	default:
	echo "no available controller";
	break;

}
