<?php

namespace framework;

include('../../../../config.php');
include("../../../../framework/autoload.class.php");
include("../../../../framework/user.class.php");

session_start(); autoload::init();

$_SESSION['LAYAN-PERMOHONAN'] = $_POST;

	if (!empty($_FILES) && $_FILES['file']['error'] == 0) {
			
		$file = $_FILES['file'];
			
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			
		$name = md5($file['name']).date("d-m-y-H-i-s").".".$ext;
				
		if (move_uploaded_file($file['tmp_name'], ROOT_PATH.'library/capsule/layan/images/temp/'.$name)){

			$_SESSION['LAYAN-FILES'] = $name;
				
		}
		else {
				
			$_SESSION['LAYAN-FILES'] = "Failed";
				
		}
		
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>