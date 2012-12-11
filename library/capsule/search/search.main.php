<?php

namespace library\capsule\search;

use \library\capsule\search\mvc\model;
use \library\capsule\search\mvc\view;
use \library\capsule\search\mvc\controller;

class search {
	   
   	public static function init($params) {
    return new view($params,'');      	   	
   	}
   	
   	public static function getSearchResult ($text) {
   	return new view('search',$text);
   	}
	
}


?>
