<?php

namespace framework\database\postgres;

use \framework\user;
use \framework\database\postgres\select;

class menu extends select {
    
    public function __construct($column,$tableName,$whereClause,$whereID) {

    	parent::__construct($column,$tableName,$whereClause,$whereID,"");
                    
    }    
    
    public function selectFindMenuPath ($page,$lang) {

    $user  = unserialize($_SESSION['user']);
	
	$userName = $user->getID(); 

    $role 	  = $user->getRole();

    $domain   = $GLOBALS['_neyClass']['sites']->domain();
    
    $template = $GLOBALS['_neyClass']['sites']->template();
    
    $roleChe  = $_SESSION['role'];

    $roleWhiteList = [1,2,3,4,5,6,7];
    
    $lastGate = in_array($roleChe, $roleWhiteList);
    
	if ($page == 'admin' || $page == 'administrator') {
    
	$queryAdmin = new select("*","CAP_PAGES",[["CAP_PAG_NAME","=","admin"],["CAP_PAG_SITES","=",$domain]]); $queryAdmin->execute(); 

	$this->pageID		  = $queryAdmin->arrayResult[0]['CAP_PAG_ID'];

	$this->singleResult   = $queryAdmin->arrayResult[0]['CAP_PAG_PATH'];

	$this->pagesContainer = $queryAdmin->arrayResult[0]['CAP_PAG_CONTAINER'];

	return $this;

	}

	if ($page == '') {

	$theDefaultPages = new select("*","CAP_PAGES",[["CAP_PAG_PATH","=","view/pages/".$template."/general/default/index.php"],["CAP_PAG_SITES","=",$domain]]);

	$theDefaultPages->execute();

	$id = $theDefaultPages->arrayResult[0]['CAP_PAG_ID'];

	$theDefaultPages->tableName = "CAP_MENU LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID";
	
	$theDefaultPages->whereClause = array(array("CAP_PAGES_CAP_PAG_ID","=",$id));

	$theDefaultPages->execute();

	$page = $theDefaultPages->arrayResult[0]['CAP_MENU_CAP_MEN_ID'];
		
	}

	if (count($role) > 1 && $page == 'role' || count($role) > 1 && isset($_GET['role']) || count($role) > 1 && !$_SESSION['roleset']) {

	$this->singleResult = ROOT_PATH."view/core/roles/index.php";

	return $this;

	}
    
	$findme   = 'c';

	$pos = strpos($page, $findme);

    	if ($pos === false):

        $this->whereID = $page;
        
    	$query = new select("*","CAP_MENU 
    	LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID 
    	LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID 
    	LEFT JOIN CAP_CONTENT ON CAP_MENU.CAP_CONTENT_CAP_CON_ID = CAP_CONTENT.CAP_CON_ID
    	LEFT JOIN CAP_MENU_TYPE ON CAP_MENU.CAP_MENU_TYPE_CAP_MEN_TYP_ID = CAP_MENU_TYPE.CAP_MEN_TYP_ID
    	LEFT JOIN CAP_MAIN ON CAP_MENU_TYPE.FK_CAP_MAI_ID = CAP_MAIN.CAP_MAI_ID",
    	[["CAP_MEN_ID","=",$this->whereID]]);

    	else:
    	
    	$this->whereID = strstr($page,'c', true);
    	
    	$query = new select("*","CAP_CONTENT LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID",[["CAP_CON_ID","=",$this->whereID]],"","");

    	endif;

    $query->execute();
    
    $menuLocation = $query->arrayResult[0]['CAP_MAI_ID'];

    	if ($menuLocation == $domain):

	    $pathID = $query->arrayResult[0]['CAP_PAG_ID'];
	    $path   = $query->arrayResult[0]['CAP_PAG_PATH'];
	    $pagesc = $query->arrayResult[0]['CAP_PAG_CONTAINER'];
	    $id 	= $query->arrayResult[0]['CAP_CON_ID'];
	    
	    elseif ($lastGate):

	    $pathID = $query->arrayResult[0]['CAP_PAG_ID'];
	    $path   = $query->arrayResult[0]['CAP_PAG_PATH'];
	    $pagesc = $query->arrayResult[0]['CAP_PAG_CONTAINER'];
	    $id 	= $query->arrayResult[0]['CAP_CON_ID'];
	    
	    endif;

    $queryContent = new select("*","CAP_LANGUAGE_COMBINE",[["CAP_LAN_COM_FKID","=",$id],["CAP_LAN_COM_LAN_ID","=",$_SESSION['language']],["CAP_LAN_COM_TYPE","=","content"]],"","CAP_LAN_COM_COLUMN DESC");

	$queryContent->execute();

	$hea  		 = $queryContent->arrayResult[0]['CAP_LAN_COM_VALUE'];
	$menu 		 = $queryContent->arrayResult[0]['CAP_LAN_COM_VALUE'];
	$con  		 = $queryContent->arrayResult[1]['CAP_LAN_COM_VALUE'];
	$description = $queryContent->arrayResult[1]['CAP_LAN_COM_DESCRIPTION'];

	//Guest level checking
	$queryMenu = new select("*","CAP_USER_ROLE",array(array("CAP_USE_ROL_NAME","=","guest")),"","");

	$queryMenu->execute();

	$guestLevelID = $queryMenu->arrayResult[0]['CAP_USE_ROL_ID'];
	
	//Check id in conjuction with the id get from guest level checking
	$queryMenu = new select("*","CAP_MENU",array(array("CAP_MEN_ID","=",$this->whereID)),"","");

	$queryMenu->execute();

	$menuIDSecurityLevel = $queryMenu->arrayResult[0]['CAP_MEN_ACCESS'];
	
	$check = count($query->arrayResult); 
		
		if (count($queryContent->arrayResult) != 0) {
			
			$checkContent = $_SESSION['language'];
			
		}
		else {
			
			$checkContent = null;
			
		}
		
	if ($pos === false):
	
	$queryMenu = new select("*","CAP_LANGUAGE_COMBINE",array(array("CAP_LAN_COM_FKID","=",$page),array("CAP_LAN_COM_LAN_ID","=",$_SESSION['language']),array("CAP_LAN_COM_TYPE","=","menu")),"","CAP_LAN_COM_COLUMN DESC");

	$queryMenu->execute();

	$menu = $queryMenu->arrayResult[0]['CAP_LAN_COM_VALUE'];

	$description = $queryMenu->arrayResult[0]['CAP_LAN_COM_DESCRIPTION'];	
	
	endif;

	if ($page == ''):
	$this->singleResult = ROOT_PATH."view/pages/".$template."/general/default/index.php";
	$this->type 		= false;

	elseif ($check == 0 || $menuIDSecurityLevel != $guestLevelID && @!in_array($menuIDSecurityLevel, $role) && $pos === false || $menuLocation != $domain && !$lastGate):

	$this->singleResult = ROOT_PATH."view/pages/".$template."/general/404-Error/index.php";
	$this->type 		= false;

	else:
	$this->type 			= true;
	$this->contentID	  	= $id;
	$this->pageID		  	= $pathID;
	$this->pagesContainer 	= $pagesc;
	$this->singleResult 	= $path; 
    $this->header      		= $hea;
    $this->menu				= $menu;
    $this->description		= $description;
    $this->content      	= $con;
    $this->check 			= $checkContent;
    $this->page				= $page;
	endif;

    return $this;
                    
	}
	
}

?>