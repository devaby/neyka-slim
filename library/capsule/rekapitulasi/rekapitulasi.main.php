<?php
namespace library\capsule\rekapitulasi;

use \library\capsule\rekapitulasi\mvc\model;
use \library\capsule\rekapitulasi\mvc\controller;
use \library\capsule\rekapitulasi\mvc\view;

class rekapitulasi{
	public static function init($params) {
   		return new view($params);
   	}
   	
   	public function dashboardYear($year){
	   	$view = new view("emptyMethod");
	   	return $view -> dashboard($year);
   	}
   	public function dashboardDate($year,$dateFrom, $dateTo){
	   	$view = new view("emptyMethod");
	   	return $view -> dashboard(null,$dateFrom, $dateTo);
   	}
   	
   /*	public function detailReport($type,$dateFrom, $dateTo){
	   	$view 		= new view("emptyMethod");
	   	$type 		= base64_encode($type);
	   	$dateFrom 	= base64_encode($dateFrom);
	   	$dateTo 	= base64_encode($dateTo);
	   	return $view -> detail($type,$dateFrom, $dateTo);
   	}*/
}

?>