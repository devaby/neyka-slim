<?php

namespace library\capsule\image\mvc;

class view extends model {

protected $data;
protected $category;
protected $userCategory;
protected $folderCategory;
protected $text;
protected $optionGear;
protected $params;
protected $optionSearch;
protected $row;
    
    public function __construct($text,$params,$rowDisplay,$category,$folder) {
    
    parent::__construct();

    if ($rowDisplay == '{row display}') {$data = $this->fetchData();} else {$data = $this->fetchImageFromFolder($folder);}
    
    	if (preg_match("/[|]/", $text)) {
    
        $text = explode("|", $text);
    
        	if ($_SESSION['language'] == 'id') {
        	$text = $text[0];
        	}
        	else {
        	$text = $text[1];
        	}
        	
        }
    
    $userCat = explode(",",$category); $userCat = $this->fetchDataForUserCategory($userCat); $folderCat = $this->fetchFolderByUserCategory($userCat);
    
    $this -> category 		= $this->fetchDataForOptionCategory();
    $this -> userCategory	= $userCat;
    $this -> folderCategory	= $folderCat;
    $this -> text     		= $text;
    $this -> data     		= $data; 
    $this -> params   		= $params; 
    $this -> row 	  		= $rowDisplay;
    
    if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $this -> optionGear = "<span class='image-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
    }
    
    $this -> $params();
    
    }
    
    public function normal() {  
    
    $view  = "<div class='" . $this->params . "'>";
    
    $myText = explode(" ", $this -> text);
    	
    	foreach ($myText as $value) {
    	$i++;
    		if ($i == 1) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
    		}
    		else {
    		$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
    		}
    	
    	}
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    	}
    
    $view .= $this -> optionGear;
    $view .= "<hr />";
    $view .= "<table>";

    	foreach ($this->data as $key => $value) {
    		
    		if (strlen($value[content]) >= 100) {
    		$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
    		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
    		}
    		else {
    		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    		}
    	
    	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
    	$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
    	$view .= "<tr><td></td></tr>";
    	
    	}
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
    
    
    public function headline_category() {  
    
        
    $view .= $this -> optionGear;	
				
	$i = 0;
	$z = 1;
	$c = count($this->data);
	
	
	$view .= "<div class='image-".$this->params."-categoryImage'>";

   		foreach ($this->folderCategory as $folder) {
   		
   			if (is_array($folder)) {
   		
   				foreach ($folder[folder] as $key => $value) {
   			
   				$imageList = scandir(ROOT_PATH.$value);
				
					foreach ($imageList as $images) {
								
						if ($images != '.' && $images != '..') {
						$i++;
   						$view .= "<img class='image-".$this->params."-images' category='$folder[name]' position='$i' src='$value/" . $images . "' alt=''/>";
   						}
   				
   					}
   			   			
   				}
   				
   			$i = 0;
   			
   			}
   		
   		}
   		
   	$view .= "</div>";
   	
   	$view .= "<div class='image-".$this->params."-categoryContainer'>";
   	
   	$view .= "<div class='image-".$this->params."-category'><ul class='image-".$this->params."-headlineList'>";
   	
   		foreach ($this->folderCategory as $key => $value) {
   		
   		$i++;
   		
   		$view .= "<li><a href='#' category='$i'>".$value[name]."</a></li>";
   		
   		}
   		
   	$view .= "</ul></div>";
   	
   	$view .= "</div>";
    
    $view .= 
    
    "
    <script type='text/javascript'>
    
    $('.image-".$this->params."-images').hide(); $('.image-".$this->params."-images:first').show();
    
    $('.image-".$this->params."-headlineList li a').click(function() {
    var cat = $(this).text();
    var len =  $('.image-".$this->params."-images[category=\"'+cat+'\"]').length;
    
    $('.image-".$this->params."-images').hide(); $('.image-".$this->params."-images[category=\"'+cat+'\"]:first').fadeIn('slow'); 
    
    clearTimeout(swapper);
    if (len == 1) {return false;} swapper = setTimeout('swapImages(1)', 7000);
    });
        
    swapper = setTimeout('swapImages(1)', 7000);
    
    function swapImages(id) { 
    
    var cat = $('.image-".$this->params."-images:visible').attr('category');
    var len =  $('.image-".$this->params."-images[category=\"'+cat+'\"]').length;
    var las = parseInt($('.image-".$this->params."-images:visible').attr('position'));
    
    if (len == 1) {return false;}
    
    if (id == \"return\") {var pos = 1;} else {var pos = parseInt($('.image-".$this->params."-images:visible').attr('position'))+1;}
    
    $('.image-".$this->params."-images[category=\"'+cat+'\"][position=\"'+pos+'\"]').animate({opacity:'toggle'}, 500);
    $('.image-".$this->params."-images[category=\"'+cat+'\"][position=\"'+las+'\"]').hide();
	
	if (pos == len) {swapper = setTimeout('swapImages(\"return\")', 7000);} else {swapper = setTimeout('swapImages('+pos+1+')', 7000);}

    }

    
    
    </script>
    
    ";
    
    echo $view;
    
    }
    
    
	public function client() {  
    
        
    $view .= $this -> optionGear;	
	
	$i = 0;
	$z = 1;
	$c = count($this->data);
	
	
	$view .= "<div class='client-".$this->params."-categoryImage'>";
   		
   		foreach ($this->data as $folder) {
   		$i++;
   		$view .= "<img class='client-".$this->params."-images' position='$i' src='$folder' alt=''/>";   		
   		}
   		
   	$view .= "</div>";
    
    echo $view;
    
    }
    
    
    public function horizontal() {  
    
    $myText = explode(" ", $this->text);
        	
        	foreach ($myText as $value) {
        	$i++;
        		if ($i == 1) {
        		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
        		}
        		else {
        		$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
        		}
        	
        	}
        	
        	if (empty($this -> text)) {
        	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> ";
        	}
        
    $view .= $this->optionGear; $view .= "<hr class='separator-line'/>"; $view .= "<table>";
 
    $view .= "<table>";
	
	$i = 0;
	$z = 1;
	$c = count($this->data);
	
	for ($i; $i < $this->row; $i++) {
	
	if ($c - $y <= 3) {break;}
	
	$view .= "<tr>";
		
		for ($y = $z; $y < $c; $y++) {

        $view .= "<td class='" . $this->params . "-NewsHeader'><img class='" . $this->params . "-daImage'src='framework/resize.class.php?src=" . $this->data[$y] . "&h=70&w=70&zc=1' alt=''/></td>";

    	if ($y != 0 && $y % 3 == 0) {$z = $y+1; break;}
    	
    	}
    	
    $view .= "<tr>";
    	
    }
   	
   	$view .= "</table>";
	$view .= " </div>";
    echo $view;
    
    }
    
    public function gallery() {  
        
            
        $view .= $this -> optionGear;	
    				
    	$i = 0;
    	$z = 1;
    	$c = count($this->data);
    	
    	$view .= "<div class='image-".$this->params."-categoryContainer'>";
       	
       	$view .= "<div class='image-".$this->params."-category'><ul class='image-".$this->params."-headlineList'>";
       	
       		foreach ($this->folderCategory as $key => $value) {
       		
       		$i++;
       		
       		$view .= "<li><a href='#' category='$i'>".ucwords($value[name])."</a></li>";
       		
       		}
       		
       	$view .= "</ul></div>";
       	
       	$view .= "</div>";
		
    	$view .= "<div class='image-".$this->params."-categoryImage'>";
    
       		foreach ($this->folderCategory as $folder) {
       		
       			if (is_array($folder)) {
       		
       				foreach ($folder[folder] as $key => $value) {
       				
       				$i = 0;	$imageList = scandir(ROOT_PATH.$value);
    				
    				$view .= "<div class='image-".$this->params."-iterationImageContainer' category='".ucwords($folder[name])."'>";
    				
    					foreach ($imageList as $images) {
    								
    						if ($images != '.' && $images != '..') {
    						$i++;
       						$view .= "<img class='image-".$this->params."-images' link='$value/$images' category='".ucwords($folder[name])."' position='$i' src='framework/resize.class.php?src=" . $value. "/" . $images . "&h=210&w=210&zc=1' alt=''/>";
       							
       						}
       				
       					}
       					
       				$view .= "</div>";
       										
       				}
       				       			
       			}
       		
       		}
       		
       	$view .= "</div>";       	
        
        echo $view;
        
        }
        
     public function roll() {  
        
            
        $view .= $this -> optionGear;	
    				
    	$i = 0;
    	$z = 1;
    	$c = count($this->data);
    	
    	
    	$view .= "<div class='image-".$this->params."-categoryImage'>";
    
       		foreach ($this->folderCategory as $folder) {
       		
       			if (is_array($folder)) {
       		
       				foreach ($folder[folder] as $key => $value) {
       			
       				$imageList = scandir(ROOT_PATH.$value);
    				
    					foreach ($imageList as $images) {
    								
    						if ($images != '.' && $images != '..') {
    						$i++;
    						
    						$track = $this->fetchContentData($value."/".$images);
    						
    							if (!empty($track)) {
    												
		    						foreach ($track as $key2 => $value2) {
		
		    							if (strtolower($value2[CAP_CON_MET_HEADER]) == 'link') {
		    							$path = $value2[CAP_CON_MET_CONTENT]; break;
		    							
		    							}
		    							
		    						}
    						
    							}
    						
    							if (!empty($path)) {
    							$view .= "<a href='$path'><img class='image-".$this->params."-images' category='$folder[name]' position='$i' src='$value/" . $images . "' alt=''/></a>";
    							}
    							else {
    							$view .= "<img class='image-".$this->params."-images' category='$folder[name]' position='$i' src='$value/" . $images . "' alt=''/>";
    							}
    						
    						$s++;
    						
    						unset($path);
    						       						
       						}
       				
       					}
       			   			
       				}
       				
       			$i = 0;
       			
       			}
       		
       		}
       		
       	$view .= "</div>";
       	
       	$view .= "<div class='image-".$this->params."-categoryContainer'>";
       	
       	$view .= "<div class='image-".$this->params."-category'><ul class='image-".$this->params."-headlineList'>";
		
		if ($s > 1) { 
		
       		for ($i = 1; $i <= $s; $i++) {
       		       		
       		$view .= "<a href='#'><li category='$i'><span style='display:none'>".$i."</span></li></a>";
       		
       		}
       		
       	}
       		
       	$view .= "</ul></div>";
       	
       	$view .= "</div>";
        
        $view .= 
        
        "
        <script type='text/javascript'>
        
        $('.image-".$this->params."-images').hide(); $('.image-".$this->params."-images:first').show();
        
        $('.image-".$this->params."-headlineList li a').click(function() {
        var cat = $(this).text();
        var len =  $('.image-".$this->params."-images[category=\"'+cat+'\"]').length;
        
        $('.image-".$this->params."-images').hide(); $('.image-".$this->params."-images[category=\"'+cat+'\"]:first').fadeIn('slow'); 
        
        clearTimeout(swapper);
        if (len == 1) {return false;} swapper = setTimeout('swapImages(1)', 7000);
        });
            
        swapper = setTimeout('swapImages(1)', 7000);
        
        
        
        function swapImages(id) {
        
        var len =  $('.image-".$this->params."-images').length;
        
        if (len == 1) {return false;}
        
        if (id == \"return\") {var pos = 1;} else {var pos = parseInt($('.image-".$this->params."-images:visible').attr('position'))+1;}
        $('.image-".$this->params."-images').hide();
        $('.image-".$this->params."-images[position=\"'+pos+'\"]').animate({opacity:'toggle'}, 500);
    	
    	if (pos == len) {swapper = setTimeout('swapImages(\"return\")', 5000);} else {swapper = setTimeout('swapImages('+pos+1+')', 5000);}
    
        }
    
        
        
        </script>
        
        ";
        
        echo $view;
        
        }
       
		public function single() {  
		
		
		
		
        
        $view .= $this -> optionGear;	
    				
    	$i = 0;
    	$z = 1;
    	$c = count($this->data);
    	
    	$folder = $this->data;
    	//print_r($this->data);
    	$view .= "<div class='image-".$this->params."-categoryImage'>";
     	
     	
       		
               if (is_array($folder)) {
       		
       				foreach ($folder as $key => $value) {
       				
       				//if (!is_dir(ROOT_PATH.$value)) {continue;}
       				
       				//$imageList = scandir(ROOT_PATH.$value);
    				
    					//if (!empty($imageList)) {
	    				
	    					//foreach ($imageList as $images) {
	    								
	    					//	if ($images != '.' && $images != '..') {
	    						//$i++;
	    						
	    						$track = $this->fetchContentData($value);
	    						
	    							if (!empty($track)) {
	    												
			    						foreach ($track as $key2 => $value2) {
			
			    							if (strtolower($value2[CAP_CON_MET_HEADER]) == 'link') {
			    							$path = $value2[CAP_CON_MET_CONTENT]; break;
			    							
			    							}
			    							
			    						}
	    						
	    							}
	    						
	    							if (!empty($path)) {
	    							$view .= "<a href='$path'><img class='image-".$this->params."-images' category='$folder[name]' position='$i' src='$value' alt=''/></a>";
	    							}
	    							else {
	    							$view .= "<img class='image-".$this->params."-images' category='$folder[name]' position='$i' src='$value' alt=''/>";
	    							}
	    						
	    						/*$s++;
	    						
	    						unset($path);
	    						       						
	       						}
	       				
	       					}
       					
       					}
       			   			*/
       				}
       				
       			//$i = 0;
       			
       			}
       		
       		
       		
       	$view .= "</div>";
             
        echo $view;
        
        }
        
        public function sprites() {  
        
        $view .= $this -> optionGear;	
    				
    	$i = 0;
    	$z = 1;
    	$c = count($this->data);
    	
    	
    	$view .= "<div class='image-".$this->params."-categoryImage'>";
    
       		foreach ($this->folderCategory as $folder) {
       		
       			if (is_array($folder)) {
       		
       				foreach ($folder[folder] as $key => $value) {
       				
       				if (!is_dir(ROOT_PATH.$value)) {continue;}
       				
       				$imageList = scandir(ROOT_PATH.$value);
    				
    					if (!empty($imageList)) {
	    				
	    					foreach ($imageList as $images) {
	    								
	    						if ($images != '.' && $images != '..') {
	    						$i++;
	    						
	    						$track = $this->fetchContentData($value."/".$images);
	    						
	    							if (!empty($track)) {
	    												
			    						foreach ($track as $key2 => $value2) {
			
			    							if (strtolower($value2[CAP_CON_MET_HEADER]) == 'link') {
			    							$path = $value2[CAP_CON_MET_CONTENT]; break;
			    							
			    							}
			    							
			    						}
	    						
	    							}
	    						
	    							if (!empty($path)) {
	    							$view .= "<a href='$path'><div class='image-".$this->params."-images'></div></a>";
	    							}
	    							else {
	    							$view .= "<div class='image-".$this->params."-images'></div>";
	    							}
	    						
	    						$s++;
	    						
	    						unset($path);
	    						       						
	       						}
	       				
	       					}
       					
       					}
       			   			
       				}
       				
       			$i = 0;
       			
       			}
       		
       		}
       		
       	$view .= "</div>";
             
        echo $view;
        
        }
    
}


?>
