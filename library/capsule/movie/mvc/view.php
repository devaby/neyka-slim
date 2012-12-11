<?php

namespace library\capsule\movie\mvc;

class view extends model {
    
    protected $data;
    protected $category;
    protected $optionGear;
    protected $params;
    protected $optionSearch;
    protected $row;
    protected $width;
    protected $height;
    
      
    public function __construct($params,$rowDisplay,$width,$height,$category,$folder) {
    
    parent::__construct(); 

    if ($folder == '{folder}') {$data = $this->fetchData();} else {$data = $this->fetchvideoFromFolder($folder);}

    if (empty($width)) {$this->width = '100%';} else {$this->width = $width;}
    
    if (empty($height)) {$this->height = '250';} else {$this->height = $height;}

    $this->category = $this->fetchDataForOptionCategory();
    $this->data     = $data; 
    $this->params   = $params; 
    $this->row      = $rowDisplay;
    
    if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $this -> optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
    }
    
    $this -> $params();
    
    }
    
    
    public function normal() {  
    
    $view  = "<div class='" . $this->params . "'>";
    
    $view .= $this -> optionGear;
    
    $view .= "Choose a view";
    
    $view .= " </div>";
    
    echo $view;
    
    }
    
    public function boxvideo() {

    $view  = "<div class='" . $this->params . "'>";
            
  	$view .= $this -> optionGear;
  	        
    $i = 0;
    $z = 1;

    if (!empty($this->data)) {
   
   		foreach ($this->data as $key => $value) {
		
			if (pathinfo($value, PATHINFO_EXTENSION) != 'jpg') {
			
			$ext = pathinfo($value, PATHINFO_DIRNAME)."/".pathinfo($value, PATHINFO_FILENAME).".".pathinfo($value, PATHINFO_EXTENSION);
			
			
				$view .= "<div class='" . $this->params . "-videoBox'>
				
						  	<video id=\"".$this->params."-".md5(rand(5,100))."\" class=\"video-js vjs-default-skin\" controls preload=\"none\" width=\"".$this->width."\" height=\"".$this->height."\" data-setup=\"{}\">
								<source src=\"$ext\" type='video/mp4' />
							</video>
				
			  		     </div>";
	
	       	}
       	
       	}
       	
    }
       
    $view .= " </div>";
              
    echo $view;
       
    }
    
    public function multiple_boxvideo() {

    $view  = "<div class='" . $this->params . "'>";
            
  	$view .= $this -> optionGear;
  	        
    $i = 0;
    $z = 1;

    if (!empty($this->data)) {
   
   		foreach ($this->data as $key => $value) {

			if (pathinfo($value, PATHINFO_EXTENSION) != 'jpg') {
			
			$ext = pathinfo($value, PATHINFO_DIRNAME)."/".pathinfo($value, PATHINFO_FILENAME).".".pathinfo($value, PATHINFO_EXTENSION);
			
				$view .= "<div class='" . $this->params . "-videoBox'>
				
						  	<video id=\"".$this->params."-".md5(rand(5,100))."\" class=\"video-js vjs-default-skin\" controls preload=\"none\" width=\"".$this->width."\" height=\"".$this->height."\" data-setup=\"{}\">
								<source src=\"$ext\" type='video/mp4' />
							</video>
				
			  		     </div>";
	
	       	}
       	
       	}
       	
    }
       
    $view .= " </div>";
              
    echo $view;
       
    }
    
}


?>