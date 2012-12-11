<?php
namespace library\capsule\rekapitulasi;

//Starting Session
session_start();

//Fill this If Your App Is In Sub Folder
include_once('../../../config.php');


//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

switch($_POST['control']) {
	
	case 'dashboardYear':
	rekapitulasi::dashboardYear($_POST['year']);
	break;
	
	case 'dashboardDate':
	rekapitulasi::dashboardDate($_POST['year'],$_POST['dateFrom'],$_POST['dateTo']);
	break;

	//case 'detailReport':
	//rekapitulasi::detail($_POST['type'],$_POST['dateFrom'],$_POST['dateTo']);
	//break;

	default:
	echo "no available controller";
	break;	

}



?>