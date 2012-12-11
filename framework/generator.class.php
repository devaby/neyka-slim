<?php

namespace framework;

class generator {

	public function password() {
		
	//$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
	$chars = "stuvwxyzABCDEFGHIJZ0256789"; 
	srand((double)microtime()*1000000); 
	$i = 0; 
	$pass = ''; 
	
		while ($i <= 7) { 
		$num = rand() % 33; 
		$tmp = substr($chars, $num, 1); 
		$pass = $pass . $tmp; 
		$i++; 
		} 
	
	return $pass; 
		
	}
	
	public function shortPassword() {
		
	$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
	srand((double)microtime()*1000000); 
	$i = 0; 
	$pass = ''; 
	
		while ($i <= 4) { 
		$num = rand() % 33; 
		$tmp = substr($chars, $num, 1); 
		$pass = $pass . $tmp; 
		$i++; 
		} 
	
	return $pass; 
		
	}
	
	function generatePassword($length) {
	$password='';
		for ($i=0;$i<=$length;$i++) {
		$chr='';
			switch (mt_rand(1,3)) {
				case 1:
				$chr=chr(mt_rand(48,57));
				break;
				case 2:
				$chr=chr(mt_rand(65,90));
				break;
				case 3:
				$chr=chr(mt_rand(97,122));
			}
		$password.=$chr;
		}	
	return $password;
	}

}

?>