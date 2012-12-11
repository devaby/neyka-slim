<?php

namespace library\capsule\share\mvc;

class view extends model {

protected $data;
protected $params;
protected $optionGear;

	public function __construct($params) {
	parent::__construct(); $this->params = $params; 
		
	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$this -> optionGear = "<span class='forex-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
	}

	if ($params == "{view}") {$this->params = 'normal';} else {$this->params = $params;} $params = $this->params; $this->$params();
	
	}

    public function normal() {
   	        
    $view .= $this -> optionGear;
       	
    	foreach ($this->data as $key => $value) {
		$view .= "<div class='". $this->params ."-share$key'>$value</div>";
    	}    
    
    echo $view;
    
    }
    
    public function icon() {

    $this->data = $this->model2nd();
    
    	foreach ($this->data as $key => $value) {
		$view .= "<div class='". $this->params ."-share$key'>$value</div>";
    	}    
    
    echo $view;
    
    }
    
    public function smallIcon() {
    
    $view = "
    
    	<ul class='socialicons'>
            <li><a class='social_facebook' target='_blank' href='https://www.facebook.com/asacreative'></a></li>
            <li><a class='social_twitter' href='#'></a></li>
            <li><a class='social_googleplus' href='#'></a></li>
            <!--<li class='share-smallIcon-lastLi'>Our Social</li>-->
        </ul>
    
    "; 
    
    echo $view;
    
    }

}

?>