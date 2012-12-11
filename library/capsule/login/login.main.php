<?php

namespace library\capsule\login;

use \library\capsule\login\mvc\model;
use \library\capsule\login\mvc\view;
use \library\capsule\login\mvc\controller;

class login {
	   
   	public static function init($params) {
   	
   		if (!empty($_POST[username]) && !empty($_POST[password])) {
   		$user = new controller($_POST[username],$_POST[password],$_POST[system_last_url]); $user->check();
   		}
   		else {
   		return new view($params);
   		}
      	   	
   	}
	
}


?>
