<?php

namespace framework\pattern\_singleton;

use \framework\database\oracle\select;

class sites {

use \framework\pattern\singleton;

public $path = null; // Time To Live
public $domain;
public $template;

    public function __construct() {

        $_SESSION['domain']   = $this->domain();
        $_SESSION['template'] = $this->template();

    }
    
    public static function init() {

	   return self::getInstance();
	    		            	    	    
    }

    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function domain() {
	   
	   $domainName = $_SERVER['HTTP_HOST'];
	   $domainName = explode('.',$domainName);
	   
	   if($domainName[0]=='www'){
		   $domainName[0] = "";
	   }
	   
	   $countArr = count($domainName);
	   $i = 1;
	   foreach($domainName as $key => $value){
		   $buildDomain .= $value;
		   if(!empty($value) && $i < $countArr ){
			   $buildDomain .= '.';
		   }
		   $i++;
	   }
	   $domainName = $buildDomain;
	   			   
	   		$domain		= new select("","","");

	   		$domain->column = "CAP_MAI_ID";
	   		$domain->tableName = "CAP_MAIN";
	   		$domain->whereClause = [["CAP_MAI_DOMAIN","=",$domainName]];
	   		$domain->execute();
	   		$mainID = $domain->arrayResult[0]['CAP_MAI_ID'];
	   		if(empty($mainID)){
	   
	   		$domain->column = "a.CAP_MAI_ID";
	   		$domain->tableName = "CAP_MAIN a, ".str_replace('/','',APP).".CAP_MAIN b WHERE a.CAP_MAI_PARENT = b.CAP_MAI_ID AND a.CAP_MAI_DOMAIN  || '.' ||  b.CAP_MAI_DOMAIN ='$domainName'";
	   		$domain->whereClause = "";
			$domain->execute();
			$mainID = $domain->arrayResult[0]["CAP_MAI_ID"];
			}    
        return $mainID;

    }

    /**
    * Return the domain template
    *
    * @return this object
    */
    public function template() {

        $select = new select("*","CAP_MAIN",[["CAP_MAI_ID","=",$this->domain()]]);

        $select->execute();
        
        return $select->arrayResult[0]['CAP_MAI_TEMPLATE'];

    }
    
    /**
    * Return the domain template
    *
    * @return this object
    */
    public function pages($id) {

        $select = new select("*","CAP_PAGES",[["CAP_PAG_ID","=",$id]]);

        $select->execute();

        return $select->arrayResult[0]['CAP_PAG_SITES'];

    }
    
    public function setTemplate($template) {
	    
	    $_SESSION['template'] = $template;
	    
    }
        
}

?>