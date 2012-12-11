<?php

namespace library\capsule\path\mvc;

class view extends model {

protected $data;
protected $params,$url;
protected $optionGear,$site;

	public function __construct($params) {

	parent::__construct(); $this->params = $params; 
		
		$this->site = substr(APP, 0, -1);
		
		if (empty($this->url)): $this->url = $GLOBALS['_neyClass']['router']; endif;
		
		if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
		$this->optionGear = "<span class='forex-optionGear'><img class='optionGear' src='".$this->site."/library/capsule/admin/image/settingCap.png'></span>";
		
		endif;
	
		if ($params == "{view}" || empty($params)): 
		
		$this->params = 'normal'; 
		
		else: 
		
		$this->params = $params; 
		
		endif; 
	
	$params = $this->params; 

	$this->$params();
	
	}
	
    public function normal() {
	
	$id = $GLOBALS['_neyClass']['router']->getID();
	
	$path = $this->setData($id)->getMyPath(1);
	
	$enty = $this->getEntityName();
	
	krsort($this->path);

	$i     = 0;
	
	$c     = count($this->path);
	
    $view .= "<div class='forex-".$this->params."-formContainer'>";
    
    $view .= $this->optionGear;   
    	
    	$view .= "<ul class='breadcrumb'>";
    	
    	foreach ($this->path as $key => $value):
    	
    		$caption= strtolower(str_replace(array('-',' '), '-', $value[1]));
    		
    		if ($i == 0):
    		
    		$view .= "<li>".$enty['CAP_ACC_USE_ACC_NAME']." <span class='divider'>/</span></li>";
    		
    		endif;
    		
    		if ($i == $c-1):

	    		if (isset($value[2])):
	    		
	    		$view .= "<li><a href='".$this->url->builder($value[0],$caption)."'>".$value[1]."</a></li>";
	    		
	    		//$view .= "<li><a href='".$value[0]."-".$caption.".html'>".$value[1]."</a></li>";

	    		else:
	    		
	    		$view .= "<li>".$value[1]."</li>";
	    		
	    		endif;
	    		
    		break;
    		
    		endif;
    		
    		if (isset($value[2])):
    		
    		$view .= "<li><a href='".$this->url->builder($value[0],$caption)."'>".$value[1]."</a> <span class='divider'>/</span></li>";

    		else:
    		
    		$view .= "<li>".$value[1]." <span class='divider'>/</span></li>";
    		
    		endif;
    		
    	    $i++;	
    	
    	endforeach;
    
    $view .= "</div>";
        
    echo $view;
    
    }
    	
}

?>